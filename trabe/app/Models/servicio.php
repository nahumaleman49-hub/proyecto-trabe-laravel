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
    public function manoObra(){
    return $this->hasMany(ManoObra::class, 'fk_id_servicio', 'ID_servicio');
}

    public function categoria(){
    return $this->belongsTo(Categoria::class, 'fk_id_categoria', 'ID_Categoria');
}

}
