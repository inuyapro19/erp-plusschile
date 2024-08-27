<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaludEnfermedad extends Model
{
    use HasFactory;
    protected $table = 'salud_enfermedades';

    protected $fillable = [
        'enfermedad_prexistente',
        'tipo_sangre',
        'enfermedades',
        'medicamentos',
        'trabajador_id'
    ];

    public $timestamps = false;
}
