<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class manoobra extends Model
{
    use HasFactory;

    protected $table = 'manoobra';
    protected $primaryKey = 'ID_mano_obra';
    
    protected $fillable = [
        'fk_id_proveedor', 
        'fk_id_servicio', 
        'unidadt', 
        'precio'
    ];

    // Relación: Esta mano de obra pertenece a un proveedor
    public function proveedor()
    {
        return $this->belongsTo(proveedores::class, 'fk_id_proveedor', 'ID_Proveedor');
    }

    // Relación: Esta mano de obra pertenece a un servicio
    public function servicio()
    {
        return $this->belongsTo(servicio::class, 'fk_id_servicio', 'ID_servicio');
    }
}