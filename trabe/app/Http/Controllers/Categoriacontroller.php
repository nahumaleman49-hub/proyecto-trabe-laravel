<?php

namespace App\Http\Controllers;

use App\Models\categoria as Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        return view('categorias.categorias', compact('categorias'));
    }

    public function agregar()
    {
        return view('categorias.categoriasagregar');
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'descripcion' => 'required|string|max:255',
        ]);

        Categoria::create($request->all()); 

        return redirect()->route('categorias.index')->with('success', 'Categoría agregada correctamente.');
    }

    public function editar($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('categorias.categoriasagregar', compact('categoria'));
    }

    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'descripcion' => 'required|string|max:255',
        ]);

        $categoria = Categoria::findOrFail($id);
        $categoria->update($request->all()); 

        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada correctamente.');
    }

    public function eliminar($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();

        return redirect()->route('categorias.index')->with('success', 'Categoría eliminada correctamente.');
    }
}