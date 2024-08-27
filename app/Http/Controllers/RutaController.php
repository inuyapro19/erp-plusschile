<?php

namespace App\Http\Controllers;

use App\Models\Ruta;
use App\Models\Vistas\TramoRuta;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class RutaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('ruta.index',[
            'notificaciones'=>auth()->user()->unreadNotifications,
        ]);
    }

    public function getTramos(){
        try {

            if (\request('opcion') ==1){

                $destino_id = \request('destino_id');
                $origen_id = \request('origen_id');
                $tramo_id = \request('tramo_id');

                $tramos = TramoRuta::where('DESTINO_ID','=',$destino_id)
                    ->where('ORIGEN_ID','=',$origen_id)
                    ->where('TRAMO_ID','=',$tramo_id)
                    ->first();

            }else{

                $tramos = TramoRuta::orderBy('ID_TRAMO','DESC')
                    ->get();

            }

            return response($tramos,200);

        }catch (Exception $exception){

            return response($exception,422);

        }
    }


    public function store(Request $request,$id = 0)
    {
        try {

            $ruta = Ruta::firstOrNew(['id'=>$id]);

            $ruta->origen_id = $request->origen_id;
            $ruta->destino_id = $request->destino_id;
            $ruta->horas = $request->horas;
            $ruta->tramo_id = $request->tramo_espacial;

            $ruta->save();

           return response('success',200);

        }catch (\Exception $exception){

            return response($exception,422);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ruta  $ruta
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
           //
           $ruta = Ruta::find($id);

           $ruta->delete();

           return response('success',200);
        }catch (\Exception $exception){
            return response($exception,422);
        }
    }
}
