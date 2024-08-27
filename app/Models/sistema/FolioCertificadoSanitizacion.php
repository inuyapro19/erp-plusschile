<?php

namespace App\Models\sistema;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FolioCertificadoSanitizacion extends Model
{
    use HasFactory;

    protected $table = 'certificadosFolios';

    protected $fillable = [
        'folio',
        'fecha_creacion',
        'hora',
        'tipo_folio'
    ];

    public $timestamps = false;

}
