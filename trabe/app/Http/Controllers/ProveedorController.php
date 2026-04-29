<?php

namespace App\Http\Controllers;

use App\Models\proveedores as Proveedor;
use Illuminate\Http\Request;
use App\Models\materiales as Material;
use App\Models\categoria as Categoria;
use App\Models\abastecimiento as Abastecimiento;
use App\Models\servicio as Servicio;
use App\Models\manoobra as ManoObra;
use Illuminate\Support\Facades\DB;
use Exception;

class ProveedorController extends Controller
{
    public function index()
    {
        $proveedores = Proveedor::all();
        return view('proveedores.proveedores', compact('proveedores'));
    }

    public function crear()
    {
        // Al crear uno nuevo, no necesitamos relaciones aún
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
            'tipo' => 'required|in:Materiales,Servicios,Ambos',
        ]);

        Proveedor::create($request->all());

        return redirect()->route('proveedores')->with('success', 'Proveedor creado correctamente.');
    }

    public function editar($id)
    {
        // 1. Cargamos el proveedor con sus materiales y servicios ya vinculados
        $proveedor = Proveedor::with(['abastecimientos.material', 'manoObra.servicio'])->findOrFail($id);
        
        // 2. Cargamos catálogos completos para los selectores
        $materiales = Material::all();
        $categorias = Categoria::all();
        $servicios = Servicio::all();

        return view('proveedores.proveedores-agregar', compact('proveedor', 'materiales', 'categorias', 'servicios'));
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

        return redirect()->route('proveedores')->with('success', 'Proveedor actualizado.');
    }

    // =========================================================================
    // FUNCIONES DE VINCULACIÓN: MATERIALES
    // =========================================================================

    public function vincularMaterial(Request $request)
    {
        $request->validate([
            'fk_id_proveedor' => 'required|exists:proveedores,ID_proveedor',
            'fk_id_material' => 'required|exists:materiales,ID_Material',
            'precio' => 'required|numeric|min:0',
        ]);

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

    public function desvincularMaterial($id_proveedor, $id_material)
    {
        try {
            Abastecimiento::where('fk_id_proveedor', $id_proveedor)
                          ->where('fk_id_material', $id_material)
                          ->delete();

            return back()->with('success', 'Material desvinculado de este proveedor correctamente.');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'No se pudo desvincular el material: ' . $e->getMessage()]);
        }
    }

    // =========================================================================
    // FUNCIONES DE VINCULACIÓN: SERVICIOS
    // =========================================================================

    public function vincularServicio(Request $request)
    {
        $request->validate([
            'fk_id_proveedor' => 'required|exists:proveedores,ID_proveedor',
            'fk_id_servicio' => 'required|exists:servicio,ID_servicio',
            'unidad' => 'required|string|max:15',
            'precio' => 'required|numeric|min:0',
        ]);

        $existe = ManoObra::where('fk_id_proveedor', $request->fk_id_proveedor)
                          ->where('fk_id_servicio', $request->fk_id_servicio)
                          ->first();

        if ($existe) {
            $existe->update([
                'precio' => $request->precio,
                'unidad' => $request->unidad
            ]);
            $mensaje = "Precio y unidad actualizados para este servicio.";
        } else {
            ManoObra::create($request->all());
            $mensaje = "Servicio vinculado al proveedor correctamente.";
        }

        return back()->with('success', $mensaje);
    }

    public function desvincularServicio($id_proveedor, $id_servicio)
    {
        try {
            ManoObra::where('fk_id_proveedor', $id_proveedor)
                    ->where('fk_id_servicio', $id_servicio)
                    ->delete();

            return back()->with('success', 'Servicio desvinculado de este proveedor correctamente.');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'No se pudo desvincular el servicio: ' . $e->getMessage()]);
        }
    }

    // =========================================================================
    // ELIMINACIÓN DE PROVEEDOR
    // =========================================================================

    public function eliminar($id)
    {
        try {
            DB::beginTransaction();
            $proveedor = Proveedor::findOrFail($id);
            
            // Borramos sus vínculos en ambas tablas antes de borrar al proveedor
            Abastecimiento::where('fk_id_proveedor', $id)->delete();
            ManoObra::where('fk_id_proveedor', $id)->delete();
            
            $proveedor->delete();

            DB::commit();
            return redirect()->route('proveedores')->with('success', 'Proveedor y sus vínculos eliminados.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'No se pudo eliminar: ' . $e->getMessage()]);
        }
    }
}