<?php

namespace App\Http\Controllers;

use App\Models\AhorroVoluntario;
use App\Models\AhorroVoluntarioTrabajador;
use Illuminate\Http\Request;

class AhorroVoluntarioController extends Controller
{
    public function getAhorroVoluntario(){
        try{
            $ahorro = AhorroVoluntario::orderBy('nombre','asc')->get();
            return response($ahorro,200);
        }  catch (\Throwable $e){
            return response($e,403);
        }
    }

       public function getCargaAhorros($id){
           try{
               $ahorro = AhorroVoluntarioTrabajador::where('trabajador_id','=',$id)->get();
               return response($ahorro,200);
           }  catch (\Throwable $e){
               return response($e,403);
           }
       }

}
