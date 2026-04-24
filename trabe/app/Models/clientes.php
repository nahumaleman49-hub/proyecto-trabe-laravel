<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes; 

class clientes extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'Clientes';
    protected $primaryKey = 'ID_cliente';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nombre', 'telefono', 'direccion'
    ];

    public $timestamps = false;
    
    public function proyectos()
{
    return $this->hasMany(proyecto::class, 'fk_id_cliente', 'ID_cliente');
}
}
