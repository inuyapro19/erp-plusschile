<?php

namespace App\Console\Commands;

use App\Mail\ContralVencimientoMail;
use App\Models\Contrato;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Notification;
use App\Notifications\ContratoVencimientoNotifications;

class ContratoVencimiento extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contrato:vencimiento';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica si el contrato esta por llegar a su fin y envia una notificacion al usuario';

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

        // UNA VEZ AL DIA
        $trabajador_por_vencer = DB::select('SELECT t.codigo_trabajador,t.rut,concat(t.primer_nombre," ",t.primer_apellido) as nombres,t.user_id,DATEDIFF(fecha_vencimiento_contrato, now()) as dias_por_vencer
                                            from contrato join trabajadores t on contrato.trabajador_id = t.id
                                            where fecha_vencimiento_contrato > now()');
        //cantidad de registros
        $cantidad_registros = count($trabajador_por_vencer);


        if ($cantidad_registros>0){
           /* foreach ($trabajador_por_vencer as $item) {

                if ($item->dias_por_vencer==30 || $item->dias_por_vencer == 5){


                }else{
                    return 0;
                }
            }*/
        }



    }
}
