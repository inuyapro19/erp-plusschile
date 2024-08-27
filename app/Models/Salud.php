<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salud extends Model
{
    use HasFactory;

    protected $table = 'salud';

    protected $fillable = ['nombre_salud'];

    public $timestamps = false;




}
