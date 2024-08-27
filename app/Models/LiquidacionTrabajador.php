<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiquidacionTrabajador extends Model
{
    use HasFactory;

    protected $table = 'liquidacion_trabajador';

    protected $fillable = [
        'trabajador_id',
        'total_haberes',
        'total_descuentos',
        'total_a_pagar',
        'resumen_detalle',
        'mes',
        'year',
        'estado'
    ];



}
