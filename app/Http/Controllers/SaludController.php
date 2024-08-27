<?php

namespace App\Http\Controllers;

use App\Models\Salud;
use App\Models\SaludTrabajador;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class SaludController extends Controller
{
    public function getSalud()
    {
        try {
            $salud = Salud::orderBy('nombre_salud','asc')->get();

            return response($salud,200);
        }catch (Throwable $e) {

            return response($e,403);
        }

    }

   public function getCargarSalud($id){
       try {
           $salud = SaludTrabajador::where('trabajador_id','=',$id)->first();
           return response($salud,200);
       }catch (Exception $e){
           return response($e,403);
       }
   }

    public function store(Request $request){
        try {
            $request->validate([
               'nombre_salud'=>'required'
            ]);

            Salud::create([
               'nombre_salud'=>$request->nombre_salud
            ]);

            return response('success',200);

        }catch (\Exception $exception){
            return response($exception,403);
        }
    }

    public function show($id){
        try {

           $salud = Salud::find($id);

            return response($salud,200);

        }catch (\Exception $exception){
            return response('error',403);
        }
    }

    public function update(Request $request,$id){
        try {
            $request->validate([
                'nombre_salud'=>'required'
            ]);

            $salud = Salud::find($id);

            Salud::create([
                'nombre_salud'=>$request->nombre_salud
            ]);

            return response('success',200);

        }catch (\Exception $exception){
            return response('error',403);
        }
    }

    public function destroy($id){
        try {

            $salud = Salud::find($id);

            $salud->delete();

            return response('success',200);

        }catch (Exception $exception){
            return response('error',403);
        }
    }

}
