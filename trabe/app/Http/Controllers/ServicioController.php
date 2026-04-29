<?php

namespace App\Http\Controllers;

use App\Models\servicio as Servicio;
use App\Models\manoobra as ManoObra;
use App\Models\proveedores as Proveedor;
use App\Models\categoria as Categoria;
use Illuminate\Http\Request;
use Exception;

class ServicioController extends Controller
{
    public function index()
    {
        $servicios = Servicio::with(['categoria', 'manoObra.proveedor'])->get();
        return view('servicios.manodeobra', compact('servicios'));
    }

    public function agregar()
    {
        $categorias = Categoria::all();
        return view('servicios.manoobraagregar', compact('categorias'));
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50|unique:servicio,nombre',
            'fk_id_categoria' => 'required|exists:categoria,ID_Categoria',
        ]);

        try {
            Servicio::create($request->only(['nombre', 'fk_id_categoria']));
            return redirect()->route('mano.de.obra')->with('success', 'Servicio base creado. Ahora puedes editarlo para asignarle mano de obra y precios.');
        } catch (Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Error al guardar: ' . $e->getMessage()]);
        }
    }

    public function editar($id)
    {
        $servicio = Servicio::with('manoObra.proveedor')->findOrFail($id);
        $categorias = Categoria::all();
        
        $proveedores = Proveedor::whereIn('tipo', ['Servicios', 'Ambos'])->get();
        
        return view('servicios.manoobraagregar', compact('servicio', 'categorias', 'proveedores'));
    }

    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:50|unique:servicio,nombre,' . $id . ',ID_servicio',
            'fk_id_categoria' => 'required|exists:categoria,ID_Categoria',
        ]);

        try {
            $servicio = Servicio::findOrFail($id);
            $servicio->update($request->only(['nombre', 'fk_id_categoria']));

            return redirect()->route('mano.de.obra')->with('success', 'Servicio actualizado correctamente.');
        } catch (Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Error al actualizar: ' . $e->getMessage()]);
        }
    }

    public function eliminar($id)
    {
        try {
            $servicio = Servicio::findOrFail($id);
            ManoObra::where('fk_id_servicio', $id)->delete();
            $servicio->delete();

            return redirect()->route('mano.de.obra')->with('success', 'Servicio eliminado correctamente.');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Error al eliminar: ' . $e->getMessage()]);
        }
    }

    // =========================================================================
    // FUNCIONES DE VINCULACIÓN (MANO DE OBRA)
    // =========================================================================

    public function vincularProveedor(Request $request)
    {
        $request->validate([
            'fk_id_servicio' => 'required|exists:servicio,ID_servicio',
            'fk_id_proveedor' => 'required|exists:proveedores,ID_proveedor',
            'unidad' => 'required|string|max:15',
            'precio' => 'required|numeric|min:0',
        ]);

        try {
            $existe = ManoObra::where('fk_id_servicio', $request->fk_id_servicio)
                              ->where('fk_id_proveedor', $request->fk_id_proveedor)
                              ->first();

            if ($existe) {
                $existe->update([
                    'precio' => $request->precio,
                    'unidad' => $request->unidad
                ]);
                $mensaje = "Precio y unidad de medida actualizados correctamente.";
            } else {
                ManoObra::create($request->all());
                $mensaje = "Mano de obra vinculada al servicio correctamente.";
            }

            return back()->with('success', $mensaje);
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Error al vincular: ' . $e->getMessage()]);
        }
    }

    public function desvincularProveedor($id_servicio, $id_proveedor)
    {
        try {
            ManoObra::where('fk_id_servicio', $id_servicio)
                    ->where('fk_id_proveedor', $id_proveedor)
                    ->delete();

            return back()->with('success', 'Proveedor desvinculado de este servicio correctamente.');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'No se pudo desvincular: ' . $e->getMessage()]);
        }
    }
}