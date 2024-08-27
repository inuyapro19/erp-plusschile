<?php

namespace App\Http\Controllers;

use App\Models\Vistas\TrabajadoresAutorizados;
use Illuminate\Http\Request;

class TrabajadoresAutorizadosController extends Controller
{
    public function getTrabajadoresAutorizados()
    {
        try{
            $trabajadores = TrabajadoresAutorizados::get();
            return response()->json($trabajadores);
        }
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


}
