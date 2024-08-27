<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalendarioConfiguracion extends Model
{
    use HasFactory;

    protected $table = 'calendario_configuracion';

    protected $fillable = [
        'anyo',
        'mes',
        'fecha',
        'tipo_de_fecha', /*feriado - fin de semana*/
        'tipo_de_feriado',
        'region_id'
    ];

    public $timestamps = false;


}
