<?php

namespace App\Http\Controllers;

use App\Models\Buses;
use App\Models\Vistas\GestionTripulacion;
use App\Models\Trabajador;
use App\Models\Vistas\GestionTrabajador;
use App\Models\GestionTripulacion as GestionOperaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GestionTripulacionController extends Controller
{

    public function index()
    {
        $request = request('tipo');

        if ($request == 'trabajadores') {
            return view('gestion.all_gestion', ['notificaciones' => auth()->user()->unreadNotifications]);
        }else{
            return view('gestion.gestion', ['notificaciones' => auth()->user()->unreadNotifications]);
        }

    }



    public function getGestionTripulacion(){
        try {
           $tipo = request('tipo');

           if ($tipo == 'trabajadores'){
               $paginate =  request('perpage');
               $trabajador = GestionTrabajador::filtros()
                                        ->paginate($paginate);

               return response($trabajador,200);

           } else{
               $paginate =  request('perpage');
               $trabajador = GestionTripulacion::filtros()
                                                ->paginate($paginate);

               return response($trabajador,200);

           }

        } catch (\Exception $exception){
            return response($exception,302);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'trabajador_id'=>'required',
                'fecha_inicio'=>'required',
                'nro_dias'=>'required|numeric',
                'tipo'    => 'required'
            ]);

            //crear gestion   dias libres - permisos - ausencias
            $gestion =  new GestionOperaciones();
            $gestion->tipo = $request->tipo;
            $gestion->trabajador_id = $request->trabajador_id;
            $gestion->fecha_inicial = $request->fecha_inicio;
            $gestion->fecha_termino = $request->fecha_termino;
            $gestion->numero_dias = $request->nro_dias;
            $gestion->fecha_retorno = $request->fecha_retorno;
            $gestion->save();

            //actualizar condicion trabajador (conductores y axiliares)
            $trabajador = Trabajador::find($request->trabajador_id);
            $trabajador->condicion = $request->tipo;
            $trabajador->save();

            return response('success',200);
        }catch (\Exception $exception){
            return response($exception, 422);
        }
    }

    //destruir gestion tripulacion
    public function destroy($id){
        try {
            $gestion = GestionOperaciones::find($id);
            $gestion->delete();

            //actualizar condicion trabajador (conductores y axiliares)
            $trabajador = Trabajador::find($gestion->trabajador_id);
            $trabajador->condicion = 'dispobible';
            $trabajador->save();

        }catch (\Exception $exception){
            return response($exception,500);
        }
    }

}
