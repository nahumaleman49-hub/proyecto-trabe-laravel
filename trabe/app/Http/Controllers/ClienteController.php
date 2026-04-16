<?php

namespace App\Http\Controllers;

use App\Models\clientes as Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();
        return view('clientes.clientes', compact('clientes'));
    }

    public function agregar()
    {
        return view('clientes.clientesagregar');
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'telefono' => 'required|integer',
            'direccion' => 'required|string|max:80',
        ]);

        Cliente::create($request->all()); 

        return redirect()->route('clientes.index')->with('success', 'Cliente agregado correctamente.');
    }

    public function editar($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('clientes.clientesagregar', compact('cliente'));
    }

    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'telefono' => 'required|integer',
            'direccion' => 'required|string|max:80',
        ]);

        $cliente = Cliente::findOrFail($id);
        $cliente->update($request->all()); 

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado correctamente.');
    }

    public function eliminar($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado correctamente.');
    }
}