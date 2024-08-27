<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonoHaber extends Model
{
    protected $table = 'bono_haberes';

    protected $fillable = [
        'descripcion',
        'monto',
        'tipo',
        'clasificacion',
        'categoria',
        'moneda',
        'factor',
        'fecha_termino',
        'aplica_gratificacion',
        'aplica_hora_extra',
        'aplica_anticipable',
        'aplica_proporcional',
        'aplica_imponible',
        'estado'
    ];

    public $timestamps = false;

    public function scopeisActive(Builder $query){
        if (empty(request('estado'))){
            return;
        }

        $estado = request('estado');

        $query->where('estado','=',$estado);

    }

}
