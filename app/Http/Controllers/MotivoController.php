<?php

namespace App\Http\Controllers;

use App\Models\Motivo;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class MotivoController extends Controller
{

    public function getMotivo(){
        try {
            $motivo = Motivo::orderBy('descripcion','asc')->get();
            return response($motivo,200);
        }catch (\Exception $exception){
            return response($exception,403);
        }
    }

    public function store(Request $request){
        try {
            $request->validate([
                'codigo'=>'required',
                'descripcion'=>'required'
            ]);

            Motivo::create([
                'codigo'=>$request->codigo,
                'descripcion'=>$request->descripcion
            ]);

            return response('succes',200);

        }catch (\Exception $exception){
            return response($exception,403);
        }
    }

    public function update(Request $request,$id){
        try {
            $request->validate([
                'codigo'=>'required',
                'descripcion'=>'required'
            ]);

            $motivo = Motivo::find($id);
            $motivo->update([
                'codigo'=>$request->codigo,
                'descripcion'=>$request->descripcion
            ]);
            return response('success',200);
        }catch (Exception $exception){
           return response($exception,200);
        }
    }

    public function destroy($id){
        try {
            $motivo = Motivo::find($id);

            $motivo->delete();

            return response('success',200);

        }catch (Exception $exception){
            return response($exception,403);
        }
    }

}
