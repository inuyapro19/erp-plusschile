<?php

namespace App\Models\Checklist;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemReported extends Model
{
    use HasFactory;

    protected $table = 'item_ticket_reported';

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
