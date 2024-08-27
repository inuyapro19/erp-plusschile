<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrabajadorViaje extends Model
{
    use HasFactory;

    protected $table = 'trabajador_viajes';

    protected $fillable = [
        'viaje_id',
        'trabajador_id',
        'trabajador_reemplazo_id',
        'tipo_tripulante',
        'orden',
        'motivo'
        ];

    public $timestamps = false;

}
