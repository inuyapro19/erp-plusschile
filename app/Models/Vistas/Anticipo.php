<?php

namespace App\Models\Vistas;

use App\Traits\ApiTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anticipo extends Model
{

    use ApiTrait;

    protected $table = 'ANTICIPO_VIEW';

}
