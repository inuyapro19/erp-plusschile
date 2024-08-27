<?php

namespace App\Http\Controllers;

use App\Models\Buses;
use App\Models\MontoAsignacion;
use App\Models\MontoViaje;
use App\Models\sistema\FolioCertificadoSanitizacion;
use App\Models\sistema\LogSistema;
use App\Models\Trabajador;
use App\Models\TrabajadorViaje;
use App\Models\Viaje;
use App\Models\Vistas\ViajeProximos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;
use \App\Traits\TrabajadorViajeTrait;
use Illuminate\Support\Facades\Log;
use \App\Traits\ViajeTrait;
class ViajeController extends Controller
{
    use TrabajadorViajeTrait , ViajeTrait;
    public function index()
    {
        $estados = request('estado');
        if ($estados == 'finalizados'){
            return view('viajes.finalizados',
                [
                    'notificaciones'=>auth()->user()->unreadNotifications
                ]);
        }else{
            return view('viajes.index',
                [
                    'notificaciones'=>auth()->user()->unreadNotifications
                ]);
        }
    }

    public function getViajes(){
        try {
            $opcion = request('opcion');
            //si la opcion es paginate, se paginan los viajes
            if ($opcion === 'paginate'){
                $viajes = Viaje::with(['trabajadores','bus','empleador','destino','origen','monto_asignaciones','monto_asignaciones.user'])
                    ->whereHas('origen')
                    ->whereHas('destino')
                    ->filtros()
                    ->filtroporBus()
                    //->where('estado','!=','FINALIZADO')
                    ->filtrosEstados()
                    ->orderBy('fecha_viaje','desc')
                    ->orderBy('hora_salida','asc')
                    ->paginate();
            }else{
                $viajes = Viaje::with(['trabajadores','bus','empleador','destino','origen','monto_asignaciones','monto_asignaciones.user',])
                    ->whereHas('origen')
                    ->whereHas('destino')
                    ->filtros()
                    ->filtroporBus()
                    //->where('estado','!=','FINALIZADO')
                    ->filtrosEstados()
                    ->orderBy('id','desc')
                    ->get();
            }


          return response($viajes,200);

        }catch (\Exception $exception){
            return response($exception,422);
        }
    }

    public function getViajesFinalizados(){
        try {
            $viajes = Viaje::with(['trabajadores','bus','empleador','destino','origen','monto_asignaciones'])
                ->where('estado','=','FINALIZADO')
                ->orderBy('fecha_viaje','desc')
                ->get();

            return response($viajes,200);

        }catch (\Exception $exception){
            return response($exception,422);
        }
    }


   public function create()
   {
       return view('viajes.create',
           [
               'notificaciones'=>auth()->user()->unreadNotifications
           ]);
   }

   public function store(Request $request){
       try {
           $request->validate([
               'empleador_id' =>'required',
               'tipo_viaje'=>'required',
               'nro_viaje'=>'required_if:tipo_viaje,==,servicio en linea',
               'bus_id'=>'required',
               'hora_viaje'=>'required',
               'fecha_viaje' =>'required',
               /*'destino_id'=>'required',
               'origen_id'=>'required',*/
               'nro_folio'=>'required',
               'monto_asignado'=>'required',
               'tripulacion'=>'required',
           ]);

           $viaje = $this->createViaje($request);

           //se crea el log del viaje
           LogSistema::create([
               'user_id'=>Auth::user()->id,
               'fecha'=>date('Y-m-d H:i:s'),
               'accion'=>'CREACION DE VIAJE',
               'tabla'=>'viajes',
               'registro_id'=>$viaje->id,
               'registro_anterior'=>null,
               'registro_nuevo'=>$viaje->toJson()
           ]);

           if ($request->viaje_especial){
               $this->createViajeEspecial($request,$viaje);
           }
           //montos viajes
          $monto = $this->createMontoAsignacion($request,$viaje);

           //generar el monto de viaje
          $this->createMontoViaje($request,$viaje);

           LogSistema::create([
               'user_id'=>Auth::user()->id,
               'fecha'=>date('Y-m-d H:i:s'),
               'accion'=>'ASIGNACION DE MONTO INICIAL',
               'tabla'=>'monto_asignacion_peajes',
               'registro_id'=>$monto->id,
               'registro_anterior'=>null,
               'registro_nuevo'=>$monto->toJson()
           ]);


           $tripulacion = $request->tripulacion; // Asegúrate de que 'trabajadores' sea el nombre correcto del campo enviado desde Vue.js

           //transforma el json en array
           $tripulacion = json_decode($tripulacion, true);

           foreach ($tripulacion as $tripulacionData) {
               $this->createTrabajadorViajeFromArray($tripulacionData, $viaje->id);
           }

           //actualiza el estado del bus
          $this->updateBusStatus($request,'en ruta');

           return response('success',200);

       }catch (Exception $exception){
            return response($exception,422);
       }
   }

