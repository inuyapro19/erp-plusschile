<?php

namespace App\Http\Controllers;

use App\Models\TrabajadorBono;
use App\Models\vistas\BonoTrabajador;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class TrabajadorBonoController extends Controller
{
    public function index(){
        return view('asignacion.index',[
            'notificaciones'=>auth()->user()->unreadNotifications
        ]);
    }

    public function getBonoTrabajador(){
        try {

            $paginas = \request('perpage');

            $bono_trabajador = BonoTrabajador::isActiveFiltro()
                                        ->trabajadorID()
                                        ->paginate($paginas);

            return response($bono_trabajador,200);
        }catch (\Exception $exception){

            return response($exception,422);
        }
     }

     public function store(Request $request, $id=0){
         try {
             $request->validate([
                'trabajador_id'=>'required',
                'bono_id'=>'required'
             ]);

             $bono_trabajador = TrabajadorBono::firstOrNew(['id'=>$id]);
             $bono_trabajador->trabajador_id = $request->trabajador_id;
             $bono_trabajador->bonos_id = $request->bono_id;
             $bono_trabajador->mes = $request->mes;
             $bono_trabajador->anyo = $request->anyo;
             $bono_trabajador->monto = $request->monto;
             $bono_trabajador->estado = $request->has('estado') ? $request->estado : 'activo';

             $bono_trabajador->save();

             return response('success',200);

         }catch (Exception $exception){
             return response($exception,422);
         }
     }

     public function destroy($id){
         try {
             $trabajador_bono = TrabajadorBono::find($id);

             $trabajador_bono->delete();

             return response('success',200);
         }catch (Exception $exception){
             return response($exception,422);
         }
     }

     public function cambioMonto(Request $request,$id){
         try {
             $trabajador_bono = TrabajadorBono::find($id);
             $trabajador_bono->monto = $request->monto;

             $trabajador_bono->save();

             return response('success',200);
         }
         catch (\Exception $exception){
             return response($exception,422);
         }
     }

     public function cambiosEstado(Request $request){
         try {

             foreach ($request->datos as $datos){

                $trabajador_bono = TrabajadorBono::find($datos);

                $trabajador_bono->estado = $request->estado;

                $trabajador_bono->save();

             }

             return response('success',200);

         }catch (\Exception $exception){

             return response($exception,422);
         }
     }

     public function eliminacionMasiva(Request $request){
         try {

             foreach ($request->datos as $datos){

                 $trabajador_bono = TrabajadorBono::find($datos);

               //  $trabajador_bono->estado = $request->estado;

                 $trabajador_bono->delete();

             }

             return response('success',200);

         }catch (\Exception $exception){

             return response($exception,422);
         }
     }

}
