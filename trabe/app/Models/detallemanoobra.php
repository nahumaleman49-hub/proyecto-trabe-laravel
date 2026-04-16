<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class detallemanoobra extends Model
{
    use HasFactory;
    
    protected $table = "detallemanoobra"; 
    protected $primaryKey = "ID_mano_obra";
    public $incrementing = true;
    protected $keyType = "int";
    
    protected $ID_mano_obra;
    protected $fk_id_mano_obra_contac;
    protected $precio_unit;
    protected $cantidad;
    protected $tipo_trabajo;
    
    protected $fillable = [
        "ID_mano_obra",
        "fk_id_mano_obra_contac",
        "precio_unit",
        "cantidad",
        "tipo_trabajo"
    ];
    
    public $timestamps = false;

    public function trabajador()
    {
        return $this->belongsTo(manoobracontac::class, 'fk_id_mano_obra_contac', 'ID_mano_obra_contac');
    }
}
