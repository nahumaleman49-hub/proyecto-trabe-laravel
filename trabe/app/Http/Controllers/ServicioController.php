<?php

namespace App\Http\Controllers;

use App\Models\servicio as Servicio;
use App\Models\manoobra as ManoObra;
use App\Models\proveedores as Proveedor;
use App\Models\categoria as Categoria;
use Illuminate\Http\Request;

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
        $proveedores = Proveedor::all();
        return view('servicios.manoobraagregar', compact('categorias', 'proveedores'));
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'fk_id_categoria' => 'required|exists:categoria,ID_Categoria',
            'mano_obra' => 'required|array|min:1',
            'mano_obra.*.fk_id_proveedor' => 'required|exists:proveedores,ID_proveedor',
            'mano_obra.*.unidad' => 'required|string|max:15',
            'mano_obra.*.precio' => 'required|numeric|min:0',
        ]);

        $servicio = Servicio::create($request->only(['nombre', 'fk_id_categoria']));

        foreach ($request->mano_obra as $detalle) {
            $detalle['fk_id_servicio'] = $servicio->ID_servicio;
            ManoObra::create($detalle);
        }

        return redirect()->route('mano.de.obra')->with('success', 'Servicio creado correctamente.');
    }

    public function editar($id)
    {
        $servicio = Servicio::with('manoObra')->findOrFail($id);
        $categorias = Categoria::all();
        $proveedores = Proveedor::all();
        return view('servicios.manoobraagregar', compact('servicio', 'categorias', 'proveedores'));
    }

    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'fk_id_categoria' => 'required|exists:categoria,ID_Categoria',
            'mano_obra' => 'required|array|min:1',
            'mano_obra.*.fk_id_proveedor' => 'required|exists:proveedores,ID_proveedor',
            'mano_obra.*.unidad' => 'required|string|max:15',
            'mano_obra.*.precio' => 'required|numeric|min:0',
        ]);

        $servicio = Servicio::findOrFail($id);
        $servicio->update($request->only(['nombre', 'fk_id_categoria']));

        // Eliminar los detalles anteriores y crear los nuevos
        ManoObra::where('fk_id_servicio', $id)->delete();

        foreach ($request->mano_obra as $detalle) {
            $detalle['fk_id_servicio'] = $servicio->ID_servicio;
            ManoObra::create($detalle);
        }

        return redirect()->route('mano.de.obra')->with('success', 'Servicio actualizado correctamente.');
    }

    public function destory($id)
    {
        $servicio = Servicio::findOrFail($id);
        // Primero eliminar los detalles asociados
        ManoObra::where('fk_id_servicio', $id)->delete();
        // Soft delete del servicio
        $servicio->delete();

        return redirect()->route('servicios.manodeobra')->with('success', 'Servicio eliminado correctamente.');
    }
}