<?php

namespace App\Http\Controllers;

use App\Mail\NewLiceciaMedica;
use App\Models\TipoLicenciaMedica;
use App\Models\Trabajador;
use App\Models\TramiteLicenciaMedica;
use App\Models\Vistas\LicenciaMedica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TramiteLicenciaMedicaController extends Controller
{
    public function index()
    {
        return view('licencia_medicas.index',[
            'notificaciones'=>auth()->user()->unreadNotifications
        ]);
    }

    public function getLicenciaMedicas(){
        try {
            /**/
            $licencias = LicenciaMedica::TrabajadorId()
                                    ->EmpleadorId()
                                     ->paginate(10);
            /**/
            return response($licencias,200);

        }catch (Exception $exception){
            return response($exception,403);
        }
    }

    public function getTipoLicenciaMedicas(){
        try {
            /**/
            $licencias = TipoLicenciaMedica::orderBy('id','desc')->get();

            /**/
            return response($licencias,200);

        }catch (Exception $exception){
            return response($exception,403);
        }
    }

    public function create(){

        $trabajadores = Trabajador::orderBy('id','asc')->get();

        return view('licencia_medicas.create',[
            'trabajadores'=>$trabajadores,
            'notificaciones'=>auth()->user()->unreadNotifications
        ]);
    }

    public function store(Request $request,$id = 0){
        try {
            $request->validate([
                'fecha_emision'=>'required',
                'fecha_inicio'=>'required',
                'fecha_termino' => [
                    'required',
                    function ($attribute, $value, $fail) use ($request) {
                        if ($value < $request['fecha_inicio']) {
                            $fail($attribute.'La fecha final, debe ser posterior a la fecha inicial.');
                        }
                    },],
                'trabajador_id'=>'required'
            ]);

            $trabajador_licencia = TramiteLicenciaMedica::firstOrNew(['id'=>$id]);

                $trabajador_licencia->fecha_emision = $request->fecha_emision;
                $trabajador_licencia->fecha_inicio  = $request->fecha_inicio;
                $trabajador_licencia->fecha_fin = $request->fecha_termino;
                $trabajador_licencia->fecha_recepcion = $request->fecha_recepcion;
                $trabajador_licencia->fecha_procesado = $request->fecha_procesado;
                $trabajador_licencia->dias = $request->dias;
                $trabajador_licencia->medio = $request->medio;
                $trabajador_licencia->motivo = $request->motivo;
                $trabajador_licencia->trabajador_id = $request->trabajador_id;
                $trabajador_licencia->user_id = Auth::user()->id;
                $trabajador_licencia->tipo_licencia_medicas_id = $request->tipo_licencia;

                $trabajador_licencia->save();

            /*$licencias = TramiteLicenciaMedica::create([
                'fecha_emision'=>$request->fecha_emision ,
                'fecha_inicio' =>$request->fecha_inicio,
                'fecha_fin'=>$request->fecha_termino,
                'fecha_recepcion'=>$request->fecha_recepcion,
                'fecha_procesado'=>$request->fecha_procesado,
                'dias'=>$request->dias,
                'medio'=>$request->medio,
                'motivo' =>$request->motivo,
                'trabajador_id' =>$request->trabajador_id,
                'user_id'=>Auth::user()->id,
                'tipo_licencia_medicas_id'=>$request->tipo_licencia
            ]);*/

            $trabajador = Trabajador::find($request->trabajador_id);
            $trabajador->condicion = 'licencia médica';
            $trabajador->save();

            //envio de correo por trabajador
            Mail::to('pedroaraya@fizz.cl')->send(new NewLiceciaMedica($trabajador,$trabajador_licencia));

            return response('success',200);

        }catch (Exception $exception){
            return response($exception,403);
        }
    }

    public function destroy($id){
        try {

           $trabajador_licencia = TramiteLicenciaMedica::find($id);

            $trabajador = Trabajador::find($trabajador_licencia->trabajador_id);
            $trabajador->condicion = 'disponible';
            $trabajador->save();

            $trabajador_licencia->delete();

            return response('success',200);

        }catch (\Exception $exception){

            return response($exception,422);

        }
    }




}
