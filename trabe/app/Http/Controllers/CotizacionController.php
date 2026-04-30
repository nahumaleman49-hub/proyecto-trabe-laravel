<?php

namespace App\Http\Controllers;

use App\Models\clientes as Cliente;
use App\Models\proyecto as Proyecto;
use App\Models\cotizacion as Cotizacion;
use App\Models\detallecotizacion as DetalleCotizacion;
use App\Models\proveedores as proveedor;

use App\Models\categoria as Categoria;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        // 1. Crear proyecto
        $proyecto = Proyecto::create([
            'nombre' => $request->nombre_proyecto,
            'fk_id_cliente' => $request->cliente_id,
            'estado' => 1, // Activo por defecto
            'fecha_ini' => now(),
            'fecha_fin' => null,
            'presupuesto' => 0, // se actualizará con el total de la cotización
        ]);

        // 2. Crear cotización
        $cotizacion = Cotizacion::create([
            'fk_id_proyecto' => $proyecto->ID_proyecto,
            'fecha' => now(),
            'estado' => 0, // Borrador (0)
            'total' => 0,
        ]);

        $total = 0;

        // 3. Guardar materiales (vienen en el formulario mediante campos dinámicos)
        //    Por simplicidad, enviaremos los datos mediante un array en el request.
        //    En tu vista deberás agregar inputs ocultos con los datos seleccionados.
        //    Para no complicar, asumiré que envías `materiales` y `servicios` como JSON.
        $materiales = json_decode($request->materiales_json, true) ?? [];
        foreach ($materiales as $mat) {
            $detalle = DetalleCotizacion::create([
                'fk_id_cotizacion' => $cotizacion->ID_cotizacion,
                'fk_id_material' => $mat['material_id'],
                'fk_id_proveedor' => $mat['proveedor_id'],
                'cantidad' => $mat['cantidad'],
                'precio_unit' => $mat['precio_unitario'],
                'fk_id_mano_obra' => null,
            ]);
            $total += $detalle->cantidad * $detalle->precio_unit;
        }

        $servicios = json_decode($request->servicios_json, true) ?? [];
        foreach ($servicios as $serv) {
            $detalle = DetalleCotizacion::create([
                'fk_id_cotizacion' => $cotizacion->ID_cotizacion,
                'fk_id_material' => null,
                'fk_id_proveedor' => $serv['proveedor_id'],
                'cantidad' => $serv['cantidad'],
                'precio_unit' => $serv['precio_unitario'],
                'fk_id_mano_obra' => $serv['mano_obra_id'],
            ]);
            $total += $detalle->cantidad * $detalle->precio_unit;
        }

        // 4. Calcular total final con gastos y margen
        $costoEquipo = $request->costo_equipo ?? 0;
        $gastosPorc = $request->gastos_generales ?? 0;
        $margenPorc = $request->margen_ganancia ?? 0;
        $subtotalBase = $total + $costoEquipo;
        $conGastos = $subtotalBase * (1 + $gastosPorc / 100);
        $totalFinal = $conGastos * (1 + $margenPorc / 100);

        $cotizacion->update(['total' => $totalFinal]);
        $proyecto->update(['presupuesto' => $totalFinal]);

        return redirect()->route('cotizaciones')->with('success', 'Cotización generada correctamente.');
    }
    
    public function show($id)
    {
        $cotizacion = Cotizacion::with([
            'proyecto.cliente',
            'detalles.material',
            'detalles.manoObra.servicio',
            'detalles.proveedor'
        ])->findOrFail($id);

        return view('cotizaciones.ver', compact('cotizacion'));
    }
    public function pdf($id){
    
    return redirect()->route('cotizaciones.ver', $id)->with('info', 'La generación de PDF estará disponible próximamente.');
    }

    public function edit($id)
    {
    $cotizacion = Cotizacion::with([
        'proyecto.cliente',
        'detalles.material.categoria',
        'detalles.manoObra.servicio.categoria',
        'detalles.proveedor'
    ])->findOrFail($id);

    // Preparar materiales existentes
    $materialesExistentes = [];
    $serviciosExistentes = [];
    foreach ($cotizacion->detalles as $detalle) {
        if ($detalle->fk_id_material) {
            $materialesExistentes[] = [
                'material_id'    => $detalle->fk_id_material,
                'proveedor_id'   => $detalle->fk_id_proveedor,
                'cantidad'       => $detalle->cantidad,
                'precio_unitario'=> $detalle->precio_unit,
                'categoria_id'   => $detalle->material->fk_id_categoria ?? null,
                'categoria_text' => $detalle->material->categoria->nombre ?? '',
                'material_text'  => $detalle->material->nombre,
                'proveedor_text' => $detalle->proveedor->nombre,
                'unidad'         => $detalle->material->medidas,
            ];
        } elseif ($detalle->fk_id_mano_obra) {
            $serviciosExistentes[] = [
                'servicio_id'    => $detalle->fk_id_mano_obra,
                'proveedor_id'   => $detalle->fk_id_proveedor,
                'cantidad'       => $detalle->cantidad,
                'precio_unitario'=> $detalle->precio_unit,
                'categoria_id'   => $detalle->manoObra->servicio->fk_id_categoria ?? null,
                'categoria_text' => $detalle->manoObra->servicio->categoria->nombre ?? '',
                'servicio_text'  => $detalle->manoObra->servicio->nombre,
                'proveedor_text' => $detalle->proveedor->nombre,
                'unidad'         => $detalle->manoObra->unidad,
            ];
        }
    }

    // Valores por defecto (si no guardaste otros)
    $costoEquipo = 0;
    $gastosPorc = 10;
    $margenPorc = 15;

    $clientes = Cliente::all();
    $categoriasMateriales = Categoria::whereHas('materiales')->get(['ID_Categoria as id', 'nombre as text']);
    $categoriasServicios = Categoria::whereHas('servicios')->get(['ID_Categoria as id', 'nombre as text']);

    return view('cotizaciones.nueva', compact(
        'cotizacion', 'clientes', 'categoriasMateriales', 'categoriasServicios',
        'costoEquipo', 'gastosPorc', 'margenPorc',
        'materialesExistentes', 'serviciosExistentes'
    ));
    }

    public function update(Request $request, $id)
    {
    $cotizacion = Cotizacion::findOrFail($id);

    // Validar datos del proyecto
    $validated = $request->validate([
        'nombre_proyecto' => 'required|string|max:50',
        'cliente_id' => 'required|exists:clientes,ID_cliente',
        'costo_equipo' => 'nullable|numeric',
        'gastos_generales' => 'nullable|numeric',
        'margen_ganancia' => 'nullable|numeric',
        'materiales_json' => 'nullable|json',
        'servicios_json' => 'nullable|json',
    ]);

    // Actualizar o crear el proyecto asociado (podría estar vinculado, pero asumimos que la cotización ya tiene proyecto)
    $proyecto = $cotizacion->proyecto;
    $proyecto->nombre = $validated['nombre_proyecto'];
    $proyecto->fk_id_cliente = $validated['cliente_id'];
    // Opcional: guardar fechas? Si no están en el formulario, las dejamos como están
    $proyecto->save();

    // Eliminar detalles antiguos
    $cotizacion->detalles()->delete();

    $materiales = json_decode($request->materiales_json, true) ?? [];
    $servicios = json_decode($request->servicios_json, true) ?? [];

    $subtotal = 0;

    foreach ($materiales as $mat) {
        $detalle = $cotizacion->detalles()->create([
            'fk_id_material' => $mat['material_id'],
            'fk_id_proveedor' => $mat['proveedor_id'],
            'cantidad' => $mat['cantidad'],
            'precio_unit' => $mat['precio_unitario'],
            'fk_id_mano_obra' => null,
        ]);
        $subtotal += $detalle->cantidad * $detalle->precio_unit;
    }

    foreach ($servicios as $serv) {
        $detalle = $cotizacion->detalles()->create([
            'fk_id_material' => null,
            'fk_id_proveedor' => $serv['proveedor_id'],
            'cantidad' => $serv['cantidad'],
            'precio_unit' => $serv['precio_unitario'],
            'fk_id_mano_obra' => $serv['mano_obra_id'],
        ]);
        $subtotal += $detalle->cantidad * $detalle->precio_unit;
    }

    // Calcular total con gastos y margen
    $costoEquipo = $request->costo_equipo ?? 0;
    $gastosPorc = $request->gastos_generales ?? 0;
    $margenPorc = $request->margen_ganancia ?? 0;

    $subtotalBase = $subtotal + $costoEquipo;
    $conGastos = $subtotalBase * (1 + $gastosPorc / 100);
    $totalFinal = $conGastos * (1 + $margenPorc / 100);

    $cotizacion->update([
        'total' => $totalFinal,
        // estado se puede mantener o resetear a Borrador si se editó
        'estado' => 0,
    ]);

    $proyecto->update(['presupuesto' => $totalFinal]);

    return redirect()->route('cotizaciones')->with('success', 'Cotización actualizada correctamente.');
    }
}