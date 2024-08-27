<?php

namespace App\Http\Controllers;

use App\Models\Areas;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;
use PhpParser\Node\Stmt\TryCatch;

class AreasController extends Controller
{


    public function getAreas(){
        try {
            $areas = Areas::orderBy('descripcion_area','asc')->get();

            return response($areas,200);
        }catch (Throwable $e) {

            return response($e,404);
        }
    }

    public function store(Request $request){
    try {
        $request->validate([
            'descripcion_area'=>'required',
        ]);
        Areas::create(['descripcion_area'=>$request->descripcion_area]);
        return response('success',200);
    }catch (Exception $exception){
        response($exception,403);
    }
    }

    public function show($id){
        try {

          $area =  Areas::find($id);

          response($area,200);

        }catch (Exception $exception){

          return response($exception,403);

        }
    }

    public function update(Request $request,$id){
        try {
            $area =  Areas::find($id);
            $area->update([
               'descripcion_area'=>$request->descripcion_area
            ]);
            return response('success',200);
        }catch (Exception $exception){
            return response($exception,403);
        }
    }

    public function destroy($id){
        try {

            $area =  Areas::find($id);
            $area->delete();
            return response('success',200);

        }catch (Exception $exception){
            return response('error',403);
        }
    }


}
