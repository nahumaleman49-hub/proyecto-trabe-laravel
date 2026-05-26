<?php

namespace App\Http\Controllers;

use App\Models\clientes as Cliente;
use App\Models\proyecto as Proyecto;
use App\Models\cotizacion as Cotizacion;
use App\Models\detallecotizacion as DetalleServicio;
use App\Models\detallecotizacion_abastecimiento as DetalleMaterial;
use App\Models\categoria as Categoria;
use App\Models\materiales as materiales;
use App\Models\abastecimiento as Abastecimiento;
use App\Models\manoobra as ManoObra;
use App\Models\proveedores as proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

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

    public function getMateriales($categoria_id) {
        $data = materiales::where('fk_id_categoria', $categoria_id)
            ->get(['ID_Material as id', 'nombre as text', 'medidas']);
        return response()->json($data);
    }

    // ESTA ES LA FUNCIÓN QUE ESTÁ FALLANDO EN TU VISTA
    public function getProveedoresMaterial($material_id) {
        $proveedores = DB::table('abastecimiento')
            ->join('proveedores', 'abastecimiento.fk_id_proveedor', '=', 'proveedores.ID_proveedor')
            ->where('abastecimiento.fk_id_material', $material_id)
            ->whereNull('abastecimiento.deleted_at')
            ->select(
                'proveedores.ID_proveedor as id', 
                'proveedores.nombre as text', 
                'abastecimiento.precio', 
                'abastecimiento.ID_prod'
            )
            ->get();

        // Retornamos una respuesta JSON pura para que el JS no se bloquee
        return response()->json($proveedores);
    }

    public function getServicios($categoria_id) {
        $servicios = DB::table('manoobra')
            ->join('servicio', 'manoobra.fk_id_servicio', '=', 'servicio.ID_servicio')
            ->where('servicio.fk_id_categoria', $categoria_id)
            ->select('manoobra.ID_mano_obra as id', 'servicio.nombre as text')
            ->distinct()
            ->get();
        return response()->json($servicios);
    }

    public function getProveedoresServicio($mano_obra_id) {
        $data = DB::table('manoobra')
            ->join('proveedores', 'manoobra.fk_id_proveedor', '=', 'proveedores.ID_proveedor')
            ->where('manoobra.ID_mano_obra', $mano_obra_id)
            ->select(
                'proveedores.ID_proveedor as id', 
                'proveedores.nombre as text', 
                'manoobra.precio', 
                'manoobra.unidad'
            )
            ->get();
        return response()->json($data);
    }

    public function store(Request $request)
{
    try {
        DB::beginTransaction();

        // Crear proyecto
        $proyecto = Proyecto::create([
            'nombre'        => $request->nombre_proyecto,
            'fk_id_cliente' => $request->cliente_id,
            'estado'        => 1,
            'fecha_ini'     => now(),
            'presupuesto'   => 0,
        ]);

        // Crear cotización
        $cotizacion = Cotizacion::create([
            'fk_id_proyecto' => $proyecto->ID_proyecto,
            'fecha'          => now(),
            'estado'         => 0,
            'total'          => 0,
        ]);

        $totalBase = 0;

        // ---- Materiales (tabla detallecotizacion_abastecimiento) ----
        $materiales = json_decode($request->materiales_json, true) ?? [];
        foreach ($materiales as $mat) {
            $abs = Abastecimiento::find($mat['abastecimiento_id']);
            if ($abs && $abs->precio > 0) {
                DetalleMaterial::create([
                    'fk_id_cotizacion'   => $cotizacion->ID_cotizacion,
                    'fk_id_abastecimiento' => $abs->ID_prod,
                    'cantidad'           => $mat['cantidad'],
                ]);
                $totalBase += $mat['cantidad'] * $abs->precio;
            }
        }

        // ---- Servicios (tabla detallecotizacion) ----
        $servicios = json_decode($request->servicios_json, true) ?? [];
        foreach ($servicios as $serv) {
            // Obtener el precio desde la tabla manoobra si no viene en el JSON
            $precioUnitario = $serv['precio_unitario'] ?? 0;
            if ($precioUnitario == 0 && isset($serv['mano_obra_id'])) {
                $mano = ManoObra::find($serv['mano_obra_id']);
                $precioUnitario = $mano->precio ?? 0;
            }
            DetalleServicio::create([
                'fk_id_cotizacion' => $cotizacion->ID_cotizacion,
                'fk_id_mano_obra'  => $serv['mano_obra_id'],
                'cantidad'         => $serv['cantidad'],
                'precio_unit'      => $precioUnitario,
            ]);
            $totalBase += $serv['cantidad'] * $precioUnitario;
        }

        // Costos adicionales
        $costoEquipo = floatval($request->costo_equipo ?? 0);
        $gastosPerc  = floatval($request->gastos_generales ?? 0);
        $margenPerc  = floatval($request->margen_ganancia ?? 0);

        $subtotalBase = $totalBase + $costoEquipo;
        $conGastos    = $subtotalBase * (1 + $gastosPerc / 100);
        $totalFinal   = $conGastos * (1 + $margenPerc / 100);

        // Actualizar cotización con totales y porcentajes
        $cotizacion->update([
            'total'            => $totalFinal,
            'costo_equipo'     => $costoEquipo,
            'gastos_generales' => $gastosPerc,
            'margen_ganancia'  => $margenPerc,
        ]);

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
        'detallesMateriales.abastecimiento.materiales',
        'detallesMateriales.abastecimiento.proveedor',
        'detallesManoObra.manoObra.servicio',
        'detallesManoObra.manoObra.proveedor'
    ])->findOrFail($id);

    return view('cotizaciones.ver', compact('cotizacion'));
}

    public function edit($id)
{
    $cotizacion = Cotizacion::with([
        'proyecto.cliente',
        'detallesMateriales.abastecimiento.materiales',
        'detallesMateriales.abastecimiento.proveedor',
        'detallesManoObra.manoObra.servicio',
        'detallesManoObra.manoObra.proveedor'
    ])->findOrFail($id);

    $materialesExistentes = $cotizacion->detallesMateriales->map(function($d) {
    return [
        'id_detalle'        => $d->ID_det_ab,
        'abastecimiento_id' => $d->fk_id_abastecimiento,
        'material_id'       => $d->abastecimiento->fk_id_material ?? null,   // ✅ NUEVO
        'material_text'     => $d->abastecimiento->materiales->nombre ?? 'N/A',
        'proveedor_text'    => $d->abastecimiento->proveedor->nombre ?? 'N/A',
        'cantidad'          => $d->cantidad,
        'precio_unitario'   => $d->abastecimiento->precio ?? 0,
        'unidad'            => $d->abastecimiento->materiales->medidas ?? 'N/A',
    ];
});

$serviciosExistentes = $cotizacion->detallesManoObra->map(function($d) {
    return [
        'id_detalle'      => $d->ID_DetalleCotiza,
        'mano_obra_id'    => $d->fk_id_mano_obra,
        'servicio_id'     => $d->manoObra->fk_id_servicio ?? null,   // ✅ NUEVO
        'cantidad'        => $d->cantidad,
        'precio_unitario' => $d->precio_unit ?? 0,
        'servicio_text'   => $d->manoObra->servicio->nombre ?? 'N/A',
        'proveedor_text'  => $d->manoObra->proveedor->nombre ?? 'N/A',
        'unidad'          => $d->manoObra->unidad ?? 'N/A',
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

        // Actualizar proyecto
        $cotizacion->proyecto->update([
            'nombre' => $request->nombre_proyecto,
            'fk_id_cliente' => $request->cliente_id
        ]);

        // Eliminar detalles antiguos de materiales (tabla detallecotizacion_abastecimiento)
        $cotizacion->detallesMateriales()->delete();
        // Eliminar detalles antiguos de servicios (tabla detallecotizacion)
        $cotizacion->detallesManoObra()->delete();

        $totalBase = 0;

        // Guardar materiales desde materiales_json
        $materiales = json_decode($request->materiales_json, true) ?? [];
        foreach ($materiales as $mat) {
            $abs = Abastecimiento::find($mat['abastecimiento_id']);
            if ($abs) {
                DetalleMaterial::create([
                    'fk_id_cotizacion'   => $cotizacion->ID_cotizacion,
                    'fk_id_abastecimiento' => $abs->ID_prod,  // Nota: usa el campo correcto
                    'cantidad'           => $mat['cantidad']
                ]);
                $totalBase += $mat['cantidad'] * $abs->precio;
            }
        }

        // Guardar servicios desde servicios_json
        $servicios = json_decode($request->servicios_json, true) ?? [];
        foreach ($servicios as $serv) {
            DetalleServicio::create([
                'fk_id_cotizacion' => $cotizacion->ID_cotizacion,
                'fk_id_mano_obra'  => $serv['mano_obra_id'],
                'cantidad'         => $serv['cantidad']
            ]);
            // Obtener precio del servicio (debería venir en $serv['precio_unitario'])
            $precio = $serv['precio_unitario'] ?? 0;
            $totalBase += $serv['cantidad'] * $precio;
        }

        // Gastos y márgenes
        $costoEquipo = $request->costo_equipo ?? 0;
        $gastosPerc  = $request->gastos_generales ?? 0;
        $margenPerc  = $request->margen_ganancia ?? 0;

        $subtotalBase = $totalBase + $costoEquipo;
        $conGastos    = $subtotalBase * (1 + $gastosPerc / 100);
        $totalFinal   = $conGastos * (1 + $margenPerc / 100);

        $cotizacion->update([
            'total'            => $totalFinal,
            'costo_equipo'     => $costoEquipo,
            'gastos_generales' => $gastosPerc,
            'margen_ganancia'  => $margenPerc,
        ]);
        $cotizacion->proyecto->update(['presupuesto' => $totalFinal]);

        DB::commit();
        return redirect()->route('cotizaciones')->with('success', 'Cotización actualizada correctamente.');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors(['error' => 'Error al actualizar: ' . $e->getMessage()]);
    }
}

public function pdf($id)
{
    $cotizacion = Cotizacion::with([
        'proyecto.cliente',
        'detallesMateriales.abastecimiento.materiales',   // ← importante
        'detallesMateriales.abastecimiento.proveedor',    // ← importante
        'detallesManoObra.manoObra.servicio',
        'detallesManoObra.manoObra.proveedor'
    ])->findOrFail($id);

    // Calcular totales manualmente desde las relaciones
    $totalMateriales = $cotizacion->detallesMateriales->sum(function($det) {
        return $det->cantidad * ($det->abastecimiento->precio ?? 0);
    });

    $totalServicios = $cotizacion->detallesManoObra->sum(function($det) {
        return $det->cantidad * ($det->precio_unit ?? 0);
    });

    $costoEquipo = $cotizacion->costo_equipo ?? 0;
    $porcGastos  = $cotizacion->gastos_generales ?? 0;
    $porcMargen  = $cotizacion->margen_ganancia ?? 0;

    $subtotalBase = $totalMateriales + $totalServicios + $costoEquipo;
    $montoGastos  = $subtotalBase * ($porcGastos / 100);
    $subtotalConGastos = $subtotalBase + $montoGastos;
    $montoMargen  = $subtotalConGastos * ($porcMargen / 100);
    $totalFinal   = $subtotalConGastos + $montoMargen;

    // Opcional: actualizar el total en la BD por si acaso
    $cotizacion->total = $totalFinal;
    $cotizacion->save();

    $pdf = Pdf::loadView('cotizaciones.PDF', compact(
        'cotizacion',
        'totalMateriales',
        'totalServicios',
        'costoEquipo',
        'porcGastos',
        'montoGastos',
        'porcMargen',
        'montoMargen',
        'totalFinal'
    ));

    return $pdf->download("cotizacion-{$cotizacion->ID_cotizacion}.pdf");
}
}