<?php

namespace App\Http\Controllers;

use App\Models\MontoEntregado;
use App\Models\Vistas\MontoEntregado as Montos;
use App\Models\Viaje;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

//use mysql_xdevapi\Exception;

class MontoEntregadoController extends Controller
{

    public function index(){
        return view('monto_entregado.index',[
            'notificaciones'=>auth()->user()->unreadNotifications
        ]);
    }


     public function getMontoEntregado(){
          try {
              //filtro por id monto asignado
             /*$montos = Viaje::with('monto_asignaciones')
                            ->where('estado','=','EN RUTA')
                           // ->where('estado','=','EN ORIGEN')
                            ->get();*/

            $montos = Montos::filtros()
                             ->get();

             return response($montos,200);

         }catch (Exception $exception){
            return response($exception,422);
         }
     }

    public function store(Request $request){
        try {

            $request->validate([
                'monto_entregado' => 'required'
            ]);

            MontoEntregado::create([
                'monto_asignacion_peajes_id'=>$request->monto_asignado_id,
                'monto_entregado'=>$request->monto_entregado,
                'nota'=>$request->nota,
                'fecha_entrega'=>now(),
                'user_id'=>Auth::user()->id
            ]);

            return response('success',200);

        }catch (Exception $exception){
            return response($exception,422);
        }
    }

    public function cambioEstado(Request $request,$id){
        try {

            $request->validate([
               'estado'=>'required'
            ]);

           $montos_entregados = MontoEntregado::find($id);
           $montos_entregados->estado = $request->estado;
           $montos_entregados->save();

           return response('success',200);

        }catch (Exception $exception){
            return response($exception,422);
        }
    }

    public function destroy($id){
        try {

          $monto_entregado =  MontoEntregado::find($id);

          $monto_entregado->delete();

          return response('success',200);

        }catch (Exception $exception){
            return response($exception,422);
        }
    }



}
