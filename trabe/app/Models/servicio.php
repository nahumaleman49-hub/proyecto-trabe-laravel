<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class servicio extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'servicio';
    protected $primaryKey = 'ID_servicio';
    
    protected $fillable = [
        'fk_id_categoria', 
        'nombre'
    ];

    // Relación: Un servicio pertenece a una categoría
    public function categoria()
    {
        return $this->belongsTo(categoria::class, 'fk_id_categoria', 'ID_Categoria');
    }

    // Relación: Un servicio puede tener muchas manos de obra (cotizaciones de distintos proveedores)
    public function manoObra()
    {
        return $this->hasMany(manoobra::class, 'fk_id_servicio', 'ID_servicio');
    }
}
