<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes; 

class preciohistorico extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = "preciohistorico"; 
    protected $primaryKey = "ID_preciohist";
    public $incrementing = true;
    protected $keyType = "int";
    
    protected $ID_preciohist;
    protected $precio;
    protected $fk_id_material;
    protected $fk_id_proveedor;
    protected $fecha_ini;
    protected $fecha_fin;
    
    protected $fillable = [
        "ID_preciohist",
        "precio",
        "fk_id_material",
        "fk_id_proveedor",
        "fecha_ini",
        "fecha_fin"
    ];
    
    public $timestamps = false;
}
