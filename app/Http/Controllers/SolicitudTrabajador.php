<?php

namespace App\Http\Controllers;

use App\Models\ArchivoSolicitud;
use App\Models\Contrato;
use App\Models\Documentos;
use App\Models\Empleador;
use App\Models\RespuestaSolicitud;
use App\Models\Solicitud;
use App\Models\Trabajador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use mysql_xdevapi\Exception;
use PDF;
class SolicitudTrabajador extends Controller
{

   public function index(){
       return view('solicitud_trabajador.index',['notificaciones'=>auth()->user()->unreadNotifications]);
   }

   public function getMisSolicitudes(){
       try {
           $user_id = Auth::user()->id;

           $solicitud = Solicitud::where('user_id','=',$user_id)
                                ->orderBy('created_at','desc')
                                 ->get();

           return response($solicitud,200);
       }
       catch (Exception $exception){
           return response($exception,403);
       }
   }

   public function getRespuestas($id){
        try {

            $user_id = Auth::user()->id;

            $solicitud = Solicitud::with(['respuestas_solicitudes'=>function($query){
                return $query->with('user')->get();
            },'archivo_solicitudes'])
                                ->where('user_id','=',$user_id)
                                ->where('id','=',$id)
                                ->first();

            return response($solicitud,200);
        }
        catch (Exception $exception){
            return response($exception,403);
        }
    }

    public function create(){
        return view('solicitud_trabajador.create',['notificaciones'=>auth()->user()->unreadNotifications]);
    }

   public function store(Request $request){
       try {

           $trabajador_id = Trabajador::where('user_id','=',Auth::user()->id)->first()->id;

         $solicitud =   Solicitud::create([
               'asunto'=>$request->asunto,
               'trabajador_id'=>$trabajador_id,
               'user_id'=>Auth::user()->id,
               'comentario'=>$request->mensaje,
               'tipo_solicitud'=>$request->tipo_solicitud,
               'datos'=>json_encode($request->datos),
               'estado'=> 'pendiente'
           ]);

           if ($request->tipo_solicitud == 'modificacion de datos'){
               $file = $request->file('documento_direccion');
               $filename =  Str::random(10).rand(1,9).'.pdf';
               $file->move('upload/solicitudes/certificado_direccion/', $filename);
               ArchivoSolicitud::create([
                   'solicitud_id'=>$solicitud->id ,
                   'nombre_archivo'=>$filename
               ]);
               //notificacion

           }

           if ($request->tipo_solicitud == 'certificado antiguidad'){
               //$file = $request->file('documento_direccion');
               $filename =  Str::random(10).rand(1,9).'.pdf';
               $this->getDocumento($filename,$request);
               ArchivoSolicitud::create([
                   'solicitud_id'=>$solicitud->id ,
                   'nombre_archivo'=>$filename
               ]);

               //notificacion

           }


           /****************************Solicitud de carga familiar********************************/
          if ($request->tipo_solicitud == 'carga familiar'){

               //$files = $request->file('certificados');
               foreach($request->file('certificados') as $file){
                   $filename =  Str::random(10).rand(1,9).'.pdf';
                   $file->move('upload/solicitudes/certificados_nac/', $filename);
                   ArchivoSolicitud::create([
                       'solicitud_id'=>$solicitud->id ,
                       'nombre_archivo'=>$filename
                   ]);
               }

               //notificacion

           }
            return response($request->certificados,200);

       }catch (Exception $exception){
           return response($exception,403);
       }
   }
    public function getDocumento($filename,$request){

        $trabajador = Trabajador::where('user_id','=',Auth::user()->id)->first();

        $empresa = Empleador::find(1);

        $contrato = Contrato::with(['empleador','cargo','ubicacion'])
                            ->where('trabajador_id','=',$trabajador->id)
                            ->first();

        $header = $this->getHeader($contrato);

        $fecha_hoy = date('d-m-Y');
        $documento = Documentos::where('tipo_documento','=','certificado antiguidad')
                                ->first()
                                ->texto;

        $documento = str_replace('%ciudad_origen%','Santiago',$documento);
        $documento = str_replace('%fecha%',$fecha_hoy,$documento);
        $documento = str_replace('%nombre%',$trabajador->primer_nombre.' '.$trabajador->segundo_nombre.' '.$trabajador->primer_apellido.' '.$trabajador->segundo_apellido,$documento);
        $documento = str_replace('%rut%',$trabajador->rut,$documento);
        $documento = str_replace('%cargo%',$contrato->cargo->nombre_cargo,$documento);
        $documento = str_replace('%fecha_ingreso%',$contrato->fecha_ingreso,$documento);
        $documento = str_replace('%empresa%',$contrato->empleador->nombre_empleador,$documento);
        $documento = str_replace('%rut_empresa%',$contrato->empleador->rut,$documento);
        $documento = str_replace('%direccion_empresa%',$contrato->empleador->direccion,$documento);
        $documento = str_replace('%comuna%',$contrato->empleador->comuna,$documento);
        $documento = str_replace('%tipo_contrato%',$contrato->tipo_jornada,$documento);
        $documento = str_replace('%tramite%',$request->otro_uso_certificado ? $request->otro_uso_certificado : $request->uso_certificado,$documento);
        $documento = str_replace('%representante%',$contrato->empleador->representante_legal,$documento);
        $documento = str_replace('%rut_representante%',$contrato->empleador->rut_representante,$documento);

        $pdf = PDF::loadView('pdf.certificado_antiguidad',['documento'=>$documento,'heading'=>$header]);
        return $pdf->save(public_path().'/upload/solicitudes/certificado_antiguidad/'.$filename);
    }

    public function getHeader($empleador){
        return '<p class="header-top">'.$empleador->empleador->nombre_empleador.'<br> RUT '.$empleador->empleador->rut.'<br>Renca - Santiago</p>';
    }

   public function edit($id){
       return view('solicitud_trabajador.edit',[
           'id'=>$id,
           'notificaciones'=>auth()->user()->unreadNotifications
       ]);
   }

   public function solicitud_respuestas(Request $request,$id){
       try {
           $request->validate([
              'mensaje'=>'required',
           ]);

           RespuestaSolicitud::create([
               'user_id'=>Auth::user()->id,
               'mensaje'=>$request->mensaje,
               'solicitud_id'=>$id,
               'archivos'=>$request->adjunto
           ]);

           return response('success',200);

       }catch (Exception $exception){
           return response($exception,403);
       }
   }


}
