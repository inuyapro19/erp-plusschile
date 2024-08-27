<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class CargoController extends Controller
{


    public function getCargos($id=false){

        try {
            if($id)
            {
                $cargos = Cargo::where('area_id','=',$id)
                    ->OrderBy('nombre_cargo','asc')
                    ->get();
            }
            else{
                $cargos = Cargo::OrderBy('nombre_cargo','asc')->get();
            }

            return response($cargos,200);
        }catch (Throwable $e) {

            return response($e,404);
        }

    }



    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre_cargo'=>'required',
                'area_id'=>'required'
            ]);

            Cargo::create([
                'nombre_cargo'=>$request->nombre_cargo,
                'area_id'=>$request->area_id
            ]);

            return response('success',200);
        }catch (Exception $exception){
            return response($exception,200);
        }
    }


    public function show($id)
    {
        try {
           $cargo = Cargo::find($id);
            return response($cargo,200);
        }catch (Exception $exception){
          return  response('error',403);
        }
    }

    public function update(Request $request,$id)
    {
        try {
            $cargo = Cargo::find($id);
            $cargo->update([
                'nombre_cargo'=>$request->nombre_cargo,
                'area_id'=>$request->area_id
            ]);
            return response($cargo,200);
        }catch (Exception $exception){
            return  response('error',403);
        }
    }


    public function destroy($id)
    {
        try {
            $cargo = Cargo::find($id);
            $cargo->delete();
            return response($cargo,200);
        }catch (Exception $exception){
            return  response('error',403);
        }
    }
}
