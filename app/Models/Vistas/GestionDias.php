<?php

namespace App\Models\Vistas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GestionDias extends Model
{
    use HasFactory;
    //VISTA PARA IMPRIMIR PDF
    protected $table = 'gestion_trabajador_dias_libres';

    public function getFechaInicial($value)
    {
        return $value->format('d/m/Y');
    }
}
