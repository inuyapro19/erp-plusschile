<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    use HasFactory;

    protected $table = 'contrato';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ubicacion_id',
        'fecha_ingreso',
        'fecha_antiguidad',
        'fecha_vencimiento_contrato',
        'fecha_segundo_vencimiento',
        'cargo_id',
        'area_id',
        'trabajador_id',
        'centro_costo',
        'tipo_jornada',
        'jornada_excepcional',
        'empleador_id',
        'tipo_contrato',
        'sueldo_base'
    ];


    protected $dates = ['fecha_ingreso'];

    public function empleador(){
        return $this->belongsTo(Empleador::class);
    }
    public function area(){
        return $this->belongsTo(Areas::class);
    }


    public function ubicacion(){
        return $this->belongsTo(Ubicacion::class);
    }

    public function cargo(){
        return $this->belongsTo(Cargo::class);
    }

}
