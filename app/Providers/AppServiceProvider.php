<?php

namespace App\Providers;

use App\Models\Viaje;
use App\Observers\ViajeObserver;
use App\View\Components\MenuComponent;
use App\View\Components\MenuItemComponent;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Viaje::observe(ViajeObserver::class);
        Blade::component('menu', MenuComponent::class);
        Blade::component('menu-item', MenuItemComponent::class);
    }
}