   public function cambio_estado_viaje(Request $request,$id){
       try {
           $request->validate([
              'estado'=>'required',
           ]);
           $viaje_old = Viaje::find($id);
          $viaje = Viaje::find($id);

          $buses_id = $viaje->buses_id;

          $viaje->estado = $request->estado;
          $viaje->save();
           // return response($buses_id);
              LogSistema::create([
                'user_id'=>Auth::user()->id,
                'fecha'=>date('Y-m-d H:i:s'),
                'accion'=>'CAMBIO DE ESTADO DE VIAJE',
                'tabla'=>'viajes',
                'registro_id'=>$viaje->id,
                'registro_anterior'=>$viaje_old->toJson(),
                'registro_nuevo'=>$viaje->toJson()
              ]);

          if ($request->estado == 'FINALIZADO' ){

              $trabajador_viaje = TrabajadorViaje::where('viaje_id','=',$id)->get();

              foreach ($trabajador_viaje as $item) {
                  $trabajador_old = Trabajador::find($item->trabajador_id);
                 $trabajador = Trabajador::find($item->trabajador_id);
                 $trabajador->condicion = 'disponible';
                 $trabajador->save();

                  LogSistema::create([
                      'user_id'=>Auth::user()->id,
                      'fecha'=>date('Y-m-d H:i:s'),
                      'accion'=>'CAMBIO DE ESTADO DE CONDUCTOR POR FINALIZACION DE VIAJE',
                      'tabla'=>'trabajadores',
                      'registro_id'=>$trabajador->id,
                      'registro_anterior'=>$trabajador_old->toJson(),
                      'registro_nuevo'=>$trabajador->toJson()
                  ]);

              }

              //cambia el estado del bus a operativo
                $bus_old = Buses::find($buses_id);
              $buses = Buses::find($buses_id);

             // return $buses;

              $buses->estado = 'Bus operativo';
              $buses->save();

              //LOG SISTEMA CAMBIO DE ESTADO DE BUS
                LogSistema::create([
                    'user_id'=>Auth::user()->id,
                    'fecha'=>date('Y-m-d H:i:s'),
                    'accion'=>'CAMBIO DE ESTADO DE BUS POR FINALIZACION DE VIAJE',
                    'tabla'=>'buses',
                    'registro_id'=>$buses->id,
                    'registro_anterior'=>$bus_old->toJson(),
                    'registro_nuevo'=>$buses->toJson()
                ]);

          }

          //si el viaje es suspendido
            if ($request->estado == 'SUSPENDIDO' ){

                $viaje->motivo_supecion = $request->motivo_supencion;

                $trabajador_viaje = TrabajadorViaje::where('viaje_id','=',$id)->get();

                foreach ($trabajador_viaje as $item) {
                    $trabajador_old = Trabajador::find($item->trabajador_id);
                    $trabajador = Trabajador::find($item->trabajador_id);
                    $trabajador->condicion = 'disponible';
                    $trabajador->save();

                    //log de sistema para el trabajador
                    LogSistema::create([
                        'user_id'=>Auth::user()->id,
                        'fecha'=>date('Y-m-d H:i:s'),
                        'accion'=>'CAMBIO DE ESTADO DE CONDUCTOR POR SUSPENCION DE VIAJE',
                        'tabla'=>'trabajadores',
                        'registro_id'=>$trabajador->id,
                        'registro_anterior'=>$trabajador_old->toJson(),
                        'registro_nuevo'=>$trabajador->toJson()
                    ]);

                }

                //cambia el estado del bus a operativo
                $bus_old = Buses::find($buses_id);
                $buses = Buses::find($buses_id);

                // return $buses;

                $buses->estado = 'Bus operativo';
                $buses->save();

                //log de sistema para el bus

                LogSistema::create([
                    'user_id'=>Auth::user()->id,
                    'fecha'=>date('Y-m-d H:i:s'),
                    'accion'=>'CAMBIO DE ESTADO DE BUS POR SUSPENCION DE VIAJE',
                    'tabla'=>'buses',
                    'registro_id'=>$buses->id,
                    'registro_anterior'=>$bus_old->toJson(),
                    'registro_nuevo'=>$buses->toJson()
                ]);

            }

          return response('success',200);

       }catch (\Exception $exception){
           return response($exception,422);
       }
   }

