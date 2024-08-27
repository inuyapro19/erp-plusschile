<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GastoPasajeViaje extends Model
{
    use HasFactory;

    protected $table = 'gasto_pasaje_viaje';

    protected $fillable = [
        'monto_asignacion_id',
        'nro_documento',
        'monto_gasto',
        'tipo',
        'fecha',
        'user_id',
        'tipo_id',
        'tripulacion_id'
    ];

    public $timestamps = false;

}
