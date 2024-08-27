<?php

namespace App\Http\Controllers;

use App\Exports\MensajeExport;
use App\Exports\Trabajadores;
use App\Models\BancoTrabajador;
use App\Models\GastoTipo;
use App\Models\Tramos;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Excel;
class OtrosController extends Controller
{
    public function getBancos($id)
    {
        $bancos = BancoTrabajador::with('banco')->where('trabajador_id','=',$id)->get();
        return response($bancos,200);
    }



    public function export_trabajadores(Request $request)
    {
        $archivo =  Str::random(10).rand(1,9).'.xlsx';
        return Excel::download(new Trabajadores(), $archivo);
    }

    public function getTramos(){
        try {
            $tramos = Tramos::orderBy('id','desc')->get();
            return response($tramos,200);
        }catch (\Exception $exception){
            return response($exception,422);
        }
    }

    public function getGastoTipo(){
        try {
            $gastos = GastoTipo::orderBy('id','desc')->get();
            return response($gastos,200);
        }catch (\Exception $exception){
            return response($exception,422);
        }
    }

}
