<?php

namespace App\Http\Controllers;

use App\Imports\BonoTrabajadorAsignacionImport;
use App\Imports\LicenciaImport;
use App\Imports\TrabajadoresImport;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class ImportController extends Controller
{
   public function asignaciones_mensuales_carga(Request $request){
       try {
           $file = $request->file('file');
           $filename =  Str::random(10).rand(1,9).'.xlsx';
           $file->move('upload/carga_mensuales/', $filename);

           Excel::import(new BonoTrabajadorAsignacionImport(),public_path('upload/carga_mensuales/'.$filename));

           //eliminar archivo de directorio
           Storage::delete('upload/carga_mensuales/'.$filename);

           return response('success',200);

       }catch (\Exception $exception){
           return response($exception,422);
       }
   }

    public function licencias_medicas_carga(Request $request){
        try {
            $file = $request->file('file');
           // $filename =  Str::random(10).rand(1,9).'.xlsx';
           // $file->move('upload/carga_mensuales/', $filename);

           Excel::import(new LicenciaImport(),$request->file('file')->store('temp'));

            //eliminar archivo de directorio
            //Storage::delete('upload/carga_mensuales/'.$filename);


            /*$request->validate([
                'file' => 'required|mimes:xlsx,xls'
            ]);

            $file = $request->file('file');
            $import = new LicenciaImport();
            Excel::import($import, $file);*/

            $registros_exitosos = session('registros_exitosos');
            $registros_fallidos = session('registros_fallidos');
            $total_row = session('total_row');
            $trabajadores = session('trabajador');
            $filas_error = session('filas_error');

            return response()->json([
                'registros_exitosos' => $registros_exitosos,
                'registros_fallidos' => $registros_fallidos,
                'total_row' => $total_row,
                'filas_error' => $filas_error,
                'trabajadores' => $trabajadores
            ]);

        }catch (\Exception $exception){
            return response($exception,422);
        }
    }



}
