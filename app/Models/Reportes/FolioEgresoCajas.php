<?php

namespace App\Models\Reportes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FolioEgresoCajas extends Model
{
    use HasFactory;

    protected $table = 'folios_impresion_caja';

    protected $fillable = [
        'nro_folio',
        'user_id',
        'fecha'
    ];

    public $timestamps = false;

}
