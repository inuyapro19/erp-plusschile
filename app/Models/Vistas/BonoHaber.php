<?php

namespace App\Models\vistas;

use App\Traits\ApiTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonoHaber extends Model
{
    use ApiTrait;
  protected $table = 'BONOS_VIEW';


}
