<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruta extends Model
{
    use HasFactory;

    protected $table = 'tramo_viajes';

    protected $fillable = [
        'origen_id',
        'destino_id',
        'horas',
        'tramo_id'
    ];

    public $timestamps = false;

}
