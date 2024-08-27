<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PuebloOriginario extends Model
{
    use HasFactory;

    protected $table = 'pueblo_originarios';

    protected $fillable = ['pueblo_originario'];

}
