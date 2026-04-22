<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class abastecimiento extends Model
{
    use HasFactory;

    protected $table = 'abastecimiento';
    protected $primaryKey = 'ID_prod';
    
    protected $fillable = [
        'fk_id_material', 
        'fk_id_proveedor', 
        'precio'
    ];

    // Relación: Un abastecimiento pertenece a un material
    public function material()
    {
        return $this->belongsTo(materiales::class, 'fk_id_material', 'ID_Material'); // Ajusta 'ID_Material' si tu PK se llama diferente
    }

    // Relación: Un abastecimiento pertenece a un proveedor
    public function proveedor()
    {
        return $this->belongsTo(proveedores::class, 'fk_id_proveedor', 'ID_Proveedor'); // Ajusta 'ID_Proveedor' si tu PK se llama diferente
    }
}