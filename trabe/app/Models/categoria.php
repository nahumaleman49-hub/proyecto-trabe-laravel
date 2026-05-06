<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes; 
use App\Models\materiales as Material;
use App\Models\servicio as Servicio;

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
    
    
    public function materiales()
{
    return $this->hasMany(Material::class, 'fk_id_categoria', 'ID_Categoria');
}

public function servicios()
{
    return $this->hasMany(Servicio::class, 'fk_id_categoria', 'ID_Categoria');
    }
    public $timestamps = false;
}