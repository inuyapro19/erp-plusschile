<?php

namespace App\Http\Controllers;

use App\Mail\SolicitudContratoMail;
use App\Mail\SugerenciaTrabajadorMail;
use App\Models\Areas;
use App\Models\Sugerencia;
use App\Models\Trabajador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SugerenciaController extends Controller
{
    public function index(){
        $area = Areas::pluck('descripcion_area','id');
        $sugerencia = Sugerencia::with(['trabajador','areas'])
                            ->where('tipo_reclamo','=','reclamo')
                            ->get();
        return view('sugerencia.index',[
            'sugerencia'=>$sugerencia,'notificaciones'=>auth()->user()->unreadNotifications,
            'area'=>$area
        ]);
    }

    public function sugerencia(){

        $area = Areas::pluck('descripcion_area','id');
        $sugerencia = Sugerencia::with(['trabajador','areas'])
            ->where('tipo_reclamo','=','sugerencia')
            ->get();
        return view('sugerencia.index',['sugerencia'=>$sugerencia,'notificaciones'=>auth()->user()->unreadNotifications,'area'=>$area]);
    }

    public function felicitaciones(){
        $area = Areas::pluck('descripcion_area','id');
        $sugerencia = Sugerencia::with('trabajador')
                            ->where('tipo_reclamo','=','felicitaciones')
                            ->get();
        return view('sugerencia.index',['sugerencia'=>$sugerencia,'notificaciones'=>auth()->user()->unreadNotifications,'area'=>$area,]);
    }

    public function create()
    {
        $area = Areas::pluck('descripcion_area','id');
        return view('sugerencia.create',[
                'area'=>$area,
                'notificaciones'=>auth()->user()->unreadNotifications
        ]);
    }

    public function mis_sugerencias(){
        try {
            $user_id=Auth::user()->id;
            $trabajador = Trabajador::where('user_id','=',$user_id)->first();

            $sugerencias = Sugerencia::with(['areas','trabajador'])
                                    ->where('trabajador_id','=',$trabajador->id)
                                    ->get();
            //dd($sugerencias);
            return view('sugerencia_trabajador.index',[
                'notificaciones'=>auth()->user()->unreadNotifications,
                'sugerencia'=>$sugerencias
            ]);

        }catch (\Exception $exception){
            return back()->with('error','Sugerencia no enviada');
        }
    }

    public function store(Request $request)
    {
        try {
            $user_id=Auth::user()->id;
            $trabajador = Trabajador::where('user_id','=',$user_id)->first();
           $su = Sugerencia::create([
                'trabajador_id'=>$trabajador->id,
                'areas_id'=>$request->area_id,
                'area_operacion'=>$request->area_operacional,
                'mensaje_descripcion'=>$request->mensaje_descripcion ,
                'mensaje_propuestas'=>$request->mensaje_propuestas ,
                'mensaje_de_mejoras' =>$request->mensaje_de_mejoras,
                'tipo_reclamo' =>$request->tipo_reclamo,
                'anonimo' =>$request->mensaje_anonimo
            ]);

            $sugrencia = Sugerencia::with(['areas'])
                                    ->where('id','=',$su->id)
                                    ->first();
            //correo

         /*   Mail::send(new SugerenciaMail([
                $trabajador->id,
                $sugrencia->areas->descripcion_area,
                $request->area_operacional,
                $request->mensaje_descripcion ,
                $request->mensaje_propuestas ,
                $request->mensaje_de_mejoras,
                $request->tipo_reclamo
            ]));*/

            return back()->with('success','Sugerencia creada exitosamente, Solo recibira respuesta si no el mensaje no es de forma anonima');
        }catch (\Exception $exception){
            return back()->with('error','Sugerencia no enviada');
        }
    }

    public function sugerencia_respuesta(Request $request){
        try {
            $sugerencia = Sugerencia::find($request->id);

            $sugerencia->respuesta = $request->respuesta;
            $sugerencia->estado = 'respuesta envida';
            $sugerencia->save();

            //correo respuesta

            /*    $sugrencia = Sugerencia::with(['areas'])
                  ->where('id','=',$sugerencia->id)
                  ->first();*/
          /* Mail::send(new SugerenciaTrabajadorMail([
                             $sugrencia->areas->descripcion_area,
                             $request->area_operacional,
                             $request->mensaje_descripcion ,
                             $request->mensaje_propuestas ,
                             $request->mensaje_de_mejoras,
                             $request->tipo_reclamo,
                              $request->respuesta
                         ]));*/
           // dd($sugerencia);
            return back()->with('success','Respuesta enviada exitosamente');

        }catch (\Exception $exception){
            return back()->with('error','Sugerencia no enviada');
        }
    }

}
