<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes; 

class cotizacion extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'cotizacion';
    public $timestamps = false;

    protected $primaryKey = 'ID_cotizacion';
    protected $fillable = [
        'fk_id_proyecto',
        'fecha',
        'estado',
        'total'
    ];
    protected $casts = [
    'fecha' => 'date',
    'estado' => 'integer',
    ];

    public function proyecto()
    {
        return $this->belongsTo(proyecto::class, 'fk_id_proyecto', 'ID_proyecto');
    }

    // Relación con Materiales (Abastecimiento)
    public function detallesMateriales()
    {
        return $this->hasMany(detallecotizacion_abastecimiento::class, 'fk_id_cotizacion', 'ID_cotizacion');
    }

    // Relación con Servicios (Mano de Obra)
    public function detallesManoObra()
    {
        return $this->hasMany(detallecotizacion::class, 'fk_id_cotizacion', 'ID_cotizacion');
    }

    // Mantengo esta por si la usas en otras vistas generales
    public function detalles()
    {
        return $this->hasMany(detallecotizacion::class, 'fk_id_cotizacion', 'ID_cotizacion');
    }
}
