<?php

namespace App\Http\Controllers;

use App\Models\PuebloOriginario;
use Illuminate\Http\Request;
use TheSeer\Tokenizer\Exception;

class PuebloOriginarioController extends Controller
{
    public function getPuebloOriginarios()
    {
        try {
            $pueblos = PuebloOriginario::orderBy('pueblo_originario','asc')->get();
            return response($pueblos,200);
        }
        catch (Throwable $e) {

            return response($e,404);
        }
    }

    public function store(Request $request){
        try {
            $request->validate([
                'pueblo_originario'=>'required'
            ]);

            PuebloOriginario::create([
                'pueblo_originario'=>$request->pueblo_originario
            ]);

            return response('success',200);

        }catch (Exception $exception){
            return response('error',403);
        }
    }

    public function show($id){
        try {
            $pueblos = PuebloOriginario::find($id);

            return response($pueblos,200);
        }catch (Exception $exception){
            return response('error',403);
        }
    }

    public function update(Request $request,$id){
        try {

            $pueblos = PuebloOriginario::find($id);

            $pueblos->update([
               'pueblo_originario' =>$request->pueblo_originario
            ]);

            return response($pueblos,200);

        }catch (Exception $exception){
            return response('error',403);
        }
    }

    public function destroy($id){
        try {
            $pueblos = PuebloOriginario::find($id);
            $pueblos->delete();
            return response($pueblos,200);
        }catch (Exception $exception){
            return response('error',403);
        }
    }


}
