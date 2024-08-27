<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tripulacion extends Model
{
    use HasFactory;

    protected $table = 'tripulaciones';

    public function scopeEstados(Builder $query)
    {

        if (empty(request('condicion'))) {
            return;
        }

        $condicion = request('condicion');

        $query->where('condicion','=',$condicion);

    }

}
