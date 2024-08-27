<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comunas extends Model
{
    use HasFactory;

    protected $table = 'comunas';

    protected $fillable = ['nombre_comuna','region_id'];

}
