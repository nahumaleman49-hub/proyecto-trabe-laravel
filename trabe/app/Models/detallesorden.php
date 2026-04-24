<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes; 

class detallesorden extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = "detallesorden"; 
    protected $primaryKey = "ID_Detalle_orden";
    public $incrementing = true;
    protected $keyType = "int";
    
    protected $ID_Detalle_orden;
    protected $fk_id_orden;
    protected $fk_id_detalle_cotiza;
    protected $estado;
    
    protected $fillable = [
        "ID_Detalle_orden",
        "fk_id_orden",
        "fk_id_detalle_cotiza",
        "estado"
    ];
    
    public $timestamps = false;
}
