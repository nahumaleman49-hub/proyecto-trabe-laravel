<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class proveedores extends Model
{
    use HasFactory;
    
    protected $table = "proveedores"; 
    protected $primaryKey = "ID_proveedor";
    public $incrementing = true;
    protected $keyType = "int";
    
    protected $ID_proveedor;
    protected $nombre;
    protected $nombre_contacto;
    protected $telefono;
    protected $correo_e;
    protected $direccion;
    
    protected $fillable = [
        "ID_proveedor",
        "nombre",
        "nombre_contacto",
        "telefono",
        "correo_e",
        "direccion"
    ];
    
    public $timestamps = false;
}
