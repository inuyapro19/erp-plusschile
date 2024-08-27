<?php

namespace App\Http\Controllers;

use App\Models\Ubicacion;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class UbicacionController extends Controller
{
    public function getUbicacion()
    {
        try {
            $ubicacion = Ubicacion::orderBy('nombre_ubicacion','asc')->get();

            return response($ubicacion,200);
        }catch (Throwable $e) {

            return response($e,404);
        }
    }

    public function store(Request $request){
        try{
            $request->validate([
                'nombre_ubicacion'=>'required'
            ]);
            Ubicacion::create([
               'nombre_ubicacion'=>$request->nombre_ubicacion
            ]);

            return  response('success',200);

        }catch (\Exception $exception){
            return response($exception,403);
        }
    }

    public function show($id){
        try{
            $ubicacion = Ubicacion::find($id);

            return  response($ubicacion,200);
        }catch (\Exception $exception){
            return response('error',403);
        }
    }

    public function update(Request $request,$id){
        try{
            $request->validate([
                'nombre_ubicacion'=>'required'
            ]);

            $ubicacion = Ubicacion::find($id);

            $ubicacion->update([
                'nombre_ubicacion'=>$request->nombre_ubicacion
            ]);

            return  response($ubicacion,200);

        }catch (\Exception $exception){
            return response('error',403);
        }
    }

    public function destroy($id){
        try{
            $ubicacion = Ubicacion::find($id);

            $ubicacion->delete();

            return  response('success',200);
        }catch (\Exception $exception){
            return response($exception,403);
        }
    }

}
