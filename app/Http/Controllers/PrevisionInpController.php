<?php

namespace App\Http\Controllers;

use App\Models\PrevisionInp;
use Illuminate\Http\Request;

class PrevisionInpController extends Controller
{
    public function getPrevicioninp(){
        try {
            $previson_inp = PrevisionInp::orderBy('nombre','asc')->get();
            return response($previson_inp,200);
        }catch (\Throwable $e){
            return response($e,403);
        }
    }

    public function store(Request $request){
        try {
            $request->validate([
                'codigo'=>'required',
                'nombre'=>'required'
            ]);

            PrevisionInp::create([
               'codigo'=>$request->codigo,
               'nombre'=>$request->nombre
            ]);

            return response('success',200);

        }catch (Exception $exception){
            return response('error',403);
        }
    }
    public function show($id){
        try {
            $prevision = PrevisionInp::find($id);
            return response($prevision,200);
        }catch (Exception $exception){
            return response('error',403);
        }
    }

    public function update(Request $request,$id){
        try {
            $request->validate([
                'codigo'=>'required',
                'nombre'=>'required'
            ]);

            $prevision = PrevisionInp::find($id);

            $prevision->update([
                'codigo'=>$request->codigo,
                'nombre'=>$request->nombre
            ]);

            return response('success',200);

        }catch (Exception $exception){
            return response('error',403);
        }
    }
    public function destroy($id){
        try {

            $prevision = PrevisionInp::find($id);

            $prevision->delete();

            return response('success',200);

        }catch (Exception $exception){
            return response('error',403);
        }
    }
}
