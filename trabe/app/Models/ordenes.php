<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes; 

class ordenes extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = "ordenes"; 
    protected $primaryKey = "ID_Orden";
    public $incrementing = true;
    protected $keyType = "int";
    
    protected $ID_Orden;
    protected $fk_id_proyecto;
    protected $no_orden;
    protected $fecha;
    
    protected $fillable = [
        "ID_Orden",
        "fk_id_proyecto",
        "no_orden",
        "fecha"
    ];
    
    public $timestamps = false;
}
