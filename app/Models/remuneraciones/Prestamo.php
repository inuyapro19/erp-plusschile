<?php

namespace App\Models\remuneraciones;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    use HasFactory;

    protected $table = 'prestamos_trabajadores';

  protected $fillable = [
      'monto',
      'cuotas',
      'tipo', //EMPRESA - CAJA
      'trabajador_id',
      'descripcion',
      'periodo_pago',
      'cuota_inicial',
      'estado',//PAGADO - NO PAGADO
  ];

  public $timestamps = false;

}
