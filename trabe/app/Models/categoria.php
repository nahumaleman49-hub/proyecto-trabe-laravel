<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes; 

class categoria extends Model
{
    use HasFactory, SoftDeletes;
    
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