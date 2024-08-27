<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrabajadorBono extends Model
{
    use HasFactory;

    protected $table = 'bono_trabajador';

    protected $fillable = ['trabajador_id','bonos_id','mes','anyo','monto','estado'];

    public $timestamps = false;
}
