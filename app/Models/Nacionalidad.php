<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nacionalidad extends Model
{
    use HasFactory;

    protected $table = 'nacionalidades';

    protected $fillable = ['descripcion_nacionalidad'];

    public $timestamps= false;

    public function getDescripcionNacionalidadAttribute($value)
    {
        return ucfirst($value);
    }

}
