<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespuestaSolicitud extends Model
{
    use HasFactory;

    protected $table = 'respuesta_solicitudes';

    protected $fillable = [
        'user_id',
        'mensaje',
        'solicitud_id',
        'archivos'
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }


}