   public function reemplazar_tripulacion(Request $request,$id){
       try {
           //primero elimina

               $tripulante = TrabajadorViaje::where('trabajador_id','=',$request->id_tripulante)
                                            ->where('viaje_id','=',$request->viaje_id)
                                            ->first();
               $tripulante->delete();
               //el trabajador pasa a esta disponible
                $trabajador = Trabajador::find($request->id_tripulante);
                $trabajador->condicion = 'disponible';
                $trabajador->save();
            //luego agrega , se debe dejar un comentario

            $new_tripulante = TrabajadorViaje::create([
                'trabajador_id'=>$request->trabajador_id,
                'viaje_id'=>$request->viaje_id
            ]);

            //el nuevo tripulante pasa a ruta
           $trabajador_new = Trabajador::find($request->trabajador_id);
           $trabajador_new->condicion = 'en ruta';
           $trabajador_new->save();

           return response('success',200);
       }catch (\Exception $exception){
           return response($exception,422);
       }
   }

    public function ultimo_viaje(){
        try {
          $viaje =  Viaje::get()->last();
          //$viaje->id;
          return response($viaje,200);
        } catch (\Exception $exception){
            return response($exception,422);
        }
    }

    //funcion para agregar un nuevo tripulante
    public function agregar_tripulante(Request $request){
        try {
            $request->validate([
                'trabajador_id'=>'required',
                'viaje_id'=>'required'
            ]);

            $trabajador = Trabajador::find($request->trabajador_id);
            $trabajador->condicion = 'en ruta';
            $trabajador->save();

            $tripulante = TrabajadorViaje::create([
                'trabajador_id'=>$request->trabajador_id,
                'viaje_id'=>$request->viaje_id
            ]);

            return response('success',200);
        }catch (\Exception $exception){
            return response($exception,422);
        }
    }

    public function update(Request $request,$id){
        try {
            $viaje_old = Viaje::find($id);
            $viaje = Viaje::find($id);

            $viaje->buses_id = $request->bus_id;
            $viaje->nro_viaje = $request->nro_viaje;
            $viaje->nota_viaje = $request->nota_viaje;
            $viaje->hora_salida = $request->hora_viaje;
            $viaje->fecha_viaje = $request->fecha_viaje;
            $viaje->save();

            LogSistema::create([
                'user_id'=>Auth::user()->id,
                'fecha'=>date('Y-m-d H:i:s'),
                'accion'=>'CAMBIOS EN VIAJE',
                'tabla'=>'viajes',
                'registro_id'=>$viaje->id,
                'registro_anterior'=>$viaje_old->toJson(),
                'registro_nuevo'=>$viaje->toJson()
            ]);

            //bus cambiado a operativo
            $bus_old =  Buses::find($request->bus_id_old);
            $bus_old->estado = 'Bus operativo';
            $bus_old->save();
            //cambia el bus a en ruta
            $bus_new=  Buses::find($request->bus_id);
            $bus_new->estado = 'en ruta';
            $bus_new->save();

            LogSistema::create([
                'user_id'=>Auth::user()->id,
                'fecha'=>date('Y-m-d H:i:s'),
                'accion'=>'CAMBIO DE BUS EN VIAJE',
                'tabla'=>'buses',
                'registro_id'=>$bus_new->id,
                'registro_anterior'=>$bus_old->toJson(),
                'registro_nuevo'=>$bus_new->toJson()
            ]);

            return response('success',200);

        }catch (Exception $exception){
            return response($exception,422);
        }
    }

    public function destroy($id){
        try {
            $viaje = Viaje::with('trabajadores','bus')->find($id);

            $monto =MontoViaje::where('viaje_id','=',$id)->first();
            $monto->delete();

            //cambiar estado de trabajadores a disponibles
            foreach ($viaje->trabajadores as $item){
                $trabajador = Trabajador::find($item->id);
                $trabajador->condicion = 'disponible';
                $trabajador->save();
            }
            //elimina los trabajadores asignados al viaje
            $viaje->trabajadores()->detach();
            //cambiar estado del bus a operativo
                $bus = Buses::find($viaje->buses_id);
                $bus->estado = 'Bus operativo';
                $bus->save();

            $viaje->delete();
            return response('success',200);
        }catch (Exception $exception){
            return response($exception,422);
        }
    }

    public function ProximosViajesview(){
        $viajes = ViajeProximos::all();
        return view('viajes.proximos_viajes',compact('viajes'));
    }
    //poximos viajes
    public function proximos_viajes()
    {
        try {
            $viajes = ViajeProximos::all();
            return response($viajes, 200);
        } catch (\Exception $exception) {
            return response($exception, 422);
        }
    }

