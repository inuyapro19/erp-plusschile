<?php

namespace App\Console\Commands;

use App\Models\Trabajador;
use App\Models\TrabajadorVacacion;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class VacacionesFinalizadas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vacaciones:finalizar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'cambia estado a las vacaciones que ya han finalizado';

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
        $vacaciones_finalizadas = DB::select("select * from trabajador_vacaciones
                                                    where fecha_ultimo_dia <= curdate()
                                                      and estado='activo' and trabajador_id is not null");
        //SI HAY REGISTRO
        if (count($vacaciones_finalizadas) > 0) {
            foreach ($vacaciones_finalizadas as $vacaciones) {
                //CAMBIAR ESTADO A FINALIZADO
                $vacacion =  TrabajadorVacacion::find($vacaciones->id);
                $vacacion->estado = 'terminada';
                $vacacion->save();

                //VUELVE A DEJAR EL TRABAJAR DISPONIBLE
                $trabajador = Trabajador::find($vacaciones->trabajador_id);
                $trabajador->condicion = 'Disponible';
                $trabajador->save();
            }
        }

        return $vacaciones_finalizadas;
    }
}
