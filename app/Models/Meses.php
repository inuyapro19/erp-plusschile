<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meses extends Model
{
    use HasFactory;

    protected $table = 'meses_remuneraciones';

    protected  $fillable = [
        'nombre_mes',
        'isOpen'
    ];

}
