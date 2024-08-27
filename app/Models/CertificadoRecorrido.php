<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificadoRecorrido extends Model
{
    use HasFactory;

    protected $table = 'certificado_recorridos';

   protected $fillable = [
       'bus_certificado_id',
       'origen_id',
       'destino_id',
       'recorrido_tramo_ida',
       'recorrido_tramo_vuelta'
   ];

   public $timestamps = false;

    public function destino(){
        return $this->belongsTo(Destino::class,'destino_id');
    }

    public function origen(){
        return $this->belongsTo(Destino::class,'origen_id');
    }

}
