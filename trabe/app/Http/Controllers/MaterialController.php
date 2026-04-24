<?php

namespace App\Http\Controllers;

use App\Models\materiales as Material;
use App\Models\categoria as Categoria;
use App\Models\proveedores as Proveedor; 
use App\Models\abastecimiento as Abastecimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Para las transacciones seguras
use Exception; // Para el manejo de errores

class MaterialController extends Controller
{
    public function index(Request $request)
    {
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
        
        // Opcional: Si ya agregaste el campo 'tipo' en la DB, podrías filtrar aquí 
        // para que no salgan los plomeros/electricistas en la lista de materiales
        // $proveedores = Proveedor::where('tipo', '!=', 'Servicios')->get();
        $proveedores = Proveedor::all(); 
        
        return view('materiales.materialesagregar', compact('categorias', 'proveedores'));
    }

    public function guardar(Request $request)
    {
        $request->validate([
            // Agregamos la regla 'unique' para evitar duplicados en la base de datos
            'nombre' => 'required|string|max:100|unique:materiales,nombre',
            'codigo' => 'required|string|max:20|unique:materiales,codigo',
            'medidas' => 'required|string|max:20',
            'fk_id_categoria' => 'required|exists:categoria,ID_Categoria',
            'precio' => 'required|numeric|min:0',
            'fk_id_proveedor' => 'required|exists:proveedores,ID_Proveedor',
        ]);

        try {
            DB::beginTransaction();

            $material = Material::create($request->only(['nombre', 'codigo', 'medidas', 'fk_id_categoria'])); 

            if (!$material || !$material->ID_Material) {
                throw new Exception("Error al obtener el ID del material creado.");
            }

            Abastecimiento::create([
                'fk_id_material' => $material->ID_Material, 
                'fk_id_proveedor' => $request->fk_id_proveedor,
                'precio' => $request->precio
            ]);

            DB::commit();
            return redirect()->route('materiales.index')->with('success', 'Material y precio inicial agregados.');
            
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Ocurrió un error al guardar: ' . $e->getMessage()]);
        }
    }

    public function editar($id)
    {
        // Traemos también las relaciones para poder ver la tabla de proveedores actuales
        $material = Material::with('abastecimientos.proveedor')->findOrFail($id);
        $categorias = Categoria::all();
        $proveedores = Proveedor::all();
        
        return view('materiales.materialesagregar', compact('material', 'categorias', 'proveedores'));
    }

    public function actualizar(Request $request, $id)
    {
        $request->validate([
            // Le decimos a unique que ignore el ID actual, así permite actualizar sin cambiar el nombre
            'nombre' => 'required|string|max:100|unique:materiales,nombre,' . $id . ',ID_Material',
            'codigo' => 'required|string|max:20|unique:materiales,codigo,' . $id . ',ID_Material',
            'medidas' => 'required|string|max:20',
            'fk_id_categoria' => 'required|exists:categoria,ID_Categoria',
        ]);

        try {
            $material = Material::findOrFail($id);
            $material->update($request->only(['nombre', 'codigo', 'medidas', 'fk_id_categoria'])); 

            return redirect()->route('materiales.index')->with('success', 'Material actualizado correctamente.');
        } catch (Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Error al actualizar: ' . $e->getMessage()]);
        }
    }

    public function eliminar($id)
    {
        try {
            DB::beginTransaction();
            
            $material = Material::findOrFail($id);
            $material->abastecimientos()->delete(); 
            $material->delete();

            DB::commit();
            return redirect()->route('materiales.index')->with('success', 'Material eliminado correctamente.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al eliminar el material: ' . $e->getMessage()]);
        }
    }

    // =========================================================================
    // NUEVA FUNCIÓN PARA LA VENTANA EMERGENTE (AJAX)
    // =========================================================================
    public function guardarRapido(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:100|unique:materiales,nombre',
                'codigo' => 'required|string|max:20|unique:materiales,codigo',
                'medidas' => 'required|string|max:20',
                'fk_id_categoria' => 'required|exists:categoria,ID_Categoria',
            ]);

            $material = Material::create($request->only(['nombre', 'codigo', 'medidas', 'fk_id_categoria']));

            // Devolvemos un JSON para que Javascript lo procese sin recargar
            return response()->json([
                'success' => true,
                'material' => [
                    'id' => $material->ID_Material, 
                    'nombre' => $material->nombre
                ],
                'mensaje' => 'Material creado correctamente'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Error de validación (Ej. Nombre duplicado)
            return response()->json([
                'success' => false,
                'mensaje' => 'Verifique sus datos. Es posible que el código o nombre ya existan.',
                'errores' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            // Error de servidor o base de datos
            return response()->json([
                'success' => false,
                'mensaje' => 'Error del servidor: ' . $e->getMessage()
            ], 500);
        }
    }
}