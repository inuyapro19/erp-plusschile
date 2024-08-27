<?php

namespace App\Http\Controllers;

use App\Models\CalendarioConfiguracion;
use Illuminate\Http\Request;

class CalendarioConfiguracionController extends Controller
{
    public function getCalendario(){
        try {
            //obtiene los calendarios agregados
           $calendario =  CalendarioConfiguracion::OrderBy('id','desc')
                                                    ->get();

           return response($calendario,200);

        }catch (Exception $exception){

            return response($calendario,200);

        }
    }

    public function index(){

        return view('calendario.index',
            [
                'notificaciones'=>auth()->user()->unreadNotifications
            ]);

    }

    public function store(Request $request,$id = false){
        try {

            $request->validate([
               'anyo'=>'required',
               'mes'=>'required',
               'dia'=>'required',
               'tipo_de_fecha'=>'required'
            ]);

           $calendario = CalendarioConfiguracion::firstOrNew(['id'=>$id]);

           $calendario->anyo = $request->anyo;
           $calendario->mes  = $request->mes;
           $calendario->dia   = $request->dia;
           $calendario->tipo_de_fecha = $request->tipo_de_fecha;
           $calendario->tipo_de_feriado = $request->tipo_de_feriado;
           $calendario->region_id = $request->has('region_id') ? $request->region_id : null;

           $calendario->save();

           return response('success',200);

        }catch (Exception $exception){
            return response($exception,422);
        }
    }

    public function destroy($id)
    {
        try {

            $calendario = CalendarioConfiguracion::find($id);

            $calendario->delete();

            return response('success',200);

        }catch (\Exception $exception){
            return response('error',422);
        }
    }

}
