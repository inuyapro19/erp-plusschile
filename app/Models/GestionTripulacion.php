<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GestionTripulacion extends Model
{
        protected $table = 'gestion_trabajadores';

        protected $fillable = [
            'tipo',
            'trabajador_id',
            'fecha_inicial',
            'fecha_termino',
            'fecha_retorno',
            'numero_dias',
            'estado'
        ];

        public function trabajadores(){
            return $this->belongsTo(Trabajador::class);
        }

        public $timestamps = false;

}
