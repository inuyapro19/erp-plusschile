<?php

namespace App\Http\Controllers;

use App\Imports\BancoImport;
use App\Imports\BusesImport;
use App\Imports\CargaFamiliarImport;
use App\Imports\ContactoImport;
use App\Imports\ContratoImport;
use App\Imports\GestionTripulacion;
use App\Imports\PrevisionImport;
use App\Imports\SaludImport;
use App\Imports\TrabajadoresImport;
use App\Imports\TrabajadorVacaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use mysql_xdevapi\Exception;

class TrabajadorImport extends Controller
{

    public function user_import()
    {
        return view('trabajador.import',['notificaciones'=>auth()->user()->unreadNotifications]);
    }

    public function ficha_import_create(Request $request)
    {
        try {
            $request->validate([
                'file'=>'required',
            ]);

            $file = $request->file('file');
            $filename =  Str::random(10).rand(1,9).'.xlsx';
            $file->move('upload/documentos/', $filename);

           //dd($file);

            switch ($request->tipo_importar){
                case 1:
                    Excel::import(new TrabajadoresImport(),public_path('upload/documentos/'.$filename));
                break;
                case 2:
                    Excel::import(new ContratoImport(),public_path('upload/documentos/'.$filename));
                break;
                case 3:
                    Excel::import(new ContactoImport(),public_path('upload/documentos/'.$filename));
                    break;
                case 4:
                    Excel::import(new PrevisionImport(),public_path('upload/documentos/'.$filename));
                    break;
                case 5:
                    Excel::import(new SaludImport(),public_path('upload/documentos/'.$filename));
                    break;
                case 6:
                    Excel::import(new CargaFamiliarImport(),public_path('upload/documentos/'.$filename));
                    break;
                case 7:
                    Excel::import(new BancoImport(),public_path('upload/documentos/'.$filename));
                    break;
                case 8:
                    Excel::import(new BusesImport(),public_path('upload/documentos/'.$filename));
                    break;
                case 9:
                    Excel::import(new GestionTripulacion(),public_path('upload/documentos/'.$filename));
                    break;
                case 10:
                    Excel::import(new TrabajadorVacaciones(),public_path('upload/documentos/'.$filename));
                    break;
                default:
                     Excel::import(new TrabajadoresImport(),public_path('upload/documentos/'.$filename));
            }


            return response('success',200);
        }catch (Exception $exception){
            return response($exception,403);
        }

    }

    public function ficha_import_update(Request $request)
    {
        try
        {
            $request->validate([
                'excel'=>'required',
            ]);
            Excel::import(new TrabajadoresImportUpdate(),request()->file('excel'));
            return response('success',200);
        }catch (\Exception $exception){
            return response($exception,403);
        }
    }

}
