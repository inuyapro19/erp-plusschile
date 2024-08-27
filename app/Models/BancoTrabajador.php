<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BancoTrabajador extends Model
{
    use HasFactory;

    protected $table = 'banco_trabajadores';

    protected $fillable = [
        'banco_id',
        'trabajador_id',
        'nro_cuenta',
        'tipo_cuenta',
        'fecha_ingreso_cuenta',
        'predeterminado',
    ];

    public $timestamps = false;

    public function banco(){
        return $this->belongsTo(Banco::class);
    }
}
