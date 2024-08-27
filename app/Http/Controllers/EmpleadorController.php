<?php

namespace App\Http\Controllers;

use App\Models\Empleador;
use Illuminate\Http\Request;

class EmpleadorController extends Controller
{
    public function getEmpleador()
    {
        try {
            $empleador = Empleador::orderBy('nombre_empleador','asc')->get();

            return response($empleador,200);
        }catch (Throwable $e) {

            return response($e,403);
        }

    }

    public function store(Request $request,$id = 0){
        try {
            $request->validate([
                //'codigo_empresa' =>'required',
                'nombre_empleador'=>'required'
            ]);

           $empleador = Empleador::firstOrNew(['id'=>$id]);

           if($id == 0){
               $empleador->codigo_empresa =$request->codigo_empresa;
           }

           $empleador->nombre_empleador = $request->nombre_empleador;
           $empleador->rut = $request->rut_empresa;
           $empleador->direccion = $request->direccion;
           $empleador->comuna = $request->comuna;
           $empleador->representante_legal = $request->representante_legal ?? '';
           $empleador->rut_representante = $request->rut_representante ?? '';

              $empleador->save();
            return response($empleador,200);
        }catch (Throwable $e) {
            return response($e,403);
        }
    }

    public function show($id){
        try {
            $empleador = Empleador::find($id);

            return response($empleador,200);
        }catch (Throwable $e) {

            return response($e,403);
        }
    }

    public function update(Request $request,$id){
        try {

            $empleador= Empleador::find($id);

           // return response($empleador,200);

            //$empleador->codigo_empresa = $request->codigo_empresa;
            $empleador->nombre_empleador = $request->nombre_empleador;
            $empleador->rut = $request->rut_empresa;
            $empleador->direccion = $request->direccion;
            $empleador->comuna = $request->comuna;
            $empleador->representante_legal = $request->representante_legal ?? '';
            $empleador->rut_representante = $request->rut_representante ?? '';

            $empleador->save();

            return response($empleador,200);
        }catch (Throwable $e) {

            return response($e,403);
        }
    }

    public function destroy($id){
        try {
            $empleador= Empleador::find($id);

            $empleador->delete();

            return response('success',200);

        }catch (Throwable $e) {
            return response($e,404);
        }
    }


}
