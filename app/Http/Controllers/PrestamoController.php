<?php

namespace App\Http\Controllers;

use App\Models\remuneraciones\Prestamo;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class PrestamoController extends Controller
{
    public function index(){
        return view('prestamos.index',[
            'notificaciones'=>auth()->user()->unreadNotifications
        ]);
    }

    public function getPrestamos(){
        try {

            $prestamos = Prestamo::where('id','desc')
                                    ->paginate();

            return response($prestamos,200);

        }catch (\Exception $exception){
            return response('error',422);
        }
    }

    public function store(Request $request,$id = 0){
        try {
            $request->validate([
                'monto'=>'required',
                'cuotas'=>'required',
                'tipo'=>'required', //EMPRESA - CAJA
                'trabajador_id'=>'required',
                'descripcion'=>'required',
                'periodo_pago'=>'required',
                'cuota_inicial'=>'required'
            ]);

            $prestamo = Prestamo::firstOrNew(['id'=>$id]);

            $prestamo->monto = $request->monto;
            $prestamo->cuotas = $request->cuotas;
            $prestamo->tipo =$request->tipo;
            $prestamo->trabajador_id = $request->trabajador_id;
            $prestamo->descripcion = $request->descripcion;
            $prestamo->periodo_pago = $request->periodo_pago;
            $prestamo->cuota_inicial = $request->cuota_inicial;

            $prestamo->save();

            return response('success',200);

        }catch (\Exception $exception){
            return response('error',422);
        }
    }

    public function destroy($id){
        try {
            $prestamo = Prestamo::find($id);
            $prestamo->delete();

            return response('success',200);
        }catch (Exception $exception){
            return response('error',422);
        }
    }



}
