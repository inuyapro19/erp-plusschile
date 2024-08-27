<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalendarioController extends Controller
{

    public function index(){
        return view('calendario.index',
            [
            'notificaciones'=>auth()->user()->unreadNotifications
        ]);
    }




}
