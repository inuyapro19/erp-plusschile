<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MontoAsignacion extends Model
{
    use HasFactory;

    protected $table = 'monto_asignacion_peajes';

    protected $fillable = [
        'nro_folio',
        'monto_asignado',
        'glosas',
        'viaje_id',
        'user_id',
        'fecha',
        'estado',
        'fecha_modificacion',
        'observacion',
    ];

    public $timestamps = false;

    public function viaje(){
        return $this->belongsTo(Viaje::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function monto_entregado(){
        return $this->hasMany(MontoEntregado::class,'monto_asignacion_peajes_id');
    }

  /* public function gasto_pasaje_viaje(){
        return $this->hasMany(GastoPasajeViaje::class,'monto_asignacion_id');
    }*/

}
