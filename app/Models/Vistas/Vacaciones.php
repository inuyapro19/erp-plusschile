<?php

namespace App\Models\Vistas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacaciones extends Model
{
    use HasFactory;

    protected $table = 'tripulacion_vacaciones';


    public function scopeEstados(Builder $query)
    {

        if (empty(request('estado'))) {
            return;
        }

        $condicion = request('estado');

        $query->where('estado','=',$condicion);

    }

    public function scopeTrabajadorID(Builder $query)
    {

        if (empty(request('trabajador_id'))) {
            return;
        }

        $trabajador_id = request('trabajador_id');

        $query->where('ID_TRABAJADOR','=',$trabajador_id);

    }

    public function scopeEmpleadorID(Builder $query)
    {

        if (empty(request('empleador_id'))) {
            return;
        }

        $empleador_id = request('empleador_id');

        $query->where('EMPLEADOR_ID','=',$empleador_id);

    }

}
