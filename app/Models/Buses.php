<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buses extends Model
{
    use HasFactory;


    protected $table = 'buses';


    public $timestamps = false;


    protected $fillable = [
          'numero_bus' ,
          'marca_chasis',
          'modelo_chasis',
          'numero_carroceria',
          'marca_carroceria',
          'modelo_carroceria',
          'numero_carroceria',
          'patente',
          'tipo_bus',
          'numero_piso',
          'empleador_id',
          'anyo_bus',
          'numero_asientos',
          'numero_asiento_premium',
          'numero_asiento_mixto',
          'numero_asiento_cama',
          'numero_asiento_semicama',
          'numero_pantallas',
          'numero_pantallas_premium',
          'numero_pantallas_mixtos',
          'numero_pantallas_cama',
          'numero_pantallas_semicama',
          'fecha_ultima_carga',
          'tipo_servicio',
          'tipo_pantalla',
          'estado'
    ];


    public function empleador(){

        return $this->belongsTo(Empleador::class);

    }

    public function trabajadores(){
        return $this->belongsToMany(Trabajador::class,'bus_trabajadores','bus_id','trabajador_id')->withPivot('tipo_chofer','fecha_inicio','fecha_termino');
    }

    //filtrado por empleador , tipo servicio , estado  ?filtro[empleador_id]=1&filtro[tipo_servicio]=texto&filtro[estado]=estado
    public function scopeFiltro(Builder $query){
        if(empty(request('filtro'))){
            return;
        }
        $filtros = request('filtro');

        foreach($filtros as $filtro => $value){
            $query->where($filtro,$value);
        }
    }

    public function scopeFiltroLike(Builder $query){
        if(empty(request('filtro_like'))){
            return;
        }
        $filtros = request('filtro_like');

        foreach($filtros as $filtro => $value){
            $query->where($filtro,'Like','%'.$value.'%');
        }
    }

    public function scopefiltroId(Builder $query){
        if(empty(request('id'))){
            return;
        }

        $id = request('id');
        $query->where('id','=',$id);
    }

    public function scopeEstado(Builder $query){
        if(empty(request('estado'))){
            return;
        }

        $estado = request('estado');
        $query->where('estado','=',$estado);
    }

    public function scopeAccion(Builder $query){
        if(empty(request('operador'))){
            return;
        }

        $operador = request('operador');

       if ($operador == 'get')
       {
           return $query->paginate(15);
       }else{
           return $query->first();
       }

       if ($operador == 'first'){
            $query->first();
       }

    }

}
