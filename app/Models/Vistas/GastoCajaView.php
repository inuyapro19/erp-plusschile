<?php

namespace App\Models\Vistas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GastoCajaView extends Model
{
    use HasFactory;

    protected $table = 'gastos_egreso_cajas_view';

    public function scopeFiltros(Builder $query)
    {
        if (empty(request('filtro'))) {
            return;
        }

        $filtros = request('filtro');

        foreach ($filtros as $filtro => $value) {
            $query->where($filtro, $value);
        }
    }
}
