<?php

namespace App\Models\Vistas;

use App\Traits\ApiTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HaberNoImponible extends Model
{
    use ApiTrait;

   protected $table = 'HABERES_NO_IMPONINLES_VIEW';

}
