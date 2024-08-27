<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = ['nombre_cliente'];

    public $timestamps = false;

    public function getNombreClienteAttribute($value)
    {
        return ucfirst($value);
    }


    public function scopeFiltrosID(Builder $query){
        if (empty(request('filtro'))){
            return;
        }

        $filtros = request('filtro');

        foreach($filtros as $filtro => $value){
            $query->where('id', $value);
        }
    }
}
