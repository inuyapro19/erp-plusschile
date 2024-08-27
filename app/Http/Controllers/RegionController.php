<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function getRegiones()
    {
        try {
            $regiones = Region::OrderBy('id','asc')->get();
            return response($regiones,200);
        }catch (Throwable $e) {

            return response($e,404);
        }
    }
}