     public function  comprobanteSalida($id){
       //$viaje = Viaje::with('trabajadores','bus')->find($id);
         $folio =  FolioCertificadoSanitizacion::create([
             //increamenta el folio anterior en 1
             'folio'=>FolioCertificadoSanitizacion::where('tipo_folio','CERTIFICADO DE SALIDA')->orderBy('folio','desc')->first()->folio + 1,
             'fecha_creacion'=>date('Y-m-d'),
             'hora'=>date('H:i:s'),
                'tipo_folio'=>'CERTIFICADO DE SALIDA',
         ]);

         $viaje = Viaje::with('bus','trabajadores')
                         ->where('id',$id)
                         ->first();

         $patente = $viaje->bus->patente;
         $nro_bus = $viaje->bus->numero_bus;



         $nro_folio = str_pad($folio->folio, 6, "0", STR_PAD_LEFT);

      $tipo = \request('TIPO_AUTORIZACION');
       /*return response([
                'viaje'=>$viaje,
                'patente'=>$patente,
                'nro_bus'=>$nro_bus,
                'folio'=>$folio
            ],200);*/


        $trabajador = Trabajador::with(['contrato','contrato.cargo'])
                                    ->where('user_id',Auth::user()->id)
                                    ->first();

        $nombre = $trabajador->primer_nombre.' '.$trabajador->segundo_nombre.' '.$trabajador->primer_apellido.' '.$trabajador->segundo_apellido;
        $cargo = $trabajador->contrato->cargo->nombre_cargo;
        $rut = $trabajador->rut;

        return view('pdf.certificado_salida_taller',[
            'viaje'=>$viaje,
            'patente'=>$patente,
            'nro_bus'=>$nro_bus,
            //fecha de viaje en formato dd/mm/aaaa
            'fecha_viaje'=>date('d/m/Y',strtotime($viaje->fecha_viaje)),
            //hora de salida en formato hh:mm y resta 1 hora
            'hora_salida'=>date('H:i',strtotime($viaje->hora_salida)-3600),
            'hora_documento'=>date('H:i'),
            'fecha_documento'=>date('d/m/Y'),
            'nombre_encargado'=>$nombre,
            'cargo_encargado'=>$cargo,
            'rut_encargado'=>$rut,
            'folio'=>$nro_folio,
            'trabajadores'=>$viaje->trabajadores,
            'tipo'=>$tipo
        ]);
     }

        public function  getCertificadoSanitizacion($id = 0){
          $folio =  FolioCertificadoSanitizacion::create([
                //increamenta el folio anterior en 1
                'folio'=>FolioCertificadoSanitizacion::where('tipo_folio','CERTIFICADO SANITIZACION')->orderBy('folio','desc')->first()->folio + 1,
                'fecha_creacion'=>date('Y-m-d'),
                'hora'=>date('H:i:s'),
                'tipo_folio'=>'CERTIFICADO SANITIZACION',
            ]);

            $viaje = Viaje::with('bus','bus.empleador')
                                ->where('id',$id)
                                ->first();

            //extraer el empleador
            $empleador = $viaje->bus->empleador->nombre_empleador;
            $rut_empleador = $viaje->bus->empleador->rut;
            $patente = $viaje->bus->patente;
            $nro_bus = $viaje->bus->numero_bus;

            //rellenar con zeros a la izquierda el folio
            $nro_folio = str_pad($folio->folio, 6, "0", STR_PAD_LEFT);

            $fecha_documento = Carbon::now()
                                    ->locale('es')
                                    ->isoFormat('D [de] MMMM [de] YYYY');


            return view('pdf.certicado_sanitizacion',[
                'empleador'=>$empleador,
                'rut_empleador'=>$rut_empleador,
                'patente'=>$patente,
                'nro_bus'=>$nro_bus,
                'nro_folio'=>$nro_folio,
                'fecha'=>date('d-m-Y'),
                'hora'=>date('H:i:s'),
                'fecha_documento'=>$fecha_documento,

            ]);
        }




        //actualizacion masiva de viajes
    public function updateViajesFinalizar(){
        try{

            $viajeRuta = $this->updateViajeStatusEnRuta();

            $viajeFinalizados = $this->updateViajeStatusFinalizados();

            return response([
                'viajeRuta'=>$viajeRuta,
                'viajesFinalizados'=>$viajeFinalizados
            ],200);

        }catch (Exception $exception){
            return response($exception,422);
        }
    }


}
