<?php

namespace App\Http\Controllers;

use App\Models\proveedores as Proveedor;
use Illuminate\Http\Request;
use App\Models\materiales as Material;
use App\Models\categoria as Categoria;
use App\Models\abastecimiento as Abastecimiento;
use Illuminate\Support\Facades\DB;

class ProveedorController extends Controller
{
    public function index()
    {
        $proveedores = Proveedor::all();
        return view('proveedores.proveedores', compact('proveedores'));
    }

    public function crear()
    {
        // Al crear uno nuevo, no necesitamos materiales ni categorías aún
        return view('proveedores.proveedores-agregar');
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'nombre_contacto' => 'required|string|max:50',
            'telefono' => 'required',
            'correo_e' => 'required|email',
            'direccion' => 'required|string|max:80',
            'tipo' => 'required|in:Materiales,Servicios,Ambos', // Validación del nuevo campo
        ]);

        Proveedor::create($request->all());

        // Nota: Asegúrate de que el nombre de la ruta sea 'proveedores' o 'proveedores.index'
        return redirect()->route('proveedores')->with('success', 'Proveedor creado correctamente.');
    }

    // Mostrar formulario de edición (AQUÍ ESTÁ EL CAMBIO PRINCIPAL)
    public function editar($id)
    {
        // 1. Cargamos el proveedor con sus materiales ya vinculados
        $proveedor = Proveedor::with('abastecimientos.material')->findOrFail($id);
        
        // 2. Cargamos materiales y categorías para el buscador y el modal
        $materiales = Material::all();
        $categorias = Categoria::all();

        return view('proveedores.proveedores-agregar', compact('proveedor', 'materiales', 'categorias'));
    }

    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'nombre_contacto' => 'required|string|max:50',
            'telefono' => 'required',
            'correo_e' => 'required|email',
            'direccion' => 'required|string|max:80',
            'tipo' => 'required|in:Materiales,Servicios,Ambos',
        ]);

        $proveedor = Proveedor::findOrFail($id);
        $proveedor->update($request->all());

        return redirect()->route('proveedores.proveedores')->with('success', 'Proveedor actualizado.');
    }

    // Nueva función para vincular un material y precio desde la vista de edición
    public function vincularMaterial(Request $request)
    {
        $request->validate([
            'fk_id_proveedor' => 'required|exists:proveedores,ID_Proveedor',
            'fk_id_material' => 'required|exists:materiales,ID_Material',
            'precio' => 'required|numeric|min:0',
        ]);

        // Verificamos si ya existe esa relación para no duplicarla
        $existe = Abastecimiento::where('fk_id_proveedor', $request->fk_id_proveedor)
                                ->where('fk_id_material', $request->fk_id_material)
                                ->first();

        if ($existe) {
            $existe->update(['precio' => $request->precio]);
            $mensaje = "Precio actualizado para este material.";
        } else {
            Abastecimiento::create($request->all());
            $mensaje = "Material vinculado al proveedor correctamente.";
        }

        return back()->with('success', $mensaje);
    }

    // Eliminar proveedor
    public function eliminar($id)
    {
        try {
            DB::beginTransaction();
            $proveedor = Proveedor::findOrFail($id);
            
            // Borramos sus vínculos de precios antes de borrar al proveedor
            $proveedor->abastecimientos()->delete();
            $proveedor->delete();

            DB::commit();
            return redirect()->route('proveedores')->with('success', 'Proveedor y sus vínculos eliminados.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'No se pudo eliminar: ' . $e->getMessage()]);
        }
    }
}