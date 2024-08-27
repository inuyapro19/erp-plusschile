<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialDesvinculacion extends Model
{
    use HasFactory;

    protected $table = 'historial_desvinculaciones';

    protected $fillable = [
        'fecha_desvinculacion',
        'causal_de_hecho',
        'motivo_interno_empresa',
        'motivo_id',
        'trabajador_id'
    ];

}
