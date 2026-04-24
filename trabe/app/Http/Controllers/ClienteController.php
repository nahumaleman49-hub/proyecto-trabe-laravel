<?php

namespace App\Http\Controllers;

use App\Models\clientes as Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all(); // solo no eliminados
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
            'telefono' => 'required|string|max:11',
            'direccion' => 'required|string|max:80',
        ]);

        Cliente::create($request->all());

        return redirect()->route('clientes')->with('success', 'Cliente agregado correctamente.');
    }

    public function editar($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('clientes-agregar', compact('cliente'));
    }

    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'telefono' => 'required|string|max:11',
            'direccion' => 'required|string|max:80',
        ]);

        $cliente = Cliente::findOrFail($id);
        $cliente->update($request->all());

        return redirect()->route('clientes')->with('success', 'Cliente actualizado correctamente.');
    }

    public function eliminar($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete(); // soft delete

        return redirect()->route('clientes')->with('success', 'Cliente eliminado correctamente.');
    }
}