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
        return view('proveedores.proveedores-agregar');
    }

    public function guardar(Request $request)
    {
        // Evitamos proveedores duplicados por nombre, correo o teléfono
        $request->validate([
            'nombre' => 'required|string|max:50|unique:proveedores,nombre',
            'nombre_contacto' => 'required|string|max:50',
            'telefono' => 'required|unique:proveedores,telefono',
            'correo_e' => 'required|email|unique:proveedores,correo_e',
            'direccion' => 'required|string|max:80',
            'tipo' => 'required|in:Materiales,Servicios,Ambos',
        ]);

        Proveedor::create($request->all());

        return redirect()->route('proveedores')->with('success', 'Proveedor creado correctamente.');
    }

    public function editar($id)
    {
        $proveedor = Proveedor::with(['abastecimiento.materiales', 'manoObra.servicio'])->findOrFail($id);
        
        $materiales = Material::all();
        $categorias = Categoria::all();
        $servicios = Servicio::all();

        return view('proveedores.proveedores-agregar', compact('proveedor', 'materiales', 'categorias', 'servicios'));
    }

    public function actualizar(Request $request, $id)
    {
        // Al actualizar, pedimos que sea único pero ignorando el registro actual ($id)
        $request->validate([
            'nombre' => 'required|string|max:50|unique:proveedores,nombre,'.$id.',ID_proveedor',
            'nombre_contacto' => 'required|string|max:50',
            'telefono' => 'required|unique:proveedores,telefono,'.$id.',ID_proveedor',
            'correo_e' => 'required|email|unique:proveedores,correo_e,'.$id.',ID_proveedor',
            'direccion' => 'required|string|max:80',
            'tipo' => 'required|in:Materiales,Servicios,Ambos',
        ]);

        $proveedor = Proveedor::findOrFail($id);
        $proveedor->update($request->all());

        return redirect()->route('proveedores')->with('success', 'Proveedor actualizado.');
    }

    // =========================================================================
    // FUNCIONES DE VINCULACIÓN: MATERIALES (Manejando Duplicados)
    // =========================================================================

    public function vincularMaterial(Request $request)
    {
        $request->validate([
            'fk_id_proveedor' => 'required|exists:proveedores,ID_proveedor',
            'fk_id_material' => 'required|exists:materiales,ID_Material',
            'precio' => 'required|numeric|min:0',
        ]);

        // Buscamos si ya existe la relación para evitar duplicidad de filas
        $existe = Abastecimiento::where('fk_id_proveedor', $request->fk_id_proveedor)
                                ->where('fk_id_material', $request->fk_id_material)
                                ->first();

        if ($existe) {
            $existe->update(['precio' => $request->precio]);
            $mensaje = "El material ya estaba vinculado. Se ha actualizado el precio.";
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

            return back()->with('success', 'Material desvinculado correctamente.');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Error al desvincular: ' . $e->getMessage()]);
        }
    }

    // =========================================================================
    // FUNCIONES DE VINCULACIÓN: SERVICIOS (Manejando Duplicados)
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
            $mensaje = "El servicio ya estaba vinculado. Se han actualizado los datos.";
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

            return back()->with('success', 'Servicio desvinculado correctamente.');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Error al desvincular: ' . $e->getMessage()]);
        }
    }

    public function eliminar($id)
    {
        try {
            DB::beginTransaction();
            $proveedor = Proveedor::findOrFail($id);
            
            // Borrado físico de vínculos para mantener limpia la DB
            Abastecimiento::where('fk_id_proveedor', $id)->delete();
            ManoObra::where('fk_id_proveedor', $id)->delete();
            
            $proveedor->delete();

            DB::commit();
            return redirect()->route('proveedores')->with('success', 'Proveedor eliminado.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'No se pudo eliminar: ' . $e->getMessage()]);
        }
    }
}