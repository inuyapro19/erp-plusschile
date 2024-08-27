<?php

namespace App\Http\Controllers\sistema;

use App\Http\Controllers\Controller;
use App\Models\sistema\LogSistema;
use Illuminate\Http\Request;

class LogSistemaController extends Controller
{
    public function index()
    {
        return view('logs.index',[
            'notificaciones'=>auth()->user()->unreadNotifications
        ]);
    }

    public function getLogSistema()
    {
        try{
            $logs = LogSistema::with('user')->orderBy('id', 'desc')
                        ->paginate(20);
            return response()->json($logs);
        }catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
