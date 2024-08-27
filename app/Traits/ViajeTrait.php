<?php
namespace App\Traits;
use App\Models\Buses;
use App\Models\MontoAsignacion;
use App\Models\MontoViaje;
use App\Models\Trabajador;
use App\Models\TrabajadorViaje;
use App\Models\Viaje;
use Illuminate\Support\Facades\Auth;

trait ViajeTrait{

    public function createViaje($request)
    {
        // Aquí va la creación del viaje
          return Viaje::create([
                'empleador_id' =>$request->empleador_id,
                'cliente_id'=> $request->cliente_id == 0 ? null : $request->cliente_id,
                'tipo_viaje'=>$request->tipo_viaje,
                'nro_viaje'=>$request->nro_viaje ?? 0,
                'buses_id' =>$request->bus_id,
                'hora_salida'=>$request->hora_viaje,
                'fecha_llegada'=>$request->fecha_llegada,
                'hora_llegada'=>$request->hora_llegada,
                'fecha_viaje' =>$request->fecha_viaje,
                'destino_id'=>$request->destino_id == 0 ? null : $request->destino_id,
                'origen_id'=>$request->origen_id == 0 ? null : $request->origen_id ,
                'nota_viaje'=>$request->nota_viaje
            ]);
    }


    public function handleViajeEspecial($request, $viaje)
    {
        // Aquí va el manejo del viaje especial

        $viaje->viaje_especial = $request->viaje_especial == true ? 'Y' : 'N';
        $viaje->destino_especial = $request->destino_espacial;
        $viaje->origen_especial = $request->origen_espacial;

        $viaje->save();

        return 'success';
    }

    public function createMontoAsignacion( $request,  $viaje)
    {
        // Aquí va la creación del monto asignado
      return  MontoAsignacion::create([
            'nro_folio'=>$request->nro_folio,
            'monto_asignado'=>$request->monto_asignado,
            'glosas'=>'Monto inicial viaje',
            'viaje_id'=>$viaje->id,
            'user_id'=> Auth::user()->id,
            'fecha'=> now()
        ]);
    }

    public function createMontoViaje( $request,  $viaje)
    {
        // Aquí va la creación del monto de viaje
        return  MontoViaje::create([
            //'monto_asignacion_id'=>$monto->id,
            'viaje_id'=>$viaje->id,
            'monto_total'=>$request->monto_asignado,
            'user_id'=>Auth::user()->id,
            'responsable_id'=>1,
        ]);

    }

    public function updateBusStatus($request,$status)
    {
        // Aquí va la actualización del estado del autobús
        $bus = Buses::find($request->bus_id);
        $bus->estado = $status;
        $bus->save();

        return 'success';
    }

    public function updateViajeStatusFinalizados()
    {
        // Seleccionar los viajes que aún no han finalizado y han llegado a su destino
        $viaje_finalizado = Viaje::select('ID', 'NRO_VIAJE', 'BUSES_ID', 'ORIGEN_ID', 'DESTINO_ID', 'VIAJE_ESPECIAL', 'DESTINO_ESPECIAL', 'ORIGEN_ESPECIAL', 'FECHA_VIAJE', 'HORA_SALIDA', 'HORA_LLEGADA', 'FECHA_LLEGADA', 'NOTA_VIAJE', 'NOTIFICACION', 'CLIENTE_ID', 'EMPLEADOR_ID', 'TIPO_VIAJE', 'ESTADO')
            ->where('hora_llegada', '>=', now()->startOfDay()->format('H:i:s'))
            ->where('fecha_llegada', '<=', now()->toDateString())
            ->where('estado', '=', 'EN RUTA')
            //->where('notificacion', '=', 'N')
            ->get();


        if ($viaje_finalizado->count() > 0) {
            foreach ($viaje_finalizado as $viajes) {
                // $viaje_old = Viaje::find($viajes->ID);
                $viaje = Viaje::find($viajes->ID);
                $viaje->notificacion = 'Y';
                $viaje->estado = 'FINALIZADO';
                $viaje->save();

                $bus_old = Buses::find($viajes->BUSES_ID);
                $bus = Buses::find($viajes->BUSES_ID);
                $bus->estado = 'Bus operativo';
                $bus->save();


                $trabajador_id = TrabajadorViaje::where('viaje_id', '=', $viajes->ID)->get();

                foreach ($trabajador_id as $trabajadores) {
                    $trabajador_old = Trabajador::find($trabajadores->trabajador_id);

                    $trabajador = Trabajador::find($trabajadores->trabajador_id);
                    $trabajador->condicion = 'disponible';
                    $trabajador->save();
                }

            }
            // return response($viajes, 200);
        }

        return $viaje_finalizado->count();
    }

    public function updateViajeStatusEnRuta()
    {
        $viajes_en_origen = Viaje::select('ID', 'NRO_VIAJE', 'BUSES_ID', 'ORIGEN_ID', 'DESTINO_ID', 'VIAJE_ESPECIAL', 'DESTINO_ESPECIAL', 'ORIGEN_ESPECIAL', 'FECHA_VIAJE', 'HORA_SALIDA', 'HORA_LLEGADA', 'FECHA_LLEGADA', 'NOTA_VIAJE', 'NOTIFICACION', 'CLIENTE_ID', 'EMPLEADOR_ID', 'TIPO_VIAJE', 'ESTADO')
            ->where('hora_salida', '>=', now()->startOfDay()->format('H:i:s'))
            ->where('fecha_viaje', '<=', now()->toDateString())
            ->where('estado', '=', 'EN ORIGEN')
            ->get();

        if ($viajes_en_origen->count()  > 0) {
            foreach ($viajes_en_origen as $viaje) {
                $viaje->estado = 'EN RUTA';
                $viaje->save();
            }
        }

        return $viajes_en_origen->count();

    }





}
