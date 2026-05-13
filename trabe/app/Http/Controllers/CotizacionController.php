<?php

namespace App\Http\Controllers;

use App\Models\clientes as Cliente;
use App\Models\proyecto as Proyecto;
use App\Models\cotizacion as Cotizacion;
use App\Models\detallecotizacion as DetalleServicio;
use App\Models\detallecotizacion_abastecimiento as DetalleMaterial;
use App\Models\categoria as Categoria;
use App\Models\materiales as Material;
use App\Models\manoobra as ManoObra;
use App\Models\proveedores as proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CotizacionController extends Controller
{
    public function index()
    {
        $cotizaciones = Cotizacion::with('proyecto.cliente')->get();
        return view('cotizaciones.cotizaciones', compact('cotizaciones'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $categoriasMateriales = Categoria::whereHas('materiales')->get(['ID_Categoria as id', 'nombre as text']);
        $categoriasServicios = Categoria::whereHas('servicios')->get(['ID_Categoria as id', 'nombre as text']);
        return view('cotizaciones.nueva', compact('clientes', 'categoriasMateriales', 'categoriasServicios'));
    }

    // Métodos AJAX necesarios para que la vista funcione
    public function getMateriales($categoria_id) {
        return Material::where('fk_id_categoria', $categoria_id)->get(['ID_Material as id', 'nombre as text', 'medidas']);
    }

    public function getProveedoresMaterial($material_id) {
        return DB::table('abastecimiento')
            ->join('proveedores', 'abastecimiento.fk_id_proveedor', '=', 'proveedores.ID_proveedor')
            ->where('abastecimiento.fk_id_material', $material_id)
            ->select('proveedores.ID_proveedor as id', 'proveedores.nombre as text', 'abastecimiento.precio', 'abastecimiento.ID_prod') // Usando ID_prod
            ->get();
    }

    public function getServicios($categoria_id) {
        return DB::table('manoobra')
            ->join('servicio', 'manoobra.fk_id_servicio', '=', 'servicio.ID_servicio')
            ->where('servicio.fk_id_categoria', $categoria_id)
            ->select('manoobra.ID_mano_obra as id', 'servicio.nombre as text')
            ->distinct()->get();
    }

    public function getProveedoresServicio($mano_obra_id) {
        return DB::table('manoobra')
            ->join('proveedores', 'manoobra.fk_id_proveedor', '=', 'proveedores.ID_proveedor')
            ->where('manoobra.ID_mano_obra', $mano_obra_id)
            ->select('proveedores.ID_proveedor as id', 'proveedores.nombre as text', 'manoobra.precio', 'manoobra.unidad')
            ->get();
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // 1. Crear proyecto
            $proyecto = Proyecto::create([
                'nombre' => $request->nombre_proyecto,
                'fk_id_cliente' => $request->cliente_id,
                'estado' => 1,
                'fecha_ini' => now(),
                'presupuesto' => 0,
            ]);

            // 2. Crear cotización
            $cotizacion = Cotizacion::create([
                'fk_id_proyecto' => $proyecto->ID_proyecto,
                'fecha' => now(),
                'estado' => 0,
                'total' => 0,
            ]);

            $totalBase = 0;

            // 3. Guardar Materiales
            $materiales = json_decode($request->materiales_json, true) ?? [];
            foreach ($materiales as $mat) {
                $abastecimiento = DB::table('abastecimiento')
                    ->where('fk_id_material', $mat['material_id'])
                    ->where('fk_id_proveedor', $mat['proveedor_id'])
                    ->first();

                if ($abastecimiento) {
                    DetalleMaterial::create([
                        'fk_id_cotizacion' => $cotizacion->ID_cotizacion,
                        'fk_id_abastecimiento' => $abastecimiento->ID_prod, // Respetando ID_prod
                        'cantidad' => $mat['cantidad']
                    ]);
                    $totalBase += $mat['cantidad'] * $abastecimiento->precio;
                }
            }

            // 4. Guardar Servicios
            $servicios = json_decode($request->servicios_json, true) ?? [];
            foreach ($servicios as $serv) {
                DetalleServicio::create([
                    'fk_id_cotizacion' => $cotizacion->ID_cotizacion,
                    'fk_id_mano_obra'  => $serv['mano_obra_id'],
                    'cantidad'         => $serv['cantidad']
                ]);
                $totalBase += $serv['cantidad'] * $serv['precio_unitario'];
            }

            // 5. Cálculos Finales
            $costoEquipo = $request->costo_equipo ?? 0;
            $gastosPorc = $request->gastos_generales ?? 0;
            $margenPorc = $request->margen_ganancia ?? 0;

            $subtotalBase = $totalBase + $costoEquipo;
            $conGastos = $subtotalBase * (1 + $gastosPorc / 100);
            $totalFinal = $conGastos * (1 + $margenPorc / 100);

            $cotizacion->update(['total' => $totalFinal]);
            $proyecto->update(['presupuesto' => $totalFinal]);

            DB::commit();
            return redirect()->route('cotizaciones')->with('success', 'Cotización generada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al guardar: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $cotizacion = Cotizacion::with([
            'proyecto.cliente',
            'detallesMateriales.abastecimiento.material', 
            'detallesMateriales.abastecimiento.proveedor',
            'detallesManoObra.manoObra.servicio'
        ])->findOrFail($id);

        return view('cotizaciones.ver', compact('cotizacion'));
    }

    public function pdf($id)
    {
        return redirect()->route('cotizaciones.ver', $id)->with('info', 'La generación de PDF estará disponible próximamente.');
    }

    public function edit($id)
    {
        $cotizacion = Cotizacion::with([
            'proyecto.cliente',
            'detallesMateriales.abastecimiento.material.categoria',
            'detallesMateriales.abastecimiento.proveedor',
            'detallesManoObra.manoObra.servicio.categoria',
            'detallesManoObra.manoObra.proveedor'
        ])->findOrFail($id);

        // Formatear Materiales para el JS
        $materialesExistentes = $cotizacion->detallesMateriales->map(function($d) {
            return [
                'material_id'     => $d->abastecimiento->fk_id_material,
                'proveedor_id'    => $d->abastecimiento->fk_id_proveedor,
                'cantidad'        => $d->cantidad,
                'precio_unitario' => $d->abastecimiento->precio,
                'material_text'   => $d->abastecimiento->material->nombre,
                'proveedor_text'  => $d->abastecimiento->proveedor->nombre,
                'unidad'          => $d->abastecimiento->material->medidas,
            ];
        });

        // Formatear Servicios para el JS
        $serviciosExistentes = $cotizacion->detallesManoObra->map(function($d) {
            return [
                'mano_obra_id'    => $d->fk_id_mano_obra,
                'cantidad'        => $d->cantidad,
                'precio_unitario' => $d->manoObra->precio,
                'servicio_text'   => $d->manoObra->servicio->nombre,
                'proveedor_text'  => $d->manoObra->proveedor->nombre ?? 'N/A',
                'unidad'          => $d->manoObra->unidad,
            ];
        });

        $clientes = Cliente::all();
        $categoriasMateriales = Categoria::whereHas('materiales')->get(['ID_Categoria as id', 'nombre as text']);
        $categoriasServicios = Categoria::whereHas('servicios')->get(['ID_Categoria as id', 'nombre as text']);

        return view('cotizaciones.nueva', compact(
            'cotizacion', 'clientes', 'categoriasMateriales', 'categoriasServicios',
            'materialesExistentes', 'serviciosExistentes'
        ));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $cotizacion = Cotizacion::findOrFail($id);

            $cotizacion->proyecto->update([
                'nombre' => $request->nombre_proyecto,
                'fk_id_cliente' => $request->cliente_id
            ]);

            // Limpiar detalles anteriores
            $cotizacion->detallesMateriales()->delete();
            $cotizacion->detallesManoObra()->delete();

            $totalBase = 0;

            // Procesar Materiales
            $materiales = json_decode($request->materiales_json, true) ?? [];
            foreach ($materiales as $mat) {
                $abastecimiento = DB::table('abastecimiento')
                    ->where('fk_id_material', $mat['material_id'])
                    ->where('fk_id_proveedor', $mat['proveedor_id'])
                    ->first();

                if ($abastecimiento) {
                    DetalleMaterial::create([
                        'fk_id_cotizacion' => $cotizacion->ID_cotizacion,
                        'fk_id_abastecimiento' => $abastecimiento->ID_prod, // Respetando ID_prod
                        'cantidad' => $mat['cantidad']
                    ]);
                    $totalBase += $mat['cantidad'] * $abastecimiento->precio;
                }
            }

            // Procesar Servicios
            $servicios = json_decode($request->servicios_json, true) ?? [];
            foreach ($servicios as $serv) {
                DetalleServicio::create([
                    'fk_id_cotizacion' => $cotizacion->ID_cotizacion,
                    'fk_id_mano_obra'  => $serv['mano_obra_id'],
                    'cantidad'         => $serv['cantidad']
                ]);
                $totalBase += $serv['cantidad'] * $serv['precio_unitario'];
            }

            // Recalcular Totales
            $subtotalBase = $totalBase + ($request->costo_equipo ?? 0);
            $conGastos = $subtotalBase * (1 + ($request->gastos_generales ?? 0) / 100);
            $totalFinal = $conGastos * (1 + ($request->margen_ganancia ?? 0) / 100);

            $cotizacion->update(['total' => $totalFinal]);
            $cotizacion->proyecto->update(['presupuesto' => $totalFinal]);

            DB::commit();
            return redirect()->route('cotizaciones')->with('success', 'Cotización actualizada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}