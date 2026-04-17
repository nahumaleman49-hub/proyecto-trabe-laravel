<?php

namespace App\Http\Controllers;

use App\Models\proyecto as Proyecto;
use App\Models\clientes as Cliente;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    // Lista de proyectos
    public function index()
    {
        $proyectos = Proyecto::with('cliente')->get();
        return view('proyectos.proyectos', compact('proyectos'));
    }

    public function agregar()
{
    $clientes = Cliente::all();
    return view('proyectos.proyectos-agregar', compact('clientes'));
}

    public function editar($id)
{
    $proyecto = proyecto::findOrFail($id);
    $clientes = Cliente::all();
    return view('proyectos.proyectos-agregar', compact('proyecto', 'clientes'));
}

    // Guardar nuevo proyecto
    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'fk_id_cliente' => 'required|integer|exists:clientes,ID_cliente',
            'estado' => 'required|boolean',
            'fecha_ini' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_ini',
            'presupuesto' => 'required|numeric|min:0',
        ]);

        Proyecto::create($request->all());

        return redirect()->route('proyectos.index')->with('success', 'Proyecto agregado correctamente.');
    }


    // Actualizar proyecto
    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'fk_id_cliente' => 'required|integer|exists:clientes,ID_cliente',
            'estado' => 'required|boolean',
            'fecha_ini' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_ini',
            'presupuesto' => 'required|numeric|min:0',
        ]);

        $proyecto = Proyecto::findOrFail($id);
        $proyecto->update($request->all());

        return redirect()->route('proyectos.index')->with('success', 'Proyecto actualizado correctamente.');
    }

    // Eliminar proyecto
    public function eliminar($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        $proyecto->delete();

        return redirect()->route('proyectos.index')->with('success', 'Proyecto eliminado correctamente.');
    }
}