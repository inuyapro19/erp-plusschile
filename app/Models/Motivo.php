<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motivo extends Model
{
    use HasFactory;


    protected $table = 'movimiento_trabajadores';

    protected $fillable = [
        'codigo',
        'descripcion'
    ];

    public $timestamps = false;

}
