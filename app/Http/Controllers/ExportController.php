<?php

namespace App\Http\Controllers;

use App\Exports\BusesExport;
use App\Exports\TrabajadorCargoExport;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;


class ExportController extends Controller
{

    public function export_trabajadores_bonos(){
        $archivo =  Str::random(10).rand(1,9).'.xlsx';
        return Excel::download(new TrabajadorCargoExport(), $archivo);
    }




}
