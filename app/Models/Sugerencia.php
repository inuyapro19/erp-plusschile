<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sugerencia extends Model
{
    use HasFactory;

  protected $table = 'sugerencias';

  protected $fillable = [
        'trabajador_id' ,
        'areas_id',
        'area_operacion',
        'mensaje_descripcion' ,
        'mensaje_propuestas' ,
        'mensaje_de_mejoras' ,
        'tipo_reclamo' ,
          'estado',
          'anonimo',
        'respuesta'
  ];

    public function trabajador(){
        return $this->belongsTo(Trabajador::class);
    }

    public function areas(){
        return $this->belongsTo(Areas::class);
    }

    public function respuestaSugerencias(){
        return $this->hasMany(RespuestaSolicitud::class);
    }

}
