<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParamentroLiquidacion extends Controller
{

    public function index(){
        return view('parametros_liquidacion.index',[
            'notificaciones'=>auth()->user()->unreadNotifications
        ]);
    }

    public function getParamentros(){
        try {

            $paginador = request('page');

            $paramentros = \App\Models\ParamentroLiquidacion::paginate($paginador);

            return response($paramentros,200);

        }catch (\Exception $exception){
            return response($exception,422);
        }
    }


    public function store(Request  $request,$id=0){
        try {

            $paramentros  = \App\Models\ParamentroLiquidacion::firstOrNew(['id'=>$id]);

            $paramentros->descripcion = $request->descripcion;
            $paramentros->valor = $request->valor;
            $paramentros->tipo = $request->tipo;
            $paramentros->save();

            return response('success',200);
        }catch (\Exception $exception){
            return response($exception ,422);
        }
    }

}
