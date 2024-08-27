<?php

namespace App\Http\Controllers;

use App\Models\BonoHaber;
use Illuminate\Http\Request;

class BonoHaberController extends Controller
{
    public function getBonos(){
        try {

            $bonos = BonoHaber::isActive()
                                ->get();

            return response($bonos,200);

        }catch (Exception $exception){

            return response($exception,422);

        }
    }

    public function store(Request $request,$id=0){
        try {

            $request->validate([
                'descripcion_bono'  =>'required',
                //'monto'             =>'required|numeric',
                //'tipo'              =>'required'
            ]);

            /***************************************************************/
            /*                CREAR O EDITAR BONO POR ID                  */
            /**************************************************************/
            $bono = BonoHaber::firstOrNew(['id'=>$id]);

            $bono->descripcion = $request->descripcion_bono;

            $bono->monto = $request->monto;

            $bono->tipo = $request->tipo;

            $bono->categoria = $request->categoria;

            $bono->clasificacion = $request->clasificacion;

            $bono->aplica_gratificacion = $request->gratificacion  ? 'SI':'NO';

            $bono->aplica_anticipable = $request->anticipable  ? 'SI':'NO';

            $bono->aplica_hora_extra = $request->hora_extra  ? 'SI':'NO';

            $bono->factor = $request->has('factor') ? $request->factor : 0;

            $bono->estado = $request->estado ? 'activo' : 'inactivo';

            $bono->save();

            return response('success',200);
        }catch (\Exception $exception){
            return response($exception,422);
        }

    }

    public function destroy($id){
        try{

            $bono = BonoHaber::find($id);
            $bono->delete();

            return response('success',200);

        }catch (\Exception $exception){
            return response($exception,422);
        }
    }

}
