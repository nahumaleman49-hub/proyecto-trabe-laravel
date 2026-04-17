<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class clientes extends Model
{
    use HasFactory;

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
