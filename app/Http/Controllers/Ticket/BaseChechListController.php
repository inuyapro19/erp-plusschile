<?php

namespace App\Http\Controllers\Ticket;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class BaseChechListController extends Controller
{
    public function index()
    {
        return view('checklist.configuracion');
    }

    public function dashboard()
    {
        return view('dashboard-calidad');
    }



    public function getUsersByAreas(Request $request)
    {
        $areaIds = $request->input('area_ids');
        $users = User::whereHas('trabajador.contrato', function ($query) use ($areaIds) {
            $query->whereIn('area_id', $areaIds);
        })->get();

        return $users;
    }

}
