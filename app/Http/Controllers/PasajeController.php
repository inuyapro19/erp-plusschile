<?php

namespace App\Http\Controllers;

use App\Models\Pasaje;
use App\Models\Vistas\Pasaje as PasajeVista;
use Illuminate\Http\Request;

class PasajeController extends Controller
{
    public function index(){
        return view('pasajes.index',[
            'notificaciones'=>auth()->user()->unreadNotifications
        ]);
    }

    public function getPasaje(){
        try {

            $pasaje = PasajeVista::filtros()
                    ->orderBy('VIAJE_ID','desc')
                    ->paginate();

            return response($pasaje,200);

        }catch (\Exception $exception){

            return response($exception,422);

        }

    }

    public function store(Request $request, $id = 0){
        try {

           /* $request->validate([
               'monto' => 'required',
                'numero_documento' => 'required'
            ]);*/

            //$pasaje = Pasaje::firstOrNew(['id'=>$id]);

            foreach ($request->datos as $datos){
                $pasaje = new Pasaje();
                $pasaje->monto = $datos['monto'];
                $pasaje->numero_documento = $datos['nro_documento'];
                $pasaje->fecha = $datos['fecha'];
                $pasaje->viaje_id = $request->viaje_id;
                $pasaje->save();
            }


            return response('succes',200);

        }catch (\Exception $exception){
            return response($exception,422);
        }
    }

    public function destroy($id){
        try {

        }catch (\Exception $exception){

        }
    }


}
