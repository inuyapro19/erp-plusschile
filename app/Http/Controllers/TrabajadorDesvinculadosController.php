<?php

namespace App\Http\Controllers;

use App\Models\Areas;
use App\Models\Cargo;
use App\Models\Contrato;
use App\Models\Empleador;
use App\Models\HistorialDesvinculacion;
use App\Models\HistorialTrabajador;
use App\Models\Trabajador;
use App\Models\Ubicacion;
use App\Models\User;
use App\Models\Vistas\TrabajadorDesvinculados;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class TrabajadorDesvinculadosController extends Controller
{
    public function index(Request $request){

        $cargos = Cargo::orderBy('nombre_cargo','asc')->get();
        $empresas = Empleador::orderBy('nombre_empleador','asc')->get();

        $trabajador = HistorialTrabajador::orderBy('primer_nombre','asc')->paginate(20);


        return view('trabajador.desvinculados.index',
            [
                'trabajadores'=>$trabajador,
                //'cargos'=>$cargos,
                //'empresas'=>$empresas,
                'notificaciones'=>auth()->user()->unreadNotifications
            ]);
    }

    public function getDesvinculados(){
        try {
            $opciones= request('opciones');

            if ($opciones === 'paginate') {
                $desvinculados = TrabajadorDesvinculados::orderBy('TRABAJADOR_ID','desc')
                                                            ->paginate(20);
            }else{
                $desvinculados = TrabajadorDesvinculados::orderBy('TRABAJADOR_ID','desc')
                                                         ->groupBy('RUT')
                                                        ->get();
            }

            return response($desvinculados,200);

        }catch (Exception $exception){
            return response($exception,422);
        }
    }

    public function reincorporar_trabajador($id){
        $trabajador = HistorialTrabajador::where('id','=',$id)->first();
        //dd($trabajador);
        $cargos = Cargo::orderBy('id','asc')->get();
        $areas = Areas::orderBy('id','asc')->get();
        $empleador = Empleador::orderBy('id','asc')->get();
        $ubicaciones = Ubicacion::orderBy('id','asc')->get();
        return view('reincorporar.reicorporar',[
            'trabajador'=>$trabajador,
            'cargos'=>$cargos,
            'areas'=>$areas,
            'empleador'=>$empleador,
            'ubicaciones'=>$ubicaciones,
            'notificaciones'=>auth()->user()->unreadNotifications
        ]);
    }

    public function reincorporar(Request $request,$id){
        try {

          //buscar y crear trabajador desde historialtrabajador
            $find = (int) $id;
            $trabajador = HistorialTrabajador::find($id);

            /********************************************************/
            /*               NUEVO USUARIO                       ***/
            /******************************************************/
            $user = new User();
            $user->rut = $trabajador->rut;
            $user->name = $trabajador->primer_nombre;
            $user->apellidos = $trabajador->primer_apellido;
            $user->email = $trabajador->correo;

            /*         Contraseña de temporal           */
            $user->password = bcrypt('pluss2021'); //settear desde setting o paramentros

            $user->primer_login = 'Y';
            $user->cambio_contrasena = 'N';

            $user->save();
            /********************************************************/
            /*            ASIGNAR  ROL TRABAJADOR                ***/
            /******************************************************/
            $user->assignRole('trabajador');

            /********************************************************/
            /*          GENERA CODIGO DE TRABAJAR                ***/
            /******************************************************/
            if($request->has('empleador_id')) {
                $empleador =  Empleador::find($request->empleador_id);

                $codigo = $empleador->codigo_empresa.'-00'.rand(1,500);

            }


            $historial = Trabajador::create([
                'codigo_trabajador'=>$codigo,
                'rut'=>$trabajador->rut,
                'primer_nombre'=>$trabajador->primer_nombre,
                'segundo_nombre'=>$trabajador->segundo_nombre,
                'primer_apellido'=>$trabajador->primer_apellido,
                'segundo_apellido'=>$trabajador->segundo_nombre,
                'fecha_nac'=>$trabajador->fecha_nac,
                'estado_civil'=>$trabajador->estado_civil,
                'sexo'=>$trabajador->sexo,
                'grado_escolaridad'=>$trabajador->grado_escolaridad,
                'telefono_local'=>$trabajador->telefono_local,
                'telefono_celular'=>$trabajador->telefono_celular,
                'correo'=>$trabajador->correo,
                'direccion'=>$trabajador->direccion,
                'region_id'=>$trabajador->region_id,
                'comuna_id'=>$trabajador->comuna_id,
                'nacionalidad_id'=>$trabajador->nacionalidad,
                'pertenece_pueblo_originario'=>$trabajador->pertenece_pueblo_originario,
                'pueblo_originario_id'=>$trabajador->pueblo_originario_id,
                'tiene_familia'=>$trabajador->carga_familiar ,
                'user_id'=>$user->id,
                'tiene_discapacidad'=>$trabajador->tiene_alguna_discapacidad,
                'estado'=>'reincorporado'
            ]);

            //crear datos de contracto
            /********************************************************/
            /*           CREAR  CONTRATO                         ***/
            /******************************************************/
            $fecha_actual = date('d-m-Y');
            $contrato = Contrato::create([
                'ubicacion_id'=>$request->ubicacion_id,
                'fecha_ingreso'=>now(),
                'fecha_antiguidad'=>now(),
                'fecha_vencimiento_contrato'=>date("d-m-Y",strtotime($fecha_actual."+ 60 days")),
                'fecha_segundo_vencimiento'=>date("d-m-Y",strtotime($fecha_actual."+ 75 days")),
                'area_id'=>$request->area_id ,
                'cargo_id'=>$request->cargo_id ,
                'trabajador_id'=>$historial->id,
                'empleador_id'=>$request->empleador_id,
            ]);

            $trabajador->delete();

            return response('success',200);

        }catch (Exception $exception){
            return response($exception,403);
        }
    }

    public function destroy(Request $request,$id)
    {
        try{

            $find = (int) $id;
            $trabajador = Trabajador::find($find);
            $historial = HistorialTrabajador::create([
                //'codigo_trabajador'=>$id,
                'rut'=>$trabajador->rut,
                'primer_nombre'=>$trabajador->primer_nombre,
                'segundo_nombre'=>$trabajador->segundo_nombre,
                'primer_apellido'=>$trabajador->primer_apellido,
                'segundo_apellido'=>$trabajador->segundo_apellido,
                'fecha_nac'=>$trabajador->fecha_nac,
                'estado_civil'=>$trabajador->estado_civil,
                'sexo'=>$trabajador->sexo,
                'grado_escolaridad'=>$trabajador->grado_escolaridad,
                'telefono_local'=>$trabajador->telefono_local,
                'telefono_celular'=>$trabajador->telefono_celular,
                'correo'=>$trabajador->correo,
                'direccion'=>$trabajador->direccion,
                'region_id'=>$trabajador->region_id,
                'comuna_id'=>$trabajador->comuna_id,
                'nacionalidad_id'=>$trabajador->nacionalidad,
                'pertenece_pueblo_originario'=>$trabajador->pertenece_pueblo_originario,
                'pueblo_originario_id'=>$trabajador->pueblo_originario_id,
                'tiene_familia'=>$trabajador->carga_familiar ,
                'tiene_discapacidad'=>$trabajador->tiene_alguna_discapacidad,
                'estado'=>'desvinculado'
            ]);
           // return response($trabajador,200);
            $user = User::find($trabajador->user_id);
            $trabajador->estado = 'desvinculado';
            $trabajador->save();
            $trabajador->delete();
            $user->delete();

            HistorialDesvinculacion::create([
                'fecha_desvinculacion'=>$request->fecha_desvinculacion,
                'causal_de_hecho'=>$request->causal_de_hecho,
                'motivo_interno_empresa'=>$request->motivo_interno_empresa,
                'motivo_id'=>$request->derecho,
                'trabajador_id'=>$trabajador->id
            ]);

            //Session::flash('success','Trabajador desvinculado exitosamente');
            return response($trabajador,200);
        }catch (\Throwable $e){
            return response($e,403);
        }
    }

}
