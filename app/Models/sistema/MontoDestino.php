<?php

namespace App\Models\sistema;

use App\Models\Destino;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MontoDestino extends Model
{
    use HasFactory;

    protected $table = 'montos_destinos';

    protected $fillable = [
        'monto_predeterminado',
        'destino_id',
    ];

    public $timestamps = false;

    public function destino(){
        return $this->belongsTo(Destino::class);
    }

}
