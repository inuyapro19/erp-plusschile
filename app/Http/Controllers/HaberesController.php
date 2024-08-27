<?php

namespace App\Http\Controllers;

use App\Models\Vistas\Anticipo;
use App\Models\vistas\BonoHaber;
use App\Models\vistas\BonoTrabajador;
use App\Models\Vistas\HaberNoImponible;
use App\Models\Vistas\HoraExtra;
use Illuminate\Http\Request;

class HaberesController extends Controller
{
   public function index(){
       return view('haberesydescuentos.index',[
           'notificaciones'=>auth()->user()->unreadNotifications
       ]);
   }

    public function getAnticipos(){
        try {
            $anticipos = Anticipo::isActive()->paginate(10);
            return response($anticipos,200);
        }catch (\Exception $exception){
            return response($exception,422);
        }
    }


    public function getHorasExtras(){
       try {

          $horaextra = HoraExtra::isActive()
                                ->paginate(10);

           return response($horaextra,200);

       }catch (\Exception $exception){
            return response($exception,422);
       }
    }

    public function getBonos(){
        try{
            $bonos = BonoHaber::isActive()
                ->paginate(10);

          return response($bonos,200);

        }catch (\Exception $exception){
            return response($exception,422);
        }
    }

    public function getDescuentos(){
        try {

        }catch (\Exception $exception){

        }
    }

    public function getHaberesNoImponibles(){
        try {
           $haberno_imponible = HaberNoImponible::isActive()
                ->paginate();

           return response($haberno_imponible,200);

        }catch (\Exception $exception){

            return response($exception,422);

        }
    }


}
