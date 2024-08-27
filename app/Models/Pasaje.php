<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasaje extends Model
{
    use HasFactory;

    protected $table = 'ruta_pasaje_ventas';

    protected $fillable = [
        'monto',
        'numero_documento',
        'fecha',
        'viaje_id'
    ];

    public $timestamps = false;

}
