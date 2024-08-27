<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\Documentos;
use App\Models\Empleador;
use App\Models\Trabajador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class DocumentosController extends Controller
{
    public function index(){
        return view('documento.index',['notificaciones'=>auth()->user()->unreadNotifications]);
    }

    public function getDocumentos(){
        try {
            $documentos = Documentos::orderBy('id','desc')->get();
            return response($documentos,200);
        }catch (Exception $exception){
            return response($exception,403);
        }
    }

    public function create(){
        return view('documento.create',['notificaciones'=>auth()->user()->unreadNotifications]);
    }

    public function store(Request $request){
        try {
          $request->validate([
                'texto'=>'required',
               'tipo_documento'=>'required'
            ]);

            Documentos::create([
               'nombre_documento'=>$request->nombre_documento,
               'texto'=>$request->texto,
               'tipo_documento'=>$request->tipo_documento
            ]);

            return response('success',200);
        }catch (Exception $exception){
            return response($exception,403);
        }
    }

    //generador desde el tabla de trabajadores
    public function generarDocumentoPdf($id){

        $trabajador = Trabajador::where('id','=',$id)->first();

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
        $documento = str_replace('%tramite%','para findes que estime conveniente',$documento);
        $documento = str_replace('%representante%',$contrato->empleador->representante_legal,$documento);
        $documento = str_replace('%rut_representante%',$contrato->empleador->rut_representante,$documento);

        $pdf = PDF::loadView('pdf.certificado_antiguidad',['documento'=>$documento,'heading'=>$header]);
        return $pdf->download('certificado-antiguidad-'.$trabajador->id.'-.pdf');
    }

    public function getHeader($empleador){
        return '<p class="header-top">'.$empleador->empleador->nombre_empleador.'<br> RUT '.$empleador->empleador->rut.'<br>Renca - Santiago</p>';
    }

    public function certificado_vacaciones(){

        $documento = Documentos::where('tipo_documento','=','certificado vacaciones')
            ->first()
            ->texto;

        PDF::setOptions(['defaultPaperSize' => "a4", 'defaultFont' => 'sans-serif']);

        $pdf = PDF::loadView('pdf.certificado_vacaciones',['documento'=>$documento]);

        return $pdf->download('comprobante-vacaciones-general.pdf');
    }

    public function edit($id){

        $documento =Documentos::find($id);

        return view('documento.edit',[
            'documento'=>$documento,
            'notificaciones'=>auth()->user()->unreadNotifications
        ]);

    }

    public function update(Request $request,$id){
        try{
            $documento = Documentos::find($id);
            $documento->update([
                'nombre_documento'=>$request->nombre_documento,
                'texto'=>$request->texto,
                'tipo_documento'=>$request->tipo_documento
            ]);
            return response('success',200);
        }catch (Exception $exception){
            return response($exception,403);
        }
    }

    public function destroy($id){
        try {
            $documento = Documentos::find($id);
            $documento->delete();
            return response('success',200);
        }catch (Exception $exception){
            return response($exception,403);
        }
    }
}
