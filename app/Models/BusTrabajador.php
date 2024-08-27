<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusTrabajador extends Model
{
    use HasFactory;

    protected $table = 'bus_trabajadores';

    protected $fillable = [
        'trabajador_id',
        'bus_id',
        'tipo_chofer',
        'fecha_inicio',
        'fecha_termino',
        'estado'
    ];

    public $timestamps = false;
}
