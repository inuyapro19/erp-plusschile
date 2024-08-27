<?php

namespace App\Http\Controllers;

use App\Models\DocumentoViajes;
use App\Models\sistema\LogSistema;
use App\Models\Vistas\DocumentoEntregadosViaje;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentoViajesController extends Controller
{
    //view documentoviajes
    public function index()
    {
        return view('documentoviajes.index',[
            'notificaciones'=>auth()->user()->unreadNotifications
        ]);
    }

    //view documentoviajes.create

    public function getDocumentoViaje()
    {
       try{
              $documentoviaje = DocumentoEntregadosViaje::filtros()->paginate(10);
              return response($documentoviaje,200);
       }
         catch (\Exception $exception){
              return response($exception,422);
         }
    }


    //store documentoviajes
    public function store(Request $request,$id = 0){
        try {
            $request->validate([
                'nro_doc_checklist' => 'required',
                'nro_doc_hoja_ruta' => 'required',
                'viaje_id' => 'required',
                'tripulacion_id' => 'required',
            ]);

            $id_doc_checklist = $request->id_doc_checklist ?? 0;
            $id_doc_hoja_ruta = $request->id_doc_hoja_ruta ?? 0;

            $documentoviajes =DocumentoViajes::firstOrNew(['id' => $id_doc_checklist]);

            $documentoviajes->nro_doc = $request->nro_doc_checklist;
            $documentoviajes->tipo ='checklist mantención';
            $documentoviajes->viaje_id = $request->viaje_id;
            $documentoviajes->tripulacion_id = $request->tripulacion_id;
            $documentoviajes->user_id = Auth::user()->id;
            $documentoviajes->estado =$request->estado_check === 0 ? 'entregado' :'pendiente';
            $documentoviajes->save();

            //llamar a logs de sistemas solo si se editar
            if($id_doc_checklist > 0){
                LogSistema::create([
                    'user_id'=>Auth::user()->id,
                    'fecha'=>date('Y-m-d H:i:s'),
                    'accion'=>'EDICIÓN DE CHECKLIST DE MANTENCIÓN',
                    'tabla'=>'entregas de documentos',
                    'registro_id'=>$documentoviajes->id,
                    'registro_anterior'=>null,
                    'registro_nuevo'=>$documentoviajes->toJson()
                ]);
            }

            $documentoviajes2 =DocumentoViajes::firstOrNew(['id' => $id_doc_hoja_ruta]);
            $documentoviajes2->nro_doc = $request->nro_doc_hoja_ruta;
            $documentoviajes2->tipo ='hoja de recorridos';
            $documentoviajes2->viaje_id = $request->viaje_id;
            $documentoviajes2->tripulacion_id = $request->tripulacion_id;
            $documentoviajes2->user_id =  Auth::user()->id;
            $documentoviajes2->estado = $request->estado_hoja === 0 ? 'entregado' :'pendiente';
            $documentoviajes2->save();

            //llamar a logs de sistemas solo si se editar
            if($id_doc_hoja_ruta > 0){
                LogSistema::create([
                    'user_id'=>Auth::user()->id,
                    'fecha'=>date('Y-m-d H:i:s'),
                    'accion'=>'EDICIÓN DE HOJA DE RECORRIDOS',
                    'tabla'=>'entrega de documentos',
                    'registro_id'=>$documentoviajes2->id,
                    'registro_anterior'=>null,
                    'registro_nuevo'=>$documentoviajes2->toJson()
                ]);
            }

            return response('success',200);

        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    //eliminar
    public function destroy($id){
        try {
            DocumentoViajes::find($id)->delete();
            return response('success',200);
        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
