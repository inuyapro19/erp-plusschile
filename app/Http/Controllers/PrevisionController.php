<?php

namespace App\Http\Controllers;

use App\Models\AhorroVoluntario;
use App\Models\Prevision;
use App\Models\PrevisionTrabajador;
use Illuminate\Http\Request;

class PrevisionController extends Controller
{
    public function getPrevicion()
    {
        try {
            $previcion =  Prevision::orderBy('nombre_prevision','asc')->get();
            return response($previcion,200);

        }catch (Throwable $e) {
            return response($e,303);
        }
    }

  public function getCargarPrevisiones($id){
      try {
         $prevision =  PrevisionTrabajador::where('trabajador_id','=',$id)->first();
         return response($prevision,200);
      }catch (\Exception $exception){
          return response($e,303);
      }
  }

    public function store(Request $request){
        try {
            $request->validate([
               'codigo'=>'required',
               'nombre_prevision'=>'required',
                'porcentaje_prevision'=>'required'
            ]);

            Prevision::create([
                'codigo'=>$request->codigo,
                'nombre_prevision'=>$request->nombre_prevision,
                'porcentaje_prevision'=>$request->porcentaje_prevision
            ]);

            return response('success',200);

        }catch (Exception $exception){
            return response('error',403);
        }
    }

    public function show($id){
        try {

           $prevision = Prevision::find($id);

            return response($prevision,200);

        }catch (Exception $exception){
            return response('error',403);
        }
    }

    public function update(Request $request,$id){
        try {

            $request->validate([
                'codigo'=>'required',
                'nombre_prevision'=>'required',
                'porcentaje_prevision'=>'required'
            ]);

            $prevision = Prevision::find($id);

            $prevision->update([
                'codigo'=>$request->codigo,
                'nombre_prevision'=>$request->nombre_prevision,
                'porcentaje_prevision'=>$request->porcentaje_prevision
            ]);

            return response('success',200);

        }catch (Exception $exception){
            return response('error',403);
        }
    }

    public function destroy($id){
        try {
            $prevision = Prevision::find($id);
            $prevision->delete();
            return response('success',200);
        }catch (\Exception $exception){
            return response('error',403);
        }
    }


}
