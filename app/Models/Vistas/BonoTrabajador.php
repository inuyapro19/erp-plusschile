<?php

namespace App\Models\vistas;

use App\Traits\ApiTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonoTrabajador extends Model
{
    use ApiTrait;

    protected $table = 'TRABAJADOR_BONOS';



}
