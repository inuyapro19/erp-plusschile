<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MontoEntregado extends Model
{
    use HasFactory;

    protected $table = 'monto_entregados';

    protected $fillable = [
        'monto_asignacion_peajes_id',
        'monto_entregado',
        'fecha_entrega',
        'user_id'
    ];

    public $timestamps = false;

    public function monto_asignado(){
        return $this->belongsTo(MontoAsignacion::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopeFiltros(Builder $query){
        if (empty(request('monto_asignado_id'))){
            return;
        }

        $monto_asignado_id = request('monto_asignado_id');

        $query->where('monto_asignado_id','=',$monto_asignado_id);

    }

}
