<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class clientes extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'ID_cliente';
    public $increment = true;
    protected $keytipe = "int";
    protected $fillable = [
        'nombre',
        'telefono',
        'direccion'
        ];
        
    public $timestamps = false;
    
    // Relaciones
    public function proyectos()
    {
        return $this->hasMany(Proyecto::class, 'fk_id_cliente', 'ID_cliente');
    }
}