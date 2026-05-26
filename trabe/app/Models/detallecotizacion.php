<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class detallecotizacion extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = "detallecotizacion"; 
    protected $primaryKey = "ID_DetalleCotiza";
    public $incrementing = true;
    protected $keyType = "int";
    
    protected $ID_DetalleCotiza;
    protected $fk_id_cotizacion;
    protected $cantidad;
    protected $fk_id_mano_obra;
    
    protected $fillable = [
        "ID_DetalleCotiza",
        "fk_id_cotizacion",
        "cantidad",
        "precio_unit",
        "fk_id_mano_obra"
    ];
    public $timestamps = false;

    // Relación con Cotizacion
    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class, 'fk_id_cotizacion', 'ID_cotizacion');
    }

    // Relación con Material (cuando es material)
    public function material()
    {
        return $this->belongsTo(Material::class, 'fk_id_material', 'ID_Material');
    }

    // Relación con Proveedor (tanto para material como para mano de obra)
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'fk_id_proveedor', 'ID_proveedor');
    }

    // Relación con ManoObra (cuando es servicio)
    public function manoObra()
    {
        return $this->belongsTo(ManoObra::class, 'fk_id_mano_obra', 'ID_mano_obra');
    }
}