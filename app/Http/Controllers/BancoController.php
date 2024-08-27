<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class BancoController extends Controller
{
    public function getBancos()
    {
        try {
            $banco = Banco::orderBy('nombre_banco','asc')->get();

            return response($banco,200);
        }catch (Throwable $e) {

            return response($e,404);
        }
    }

    public function store(Request $request){
        try {
            $request->validate([
                'nombre_banco'=>'required'
            ]);

            Banco::create(['nombre_banco'=>$request->nombre_banco]);

            return response('success',200);
        }
        catch (Exception $exception){
            return response($exception,403);
        }
    }

    public function show($id){
        try {
           $banco = Banco::find($id);
           return response($banco,200);
        }catch (Exception $exception){
            return response('error',403);
        }
    }

    public function update(Request $request,$id){
        try {
            $banco = Banco::find($id);
            $banco->update(['nombre_banco'=>$request->nombre_banco]);
            return response('success',200);
        }catch (\Exception $exception){
            return response($exception,403);
        }
    }

    public function destroy($id){
        try {
            $banco = Banco::find($id);
            $banco->delete();
            return response('success',200);
        }catch (\Exception $exception){
            return response($exception,403);
        }
    }


}
