<?php

namespace App\Http\Controllers;

use App\Models\BusTrabajador;
use App\Models\Trabajador;
use App\Models\TrabajadorTripulacion;
use App\Models\Tripulacion;
use App\Models\Vistas\TripulacionView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class TripulacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tripulacion.index',
            [ 'notificaciones'=>auth()->user()->unreadNotifications]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function create()
    {
        return view('tripulacion.create',
            ['notificaciones'=>auth()->user()->unreadNotifications]
        );
    }

    public function getTripulaciones(){
       $conductores = Trabajador::with(['contrato.ubicacion','contrato.cargo','contrato.empleador','user.roles'])
           ->filtros()
           ->filtroCargo()
           ->filtroEmpleador()
           ->estados()
           ->UserRole()
           ->get();

       return response($conductores,200);
    }


  //crear ruta
    public function getListaTripulaciones(Request $request){
        try {
            $opciones = request('opciones');
            $cargo = $request->cargo_id;
            // con paginacion o sin paginacion
            if ($opciones == 'listPage'){
                //trabajadores por paginas
                $paginate =  request('perpage');
                $tripulacion = \App\Models\Vistas\TripulacionView::filtros()
                    ->orderby('NOMBRE_COMPLETO','ASC')
                    ->paginate($paginate);
            }else{
                //todos los trabajadores
               /* $trabajador = Trabajador::with(['buses','contrato.ubicacion','contrato.cargo','contrato.empleador','user.roles'])
                    ->filtros()
                    ->filtroCargo()
                    ->filtroEmpleador()
                    ->filtroUbicacion()
                    ->estados()
                    ->UserRole()
                    ->get();*/
                $tripulacion = \App\Models\Vistas\TripulacionView::filtros()
                    ->get();
            }
          return response($tripulacion,200);
        }catch (\Exception $exception){
            return response($exception,422);
        }
    }

    public function get_buses_conductor(){
        try {
            //** OBTIENE LOS CONDUCTORES JEFE ASIGNADO A UN BUS */**//
           /* $jefetriplacion = Trabajador::with(['buses'=>function($q){
                $q->select('patente','numero_bus','tipo_chofer','fecha_inicio','fecha_termino','bus_trabajadores.estado as estado_jefe_conductor')->where('bus_trabajadores.estado','=',1)->get();
            },'contrato.cargo','contrato.empleador'])
                ->whereHas('buses')->get();*/
            $jefetriplacion = DB::select('select bt.id as buses_trabajador_id,t.id as trabajador_id,t.rut,t.primer_nombre,t.segundo_nombre ,t.primer_apellido,t.segundo_apellido,t.condicion ,b.id as bus_id,b.patente,b.numero_bus,c2.nombre_cargo,e.nombre_empleador
                                                ,bt.tipo_chofer , bt.fecha_inicio, bt.fecha_termino
                                                from trabajadores as t
                                                    join bus_trabajadores bt on t.id = bt.trabajador_id
                                                    join contrato c on t.id = c.trabajador_id
                                                    join empleadores e on c.empleador_id = e.id
                                                    join cargos c2 on c.cargo_id = c2.id
                                                    join buses b on bt.bus_id = b.id
                                                    order by bt.id desc');

            return response($jefetriplacion,200);
        }catch (Exception $exception){
            return response($exception,422);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       try{

           $request->validate([
                'trabajador_id'=>'required',
                'tipo_chofer'=>'required',

           ]);

              $tripulacion = BusTrabajador::firstOrNew(['id'=>$request->id_bus_trabajador]);

              $tripulacion->trabajador_id =$request->trabajador_id;
              $tripulacion->bus_id=$request->bus_id;
              $tripulacion->tipo_chofer=$request->tipo_chofer;
              $tripulacion->fecha_inicio=$request->fecha_inicio;
              $tripulacion->fecha_termino=$request->fecha_termino;

              $tripulacion->save();


        return response('succes',200);

       }catch (\Exception $exception){
            return response('error',403);
       }
    }

    public function actualizacion_ubicacion(Request $request,$id){
        try {

            $trabajador = Trabajador::find($id);
            $trabajador->ubicacion_actual = $request->ubicacion_actual;
            $trabajador->save();

            return response('success',200);

        }catch (Exception $exception){

            return response($exception,422);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tripulacion  $tripulacion
     * @return \Illuminate\Http\Response
     */
    public function show(Tripulacion $tripulacion)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tripulacion  $tripulacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Tripulacion $tripulacion)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        try{

            $request->validate([
                'codigo'=>'required',
                'buses_id'=>'required',
            ]);

            $tripulacion = Tripulacion::find($id);

            $tripulacion->update([
                'codigo'=>$request->input('codigo') ,
                'buses_id'=>$request->input('buses_id')
            ]);

            /********************************************************/
            /*           CREAR  tripilacion trabajadores         ***/
            /******************************************************/

            $trabajadores = json_decode($request->trabajadores);

            foreach ($trabajadores as $trabajador )
            {
                foreach($trabajador as $item)
                {
                   $trabajadorTripulacion =  TrabajadorTripulacion::where('trabajador_id','=',$trabajador->id)->first();

                    $trabajadorTripulacion->update([
                        'tripulacion_id'=>$tripulacion->id,
                        'trabajador_id' =>$item->trabajador_id,
                        'jefe_maquina'=>$item->jefe_maquina ? 'si':'no',
                        'segundo_chofer'=>$item->segundo_chofer ? 'si':'no',
                        'auxiliar'=>$item->auxiliar ? 'si':'no',
                        'estado'=>$item->estado
                    ]);
                }
            }

        }catch (\Exception $exception){
            return response('error',403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tripulacion  $tripulacion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $bus_trabajador = BusTrabajador::find($id);
            $bus_trabajador->delete();

            return response('success',200);

        }catch (\Exception $exception){
            return response('error',422);
        }
    }

    public function cambio_estado(Request $request,$id){
        try {
            $trabajador = Trabajador::find($id);
            $trabajador->condicion = $request->estado;
            $trabajador->save();

            return response('success',200);

        }catch (Exception $exception){
            return response($exception,422);
        }
    }



}
