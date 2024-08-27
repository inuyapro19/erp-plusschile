<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected $commands = [
        //
        'App\Console\Commands\ContratoVencimiento',
        'App\Console\Commands\LiceciaVencimiento',
        'App\Console\Commands\CertificadoBus',
        'App\Console\Commands\ViajeFinalizado',
        'App\Console\Commands\ViajeRuta',
        'App\Console\Commands\DiasLibresFinalizados',
        'App\Console\Commands\VacacionesFinalizadas',
        'App\Console\Commands\LicenciasMedicasFinalizadas',
    ];


    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('contrato:vencimiento')->everyMinute();
        $schedule->command('licencia:vencimiento')->everyMinute();
       // $schedule->command('viaje:finalizar')->everyMinute();
        //$schedule->command('viaje:ruta')->everyMinute();
        //$schedule->command('certificado:bus')->everyMinute();
        //$schedule->command('DiasLibres:finalizar')->everyMinute();
        $schedule->command('vacaciones:finalizar')->everyMinute();
        $schedule->command('licenciaMedicas:finalizar')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
