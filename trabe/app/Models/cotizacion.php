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
        'total',
        'costo_equipo',        
        'gastos_generales',   
        'margen_ganancia',
    ];
    protected $casts = [
    'fecha' => 'date',
    'estado' => 'integer',
    'total' => 'float',
    'costo_equipo' => 'float',
    'gastos_generales' => 'float',
    'margen_ganancia' => 'float',
    ];

    public function proyecto()
    {
        return $this->belongsTo(proyecto::class, 'fk_id_proyecto', 'ID_proyecto');
    }

    public function detallesMateriales()
{
    return $this->hasMany(detallecotizacion_abastecimiento::class, 'fk_id_cotizacion', 'ID_cotizacion');
}

// Relación para servicios (usando la tabla detallecotizacion)
public function detallesManoObra()
{
    return $this->hasMany(detallecotizacion::class, 'fk_id_cotizacion', 'ID_cotizacion')
                ->whereNotNull('fk_id_mano_obra');
}

    // Mantengo esta por si la usas en otras vistas generales
    public function detalles()
    {
        return $this->hasMany(detallecotizacion::class, 'fk_id_cotizacion', 'ID_cotizacion');
    }
}
