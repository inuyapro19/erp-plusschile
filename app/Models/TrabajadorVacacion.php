<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrabajadorVacacion extends Model
{
    use HasFactory;

    protected $table = 'trabajador_vacaciones';

    protected $fillable = [
        'trabajador_id',
        'dias_habiles_solicitados',
        'fecha_primer_dia' ,
        'saldo_previo_vacaciones',
        'saldo_despues_vacacaciones' ,
        'dias_corridos_del_periodo_de_vac' ,
        'fecha_ultimo_dia' ,
        'fecha_corte_calculo1' ,
        'fecha_corte_calculo2'
    ];

    public $timestamps = false;

    public function trabajador(){
        return $this->belongsTo(Trabajador::class);
    }

}
