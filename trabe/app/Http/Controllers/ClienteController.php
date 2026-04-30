<?php

namespace App\Http\Controllers;

use App\Models\clientes as Cliente;
use Illuminate\Http\Request;
use Exception;

class ClienteController extends Controller
{
    public function index()
    {
        // Cargamos los clientes con el conteo de sus proyectos vinculados
        // (Asumiendo que en tu modelo Clientes tienes la relación proyectos())
        $clientes = Cliente::withCount('proyectos')->get(); 
        return view('clientes.clientes', compact('clientes'));
    }

    public function agregar()
    {
        return view('clientes.clientesagregar');
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50|unique:clientes,nombre',
            'telefono' => 'required|string|max:11|unique:clientes,telefono',
            'direccion' => 'required|string|max:80',
        ]);

        try {
            Cliente::create($request->all());
            return redirect()->route('clientes')->with('success', 'Cliente agregado correctamente.');
        } catch (Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Error al guardar: ' . $e->getMessage()]);
        }
    }

    public function editar($id)
    {
        // Cargamos también los proyectos del cliente para la vista de edición/detalle
        $cliente = Cliente::with('proyectos')->findOrFail($id);
        return view('clientes.clientesagregar', compact('cliente'));
    }

    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:50|unique:clientes,nombre,' . $id . ',ID_cliente', // Ajusta 'ID_cliente' si tu PK se llama distinto
            'telefono' => 'required|string|max:11|unique:clientes,telefono,' . $id . ',ID_cliente',
            'direccion' => 'required|string|max:80',
        ]);

        try {
            $cliente = Cliente::findOrFail($id);
            $cliente->update($request->all());
            return redirect()->route('clientes')->with('success', 'Cliente actualizado correctamente.');
        } catch (Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Error al actualizar: ' . $e->getMessage()]);
        }
    }

    public function eliminar($id)
    {
        try {
            $cliente = Cliente::findOrFail($id);
            // Podrías verificar aquí si tiene proyectos activos antes de permitir eliminarlo
            $cliente->delete(); 
            return redirect()->route('clientes')->with('success', 'Cliente eliminado correctamente.');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'No se pudo eliminar el cliente.']);
        }
    }
}