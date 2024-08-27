<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    use HasFactory;

    protected $table = 'contactos';

    protected $fillable = [
        'nombre',
        'apellido',
        'correo',
        'telefono',
        'direccion',
        'region_id',
        'comuna_id',
        'parentesco',
        'otro_parentesco',
        'trabajador_id'
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function comuna()
    {
        return $this->belongsTo(Comunas::class);
    }

    public function trabajador(){
        return $this->belongsTo(Trabajador::class);
    }

}
