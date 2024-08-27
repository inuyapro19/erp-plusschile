<?php

namespace App\Http\Controllers;

use App\Models\sistema\MontoDestino;
use Illuminate\Http\Request;

class MontoDestinoController extends Controller
{
    //devuelve vista
    public function index(){
        return view('montoDestino.index');
    }

    //getMontoDestinos
    public function getMontoDestinosBydestinoID($id){
        try{
            $montoDestinos = MontoDestino::where('destino_id', '=',$id)->first();
            return response($montoDestinos,200);
        }catch (\Exception $e){
            return response($e->getMessage(),500);
        }
    }

    //getMontoDestinos
    public function getMontoDestinos(){
        try{
            $montoDestinos = MontoDestino::with('destino')->get();
            return response($montoDestinos,200);
        }catch (\Exception $e){
            return response($e->getMessage(),500);
        }
    }

    //create
    public function store(Request $request,$id=0){
        try{
            $montoDestino = MontoDestino::firstOrNew(['id' => $request->id]);
            $montoDestino->monto_predeterminado = $request->monto_predeterminado;
            $montoDestino->destino_id = $request->destino_id;
            $montoDestino->save();

            return response($montoDestino,200);
        }catch (\Exception $e){
            return response($e->getMessage(),500);
        }
    }

    //destroy
    public function destroy($id){
        try{
            $montoDestino = MontoDestino::find($id);
            $montoDestino->delete();
            return response($montoDestino,200);
        }catch (\Exception $e){
            return response($e->getMessage(),500);
        }
    }


}
