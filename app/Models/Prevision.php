<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prevision extends Model
{
    use HasFactory;

    protected $table = 'previsiones';

    protected $fillable = [
        'codigo',
        'nombre_prevision',
        'porcentaje_prevision'
    ];

    public $timestamps = false;
}
