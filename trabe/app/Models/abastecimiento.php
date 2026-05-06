<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class abastecimiento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'abastecimiento';
    protected $primaryKey = 'ID_prod';
    
    protected $fillable = [
        'fk_id_material', 
        'fk_id_proveedor', 
        'precio'
    ];

    public function material()
{
    return $this->belongsTo(Material::class, 'fk_id_material', 'ID_Material');
}

    // Relación: Un abastecimiento pertenece a un proveedor
    public function proveedor()
    {
        return $this->belongsTo(proveedores::class, 'fk_id_proveedor', 'ID_proveedor');
    }
}