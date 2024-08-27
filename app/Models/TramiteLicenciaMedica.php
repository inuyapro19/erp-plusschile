<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TramiteLicenciaMedica extends Model
{
    use HasFactory;

    protected $table = 'tramite_licencia_medicas';

    protected $fillable = [
        'fecha_emision' ,
        'fecha_inicio' ,
        'fecha_recepcion',
         'fecha_procesado',
        'dias',
        'fecha_fin',
        'medio',
        'motivo',
        'trabajador_id' ,
        'user_id',
        'tipo_licencia_medicas_id',
        'estado',
        'rut'
    ];

    public $timestamps = false;

    public function trabajador(){
        return $this->belongsTo(Trabajador::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopeTrabajadorId(Builder $query)
    {
        if (empty(request('trabajador_id'))) {
            return;
        }

        $trabajador_id = request('trabajador_id');

        $query->where('trabajador_id','=',$trabajador_id);

    }

}
