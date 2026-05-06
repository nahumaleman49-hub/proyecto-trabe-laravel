<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes; 

class materiales extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = "materiales"; 
    protected $primaryKey = "ID_Material";
    public $incrementing = true;
    protected $keyType = "int";
    
    protected $ID_Material;
    protected $nombre;
    protected $codigo;
    protected $medidas;
    protected $fk_id_categoria;
    protected $ficha_tecnica;
    
    protected $fillable = [
        "ID_Material",
        "nombre",
        "codigo",
        "medidas",
        "fk_id_categoria",
        "ficha_tecnica",

    ];
    
    public function categoria()
{
    return $this->belongsTo(Categoria::class, 'fk_id_categoria', 'ID_Categoria');
}

// Opcional, pero útil para las pruebas
public function abastecimientos()
{
    return $this->hasMany(Abastecimiento::class, 'fk_id_material', 'ID_Material');
}

    public $timestamps = false;
}
