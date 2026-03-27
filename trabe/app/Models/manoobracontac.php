<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class manoobracontac extends Model
{
    use HasFactory;
    
    protected $table = "manoobracontac"; 
    protected $primaryKey = "ID_mano_obra_contac";
    public $incrementing = true;
    protected $keyType = "int";
    
    protected $ID_mano_obra_contac;
    protected $nombre;
    protected $telefono;
    protected $direccion;
    
    protected $fillable = [
        "ID_mano_obra_contac",
        "nombre",
        "telefono",
        "direccion"
    ];
    
    public $timestamps = false;
}