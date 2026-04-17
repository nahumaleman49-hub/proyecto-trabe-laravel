<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\proveedores;

class ProveedorController extends Controller
{
    public function index()
    {
        $proveedores = proveedores::all();
        return view('proveedores.proveedores', compact('proveedores'));
    }

    // Mostrar formulario de creación
    public function crear()
    {
        return view('proveedores.proveedores-agregar');
    }

    // Guardar nuevo proveedor
    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'nombre_contacto' => 'required|string|max:50',
            'telefono' => 'required',
            'correo_e' => 'required|email',
            'direccion' => 'required|string|max:80',
        ]);

        proveedores::create($request->all());

        return redirect()->route('proveedores')->with('success', 'Proveedor creado correctamente.');
    }

    // Mostrar formulario de edición
    public function editar($id)
    {
        $proveedor = proveedores::findOrFail($id);
        return view('proveedores.proveedores-agregar', compact('proveedor'));
    }

    // Actualizar proveedor
    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'nombre_contacto' => 'required|string|max:50',
            'telefono' => 'required',
            'correo_e' => 'required|email',
            'direccion' => 'required|string|max:80',
        ]);

        $proveedor = proveedores::findOrFail($id);
        $proveedor->update($request->all());

        return redirect()->route('proveedores')->with('success', 'Proveedor actualizado.');
    }

    // Eliminar proveedor
    public function eliminar($id)
    {
        $proveedor = proveedores::findOrFail($id);
        $proveedor->delete();

        return redirect()->route('proveedores')->with('success', 'Proveedor eliminado.');
    }
}