<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tramos extends Model
{
    use HasFactory;

    protected $table = 'tramos';

    protected $fillable = ['tramo'];

    public $timestamps = false;

}
