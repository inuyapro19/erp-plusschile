<?php

namespace App\Console\Commands;

use App\Models\GestionTripulacion;
use App\Models\Trabajador;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DiasLibresFinalizados extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DiasLibres:finalizar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Finzaliza los dias libre que ya han finalizado';

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
        $diaslibres_finalizadas = DB::select("select * from gestion_trabajadores
                                                    where fecha_termino <= curdate()
                                                    and tipo = 'dias libre'
                                                    and estado = 'EN CURSO'");
        //SI HAY REGISTRO
        $diaslibres_contar = count($diaslibres_finalizadas);
        if($diaslibres_contar>0){
            foreach ($diaslibres_finalizadas as $dias)
            {
                //CAMBIAR ESTADO A FINALIZADO
                $dias =  GestionTripulacion::find($dias->id);
                $dias->estado = 'FINALIZADO';
                $dias->save();
                //VUELVE A DEJAR EL TRABAJAR DISPONIBLE
                $trabajador = Trabajador::find($dias->trabajador_id);
                $trabajador->condicion = 'disponible';
                $trabajador->save();
            }
        }
        return $diaslibres_finalizadas;
    }
}
