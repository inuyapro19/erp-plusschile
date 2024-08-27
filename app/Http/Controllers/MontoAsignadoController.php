<?php

namespace App\Http\Controllers;

use App\Models\MontoViaje;
use App\Models\otros\Folios;
use Illuminate\Http\Request;
use App\Models\MontoAsignacion;
use Illuminate\Support\Facades\Auth;

class MontoAsignadoController extends Controller
{
   public function obtener_ultimo_folio(){
       try {

           $folio =  Folios::select('nro_folio')->limit(1)->orderBy('id','desc')->first();

           $folio_generado = Folios::create([
                 'nro_folio' => $folio->nro_folio + 1,
                'fecha'=>date('Y-m-d H:i:s'),
              ]);

          return response($folio_generado->nro_folio,200);

       }catch (\Exception $exception){
           return response($exception,422);
       }
   }

    public function obtenerFolios(){
        try {
            $folios = MontoAsignacion::orderBy('viaje_id','desc')->get();
            return response($folios,200);
        }catch (\Exception $exception){
            return response($exception,422);
        }
    }

    public function agregar_folio(Request $request,$id = 0){
        try {
            $request->validate([
               // 'nro_folio'=>'required',
                'monto_asignado'=>'required',
            ]);
/**/
            $folio = MontoAsignacion::firstOrNew(['id'=>$id]);

            $folio->nro_folio = $request->nro_folio;
            $folio->monto_asignado = $request->monto_asignado;
            $folio->glosas = $request->glosa;
            $folio->viaje_id = $folio->viaje_id ?? $request->viaje_id;
            $folio->fecha = $folio->fecha ?? date('Y-m-d');
            $folio->user_id = Auth::user()->id;
            $folio->save();

            //obtienes todos los folios del viaje
            $folios = MontoAsignacion::where('viaje_id',$request->viaje_id)->get();
            //suma todos los montos de los folios y actualiza el monto del viaje
            $montos = $folios->sum('monto_asignado');
            $monto_viaje = MontoViaje::where('viaje_id',$request->viaje_id)->first();
            $monto_viaje->monto_total=$montos;
            $monto_viaje->save();


            /*MontoAsignacion::create([
                'nro_folio'=>$request->nro_folio,
                'monto_asignado'=>$request->monto_asignado,
                'glosas'=> $request->glosa ?? 'monto peaje inicial',
                'viaje_id' => $id,
                'user_id'=> Auth::user()->id,
                'fecha'=> now()
            ]);*/

            return response('success',200);

        }catch (\Exception $exception){
            return response($exception,422);
        }


    }

}
