<?php

namespace App\Models\Vistas;

use App\Traits\ApiTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoraExtra extends Model
{
    use ApiTrait;

   protected $table = 'HORA_EXTRA_VIEW';


}
