<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrevisionInp extends Model
{
    use HasFactory;

    protected $table = 'prevision_inp';

    protected $fillable = ['codigo','nombre'];

    public $timestamps = false;

}
