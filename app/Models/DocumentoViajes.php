<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoViajes extends Model
{
    use HasFactory;

    protected $table = 'documento_entragados';

    protected $fillable = [
            'nro_doc',
            'fecha_de_entrega',
            'tipo',
            'viaje_id',
            'tripulacion_id',
            'user_id',
            'estado'
    ];

    public $timestamps = false;


}
