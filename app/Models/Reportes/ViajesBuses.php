<?php

namespace App\Models\Reportes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViajesBuses extends Model
{
    use HasFactory;

    protected $table = 'viajes_realizados';

    public function scopeFiltros(Builder $query){
        if (empty(request('filtro'))){
            return;
        }

        $filtros = request('filtro');

        foreach($filtros as $filtro => $value){
            $query->where($filtro, $value);
        }
    }

    public function scopeFechasEntre(Builder $query){
        if (empty(request('FECHA_INICIO'))){
            return;
        }

        $query->whereBetween('FECHA_VIAJE',
            [request('FECHA_INICIO'),
                request('FECHA_FIN')]);
    }

}
