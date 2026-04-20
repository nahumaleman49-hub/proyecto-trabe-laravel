<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class materiales extends Model
{
    use HasFactory;
    
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
    protected $precio;
    
    protected $fillable = [
        "ID_Material",
        "nombre",
        "codigo",
        "medidas",
        "fk_id_categoria",
        "ficha_tecnica",
        "precio"

    ];
    
    public function categoria()
    {
        return $this->belongsTo(categoria::class, 'fk_id_categoria', 'ID_Categoria');

    }
    public $timestamps = false;
}
