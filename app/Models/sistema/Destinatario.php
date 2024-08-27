<?php

namespace App\Models\sistema;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destinatario extends Model
{
    use HasFactory;

    protected $table = 'destinatarios';

    protected $fillable = [
        'email',
        'type',
    ];
}
