<?php

namespace App\Http\Controllers;

use App\Models\proveedores as Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function index()
    {
        $proveedores = Proveedor::all();
        return view('proveedores.proveedores', compact('proveedores'));
    }

    public function crear()
    {
        return view('proveedores.proveedores-agregar');
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'nombre_contacto' => 'required|string|max:40',
            'telefono' => 'required|integer',
            'correo_e' => 'required|email|max:30',
            'direccion' => 'required|string|max:50',
        ]);

        Proveedor::create($request->all());

        return redirect()->route('proveedores')->with('success', 'Proveedor creado correctamente.');
    }

    public function editar($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        return view('proveedores.proveedores-agregar', compact('proveedor'));
    }

    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'nombre_contacto' => 'required|string|max:40',
            'telefono' => 'required|integer',
            'correo_e' => 'required|email|max:30',
            'direccion' => 'required|string|max:50',
        ]);

        $proveedor = Proveedor::findOrFail($id);
        $proveedor->update($request->all());

        return redirect()->route('proveedores.proveedores')->with('success', 'Proveedor actualizado.');
    }

    public function eliminar($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->delete();

        return redirect()->route('proveedores.proveedores')->with('success', 'Proveedor eliminado.');
    }
}