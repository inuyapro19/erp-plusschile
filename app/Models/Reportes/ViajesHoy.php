<?php

namespace App\Models\Reportes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViajesHoy extends Model
{
    use HasFactory;

    protected $table = 'viajes_hoy';

    public function scopeFiltros(Builder $query){
        if (empty(request('filtro'))){
            return;
        }

        $filtros = request('filtro');

        foreach($filtros as $filtro => $value){
            $query->where($filtro, $value);
        }
    }
}
