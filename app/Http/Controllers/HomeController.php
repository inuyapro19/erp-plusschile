<?php

namespace App\Http\Controllers;

use App\Models\Buses;
use App\Models\User;
use App\Models\Viaje;
use App\Models\Vistas\Auxiliares_status_view;
use App\Models\Vistas\Conductores_status_view;
use App\Models\Vistas\TripulacionRetorno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized');
        }

        if (Auth::user()->primer_login == 'Y' && Auth::user()->cambio_contrasena == 'N') {
            Session::flash('danger', 'Debe cambiar la contraseña');
            return redirect(route('profile.edit'));
        }

        // Mapeo de permisos a rutas de dashboard
        $dashboardRoutes = [
            'dashboard admin' => 'dashboard.administrador',
            'dashboard rrhh' => 'dashboard.rrhh',
            'dashboard operaciones' => 'dashboard.operaciones',
            'dashboard calidad' => 'dashboard.calidad',
            'dashboard prevencion' => 'dashboard.prevencion',
            'dashboard trabajador' => 'dashboard.trabajador',
        ];

        $user = User::find(Auth::id());

        foreach ($dashboardRoutes as $permission => $routeName) {
            if ($user->can($permission)) {
                return redirect()->route($routeName);
            }
        }

        $empresa_cantidad = DB::table('contrato as c')
            ->join('empleadores as e', 'c.empleador_id', '=', 'e.id')
            ->select('e.nombre_empleador', DB::raw('count(c.empleador_id) as cantidad_trabajadores_empresa'))
            ->groupBy('e.nombre_empleador')
            ->get();

        return response()->json([
            //'notificaciones' => auth()->user()->unreadNotifications,
            'empresa_cantidad' => $empresa_cantidad,
        ]);
    }

    //pasar a vue js
    public function dashboard_operaciones(){
       try{

           $tripulacion_auxiliares = Auxiliares_status_view::first();
           $tripulacion_conductores = Conductores_status_view::first();

           $tripulacion_conductores_disponible = Conductores_status_view::select(DB::RAW('DISPONIBLE'))->first();
           $tripulacion_auxiliares_disponible = Auxiliares_status_view::select(DB::RAW('DISPONIBLE'))->first();
           $buses_operativos = Buses::where('estado','bus operativo')->select(DB::RAW('count(estado) as Cantidad'))->first();
           $viajes_en_ruta = Viaje::where('estado','EN RUTA')->select(DB::RAW('count(estado) as Cantidad'))->first();
           $tripulacion_retorno = TripulacionRetorno::all();

           return view('dashboard_operaciones',[
               'tripulacion_conductores'=>$tripulacion_conductores,
               'tripulacion_axuliares'=>$tripulacion_auxiliares,
               'tripulacion_conductores_disponible'=>$tripulacion_conductores_disponible,
               'tripulacion_auxiliares_disponible'=>$tripulacion_auxiliares_disponible,

               'buses_operativos'=>$buses_operativos,
               'viajes_en_ruta'=>$viajes_en_ruta,
               'tripulacion_retorno'=>$tripulacion_retorno,
               'notificaciones'=>auth()->user()->unreadNotifications]);

       }catch (\Exception $e){
             return $e->getMessage();
        }

    }


}
