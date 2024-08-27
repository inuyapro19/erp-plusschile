<?php

namespace App\Console\Commands;

use App\Models\Trabajador;
use App\Models\TramiteLicenciaMedica;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class LicenciasMedicasFinalizadas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'licenciaMedicas:finalizar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'cambia estado a las licencias medicas que ya han finalizado';

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
        $licencias_finalizadas = DB::select("select * from tramite_licencia_medicas
                                                    where fecha_fin <= curdate() and estado = 'Iniciado' and trabajador_id is not null");
        //SI HAY REGISTRO
        $licencias_contar = count($licencias_finalizadas);
        if($licencias_contar>0){
            foreach ($licencias_finalizadas as $licencias)
            {
                //CAMBIAR ESTADO A FINALIZADO
                $licencia =  TramiteLicenciaMedica::find($licencias->id);
                $licencia->estado = 'finalizado';
                $licencia->save();
                //VUELVE A DEJAR EL TRABAJAR DISPONIBLE
                $trabajador = Trabajador::find($licencias->trabajador_id);
                $trabajador->condicion = 'Disponible';
                $trabajador->save();
            }
        }
        return $licencias_finalizadas;
    }
}
