<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleador extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'empleadores';

    protected $fillable = [
        'codigo_empresa',
        'rut',
        'nombre_empleador',
        'direccion',
        'comuna',
        'region',
        'representante_legal',
        'rut_representante'
    ];

}
