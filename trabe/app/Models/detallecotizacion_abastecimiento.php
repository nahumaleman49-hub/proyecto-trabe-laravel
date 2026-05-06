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

    public function abastecimiento()
    {
        return $this->belongsTo(abastecimiento::class, 'fk_id_abastecimiento', 'ID_prod');
    }

    public function cotizacion()
    {
        return $this->belongsTo(cotizacion::class, 'fk_id_cotizacion', 'ID_cotizacion');
        
    }
}