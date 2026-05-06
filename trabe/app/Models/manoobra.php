<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class manoobra extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'manoobra';
    protected $primaryKey = 'ID_mano_obra';
    
    protected $fillable = [
        'fk_id_proveedor', 
        'fk_id_servicio', 
        'unidad', 
        'precio'
    ];

    public function proveedor()
{
    return $this->belongsTo(proveedores::class, 'fk_id_proveedor', 'ID_proveedor');
}

public function servicio()
{
    return $this->belongsTo(Servicio::class, 'fk_id_servicio', 'ID_servicio');
}
}