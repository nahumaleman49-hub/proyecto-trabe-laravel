<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes; 

class proveedores extends Model
{
    use HasFactory, SoftDeletes;
    
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
    protected $tipo;
    
    protected $fillable = [
        "ID_proveedor",
        "nombre",
        "nombre_contacto",
        "telefono",
        "correo_e",
        "direccion",
        "tipo"
        
    ];
    public function abastecimientos()
    {
        return $this->hasMany(abastecimiento::class, 'fk_id_proveedor', 'ID_proveedor');
    }

    public function manosDeObra()
    {
        return $this->hasMany(manoobra::class, 'fk_id_proveedor', 'ID_proveedor');
    }
    
    public $timestamps = false;
}
