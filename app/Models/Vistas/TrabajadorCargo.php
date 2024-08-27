<?php

namespace App\Models\Vistas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ApiTrait;
class TrabajadorCargo extends Model
{
    use HasFactory, ApiTrait;

    protected $table = 'TRABAJADOR_CARGO_BONO';




}
