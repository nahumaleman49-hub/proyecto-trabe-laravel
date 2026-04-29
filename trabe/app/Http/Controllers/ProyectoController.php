<?php

namespace App\Http\Controllers;

use App\Models\proyecto as Proyecto;
use App\Models\clientes as Cliente;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    public function index(Request $request){
    $search = $request->input('search');
    
    $proyectos = Proyecto::with('cliente')
        ->when($search, function ($query, $search) {
            return $query->whereHas('cliente', function ($q) use ($search) {
                $q->where('nombre', 'LIKE', "%{$search}%");
            });
        })
        ->get();

    return view('proyectos.proyectos', compact('proyectos', 'search'));
    }

    public function agregar()
    {
        $clientes = Cliente::all();
        return view('proyectos.proyectos-agregar', compact('clientes'));
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'fk_id_cliente' => 'required|exists:clientes,ID_cliente',
            'estado' => 'required|boolean',
            'fecha_ini' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_ini',
            'presupuesto' => 'required|numeric|min:0',
        ]);

        Proyecto::create($request->all());

        return redirect()->route('proyectos')->with('success', 'Proyecto agregado correctamente.');
    }

    public function editar($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        $clientes = Cliente::all();
        return view('proyectos.proyectos-agregar', compact('proyecto', 'clientes'));
    }

    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'fk_id_cliente' => 'required|exists:clientes,ID_cliente',
            'estado' => 'required|boolean',
            'fecha_ini' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_ini',
            'presupuesto' => 'required|numeric|min:0',
        ]);

        $proyecto = Proyecto::findOrFail($id);
        $proyecto->update($request->all());

        return redirect()->route('proyectos')->with('success', 'Proyecto actualizado correctamente.');
    }

    public function eliminar($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        $proyecto->delete();

        return redirect()->route('proyectos')->with('success', 'Proyecto eliminado correctamente.');
    }
}