<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialTrabajador extends Model
{
    use HasFactory;

    protected $table = 'historial_trabajadores';

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
        'estado'
    ];
    public function contrato(){
        return $this->hasOne(Contrato::class);
    }

    public function contacto()
    {
        return $this->hasMany(Contacto::class);
    }

    public function historial()
    {
        return $this->hasMany(HistorialDesvinculacion::class);
    }
}
