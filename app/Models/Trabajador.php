<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

//use Illuminate\Database\Eloquent\SoftDeletes;

class Trabajador extends Model
{
    use HasFactory , SoftDeletes;

    protected $table = 'trabajadores';

    protected $fillable = [
        'codigo_trabajador',
        'rut',
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'fecha_nac',
        'estado_civil',
        'sexo',
        'grado_escolaridad',
        'telefono_local',
        'telefono_celular',
        'correo',
        'direccion',
        'user_id',
        'region_id',
        'comuna_id',
        'nacionalidad_id',
        'pertenece_pueblo_originario',
        'pueblo_originario_id',
        'tiene_familia',
        'tiene_discapacidad',
        'condicion',
        'ubicacion_actual',
        'estado'
    ];

    /*/protected $casts = [
        'pertenece_pueblo_originario' => 'boolean',
    ];*/

    protected $dates = ['deleted_at'];

    public static function boot() {
        parent::boot();

        static::deleting(function($trabajador) {
            $trabajador->contrato()->delete();
            $trabajador->contacto()->delete();
            $trabajador->cargaFamiliares()->delete();
        });
    }

    //*******//

    public function Scopefiltro(Builder $query){

         return  $query->where('cargo_id','=',request('cargo_id'));

    }

   // protected $primaryKey = 'rut';
    public function contrato(){
        return $this->hasOne(Contrato::class);
    }

    public function contacto()
    {
        return $this->hasMany(Contacto::class);
    }
    public function bancotrabajador()
    {
        return $this->hasMany(BancoTrabajador::class);
    }
    public function historial()
    {
        return $this->hasMany(HistorialDesvinculacion::class);
    }

    public function cargaFamiliares()
    {
        return $this->hasMany(CargaFamiliar::class);
    }

    public function gestion_tripulacion(){
        return $this->hasMany(GestionTripulacion::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function comuna()
    {
        return $this->belongsTo(Comunas::class);
    }

    public function previsiontrabajador(){
        return $this->hasOne(PrevisionTrabajador::class);
    }

    public function ahorroTrabajador(){
        return $this->hasMany(AhorroVoluntarioTrabajador::class);
    }

    public function saludtrabajador(){
        return $this->hasOne(SaludTrabajador::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function buses(){
        return $this->belongsToMany(Buses::class,'bus_trabajadores','trabajador_id','bus_id');
    }

    public function gestiones(){
       return $this->hasMany(GestionTripulacion::class);
    }


    public function getPertenecePuebloOriginarioAttribute($value)
    {
          $res = $value == 'si' ? true : false;

          return $res;
    }
    public function setPertenecePuebloOriginarioAttribute($value)
    {
       $value =  $value == 'true' ? true : false;

        if ($value){
            $this->attributes['pertenece_pueblo_originario'] = 'si';
        }else {
            $this->attributes['pertenece_pueblo_originario'] = 'no';
        }
    }


    public function getTieneFamiliaAttribute($value)
    {
        $res = $value == 'si' ? true : false;

        return $res;
    }

    public function setTieneFamiliaAttribute($value)
    {
        $value =  $value == 'true' ? true : false;

        if ($value){
            $this->attributes['tiene_familia'] = 'si';
        }else {
            $this->attributes['tiene_familia'] = 'no';
        }
    }


    public function getTieneDiscapacidadAttribute($value)
    {
        $res = $value == 'si' ? true : false;

        return $res;
    }

    public function setTieneDiscapacidadAttribute($value)
    {
        $value =  $value == 'true' ? true : false;

        if ($value){
            $this->attributes['tiene_discapacidad'] = 'si';
        }else {
            $this->attributes['tiene_discapacidad'] = 'no';
        }
    }

    public function getFullNameAttribute()
    {
        return preg_replace('/\s+/', ' ',$this->primer_nombre.' '.$this->segundo_nombre.' '.$this->primer_apellido.' '.$this->segundo_apellido);
    }

   /* public function getEstadoAttribute($value)
    {
        return $value == 'contratado' ? '<span class="text-success">Contratado</span>' : '<span class="text-warning">Postulado</span>';
    }*/

    //query scope

    public function scopeFiltros(Builder $query){
        if (empty(request('filtro'))){
            return;
        }

        $filtros = request('filtro');

      foreach($filtros as $filtro => $value){
          $query->where($filtro, $value);
      }

    }

    public function scopefiltroCargo(Builder $query){

        if(empty(request('filtros_cargos'))){
            return;
        }

        if(empty(request('opcion'))){
            return;
        }

        $filtros = request('filtros_cargos');

        $opcion = request('opcion');

        if($opcion == 1){
            $query->whereHas('contrato',function($q){
                $q->whereIn('cargo_id',[2,3]);
            });
        }
        if($opcion == 2){
            $query->whereHas('contrato',function($q){
                $q->whereIn('cargo_id',[3]);
            });
        }

        if($opcion == 3){
            $query->whereHas('contrato',function($q){
                $q->whereIn('cargo_id',[2]);
            });
        }

        if($opcion == 4){
            $query->whereHas('contrato',function($q) use($filtros){
                $q->where('cargo_id','=',$filtros);
            });
        }
       /* foreach($filtros as $filtro => $value)
        {
            $query->whereHas(['contrato' => function($q) use ($value){
                $q->where('cargo_id',$value);
            }]);
        }*/

    }

    public function scopeEstados(Builder $query)
    {

        if (empty(request('estados'))) {
            return;
        }

        $query->where('condicion','=','disponible');

    }

    public function scopeGrupoEstado(Builder $query){
        if (empty(request('agrupar_by'))){
            return;
        }

        //$query->select('estado,count(condicion)');
        return $query->groupBy('condicion');

    }

    public function scopeFiltroEmpleador(Builder $query){
        if (empty(request('empleador_id'))){
            return;
        }

        $filtro = request('empleador_id');

        $query->whereHas('contrato',function($q) use($filtro){
            $q->where('empleador_id',$filtro);
        });

    }

    public function scopeFiltroUbicacion(Builder $query){
        if (empty(request('ubicacion_id'))){
            return;
        }

        $filtro = request('ubicacion_id');

        $query->whereHas('contrato',function($q) use($filtro){
            $q->where('ubicacion_id',$filtro);
        });

    }

    public function scopeUserRole(Builder $query){
        if(empty(request('user_role'))){
            return;
        }

        $roles = request('user_role');

        $query->whereHas('user.roles',function($q) use($roles){
            $q->where('name',$roles);
        });

    }

}
