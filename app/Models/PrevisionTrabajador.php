<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrevisionTrabajador extends Model
{
    use HasFactory;

    protected $table = 'prevision_trabajadores';

    public $timestamps = false;

    protected $fillable = [
        'tipo_entidad',
        'prevision_id',
        'prevision_inp_id',
        'trabajador_id'
    ];

    public function prevision(){
        return $this->belongsTo(Prevision::class);
    }

}
