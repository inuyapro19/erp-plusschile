<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Using Closure based composers...
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $view->with('notificaciones', Auth::user()->unreadNotifications);

                // Obtener y compartir permisos
                $permisos = Auth::user()->getAllPermissions()->pluck('name'); // Asegúrate de que el método getAllPermissions() existe y es accesible
                $view->with('permisos', $permisos);
            }
        });
    }
}
