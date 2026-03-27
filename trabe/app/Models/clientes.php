<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class clientes extends Model
{
<<<<<<< ramita
    use HasFactory;
    
    protected $table = "clientes"; 
    protected $primaryKey = "ID_cliente";
    public $incrementing = true;
    protected $keyType = "int";
    
    protected $ID_cliente;
    protected $nombre;
    protected $telefono;
    protected $direccion;
    
    protected $fillable = [
        "ID_cliente",
        "nombre",
        "telefono",
        "direccion"
    ];
    
    public $timestamps = false;
}
=======
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
>>>>>>> main
