<?php

namespace App\Http\Controllers;

use App\Models\Meses;
use Illuminate\Http\Request;

class MesesController extends Controller
{
    public function index(){
        return view('meses.index',[
            'notificaciones'=>auth()->user()->unreadNotifications,
        ]);
    }

   public function  getMeses(){
       try {
           $meses = Meses::all();

           return response($meses,200);

       } catch (\Exception $exception){
           return response($exception ,422);
       }
    }

    public function store(Request $request,$id){
        try {

            $meses = Meses::find($id);
            $meses->isOpen = $request->isOpen;
            $meses->save();

            return response('success',200);

        }catch (\Exception $exception){
            return response($exception,422);
        }
    }

}
