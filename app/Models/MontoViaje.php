<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MontoViaje extends Model
{
    use HasFactory;

    protected $table = 'monto_viajes';

    protected $fillable = [
              'viaje_id',
              'monto_total',
              'user_id',
              'responsable_id',
              'estado'
        ];

    public $timestamps = false;

}
