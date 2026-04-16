<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\materiales;
use App\Models\categoria;

class MaterialController extends Controller
{
    public function index(Request $request)
{
    // Obtenemos todas las categorías con sus materiales y precios
    $categorias = \App\Models\Categoria::with(['materiales.preciosHistoricos.proveedor'])->get();
    
    // Detectamos si el usuario seleccionó una categoría o material específico por la URL
    $categoriaId = $request->query('categoria');
    $materialId = $request->query('material');

    return view('materiales', compact('categorias', 'categoriaId', 'materialId'));
}

public function create() {
    $categorias = \App\Models\categoria::all(); // Obtenemos las categorías para el select
    return view('materiales_crear', compact('categorias'));
}

public function store(Request $request) {
    // Validamos los datos según las columnas de tu tabla materiales
    $request->validate([
        'nombre' => 'required',
        'codigo' => 'required',
        'medidas' => 'required',
        'fk_id_categoria' => 'required'
    ]);

    // Creamos el registro
    \App\Models\materiales::create($request->all());

    return redirect('/materiales')->with('success', 'Material agregado correctamente');
}
protected $fillable = ['nombre', 'codigo', 'medidas', 'fk_id_categoria', 'ficha_tecnica'];
}


