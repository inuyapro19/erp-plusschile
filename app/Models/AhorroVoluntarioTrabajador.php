<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AhorroVoluntarioTrabajador extends Model
{
    use HasFactory;

    protected $table = 'ahorro_trabajadores';
    protected $fillable = [
        'tipo_ahorro',
        'ahorro_voluntario_id',
        'tipo_moneda',
        'monto',
        'forma_pago',
        'trabajador_id'
    ];

    public $timestamps = false;

}
