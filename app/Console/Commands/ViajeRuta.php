<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ViajeRuta extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'viaje:ruta';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cambia el estado de los viajes  de en origen a en ruta';

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

        $viaje_ruta = DB::select("SELECT ID, NRO_VIAJE, BUSES_ID, ORIGEN_ID, DESTINO_ID, VIAJE_ESPECIAL, DESTINO_ESPECIAL, ORIGEN_ESPECIAL, FECHA_VIAJE, HORA_SALIDA, HORA_LLEGADA, FECHA_LLEGADA, NOTA_VIAJE, NOTIFICACION,CLIENTE_ID, EMPLEADOR_ID, TIPO_VIAJE, ESTADO
                                              FROM viajes
                                              WHERE (hora_salida <= TIME(CURRENT_DATE()) AND fecha_viaje <= CURDATE())
                                              AND estado = 'EN ORIGEN'
                                              AND (notificacion = 'N')");

        $viajes_contar = count($viaje_ruta);

        if($viajes_contar>0){
            foreach ($viaje_ruta as $viajes)
            {
                $viaje =  Viaje::find($viajes->ID);
                //$viaje->notificacion = 'Y';
                $viaje->estado = 'EN RUTA';
                $viaje->save();
            }
        }

    }
}
