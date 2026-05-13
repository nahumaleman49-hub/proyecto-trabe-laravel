<?php

namespace App\Http\Controllers;

use App\Models\clientes as Cliente;
use App\Models\categoria as Categoria;
use App\Models\materiales as materiales;
use App\Models\abastecimiento as Abastecimiento;
use App\Models\servicio as Servicio;
use App\Models\manoobra as ManoObra;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function clientes(Request $request)
    {
        $term = $request->get('q');
        $clientes = Cliente::where('nombre', 'like', "%{$term}%")
            ->get(['ID_cliente as id', 'nombre as text', 'telefono', 'direccion']);
        return response()->json($clientes);
    }

    public function categoriasMateriales()
    {
        $cats = Categoria::whereHas('materiales')->get(['ID_Categoria as id', 'nombre as text']);
        return response()->json($cats);
    }

    public function materialesPorCategoria($id)
    {
        $materiales = materiales::where('fk_id_categoria', $id)
            ->get(['ID_Material as id', 'nombre as text', 'medidas']);
        return response()->json($materiales);
    }

    public function proveedoresPorMaterial($id)
    {
        $rows = Abastecimiento::with('proveedor')
            ->where('fk_id_material', $id)
            ->whereNull('deleted_at')
            ->get();

        // Devuelve JSON plano con las claves exactas que usa el JS en nueva.blade.php:
        //   ID_prod  → value del <option> (ID de abastecimiento, lo que guarda el backend)
        //   id       → ID_proveedor (guardado en data-proveedor-id por si se necesita)
        //   text     → nombre del proveedor (se muestra en el label del <option>)
        //   precio   → precio unitario (guardado en data-precio)
        $data = $rows->map(fn($a) => [
            'ID_prod' => $a->ID_prod,
            'id'      => $a->fk_id_proveedor,
            'text'    => $a->proveedor->nombre ?? 'Sin nombre',
            'precio'  => $a->precio,
        ]);

        return response()->json($data);
    }

    public function categoriasServicios()
    {
        $cats = Categoria::whereHas('servicios')->get(['ID_Categoria as id', 'nombre as text']);
        return response()->json($cats);
    }

    public function serviciosPorCategoria($id)
    {
        // Devuelve los servicios únicos de la categoría.
        // El segundo select (proveedor) se carga con el ID_servicio.
        $servicios = Servicio::where('fk_id_categoria', $id)
            ->get(['ID_servicio as id', 'nombre as text']);
        return response()->json($servicios);
    }

    public function proveedoresPorServicio($id)
    {
        // $id es el ID_servicio elegido.
        // Cada fila de manoobra es un proveedor distinto para ese servicio.
        // El JS usa p.id como value del <option> → es el ID_mano_obra que
        // guarda DetalleServicio (fk_id_mano_obra) en el backend.
        $rows = ManoObra::with('proveedor')
            ->where('fk_id_servicio', $id)
            ->get();

        // Claves exactas que usa el JS en nueva.blade.php:
        //   id      → ID_mano_obra  (value del <option>, lo que guarda el backend)
        //   text    → nombre del proveedor
        //   precio  → precio unitario (guardado en data-precio)
        //   unidad  → unidad de medida (guardado en data-unidad)
        $data = $rows->map(fn($m) => [
            'id'     => $m->ID_mano_obra,
            'text'   => $m->proveedor->nombre ?? 'Sin nombre',
            'precio' => $m->precio,
            'unidad' => $m->unidad ?? '',
        ]);

        return response()->json($data);
    }
}