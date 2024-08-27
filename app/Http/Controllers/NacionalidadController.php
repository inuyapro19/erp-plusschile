<?php

namespace App\Http\Controllers;

use App\Models\Nacionalidad;
use Illuminate\Http\Request;

class NacionalidadController extends Controller
{

    public function getNacionalidad()
    {
        try {
            $nacionalidad = Nacionalidad::OrderBy('descripcion_nacionalidad','asc')->get();
            return response($nacionalidad,200);
        }catch (Throwable $e) {
            return response($e,404);
        }
    }

    public function store(Request $request){
        try{
            $request->validate([
                'descripcion_nacionalidad'=>'required'
            ]);

            Nacionalidad::create([
                'descripcion_nacionalidad'=>$request->descripcion_nacionalidad
            ]);

            return response('success',200);

        }catch (\Throwable $e){
            return response($e,500);
        }
    }

    public function update(Request $request,$id){
        try {
            $request->validate([
                'descripcion_nacionalidad'=>'required'
            ]);

            $nacionalidad = Nacionalidad::find($id);

            $nacionalidad->update([
                'descripcion_nacionalidad'=>$request->descripcion_nacionalidad
            ]);

            return response('success',200);

        }catch (\Throwable $e){
            return response('error',203);
        }
    }

    public function destroy($id){
        try {
            $nacionalidad = Nacionalidad::find($id);

            $nacionalidad->delete();

           return response('success',200);
        }
        catch (\Throwable $e){
            return response('error',203);
        }
    }
}
