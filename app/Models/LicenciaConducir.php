<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LicenciaConducir extends Model
{
    use HasFactory;

    protected $table = 'licencia_conducir';

    protected $fillable = [
        'tipo_licencia_id',
        'tipo_licencias',
        'nro_serie',
        'categorias',
        'fecha_de_ingreso',
        'fecha_de_vencimiento',
        'restriccion',
        'trabajador_id'
    ];

    public $timestamps = false;

}
