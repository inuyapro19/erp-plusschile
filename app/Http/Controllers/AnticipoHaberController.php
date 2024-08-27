<?php

namespace App\Http\Controllers;


use App\Models\remuneraciones\AnticipoHaber;
use Illuminate\Http\Request;

class AnticipoHaberController extends Controller
{
     public function getAnticipos(){
         try {
             $anticipo = AnticipoHaber::isActive()
                                        ->orderBy('id','desc')
                                        ->paginate(10);

             return response($anticipo,200);
         }catch (Exception $exception){
             return response($exception,422);
         }
     }

     public function store(Request $request,$id = 0){
         try {
             $request->validate([
                'descripcion'=>'required',
                'monto'=>'required',
             ]);

             /***************************************************************/
             /*                CREAR O EDITAR ANTICIPO POR ID                  */
             /**************************************************************/
             $anticipo = AnticipoHaber::firstOrNew(['id'=>$id]);

             $anticipo->descripcion = $request->descripcion;
             $anticipo->monto = $request->monto;
             $anticipo->estado = $request->estado ? 'activo' : 'inactivo';

             $anticipo->save();

             return response('success',200);

         }catch (\Exception $exception){
             return response($exception,422);
         }
     }

     public function destroy($id){
         try {
            $anticipo = AnticipoHaber::find($id);
            $anticipo->delete();

            return response('success',200);
         }catch (\Exception $exception){
             return response($exception,422);
         }
     }


}
