<?php

namespace App\Console\Commands;

use App\Mail\ViajeFinalizadoMail;
use App\Models\sistema\LogSistema;
use App\Models\Trabajador;
use App\Models\TrabajadorViaje;
use App\Models\User;
use App\Models\Viaje;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Node\NodeWalker;
use Illuminate\Support\Facades\Mail;


class ViajeFinalizado extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'viaje:finalizar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Finaliza el viaje si la hora y fecha actual es igual a la hora fecha de llegada';

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
        $viaje_finalizado = DB::select("SELECT ID, NRO_VIAJE, BUSES_ID, ORIGEN_ID, DESTINO_ID, VIAJE_ESPECIAL, DESTINO_ESPECIAL, ORIGEN_ESPECIAL, FECHA_VIAJE, HORA_SALIDA, HORA_LLEGADA, FECHA_LLEGADA, NOTA_VIAJE, NOTIFICACION,CLIENTE_ID, EMPLEADOR_ID, TIPO_VIAJE, ESTADO
                                              FROM viajes
                                              WHERE (hora_llegada >= TIME(CURRENT_DATE()) AND fecha_llegada <= CURDATE())
                                              AND (estado ='EN RUTA')
                                              AND (notificacion = 'N');");
        //return response($viaje_finalizado,200);
        //si devuelve registros cambiar estado a traves del foreach
        $viajes_contar = count($viaje_finalizado);
        if($viajes_contar>0){
            foreach ($viaje_finalizado as $viajes)
            {
                $viaje_old =  Viaje::find($viajes->ID);
                $viaje =  Viaje::find($viajes->ID);
                $viaje->notificacion = 'Y';
                $viaje->estado = 'FINALIZADO';
                $viaje->save();

                LogSistema::create([
                    'user_id'=>1,
                    'fecha'=>date('Y-m-d H:i:s'),
                    'accion'=>'VIAJE FINALIZADO POR CRONJOB',
                    'tabla'=>'viajes',
                    'registro_id'=>$viaje->id,
                    'registro_anterior'=>$viaje_old->toJson(),
                    'registro_nuevo'=>$viaje->toJson()
                ]);

                $bus_old = \App\Models\Buses::find($viajes->BUSES_ID);
                $bus = \App\Models\Buses::find($viajes->BUSES_ID);
                $bus->estado = 'Bus operativo';
                $bus->save();

                LogSistema::create([
                    'user_id'=>1,
                    'fecha'=>date('Y-m-d H:i:s'),
                    'accion'=>'BUS EN RUTA A OPERATIVO POR CRONJOB',
                    'tabla'=>'viajes',
                    'registro_id'=>$bus->id,
                    'registro_anterior'=>$bus_old->toJson(),
                    'registro_nuevo'=>$bus->toJson()
                ]);

                $trabajador_id = TrabajadorViaje::where('viaje_id','=',$viajes->ID)->get();

                foreach ($trabajador_id as $trabajadores){
                    $trabajador_old = Trabajador::find($trabajadores->trabajador_id);

                    $trabajador = Trabajador::find($trabajadores->trabajador_id);
                    $trabajador->condicion = 'disponible';
                    $trabajador->save();

                    LogSistema::create([
                        'user_id'=>1,
                        'fecha'=>date('Y-m-d H:i:s'),
                        'accion'=>'TRIPULANTE EN RUTA A DISPONIBLE POR CRONJOB',
                        'tabla'=>'viajes',
                        'registro_id'=>$trabajador->id,
                        'registro_anterior'=>$trabajador_old->toJson(),
                        'registro_nuevo'=>$trabajador->toJson()
                    ]);

                }

            }
            //dispara correo recordatorio al encargado
            Mail::send(new ViajeFinalizadoMail($viaje_finalizado));

            //se busca usuarios con el rol operaciones y se les notificas
            $roles =   \Spatie\Permission\Models\Role::with('users')
                ->where('name','=','operaciones')
                ->first();

            foreach ($roles->users as $user){
                $user_notificacion = User::find($user->id);
                $user_notificacion->notify(new ViajeFinalizadoNotifications());
            }
        }

        //dispara notificacion

        return $viaje_finalizado;
    }
}
