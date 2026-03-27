<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    protected $table = 'cotizacion';
    public $timestamps = false;

    protected $primaryKey = 'ID_cotizacion';
    protected $fillable = [
        'fk_id_proyecto',
        'fecha',
        'estado',
        'total'
    ];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'fk_id_proyecto', 'ID_proyecto');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleCotizacion::class, 'fk_id_cotizacion', 'ID_cotizacion');
    }
}
