<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaludDiscapacidad extends Model
{
    use HasFactory;

    protected $table = 'salud_discapacidades';

    protected $fillable = [
        'posee_carnet',
        'discpacidad',
        'causa_principal',
        'causa_secundaria',
        'capacidad_reducidad',
        'trabajador_id'
    ];

    public $timestamps = false;
}
