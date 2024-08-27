<?php

namespace App\Models\Vistas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LicenciaMedica extends Model
{
    use HasFactory;

    protected $table = 'licencias_medicas_trabajador';


    public function scopeTrabajadorId(Builder $query)
    {
        if (empty(request('trabajador_id'))) {
            return;
        }

        $trabajador_id = request('trabajador_id');

        $query->where('trabajador_id','=',$trabajador_id);

    }

    public function scopeEmpleadorId(Builder $query)
    {
        if (empty(request('empleador_id'))) {
            return;
        }

        $empleador_id = request('empleador_id');

        $query->where('empleador_id','=',$empleador_id);

    }


}
