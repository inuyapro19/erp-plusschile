<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaludTrabajador extends Model
{
    use HasFactory;

    protected $table = 'salud_trabajadores';

    protected $fillable = [
        'salud_id',
       'cotiza_siete_porciento',
       'tipo_plan_salud',
       'monto_peso',
       'monto_uf',
        'trabajador_id'
    ];

    public $timestamps = false;

    public function salud(){
        return $this->belongsTo(Salud::class);
    }

    public function getCotizaSietePorcientoAttribute($value){

        return strtolower($value);

    }

}
