<?php
 namespace App\Traits;

 use Illuminate\Database\Eloquent\Builder;

 trait ApiTrait{
    /* Filtra por estados*/
     public function scopeisActive(Builder $query){
         if (empty(request('estado'))){
             return;
         }

         $estado = request('estado');

         $query->where('estado','=',$estado);
     }

    /* Filta por cargo ID */
     public function scopeCargo(Builder $query){
         if (empty(request('cargo'))){
             return;
         }

         $cargo = request('cargo');

         $query->where('ID_CARGO','=',$cargo);
     }

     public function scopeTrabajadorID(Builder $query){
         if (empty(request('trabajador_id'))){
             return;
         }

         $trabajador_id = request('trabajador_id');

         $query->where('TRABAJADOR_ID','=',$trabajador_id);
     }

     public function scopeisActiveFiltro(Builder $query){
         if (empty(request('estado'))){
             return;
         }

         $estado = request('estado');

         $query->where('ESTADO_ASIGNACION','=',$estado);
     }

 }
