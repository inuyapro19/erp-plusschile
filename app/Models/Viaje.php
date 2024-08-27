<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Viaje extends Model
{
    use HasFactory;

    protected $table = 'viajes';

    protected $fillable = [
        'nro_viaje' ,
        'buses_id' ,
        'origen_id' ,
        'destino_id',
        'viaje_especial',
        'destino_especial',
        'origen_especial',
        'fecha_viaje' ,
        'hora_salida' ,
        'fecha_llegada',
        'hora_llegada',
        'nota_viaje' ,
        'empleador_id' ,
        'tipo_viaje' ,
        'cliente_id',
        'motivo_supencion'
    ];

    public $timestamps = false;

    public function trabajadores(){
        return $this->belongsToMany(Trabajador::class,'trabajador_viajes','viaje_id','trabajador_id');
    }

    public function monto_asignaciones(){
        return $this->hasMany(MontoAsignacion::class);
    }

    public function bus(){
        return $this->belongsTo(Buses::class,'buses_id');
    }

    public function empleador(){
        return $this->belongsTo(Empleador::class);
    }

    public function destino(){
        return $this->belongsTo(Destino::class,'destino_id');
    }

    public function origen(){
        return $this->belongsTo(Destino::class,'origen_id');
    }

    public function scopeFiltros(Builder $query){
        if (empty(request('filtro'))){
            return;
        }

        $filtros = request('filtro');

        foreach($filtros as $filtro => $value){
            $query->where($filtro, $value);
        }

    }

    public function scopeFiltrosEstados(Builder $query){
        if (empty(request('estado_activos'))){
            return;
        }

        //$filtros = request('estado_activos');
       $query->where('estado','!=','FINALIZADO');

    }

    public function scopefiltroporBus(Builder $query){
        if (empty(request('filtroporBus'))){
            return;
        }

        $filtros = request('filtroporBus');

        //filtros por bus
        $query->where('buses_id','=',$filtros);

    }

}
