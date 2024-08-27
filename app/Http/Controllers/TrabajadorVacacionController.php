<?php

namespace App\Http\Controllers;

use App\Mail\NuevaVacacion;
use App\Models\Trabajador;
use App\Models\TrabajadorVacacion;
use App\Models\Vistas\Vacaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TrabajadorVacacionController extends Controller
{

    public function index(){
        return view('vacaciones.index',[
        'notificaciones'=>auth()->user()->unreadNotifications
        ]);
    }

    public function getTrabajadoresVacaciones($id = false){
        try{
            if ($id){
                $trabajador_vacacion = TrabajadorVacacion::with(['trabajador'])
                                        ->where('id','=',$id)
                                        ->first();
            }else{
                $trabajador_vacacion = Vacaciones::trabajadorID()
                    ->EmpleadorID()
                    ->orderBy('VACACIONES_ID','desc')
                    ->paginate(20);
            }

          return response($trabajador_vacacion,200);
        }catch (\Exception $exception){
            return response($exception,403);
        }
    }

    public function create(){
        return view('vacaciones.create',[
            'notificaciones'=>auth()->user()->unreadNotifications
        ]);
    }

    public function index_solicitud($id){
        return view('profile.solicitud');
    }
    public function store_solicitud(Request $request){
        try {
            $request->validate([
                'dias_habiles_solicitados'=>'required',
                'fecha_primer_dia'=>'required',
            ]);

            $trabajador_id = Trabajador::where('user_id',auth()->user()->id)->first()->id;

            $vacaciones = new TrabajadorVacacion();
            $vacaciones->trabajador_id = $trabajador_id;
            $vacaciones->dias_habiles_solicitados = $request->dias_habiles_solicitados;
            $vacaciones->fecha_primer_dia = $request->fecha_primer_dia;
            $vacaciones->fecha_solicitud = now();

            $vacaciones->estado_solicitud = 'pendiente';

            $vacaciones->save();

            return response('success',200);

        }catch (Exception $exception){
            return response($exception,403);
        }
    }


    public function store(Request $request,$id = 0){
        try {
            $request->validate([
                'trabajador_id'=>'required',
                'dias_habiles_solicitados'=>'required',
                'fecha_primer_dia'=>'required',
                'saldo_previo_vacaciones'=>'required',
                'saldo_despues_vacaciones'=>'required',
                'dias_corridos_del_periodo_de_vac'=>'required',
                'fecha_ultimo_dia'=>'required',
                'fecha_corte_calculo1'=>'required',
                'fecha_corte_calculo2'=>'required'
            ]);

            $vacaciones = TrabajadorVacacion::firstOrNew(['id'=>$id]);

            $vacaciones->trabajador_id = $request->trabajador_id;
            $vacaciones->dias_habiles_solicitados = $request->dias_habiles_solicitados;
            $vacaciones->fecha_primer_dia = $request->fecha_primer_dia;
            $vacaciones->saldo_previo_vacaciones  =$request->saldo_previo_vacaciones;
            $vacaciones->saldo_despues_vacacaciones =$request->saldo_despues_vacaciones;
            $vacaciones->dias_corridos_del_periodo_de_vac = $request->dias_corridos_del_periodo_de_vac;
            $vacaciones->fecha_ultimo_dia = $request->fecha_ultimo_dia;
            $vacaciones->fecha_corte_calculo1 = $request->fecha_corte_calculo1;
            $vacaciones->fecha_corte_calculo2 = $request->fecha_corte_calculo2;

            $vacaciones->save();

           $trabajador = Trabajador::find($request->trabajador_id);

           $trabajador->condicion = 'en vacaciones';

           $trabajador->save();


           //Email send laravel mail
            Mail::to(ENV('EMAIL_TO'))->send(new NuevaVacacion($trabajador,$vacaciones));

           return response($trabajador,200);

        }catch (Exception $exception){
            return response($exception,403);
        }
    }

    public function edit($id){
        return view('vacaciones.edit',[
            'notificaciones'=>auth()->user()->unreadNotifications,
            'id'=>$id
        ]);
    }

    public function update(Request $request,$id){
        try {

            $request->validate([
                'trabajador_id'=>'required',
                'dias_habiles_solicitados'=>'required',
                'fecha_primer_dia'=>'required',
                'saldo_previo_vacaciones'=>'required',
                'saldo_despues_vacacaciones'=>'required',
                'dias_corridos_del_periodo_de_vac'=>'required',
                'fecha_ultimo_dia'=>'required',
                'fecha_corte_calculo1'=>'required',
                'fecha_corte_calculo2'=>'required',
                'condicion'=>'required'
            ]);

            $vacaciones = TrabajadorVacacion::find($id);

            $vacaciones->update([
                'trabajador_id'=>$request->trabajador_id,
                'dias_habiles_solicitados'=>$request->dias_habiles_solicitado,
                'fecha_primer_dia'=> $request->fecha_primer_dia,
                'saldo_previo_vacaciones'=>$request->saldo_previo_vacaciones,
                'saldo_despues_vacacaciones'=>$request->saldo_despues_vacaciones,
                'dias_corridos_del_periodo_de_vac'=>$request->dias_corridos_del_periodo_de_vac,
                'fecha_ultimo_dia'=>$request->fecha_ultimo_dia,
                'fecha_corte_calculo1'=>$request->fecha_corte_calculo1,
                'fecha_corte_calculo2'=>$request->fecha_corte_calculo2
            ]);

            $trabajador = Trabajador::find($request->trabajdor_id);

            $trabajador->condicion = $request->condicion;

            $trabajador->save();

            return response('success',200);

        }catch (Exception $exception){
            return response($exception,403);
        }
    }

    public function destroy($id){
        try {

            $vacaciones = TrabajadorVacacion::find($id);

            $trabajadores = Trabajador::find($vacaciones->trabajador_id);
            $trabajadores->condicion = 'activo';
            $trabajadores->save();

            $vacaciones->delete();

            return response('success',200);
        }catch (Exception $exception){
            return response($exception,403);
        }
    }

}
