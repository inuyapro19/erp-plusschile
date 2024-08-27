<?php

namespace App\Http\Controllers;

use App\Models\LicenciaConducir;
use App\Models\TipoLicencia;
use Illuminate\Http\Request;

class LicenciaController extends Controller
{
    public function getCargaLicencias($id){
        try{
            $licencia = LicenciaConducir::where('trabajador_id','=',$id)->get();
            return response($ahorro,200);
        }  catch (\Throwable $e){
            return response($e,403);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo_licencia_id'=>'required',
            'nro_serie'=>'required',
            'fecha_de_ingreso'=>'required',
            'fecha_de_vencimiento'=>'required',
        ]);

        return response('ok',200);
    }

    public function getTipoLicencia()
    {
        try {
            $tipo_licencia = TipoLicencia::orderBy('id','asc')->get();
            return response($tipo_licencia,200);
        } catch (Throwable $e) {

            return response($e,404);
        }
    }

}
