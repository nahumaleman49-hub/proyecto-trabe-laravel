<?php

namespace App\Http\Controllers;

use App\Models\clientes as Cliente;
use App\Models\categoria as Categoria;
use App\Models\materiales as Material;
use App\Models\abastecimiento as Abastecimiento;
use App\Models\servicio as Servicio;
use App\Models\manoobra as ManoObra;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function clientes(Request $request)
    {
        $term = $request->get('q');
        $clientes = Cliente::where('nombre', 'like', "%{$term}%")->get(['ID_cliente as id', 'nombre as text', 'telefono', 'direccion']);
        return response()->json($clientes);
    }

    public function categoriasMateriales()
    {
        $cats = Categoria::has('materiales')->get(['ID_Categoria as id', 'nombre as text']);
        return response()->json($cats);
    }

    public function materialesPorCategoria($id)
    {
    $materiales = Material::where('fk_id_categoria', $id)->get(['ID_Material as id', 'nombre as text', 'medidas']);
    return response()->json($materiales);
    }

    public function proveedoresPorMaterial($id)
    {
        $proveedores = Abastecimiento::with('proveedor')
            ->where('fk_id_material', $id)
            ->get()
            ->map(function ($ab) {
                return [
                    'id' => $ab->proveedor->ID_proveedor,
                    'text' => $ab->proveedor->nombre,
                    'precio' => $ab->precio,
                    'unidad' => $ab->material->medidas,
                ];
            });
        return response()->json($proveedores);
    }

    // Para servicios
    public function categoriasServicios()
    {
        $cats = Categoria::has('servicios')->get(['ID_Categoria as id', 'nombre as text']);
        return response()->json($cats);
    }

    public function serviciosPorCategoria($id)
    {
        $servicios = Servicio::where('fk_id_categoria', $id)->get(['ID_servicio as id', 'nombre as text']);
        return response()->json($servicios);
    }

    public function proveedoresPorServicio($id)
    {
        $proveedores = ManoObra::with('proveedor')
            ->where('fk_id_servicio', $id)
            ->get()
            ->map(function ($mo) {
                return [
                    'id' => $mo->proveedor->ID_proveedor,
                    'text' => $mo->proveedor->nombre,
                    'precio' => $mo->precio,
                    'unidad' => $mo->unidad,
                ];
            });
        return response()->json($proveedores);
    }
}