<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargaFamiliar extends Model
{
    use HasFactory;

    protected $table = 'carga_familiares';

    protected $fillable = [
        'rut',
        'nombres',
        'apellidos',
        'fecha_nacimiento',
        'fecha_vencimiento_carga',
        'parentesco_id',
        'trabajador_id'
    ];

    public $timestamps = false;



}
