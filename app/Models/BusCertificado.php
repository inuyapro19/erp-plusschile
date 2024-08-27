<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusCertificado extends Model
{
    use HasFactory;


    protected $table = 'bus_certificados';

    protected $fillable = [
        'bus_id',
        'fecha_emision',
        'fecha_vencimiento',
        'tipo_certificado',
        'compania',
        'municipalidad',
        'nro_certificado',
        'fecha_inicio_vehiculo',
        'fecha_vencimiento_vehiculo',
        'fecha_inicio_servicio',
        'fecha_vencimiento_servicio',
        'certificado_pdf',
        'estado'
    ];

    public $timestamps = false;

    public function bus(){
        return $this->belongsTo(Buses::class);
    }

    public function certificadoRecorrido(){
        return $this->hasMany(CertificadoRecorrido::Class);
    }

    /* Filtro por campos de certificados */
    public function scopeFiltros(Builder $query){

        if (empty(request('filtro'))){
            return;
        }

        $filtros = request('filtro');

        foreach($filtros as $filtro => $value){
            $query->where($filtro,$value);
        }
    }

    public function scopeFiltroRelacionNumeroBus(Builder $query){
        if (empty(request('numero_bus'))){
            return;
        }

        $filtro = request('numero_bus');

        $query->whereHas('bus',function($q) use($filtro){
           return $q->where('numero_bus','=',$filtro);
        });

    }

    public function scopeFiltroRelacionPatente(Builder $query){
        if (empty(request('patente'))){
            return;
        }

        $filtro = request('patente');

        $query->whereHas('bus',function($q) use($filtro){
           return $q->where('patente','=',$filtro);
        });

    }
}
