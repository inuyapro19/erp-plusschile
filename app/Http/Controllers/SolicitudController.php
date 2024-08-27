<?php

namespace App\Http\Controllers;

use App\Mail\SolicitudContratoMail;
use App\Models\ArchivoSolicitud;
use App\Models\RespuestaSolicitud;
use App\Models\Solicitud;
use App\Models\Trabajador;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use mysql_xdevapi\Exception;

class SolicitudController extends Controller
{
    public function index(){
        $solicitudes = Solicitud::with(['trabajador','user'])
            ->where('estado','=','pendiente')
            ->orderBy('created_at','desc')
            ->get();

        return view('solicitudes.index',['solicitudes'=>$solicitudes,'notificaciones'=>auth()->user()->unreadNotifications]);
    }

    public function finalizadas(){
        $solicitudes = Solicitud::with(['trabajador','user'])
            ->where('estado','=','finalizado')
            ->orderBy('created_at','desc')
            ->get();

        return view('solicitudes.finalizadas',['solicitudes'=>$solicitudes,'notificaciones'=>auth()->user()->unreadNotifications]);
    }

    public function verRespuestas($id){
        return view('solicitudes.finalizadas',['notificaciones'=>auth()->user()->unreadNotifications,'id'=>$id]);
    }

    public function getSolicitudes(){
        try {
            $solicitudes = Solicitud::with(['trabajador','user'])
                ->orderBy('created_at','desc')
                ->get();

            return response($solicitudes,200);

        }catch (\Exception $exception){
            return response($exception ,403);
        }
    }

    public function getRespuestas($id){
        try {

            $user_id = User::where('id','=',$id)->first()->user_id;

            $solicitud = Solicitud::with(['trabajador','respuestas_solicitudes'=>function($query){
                return $query->with('user')->get();
            },'archivo_solicitudes'])
                ->where('id','=',$id)
                ->first();

            return response($solicitud,200);
        }
        catch (Exception $exception){
            return response($exception,403);
        }
    }

    public function create(){
        return view('solicitudes.create',['notificaciones'=>auth()->user()->unreadNotifications]);
    }

    public function store(Request $request){
        try {
            $request->validate([
                'comentario'=>'required',
                'tipo_solicitud'=>'required',
            ]);

            $user_id=Auth::user()->id;
            $trabajador = Trabajador::where('user_id','=',$user_id)->first();

            Solicitud::create([
                'trabajador_id'=>$trabajador->id,
                'user_id'=>$user_id,
                'comentario'=>$request->comentario,
                'tipo_solicitud'=>$request->tipo_solicitud,
                'estado'=>$request->estado
            ]);
            //dispara correo

            return redirect(route('solicitudes.create'))->with('success','Solicitud creada exitosamente');

        }catch (\Exception $exception){
            return redirect(route('solicitudes.create'))->with('error','Error al enviar Solicitud');
        }
    }
    public function solicitud_respuestas(Request $request,$id){
        try {
            $request->validate([
                'mensaje'=>'required',
            ]);

            $solicitud = Solicitud::find($id);

            $solicitud->estado = $request->estado;
            $solicitud->save();

           $respuestas = RespuestaSolicitud::create([
                'user_id'=>Auth::user()->id,
                'mensaje'=>$request->mensaje,
                'solicitud_id'=>$id,
            ]);

            if ($request->tipo_solicitud == 'copia de contrato'){
                $file = $request->file('contrato');
                $filename =  Str::random(10).rand(1,9).'.pdf';
                $file->move('upload/solicitudes/contratos/', $filename);
                $respuestas->archivos = $filename;
                $respuestas->save();

                //genero los notificacion de correo
               // SolicitudContratoMail
                Mail::send(new SolicitudContratoMail(
                    $filename
                ));
            }

            if ($request->tipo_solicitud == 'certificado antiguidad'){
                $file = $request->file('certificado');
                $filename =  Str::random(10).rand(1,9).'.pdf';
                $file->move('upload/solicitudes/certificado_antiguidad_firmados/', $filename);
               $respuestas->archivos = $filename;
               $respuestas->save();


            }


            return response('success',200);

        }catch (Exception $exception){
            return response($exception,403);
        }
    }

    public function edit($id){
        $solicitudes = Solicitud::find($id);
        return view('solicitudes.edit',['solicitud'=>$solicitudes,'notificaciones'=>auth()->user()->unreadNotifications]);
    }

    public function update(Request $request,$id){
        try {
            //dd($request->all());
            $solicitudes = Solicitud::find($id);
           // $user_id=Auth::user()->id;
            //$trabajador = Trabajador::where('user_id','=',$user_id)->first();

            $solicitudes->update([
               // 'trabajador_id'=>$trabajador->id,
                //'user_id'=>$user_id,
                'comentario'=>$request->comentario,
                'tipo_solicitud'=>$request->tipo_solicitud,
                'estado'=>$request->estado
            ]);

            //dispara correo

            return back()->with('success','Solicitud finalizada exitosamente');
        }catch (\Exception $exception){
            //dd($exception);
            return back()->with('danger','error al enviar la solicitud');
        }

    }

}
