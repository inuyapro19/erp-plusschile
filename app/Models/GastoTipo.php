<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GastoTipo extends Model
{
    use HasFactory;

    protected $table = 'gasto_tipos';

    protected $fillable = ['tipo_name'];

    public $timestamps = false;

}
