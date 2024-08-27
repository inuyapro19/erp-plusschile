<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RemuneracionesController extends Controller
{
    public function index(){
        return view('remuneraciones.index');
    }

    public function getRemuneraciones($mes = 1){
        try {
            $remunereaciones = DB::select('CALL CALCULAR_REMUNERACION_MENSUAL('.$mes.',227)');
            return response($remunereaciones,200);

        }catch (\Exception $exception){
            return response($exception,422);
        }
    }



}
