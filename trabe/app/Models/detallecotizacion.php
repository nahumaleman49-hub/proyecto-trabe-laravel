<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\manoobra as ManoObra;
use App\Models\materiales as Material;
use App\Models\proveedores as Proveedor;

class detallecotizacion extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = "detallecotizacion"; 
    protected $primaryKey = "ID_DetalleCotiza";
    public $incrementing = true;
    protected $keyType = "int";
    
    protected $ID_DetalleCotiza;
    protected $fk_id_material;
    protected $fk_id_proveedor;
    protected $fk_id_cotizacion;
    protected $cantidad;
    protected $precio_unit;
    protected $tiempo_entrega_dias;
    protected $fk_id_mano_obra;
    
    protected $fillable = [
        "ID_DetalleCotiza",
        "fk_id_material",
        "fk_id_proveedor",
        "fk_id_cotizacion",
        "cantidad",
        "precio_unit",
        "tiempo_entrega_dias",
        "fk_id_mano_obra"
    ];
    
    public $timestamps = false;
    public function manoObra(){
        return $this->belongsTo(ManoObra::class, 'fk_id_mano_obra', 'ID_mano_obra');
    }

    public function material(){
        return $this->belongsTo(Material::class, 'fk_id_material', 'ID_Material');
    }

    public function proveedor(){
        return $this->belongsTo(Proveedor::class, 'fk_id_proveedor', 'ID_proveedor');
    }
}