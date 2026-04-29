<?php

namespace App\Http\Controllers;

use App\Models\clientes as Cliente;
use App\Models\proyecto as Proyecto;
use App\Models\cotizacion as Cotizacion;
use App\Models\detallecotizacion as DetalleCotizacion;
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
}