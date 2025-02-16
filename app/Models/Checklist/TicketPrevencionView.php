<?php

namespace App\Models\Checklist;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketPrevencionView extends Model
{
    use HasFactory;

    protected $table = 'ticket_prevencion';

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

    public function scopeDateBetween(Builder $query)
    {
        // Comprobar si existe el array de filtros
        if (empty(request('filtros'))) {
            return;
        }

        $fechaInicio = request('filtros[FECHA_INICIO]');
        $fechaFin = request('filtros[FECHA_FIN]');

        if ($fechaInicio && $fechaFin) {
            $query->whereBetween('FECHA_REPORTADO', [$fechaInicio, $fechaFin]);
        }
    }
}
