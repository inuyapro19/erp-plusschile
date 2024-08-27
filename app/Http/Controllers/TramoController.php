<?php

namespace App\Http\Controllers;

use App\Models\Tramos;
use Illuminate\Http\Request;

class TramoController extends Controller
{
    public function store(Request $request){
        try {
            $request->validate(['tramo'=>'required']);

            Tramos::create([
                'tramo'=>$request->tramo
            ]);

            return response('success',200);

        }catch (\Exception $exception){
            return response($exception,422);
        }
    }
}
