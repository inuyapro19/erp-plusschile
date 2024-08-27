<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrabajadorTripulacion extends Model
{
    use HasFactory;

    protected $table = 'trabajador_tripulacion';

    protected $fillable = [
        'tripulacion_id',
        'trabajador_id' ,
        'jefe_maquina' ,
        'segundo_chofer' ,
        'auxiliar' ,
        'estado'
    ];

    public function trabajador(){

        return $this->belongsTo(Trabajador::class);

    }

}
