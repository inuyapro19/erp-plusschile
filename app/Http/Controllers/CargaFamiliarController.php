<?php

namespace App\Http\Controllers;

use App\Models\CargaFamiliar;
use App\Models\Parentescos;
use Illuminate\Http\Request;

class CargaFamiliarController extends Controller
{
       public function getCargaFamiliar($id)
       {
           $cargaFamiliar = CargaFamiliar::where('trabajador_id','=',$id)->get();
           return response($cargaFamiliar,200);
       }

    public function getCadigoParentesco()
    {
        try {
            $parentesco = Parentescos::orderBy('id','asc')->get();

            return response($parentesco,200);
        }catch (Throwable $e) {

            return response($e,404);
        }
    }

}
