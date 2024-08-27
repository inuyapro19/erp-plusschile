<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Viaje;
use App\Notifications\GlobalNotification;
use App\Notifications\NuevoViajeNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
class ViajeObserver
{
    /**
     * Handle the Viaje "created" event.
     *
     * @param  \App\Models\Viaje  $viaje
     * @return void
     */
    public function created(Viaje $viaje)
    {
        Log::channel('file')->info('Se agregó nueva información al sistema', [
            'viaje_id' => $viaje->id,
            'user_id' => Auth::user()->id,
            'information' => 'Se ha creado un nuevo viaje'.$viaje->toJson(),
        ]);

        //notificar a los usuarios de role operaciones
        $users = User::role('operaciones')->get();
        foreach ($users as $user) {
            $user->notify(new GlobalNotification(
                'Nuevo viaje',
                'Se ha creado un nuevo viaje',
                $viaje));
        }


    }

    /**
     * Handle the Viaje "updated" event.
     *
     * @param  \App\Models\Viaje  $viaje
     * @return void
     */
    public function updated(Viaje $viaje)
    {
        Log::channel('file')->info('Se modifico información al sistema', [
            'viaje_id' => $viaje->id,
            'user_id' => Auth::user()->id,
            'information' => 'Se ha creado un nuevo viaje'.$viaje->toJson(),
        ]);

        //notificar a los usuarios de role operaciones
       /* $users = User::role('operaciones')->get();
        foreach ($users as $user) {
            $user->notify(new NuevoViajeNotification($viaje));
        }*/
    }

    /**
     * Handle the Viaje "deleted" event.
     *
     * @param  \App\Models\Viaje  $viaje
     * @return void
     */
    public function deleted(Viaje $viaje)
    {
        //
    }

    /**
     * Handle the Viaje "restored" event.
     *
     * @param  \App\Models\Viaje  $viaje
     * @return void
     */
    public function restored(Viaje $viaje)
    {
        //
    }

    /**
     * Handle the Viaje "force deleted" event.
     *
     * @param  \App\Models\Viaje  $viaje
     * @return void
     */
    public function forceDeleted(Viaje $viaje)
    {
        //
    }
}
