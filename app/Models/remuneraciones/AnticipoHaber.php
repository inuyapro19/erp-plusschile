<?php

namespace App\Models\remuneraciones;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnticipoHaber extends Model
{
    protected $table = 'anticipos_haberes';

    protected $fillable = [
        'descripcion',
        'monto',
        'estado'
    ];

    public $timestamps = false;

    public function scopeisActive(Builder $query){
        if (empty(request('estado'))){
            return;
        }

        $estado = request('estado');

        $query->where('estado','=',$estado);

    }

}
