<?php

namespace App\Http\Controllers;

use App\Models\Destino;
use Illuminate\Http\Request;

class DestinoController extends Controller
{
    public function getDestinos(){
        try {
           $destinos = Destino::all();
           return response($destinos);
        }catch (\Exception $exception){
            return response($exception,422);
        }
    }

    public function index(){
        return view('destinos.index', [
            'notificaciones'=>auth()->user()->unreadNotifications
        ]);
    }

    public function store(Request $request,$id = false)
    {
        try {
            /*  nuevo cliente o actualizar cliente  */
            $destinos =  Destino::firstOrNew(['id'=>$id]);

            $destinos->ciudad = $request->ciudad;
            $destinos->save();

            return response('success',200);

        }catch (\Exception $exception){

            return response($exception,422);

        }
    }

    public function destroy($id)
    {
        try {

            $destino = Destino::find($id);

            $destino->delete();

            return response('success',200);

        }catch (\Exception $exception){
            return response('error',422);
        }
    }
}
