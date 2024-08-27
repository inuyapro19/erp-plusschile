<?php

namespace App\Models\sistema;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrabajadorVitacora extends Model
{
    use HasFactory;

    protected $table = 'trabajador_vitacora';


    protected $fillable = [
        'trabajador_id',
        'fecha',
        'observacion',
        'user_id',
    ];


    public $timestamps = false;

    public function trabajador(){
        return $this->belongsTo(Trabajador::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }


}
