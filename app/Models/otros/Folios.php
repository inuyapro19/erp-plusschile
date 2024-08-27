<?php

namespace App\Models\otros;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folios extends Model
{
    use HasFactory;

    protected $table = 'folios_viajes';

    protected $fillable = [
        'nro_folio',
        'fecha'
    ];

    public $timestamps = false;
}
