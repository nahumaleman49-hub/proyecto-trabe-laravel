<?php

namespace App\Http\Controllers;

use App\Models\materiales as Material;
use App\Models\categoria as Categoria;
use App\Models\proveedores as Proveedor; // 
use App\Models\abastecimiento as Abastecimiento;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        // 1. CARGAMOS LA NUEVA RELACIÓN
        // Ahora traemos la categoría, los abastecimientos y el proveedor asociado a cada abastecimiento
        $query = Material::with(['categoria', 'abastecimientos.proveedor']);

        if ($request->has('buscar') && $request->buscar != '') {
            $termino = $request->buscar;
            
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
        $categorias = Categoria::all(); 
        $proveedores = Proveedor::all(); // 2. Traemos los proveedores para poder asignar un precio inicial
        
        return view('materiales.materialesagregar', compact('categorias', 'proveedores'));
    }

    public function guardar(Request $request)
    {
        // 3. ACTUALIZAMOS LA VALIDACIÓN
        $request->validate([
            'nombre' => 'required|string|max:100',
            'codigo' => 'required|string|max:20',
            'medidas' => 'required|string|max:20',
            'fk_id_categoria' => 'required|exists:categoria,ID_Categoria',
            // Validaciones para el precio inicial en abastecimiento:
            'precio' => 'required|numeric|min:0',
            'fk_id_proveedor' => 'required|exists:proveedores,ID_Proveedor',
        ]);

        // 4. GUARDAMOS EN DOS TABLAS DISTINTAS
        // Primero creamos el material (usamos solo los campos que pertenecen a la tabla materiales)
        $material = Material::create($request->only(['nombre', 'codigo', 'medidas', 'fk_id_categoria'])); 

        // Luego creamos el registro de abastecimiento (el precio ligado al proveedor y al nuevo material)
        Abastecimiento::create([
            'fk_id_material' => $material->ID_Material, // Usa la llave primaria de tu modelo material
            'fk_id_proveedor' => $request->fk_id_proveedor,
            'precio' => $request->precio
        ]);

        return redirect()->route('materiales.index')->with('success', 'Material y precio inicial agregados.');
    }

    public function editar($id)
    {
        $material = Material::findOrFail($id);
        $categorias = Categoria::all();
        // Solo pasamos categorías porque aquí editaremos la información general del material
        return view('materiales.materialesagregar', compact('material', 'categorias'));
    }

    public function actualizar(Request $request, $id)
    {
        // 5. REMOVEMOS PRECIO DE LA ACTUALIZACIÓN
        // Al actualizar, solo modificamos los datos básicos. 
        // (Los precios se gestionan ahora por proveedor en su propia sección o tabla).
        $request->validate([
            'nombre' => 'required|string|max:100',
            'codigo' => 'required|string|max:20',
            'medidas' => 'required|string|max:20',
            'fk_id_categoria' => 'required|exists:categoria,ID_Categoria',
        ]);

        $material = Material::findOrFail($id);
        
        // Usamos only() para asegurar que no intentamos guardar un precio o proveedor directamente en la tabla material
        $material->update($request->only(['nombre', 'codigo', 'medidas', 'fk_id_categoria'])); 

        return redirect()->route('materiales.index')->with('success', 'Material actualizado correctamente.');
    }

    public function eliminar($id)
    {
        $material = Material::findOrFail($id);
        
        // 6. ELIMINACIÓN EN CASCADA
        // Como el material tiene abastecimientos ligados, debemos borrarlos primero 
        // para que la base de datos no dé error por las llaves foráneas.
        $material->abastecimientos()->delete(); 
        
        // Finalmente borramos el material
        $material->delete();

        return redirect()->route('materiales.index')->with('success', 'Material eliminado correctamente.');
    }
}
