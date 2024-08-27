<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\MyResetPassword;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\HasNotifications;
//use Illuminate\Database\Eloquent\SoftDeletes;
class User extends Authenticatable
{
    use HasFactory, Notifiable , HasRoles,HasNotifications, softDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'apellidos',
        'rut',
        'email',
        'password',
        'digitos_rut',
        'cargo',
        'tpluss' ,
        'thcm' ,
        'tgcm' ,
        'tdcm' ,
        'bgcm',
        'gcm',
        'turis',
        'administracion' ,
        'mantencion' ,
        'servicios_generales' ,
        'agentes_ventas' ,
        'plussmineria',
        'primer_login',
        'oficina_id'
    ];

    protected $dates = ['deleted_at'];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MyResetPassword($token));
    }

    public function scopeBusqueda($query,$valor)
    {
        if ($valor)
            return $query->where('name','=','%'.$valor.'%');
    }

   public function trabajador(){
        return $this->hasOne(Trabajador::class,'user_id');
    }

    public function votaciones(){

        return $this->hasMany(Votacion::class);

    }


}
