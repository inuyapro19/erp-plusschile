<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaUser extends Model
{
    use HasFactory;

    protected $table = 'categoria_user';

    public $timestamps = false;

    protected $fillable = [
       'categoria_id',
       'user_id'
   ];


}
