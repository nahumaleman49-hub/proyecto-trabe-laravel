<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class proyecto extends Model
{
    use HasFactory;
    
    protected $table = "proyecto"; 
    protected $primaryKey = "ID_proyecto";
    public $incrementing = true;
    protected $keyType = "int";
    
    protected $ID_proyecto;
    protected $nombre;
    protected $fk_id_cliente;
    protected $estado;
    protected $fecha_ini;
    protected $fecha_fin;
    protected $presupuesto;
    
    protected $fillable = [
        "ID_proyecto",
        "nombre",
        "fk_id_cliente",
        "estado",
        "fecha_ini",
        "fecha_fin",
        "presupuesto"
    ];
    
    public $timestamps = false;
}
