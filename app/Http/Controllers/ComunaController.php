<?php

namespace App\Http\Controllers;

use App\Models\Comunas;
use Illuminate\Http\Request;

class ComunaController extends Controller
{
    public function getComunas($id = false)
    {
        try {
            if ($id){
                $comunas =  Comunas::where('region_id','=',$id)
                    ->orderBy('nombre_comuna','asc')
                    ->get();
            }
            else{
                $comunas =  Comunas::orderBy('nombre_comuna','asc')->get();
            }

            return response($comunas,200);
        }catch (Throwable $e) {
            return response($e,404);
        }

    }
}
