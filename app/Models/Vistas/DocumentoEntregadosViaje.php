<?php

namespace App\Models\Vistas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoEntregadosViaje extends Model
{
    use HasFactory;

    protected $table = 'documento_entregado_viaje';

    public function scopeFiltros(Builder $query){
        if (empty(request('filtro'))){
            return;
        }

        $filtros = request('filtro');

        foreach($filtros as $filtro => $value){
            $query->where($filtro, $value);
        }
    }

    public function getTripulacionAttribute($value)
    {
        return explode(',', $value);
    }

}
