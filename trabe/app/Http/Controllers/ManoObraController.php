<?php

namespace App\Http\Controllers;

use App\Models\manoobracontac;
use App\Models\detallemanoobra;

class ManoObraController extends Controller
{
    public function index(){
    $trabajadores = manoobracontac::with('detalles')->get();
    $tiposTrabajo = detallemanoobra::distinct('tipo_trabajo')->pluck('tipo_trabajo');
    return view('manoObra.manoDeObra', compact('trabajadores', 'tiposTrabajo'));
}
public function agregar(){
    return view('manoObra.manoobraagregar');
}

public function guardar(Request $request){
    $request->validate([
        'nombre' => 'required|string|max:50',
        'telefono' => 'required|integer',
        'direccion' => 'required|string|max:80',
        'detalles' => 'required|array|min:1',
        'detalles.*.tipo_trabajo' => 'required|string|max:30',
        'detalles.*.precio_unit' => 'required|numeric|min:0',
        'detalles.*.cantidad' => 'required|integer|min:1',
    ]);

    DB::beginTransaction();
    try {
        $trabajador = manoobracontac::create([
            'nombre' => $request->nombre,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
        ]);

        foreach ($request->detalles as $detalle) {
            detallemanoobra::create([
                'fk_id_mano_obra_contac' => $trabajador->ID_mano_obra_contac,
                'tipo_trabajo' => $detalle['tipo_trabajo'],
                'precio_unit' => $detalle['precio_unit'],
                'cantidad' => $detalle['cantidad'],
            ]);
        }

        DB::commit();
        return redirect()->route('mano.de.obra')->with('success', 'Trabajador agregado correctamente.');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors('Error al guardar: ' . $e->getMessage());
    }
    }
}