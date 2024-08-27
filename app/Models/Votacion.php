<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Votacion extends Model
{
    use HasFactory;

    protected $table = 'votaciones';
    public $timestamps = false;
    protected $fillable = [
      'user_id',
      'trabajador_id',
      'fecha_votacion',
    ];

    public function users(){
        return $this->belongsTo(User::class);
    }

}
