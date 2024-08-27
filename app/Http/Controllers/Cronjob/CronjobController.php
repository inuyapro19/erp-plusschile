<?php

namespace App\Http\Controllers\Cronjob;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CronjobController extends Controller
{

    //comprobar si los viajes superan la hora de llegada
    public function checkTimeArrival(){
        $trips = Viajes::where('estado', '==', 'EN RUTA')->get();


    }

    //comprobar si los viajes superan la hora de llegada Y NO SUPERAN LA HORA DE LLEGADA
    public function checkTimeArrivalAndTimeArrival(){
        $trips = Viajes::where('estado', '==', 'EN ORIGEN')->get();

        return response($trips,200);
    }


}
