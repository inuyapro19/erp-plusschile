<?php

namespace App\Http\Controllers;

use App\Models\BusCertificado;
use App\Models\Contrato;
use App\Models\Documentos;
use App\Models\Empleador;
use App\Models\MontoAsignacion;
use App\Models\Remuneraciones\LiquidacionTrabajador;
use App\Models\Trabajador;
use App\Models\Vistas\GestionDias;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use PDF;
use Illuminate\Http\Request;

class PdfController extends Controller
{
     //generador desde el tabla de trabajadores
    public function generarDocumentoPdf($id){

        $contenido = $this->generarContenidoDocumentoPdf($id);
        return $this->descargarPdf($contenido, 'certificado-antiguidad-'.$id.'.pdf');

    }

    public function generarContenidoDocumentoPdf($id, $tipoDocumento = 'certificado antiguidad')
    {
        $trabajador = Trabajador::findOrFail($id);
        $empresa = Empleador::find(1); // Considerar parametrizar este valor
        $contrato = Contrato::with(['empleador', 'cargo', 'ubicacion'])
            ->where('trabajador_id', $trabajador->id)
            ->firstOrFail();

        $documento = Documentos::where('tipo_documento', $tipoDocumento)->firstOrFail()->texto;

        // Preparar datos para reemplazar en el documento
        $date = Carbon::now();
        $fecha_hoy = $date->format('d/m/Y');
        $fechaIngreso = Carbon::createFromFormat('Y-m-d', $contrato->fecha_ingreso);
        $nombre_completo = $trabajador->primer_nombre . ' ' . $trabajador->segundo_nombre . ' ' . $trabajador->primer_apellido . ' ' . $trabajador->segundo_apellido;
        $reemplazos = [
            '%ciudad_origen%' => 'Santiago',
            '%fecha%' => $fecha_hoy,
            '%nombre%' => $nombre_completo,
            '%rut%' => $trabajador->rut,
            '%cargo%' => $contrato->cargo->nombre_cargo,
            '%fecha_ingreso%' => $fechaIngreso->format('d/m/Y'),
            '%empresa%' => $contrato->empleador->nombre_empleador,
            '%rut_empresa%' => $contrato->empleador->rut,
            '%direccion_empresa%' => $contrato->empleador->direccion,
            '%comuna%' => $contrato->empleador->comuna,
            '%tipo_contrato%' => $contrato->tipo_jornada,
            '%tramite%' => 'para fines que estime conveniente',
            '%representante%' => $contrato->empleador->representante_legal,
            '%rut_representante%' => $contrato->empleador->rut_representante,
        ];

        foreach ($reemplazos as $buscar => $reemplazar) {
            $documento = str_replace($buscar, $reemplazar, $documento);
        }

        $header = $this->getHeader($contrato->empleador);

        return ['documento' => $documento, 'header' => $header];
    }

    public function getHeader($empleador)
    {
        return "<p class='header-top'>{$empleador->nombre_empleador}<br> RUT {$empleador->rut}<br>Renca - Santiago</p>";
    }

    public function descargarPdf($contenido, $nombreArchivo = 'documento.pdf')
    {
        $pdf = PDF::loadView('pdf.certificado_antiguidad', ['documento' => $contenido['documento'], 'header' => $contenido['header']]);
        return $pdf->download($nombreArchivo);
    }


    public function certificado_recorrido($id){
           $certificado = BusCertificado::with('certificadoRecorrido')
                                        ->where('id','=',$id)
                                        ->where('tipo_certificado','=','CARTON DE RECORRIDO')
                                        ->first();

        $documento = Documentos::where('id','=',4)
            ->first()
            ->texto;

        $pdf = PDF::loadView('pdf.certificado_recorrido',['documento'=>$documento]);
        return $pdf->download('certificado-recorrido.pdf');
    }

    public function generar_folio($folio){

        $folio =MontoAsignacion::with('viaje.origen','viaje.destino','viaje.bus','viaje.trabajadores','viaje.trabajadores.contrato.cargo','user')->where('nro_folio','=',$folio)->first();
        //dd($folio);
        // return view('pdf.folio',['folio'=>$folio]);

        $pdf = PDF::loadView('pdf.folio',['folio'=>$folio]);
        return $pdf->download('folio-'.$folio->nro_folio.'.pdf');
    }

 public function getLiquidacionesAll(){
     try {
         $mes = \request('mes');
         $data = LiquidacionTrabajador::select('RESUMEN_DETALLE')
             ->where('MES','=',$mes)
             ->where('ESTADO_LIQUIDACION','=','OPEN')
             ->get();

         return response($data,200);

     }catch (\Exception $exception){
         return response($exception,422);
     }
}

    public function liquidacion_mensual_all(Request $request){
        try {

            $data = $request->all();

            $pdf = PDF::loadView('pdf.liquidacion-mensual-all',['data'=>$data]);
            $nombre_archivo = 'liquidaciones'.date('m.Y');
            $pdf->save(public_path().'/upload/liquidaciones/'.$nombre_archivo.'.pdf');

            return response($nombre_archivo.'.pdf',200);
        }catch (\Exception $exception){
            return response($exception);
        }
    }


    public function liquidacion_mensual_single(Request $request){
        try {
            //return view('pdf.liquidacion-mensual');
            $data = $request->all();
          // return response($data['cabezera']['afp'],200);
            $pdf = PDF::loadView('pdf.liquidacion-mensual',['data'=>$data]);
            $nombre_archivo = $data['cabezera']['rut'].'-'.date('m.Y');
            $pdf->save(public_path().'/upload/liquidaciones/'.$nombre_archivo.'.pdf');

            return response($nombre_archivo.'.pdf',200);
        }catch (\Exception $exception){
            return response($exception ,422);
        }
    }

    public function borrar_liquidacion_pdf_single(){

    }


    public function dias_libres($id){
        //aqui va la consylta
        $gestion = GestionDias::where('GESTION_ID','=',$id)->first();
        $fecha = date('d-m-Y');
        $hora = time();
        $username = Auth::user()->name;
        $pdf = PDF::loadView('pdf.dias',['gestion'=>$gestion,'fecha_hoy'=>$fecha,'hora_actual'=>$hora,'username'=>$username]);
        return $pdf->download('dias_libres.pdf');
    }

}
