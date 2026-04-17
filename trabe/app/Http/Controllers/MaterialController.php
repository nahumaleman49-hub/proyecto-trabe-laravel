<?php

namespace App\Http\Controllers;

use App\Models\materiales as Material;
use App\Models\categoria as Categoria;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        // Traemos los materiales con su categoría para evitar el error N+1 y null properties
        $materiales = Material::with('categoria')->get();
        return view('materiales.materiales', compact('materiales'));
    }

    public function agregar()
    {
        $categorias = Categoria::all(); // Traemos las categorías para el select
        return view('materiales.materialesagregar', compact('categorias'));
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'codigo' => 'required|string|max:20',
            'medidas' => 'required|string|max:20',
            'fk_id_categoria' => 'required|exists:categoria,ID_Categoria',
        ]);

        Material::create($request->all()); 

        return redirect()->route('materiales.index')->with('success', 'Material agregado correctamente.');
    }

    public function editar($id)
    {
        $material = Material::findOrFail($id);
        $categorias = Categoria::all();
        return view('materiales.materialesagregar', compact('material', 'categorias'));
    }

    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'codigo' => 'required|string|max:20',
            'medidas' => 'required|string|max:20',
            'fk_id_categoria' => 'required|exists:categoria,ID_Categoria',
        ]);

        $material = Material::findOrFail($id);
        $material->update($request->all()); 

        return redirect()->route('materiales.index')->with('success', 'Material actualizado correctamente.');
    }

    public function eliminar($id)
    {
        $material = Material::findOrFail($id);
        $material->delete();

        return redirect()->route('materiales.index')->with('success', 'Material eliminado correctamente.');
    }
}
