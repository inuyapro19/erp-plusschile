<?php

namespace App\Models\Vistas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripulacionView extends Model
{
    use HasFactory;

    protected $table = 'tripulaciones_view';

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
