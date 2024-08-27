<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\LicenciaVencimientoNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class LiceciaVencimiento extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'licencia:vencimiento';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comprueba cuando la licencia de conducir esta por vencer';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // DEBE DISPARASE UNA VEZ AL DIA
        $trabajador_por_vencer = DB::select('SELECT t.codigo_trabajador,t.rut,concat(t.primer_nombre," ",t.primer_apellido) as nombres,t.user_id,DATEDIFF(fecha_de_vencimiento, now()) as dias_por_vencer
                                            from licencia_conducir lc join trabajadores t on t.id = lc.trabajador_id
                                            where lc.fecha_de_vencimiento > now()');

        foreach ($trabajador_por_vencer as $item) {

            if ($item->dias_por_vencer==30 || $item->dias_por_vencer == 5){
                $user = User::find($item->user_id);
                $user->notify(new LicenciaVencimientoNotification($item));

                Mail::to('pedroaraya@fizz.cl')->send(new LicenciaMail(
                    $item->codigo_trabajador,
                    $item->rut,
                    $item->nombres,
                    $item->dias_por_vencer
                ));

            }else{
                return 0;
            }
        }
    }
}
