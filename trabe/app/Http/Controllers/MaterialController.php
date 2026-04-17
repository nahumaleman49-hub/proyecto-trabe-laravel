<?php

namespace App\Http\Controllers;

use App\Models\materiales as Material;
use App\Models\categoria as Categoria;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index(Request $request)
{
    $query = Material::with('categoria');

    if ($request->has('buscar') && $request->buscar != '') {
        $termino = $request->buscar;
        
        // Agrupamos la consulta usando una función anónima (closure)
        // Esto le dice a Laravel: "Busca ESTO en el nombre O en el código" de forma segura.
        $query->where(function($q) use ($termino) {
            $q->where('nombre', 'LIKE', '%' . $termino . '%')
              ->orWhere('codigo', 'LIKE', '%' . $termino . '%');
        });
    }

    $materiales = $query->get();

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
            'precio' => 'required|numeric|min:0',
            'fk_id_categoria' => 'required|exists:categoria,ID_Categoria',
        ]);

        Material::create($request->all()); 

        return redirect()->route('materiales.index')->with('success', 'Material agregado.');
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
            'precio' => 'required|numeric|min:0',
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
