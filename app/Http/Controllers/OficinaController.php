<?php

namespace App\Http\Controllers;

use App\Models\Oficina;
use Illuminate\Http\Request;

class OficinaController extends Controller
{
    public function getOficinas(){
        try {
            $oficina = Oficina::orderBy('ciudad','asc')->get();

            return response($oficina,200);
        }catch (\Exception $e) {

            return response($e,404);
        }
    }

    public function store(Request $request){
        try {
            $request->validate([
                'ciudad'=>'required',
            ]);

            Areas::create(['ciudad'=>$request->oficina]);

            return response('success',200);
        }catch (Exception $exception){
            response($exception,403);
        }
    }

    public function show($id){
        try {

            $area =  Oficina::find($id);

            response($area,200);

        }catch (Exception $exception){

            return response($exception,403);

        }
    }

    public function update(Request $request,$id){
        try {
            $oficina =  Oficina::find($id);

            $oficina->update([
                'ciudad'=>$request->oficina
            ]);

            return response('success',200);

        }catch (Exception $exception){
            return response($exception,403);
        }
    }

    public function destroy($id){
        try {

            $oficina =  Oficina::find($id);

            $oficina->delete();

            return response('success',200);

        }catch (Exception $exception){
            return response('error',403);
        }
    }
}
