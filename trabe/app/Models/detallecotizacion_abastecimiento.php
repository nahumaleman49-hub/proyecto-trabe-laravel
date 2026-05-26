<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class detallecotizacion_abastecimiento extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = "detallecotizacion_abastecimiento"; 
    protected $primaryKey = "ID_det_ab";
    public $incrementing = true;
    protected $keyType = "int";
    
    protected $ID_det_ab;
    protected $fk_id_cotizacion;
    protected $fk_id_abastecimiento;
    protected $cantidad;
    
    
    protected $fillable = [
        "ID_det_ab",
        "fk_id_cotizacion",
        "fk_id_abastecimiento",
        "cantidad"
    ];

    public $timestamps = false;

    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class, 'fk_id_cotizacion', 'ID_cotizacion');
    }

    // Relación con el abastecimiento (que contiene material, proveedor y precio)
    public function abastecimiento()
    {
        return $this->belongsTo(Abastecimiento::class, 'fk_id_abastecimiento', 'ID_prod');
    }

    // Accesor para obtener el material a través del abastecimiento (opcional)
    public function getMaterialAttribute()
    {
        return $this->abastecimiento ? $this->abastecimiento->materiales : null;
    }

    // Accesor para obtener el proveedor a través del abastecimiento (opcional)
    public function getProveedorAttribute()
    {
        return $this->abastecimiento ? $this->abastecimiento->proveedor : null;
    }

    public function material()
    {
        return $this->hasOneThrough(
            materiales::class,
            abastecimiento::class,
            'ID_prod', // Foreign key on abastecimiento table
            'ID_Material', // Foreign key on Material table
            'fk_id_abastecimiento', // Local key on detallecotizacion_abastecimiento table
            'fk_id_material' // Local key on abastecimiento table
        );
    }
    public function proveedor()
    {
        return $this->hasOneThrough(
            proveedores::class,
            abastecimiento::class,
            'ID_prod', // Foreign key on abastecimiento table
            'ID_proveedor', // Foreign key on Proveedor table
            'fk_id_abastecimiento', // Local key on detallecotizacion_abastecimiento table
            'fk_id_proveedor' // Local key on abastecimiento table
        );
    }
}