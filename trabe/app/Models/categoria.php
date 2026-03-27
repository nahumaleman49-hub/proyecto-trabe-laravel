<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class categoria extends Model
{
    use HasFactory;
    
    protected $table = "categoria"; 
    protected $primaryKey = "ID_Categoria";
    public $incrementing = true;
    protected $keyType = "int";
    
    protected $ID_Categoria;
    protected $nombre;
    protected $descripcion;
    
    protected $fillable = [
        "ID_Categoria",
        "nombre",
        "descripcion"
    ];
    
    public $timestamps = false;
}