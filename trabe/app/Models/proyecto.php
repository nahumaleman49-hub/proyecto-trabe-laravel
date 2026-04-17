<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class proyecto extends Model
{
    use HasFactory;
    
    protected $table = "proyecto";  // Asegúrate que coincida con la BD
    protected $primaryKey = "ID_proyecto";
    public $incrementing = true;
    protected $keyType = "int";
    
    protected $fillable = [
        "nombre",
        "fk_id_cliente",
        "estado",
        "fecha_ini",
        "fecha_fin",
        "presupuesto"
    ];
    
    public $timestamps = false;

    public function cliente()
    {
        return $this->belongsTo(clientes::class, 'fk_id_cliente', 'ID_cliente');
    }
}
