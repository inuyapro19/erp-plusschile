<?php

namespace App\Http\Controllers;

use App\Models\GastoPasajeViaje;
use App\Models\MontoAsignacion;
use App\Models\MontoViaje;
use App\Models\Pasaje;
use App\Models\Vistas\GastoPasajeViaje as GastoView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RecaudacionGastosController extends Controller
{
   public function index(){
       return view('gastos.index',[
           'notificaciones'=>auth()->user()->unreadNotifications
       ]);
   }

   public function getGastos(){
       try {

           $gastos = GastoView::filtros()
               ->orderBy('VIAJE_ID','DESC')
               ->paginate(30);

           return response($gastos,200);

       }catch (\Exception $exception){
           return response($exception,422);
       }
   }

//monto de viaje
    public function getMontoViaje(){
         try {

              $monto_viaje = GastoPasajeViaje::all();

              return response($monto_viaje,200);

         }catch (\Exception $exception){
              return response($exception,422);
         }
    }


    public function store(Request $request,$id = 0){
        try {

            //requiero el viaje id
            $viaje_id = $request->viaje_id;
            $monto_viaje = MontoViaje::where('viaje_id',$viaje_id)->first();

            $gastos = json_decode($request->datos);

            foreach ($gastos as $datos){
                $gasto =  GastoPasajeViaje::firstOrNew(['id'=>$datos->id]);
                $gasto->monto_gasto = $datos->monto_gasto;
                $gasto->nro_documento = $datos->nro_documento;
                $gasto->tipo = 'GASTOS';
                $gasto->fecha = $datos->fecha;
                $gasto->monto_viaje_id = $monto_viaje->id;
                $gasto->user_id = Auth::user()->id;
                $gasto->tipo_id = $datos->tipo_id;
                $gasto->tripulacion_id = $request->tripulacion_id;
                $gasto->save();
            }

            $monto_viaje->responsable_id = $request->tripulacion_id;

            /*
            $folio = MontoAsignacion::find($request->folio_id);
            $folio->estado = 'conciliar';
            $folio->save();*/

            //'CONCILIADO','NO CONCILIADO','SALDO A DEVOLVER'

            $monto_viaje->estado = $request->total_final == 0 ? 'CONCILIADO' : 'NO CONCILIADO';

            if ($request->total_final < 0) {
                $monto_viaje->estado = 'SALDO A DEVOLVER';
            }

            $monto_viaje->save();



            return response('success',200);

        }catch (Exception $exception){
            return response($exception,422);
        }
    }

    public function destroy($id){
        try {
            $gasto = GastoPasajeViaje::find($id);
            $gasto->delete();
            return response('success',200);
        }catch (\Exception $exception){
            return response($exception,422);
        }
    }

}
