<?php

namespace App\Http\Controllers;

use App\Models\materiales as Material;
use App\Models\categoria as Categoria;
use App\Models\proveedores as Proveedor; 
use App\Models\abastecimiento as Abastecimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

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
        
        // ¡CUMPLIENDO EL PENDIENTE #5! 
        // Ya no cargamos los proveedores aquí porque crear un material 
        // debe ser independiente de asignarle un proveedor.
        return view('materiales.materialesagregar', compact('categorias'));
    }

    public function guardar(Request $request)
    {
        // ¡CUMPLIENDO EL PENDIENTE #5!
        // Limpiamos la validación. Ya no exigimos 'precio' ni 'fk_id_proveedor'
        $request->validate([
            'nombre' => 'required|string|max:100|unique:materiales,nombre',
            'codigo' => 'required|string|max:20|unique:materiales,codigo',
            'medidas' => 'required|string|max:20',
            'fk_id_categoria' => 'required|exists:categoria,ID_Categoria',
        ]);

        try {
            // Creamos el material limpio, sin transacciones pesadas porque es una sola tabla
            Material::create($request->only(['nombre', 'codigo', 'medidas', 'fk_id_categoria'])); 

            return redirect()->route('materiales.index')->with('success', 'Material creado. Ahora puedes editarlo para asignarle proveedores y precios.');
            
        } catch (Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Ocurrió un error al guardar: ' . $e->getMessage()]);
        }
    }

    public function editar($id)
    {
        $material = Material::with('abastecimientos.proveedor')->findOrFail($id);
        $categorias = Categoria::all();
        
        // Lógica bidireccional: Solo traemos proveedores que vendan materiales
        $proveedores = Proveedor::whereIn('tipo', ['Materiales', 'Ambos'])->get();
        
        return view('materiales.materialesagregar', compact('material', 'categorias', 'proveedores'));
    }

    public function actualizar(Request $request, $id)
    {
        $request->validate([
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
    // FUNCIONES DE VINCULACIÓN (LÓGICA BIDIRECCIONAL Y PENDIENTE #7)
    // =========================================================================

    public function vincularProveedor(Request $request)
    {
        $request->validate([
            'fk_id_material' => 'required|exists:materiales,ID_Material',
            'fk_id_proveedor' => 'required|exists:proveedores,ID_proveedor',
            'precio' => 'required|numeric|min:0',
        ]);

        $existe = Abastecimiento::where('fk_id_material', $request->fk_id_material)
                                ->where('fk_id_proveedor', $request->fk_id_proveedor)
                                ->first();

        if ($existe) {
            $existe->update(['precio' => $request->precio]);
            $mensaje = "Precio actualizado correctamente.";
        } else {
            Abastecimiento::create($request->all());
            $mensaje = "Proveedor vinculado al material correctamente.";
        }

        return back()->with('success', $mensaje);
    }

    // ¡CUMPLIENDO EL PENDIENTE #7! (Desvincular en caso de que deje de surtir)
    public function desvincularProveedor($ID_Material, $ID_proveedor)
    {
        try {
            Abastecimiento::where('fk_id_material', $ID_Material)
                          ->where('fk_id_proveedor', $ID_proveedor)
                          ->delete();

            return back()->with('success', 'Proveedor desvinculado correctamente.');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'No se pudo desvincular: ' . $e->getMessage()]);
        }
    }

    // =========================================================================
    // FUNCIÓN PARA LA VENTANA EMERGENTE (AJAX)
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

            return response()->json([
                'success' => true,
                'material' => [
                    'id' => $material->ID_Material, 
                    'nombre' => $material->nombre
                ],
                'mensaje' => 'Material creado correctamente'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Verifique sus datos. Es posible que el código o nombre ya existan.',
                'errores' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Error del servidor: ' . $e->getMessage()
            ], 500);
        }
    }
}