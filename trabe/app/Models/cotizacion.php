<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cotizacion extends Model
{
<<<<<<< ramita
    use HasFactory;
    
    protected $table = "cotizacion"; 
    protected $primaryKey = "ID_cotizacion";
    public $incrementing = true;
    protected $keyType = "int";
    
    protected $ID_cotizacion;
    protected $fk_id_proyecto;
    protected $fecha;
    protected $estado;
    protected $total;
    
    protected $fillable = [
        "ID_cotizacion",
        "fk_id_proyecto",
        "fecha",
        "estado",
        "total"
    ];
    
    public $timestamps = false;
=======
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
>>>>>>> main
}
