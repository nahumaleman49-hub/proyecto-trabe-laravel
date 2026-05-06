<?php

namespace App\Http\Controllers;

use App\Models\clientes as Cliente;
use App\Models\categoria as Categoria;
use App\Models\materiales as materiales;
use App\Models\abastecimiento as Abastecimiento;
use App\Models\servicio as Servicio; 
use App\Models\manoobra as ManoObra; // Ajustado a 'manoobra' según tu modelo
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
        // Usamos whereHas con el nombre de la relación definida en el modelo Categoria
        $cats = Categoria::whereHas('materiales')->get(['ID_Categoria as id', 'nombre as text']);
        return response()->json($cats);
    }

    public function materialesPorCategoria($id)
    {
        // Usamos ID_Material respetando las mayúsculas de tu modelo
        $materiales = materiales::where('fk_id_categoria', $id)
            ->get(['ID_Material as id', 'nombre as text', 'medidas']);
        return response()->json($materiales);
    }

    public function proveedoresPorMaterial($id)
    {
        // Cargamos la relación 'material' (singular) como definimos en el modelo abastecimiento
        $proveedores = Abastecimiento::with(['proveedor', 'materiales'])
            ->where('fk_id_material', $id)
            ->get()
            ->map(function ($ab) {
                return [
                    'id'      => $ab->proveedor->ID_proveedor ?? null,
                    'text'    => $ab->proveedor->nombre ?? 'Sin nombre',
                    'precio'  => $ab->precio,
                    'unidad'  => $ab->materiales->medidas ?? 'unid',
                    'id_prod' => $ab->ID_prod // IMPORTANTE: Usando tu llave primaria real
                ];
            });
        return response()->json($proveedores);
    }

    public function categoriasServicios()
    {
        $cats = Categoria::whereHas('servicios')->get(['ID_Categoria as id', 'nombre as text']);
        return response()->json($cats);
    }

    public function serviciosPorCategoria($id)
    {
        $servicios = Servicio::where('fk_id_categoria', $id)
            ->get(['ID_servicio as id', 'nombre as text']);
        return response()->json($servicios);
    }

    public function proveedoresPorServicio($id)
    {
        $proveedores = ManoObra::with('proveedor')
            ->where('fk_id_servicio', $id)
            ->get()
            ->map(function ($mo) {
                return [
                    'id'           => $mo->ID_mano_obra,
                    'text'         => ($mo->proveedor->nombre ?? 'Interno') . " - $" . number_format($mo->precio, 2),
                    'precio'       => $mo->precio,
                    'unidad'       => $mo->unidad,
                    'proveedor_id' => $mo->fk_id_proveedor 
                ];
            });
        return response()->json($proveedores);
    }
}