<?php

namespace App\Models\sistema;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogSistema extends Model
{
    use HasFactory;

    protected $table = 'log_sistemas';

    protected $fillable = [
        'user_id',
        'fecha',
        'accion',
        'tabla',
        'registro_id',
        'registro_anterior',
        'registro_nuevo',
    ];

    public $timestamps = false;

    public function user(){
        return $this->belongsTo(User::class);
    }



}
