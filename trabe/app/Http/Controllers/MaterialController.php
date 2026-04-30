<?php

namespace App\Http\Controllers;

use App\Models\materiales as Material;
use App\Models\categoria as Categoria;
use App\Models\proveedores as Proveedor; 
use App\Models\abastecimiento as abastecimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class MaterialController extends Controller
{
    /**
     * Lista principal de materiales con buscador
     */
    public function index(Request $request)
    {
        $query = Material::with(['categoria', 'abastecimiento.proveedor']);

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

    /**
     * Formulario para agregar material
     */
    public function agregar()
    {
        $categorias = Categoria::all(); 
        return view('materiales.materialesagregar', compact('categorias'));
    }

    /**
     * Guardar nuevo material
     */
    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:materiales,nombre',
            'codigo' => 'required|string|max:20|unique:materiales,codigo',
            'medidas' => 'required|string|max:20',
            'fk_id_categoria' => 'required|exists:categoria,ID_Categoria',
        ]);

        try {
            Material::create($request->only(['nombre', 'codigo', 'medidas', 'fk_id_categoria'])); 
            return redirect()->route('materiales.index')->with('success', 'Material creado exitosamente.');
        } catch (Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Ocurrió un error al guardar: ' . $e->getMessage()]);
        }
    }

    /**
     * Formulario de edición
     */
    public function editar($id)
    {
        $material = Material::with('abastecimiento.proveedor')->findOrFail($id);
        $categorias = Categoria::all();
        $proveedores = Proveedor::whereIn('tipo', ['Materiales', 'Ambos'])->get();
        
        return view('materiales.materialesagregar', compact('material', 'categorias', 'proveedores'));
    }

    /**
     * Actualizar material existente
     */
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

    /**
     * Eliminar material
     */
    public function eliminar($id)
    {
        try {
            DB::beginTransaction();
            $material = Material::findOrFail($id);
            abastecimiento::where('fk_id_material', $id)->delete();
            $material->delete();
            DB::commit();
            return redirect()->route('materiales.index')->with('success', 'Material eliminado correctamente.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al eliminar: ' . $e->getMessage()]);
        }
    }

    /**
     * Vinculación individual (Manual)
     */
    public function vincularProveedor(Request $request)
    {
        $request->validate([
            'fk_id_material' => 'required|exists:materiales,ID_Material',
            'fk_id_proveedor' => 'required|exists:proveedores,ID_proveedor',
            'precio' => 'required|numeric|min:0',
        ]);

        abastecimiento::updateOrCreate(
            [
                'fk_id_material' => $request->fk_id_material,
                'fk_id_proveedor' => $request->fk_id_proveedor
            ],
            ['precio' => $request->precio]
        );

        return back()->with('success', 'Vinculación procesada correctamente.');
    }

    /**
     * Carga Masiva "TODO EN UNO" vía CSV
     * CORREGIDO: Sin columna 'unidad' en tabla abastecimiento
     */
    public function importarDesdeCSV(Request $request)
    {
        $request->validate([
            'fk_id_proveedor' => 'required|exists:proveedores,ID_proveedor',
            'archivo_csv' => 'required|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('archivo_csv');
        $handle = fopen($file->getRealPath(), 'r');
        fgetcsv($handle); // Ignorar encabezados

        try {
            DB::beginTransaction();
            $contador = 0;
            $ahora = now();

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if (count($data) >= 5) {
                    $codigo = trim($data[0]);
                    $nombre = trim($data[1]);
                    $catId  = trim($data[2]);
                    $medida = trim($data[3]);
                    $precio = (float)trim($data[4]);

                    // 1. Buscar el material por código o crearlo si no existe
                    $material = Material::updateOrCreate(
                        ['codigo' => $codigo],
                        [
                            'nombre' => $nombre,
                            'fk_id_categoria' => $catId,
                            'medidas' => $medida
                        ]
                    );

                    // 2. Vincular el precio al proveedor (Tabla Abastecimiento)
                    // CORRECCIÓN: Se quita 'unidad' para evitar SQLSTATE[42S22]
                    DB::table('abastecimiento')->updateOrInsert(
                        [
                            'fk_id_material' => $material->ID_Material,
                            'fk_id_proveedor' => $request->fk_id_proveedor
                        ],
                        [
                            'precio' => $precio,
                            'created_at' => $ahora,
                            'updated_at' => $ahora
                        ]
                    );
                    $contador++;
                }
            }

            fclose($handle);
            DB::commit();
            return back()->with('success', "Se procesaron $contador materiales exitosamente.");
            
        } catch (Exception $e) {
            DB::rollBack();
            if (isset($handle)) fclose($handle);
            return back()->withErrors(['error' => 'Error en la importación: ' . $e->getMessage()]);
        }
    }

    /**
     * Creación rápida (AJAX) para el Modal
     */
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

        } catch (Exception $e) {
            return response()->json(['success' => false, 'mensaje' => $e->getMessage()], 500);
        }
    }
}