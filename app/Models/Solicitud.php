<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use PhpParser\Node\Expr\Array_;

class Solicitud extends Model
{
    use HasFactory,Notifiable;

    protected $table = 'solicitud_trabajador';

    protected $fillable = [
        'asunto',
        'trabajador_id',
        'user_id',
        'comentario',
        'tipo_solicitud',
        'datos',
        'estado'
    ];
    protected $casts = [
        'datos:Array'
    ];
//getRespuestasAttribute
    public function getDatosAttribute($value)
    {
        return json_decode($value);
    }



    public function trabajador(){
        return $this->belongsTo(Trabajador::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function respuestas_solicitudes(){
        return $this->hasMany(RespuestaSolicitud::class);
    }

    public function archivo_solicitudes(){
        return $this->hasMany(ArchivoSolicitud::class);
    }

}
