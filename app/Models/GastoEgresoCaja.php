<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GastoEgresoCaja extends Model
{
    use HasFactory;

    protected $table = 'gastos_egreso_cajas';

    protected $fillable = [
        'fecha',
        'nro_documento',
        'monto',
        'observacion',
        'empleador_id',
        'trabajador_id',
        'user_id',
    ];

    public function empleador()
    {
        return $this->belongsTo(Empleador::class);
    }

    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public $timestamps = false;

}
