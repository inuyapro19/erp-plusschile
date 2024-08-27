<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParamentroLiquidacion extends Model
{
    use HasFactory;

    //enum('GRATIFICACION DEFINIDA','PREVIRED','TRAMOS FAMILIAR','SEGURO CENSANTIA TRABAJADOR','TRAMOS IMPUESTO')

    protected $table = 'parametro_liquidaciones';

    protected $fillable = ['descripcion','valor','tipo'];

    public $timestamps = false;

}
