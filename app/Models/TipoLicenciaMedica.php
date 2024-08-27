<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoLicenciaMedica extends Model
{
    use HasFactory;

    protected $table = 'tipo_licencia_medicas';

    protected $fillable = [
        'nombre_licencia'
    ];

}
