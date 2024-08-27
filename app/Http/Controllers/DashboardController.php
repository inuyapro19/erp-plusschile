<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function adminDashboard()
    {
        return view('dashboard.administrador');
    }

    public function rrhhDashboard()
    {
        return view('dashboard.rrhh');
    }

    public function operacionesDashboard()
    {
        return view('dashboard.operaciones');
    }

    public function calidadDashboard()
    {
        //dd('hola');
        return view('dashboard.calidad');
    }

    public function trabajadorDashboard()
    {
        return view('dashboard.trabajador');
    }


    public function prevencionDashboard()
    {
        return view('dashboard.prevencion');
    }


}
