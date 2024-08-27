<?php

namespace App\Http\Controllers;

use App\Models\Comunas;
use App\Models\Contacto;
use App\Models\Contrato;
use App\Models\Empleador;
use App\Models\Prevision;
use App\Models\Region;
use App\Models\Salud;
use App\Models\Trabajador;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
class PerfilController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Trabajador  $trabajador
     * @return \Illuminate\Http\Response
     */
    public function edit($rut)
    {
        if(Auth::user()->cambio_contrasena == 'N'):
            Session::flash('danger','Debe cambiar su contraseña');
        endif;
        //$notifications = auth()->user()->unreadNotifications;
        // dd($notifications);
        return view('trabajador.edit',[
            'rut'=>$rut,
            'notificaciones'=>auth()->user()->unreadNotifications
        ]);
    }


    public function getPerfilTrabajador($rut){
        try{

           $trabajador =  Trabajador::with(['region','comuna','contrato.empleador','contrato.ubicacion','contrato.cargo','contrato.area'])
               ->where('rut','=',$rut)
               ->first();

           return response($trabajador,200);
        }catch (Exception $exception){
            return response($exception,403);
        }
    }


    public function getPerfilPrimerContacto(){
        try{

            $user_id = Auth::user()->id;
            $trabajador = Trabajador::where('user_id','=',$user_id)->first();
            $contacto = Contacto::where('trabajador_id','=',$trabajador->id)
                        ->orderBy('id','asc')
                        ->first();

            if($contacto){
                return response($contacto,200);
            }else{
                $contacto = [
                    'id'=>0,
                    'nombre' => '',
                    'apellido' =>'',
                    'correo'  => '',
                    'telefono'  => '',
                    'direccion' =>'',
                    'region_id' =>'',
                    'comuna_id' =>'',
                    'trabajador_id'=>'',
                    'parentesco' => '',
                    'otro_parentesco' =>''
                ];
                return response(json_encode($contacto),200);
            }


        }catch (Exception $exception){
            return response($exception,403);
        }
    }
    public function getPerfilSegundoContacto(){
        try{
            $user_id = Auth::user()->id;
            $trabajador = Trabajador::where('user_id','=',$user_id)->first();
            $contacto = Contacto::where('trabajador_id','=',$trabajador->id)->orderBy('id','desc')->first();
            if($contacto){
                return response($contacto,200);
            }else{
                $contacto = [
                    'id'=>0,
                    'nombre2' => '',
                    'apellido2' =>'',
                    'correo2'  => '',
                    'telefono2'  => '',
                    'direccion2' =>'',
                    'region_id2' =>'',
                    'comuna_id2' =>'',
                    'trabajador_id2'=>'',
                    'parentesco2' => '',
                    'otro_parentesco2' =>''
                ];
                return response(json_encode($contacto),200);
            }

        }catch (Exception $exception){
            return response($exception,403);
        }
    }
    public function getDatosContractuales(){
        try{
            $user_id = Auth::user()->id;
            $trabajador = Trabajador::where('user_id','=',$user_id)
                                     ->first();
            $contrato = Contrato::with(['empleador','ubicacion','cargo','area'])
                                ->where('trabajador_id','=',$trabajador->id)
                                ->orderBy('id','desc')->first();

            return response($contrato,200);
        }catch (Exception $exception){
            return response($exception,403);
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Trabajador  $trabajador
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $rut)
    {
        try {


            $user_id = Auth::user()->id;
            $trabajador = Trabajador::where('user_id','=',$user_id)->first();

            if($request->has('datos_personales')){
                $request->validate([
                    'telefono_celular'=>'required',
                ]);
                $trabajador->telefono_local=$request->telefono_local;
                $trabajador->telefono_celular=$request->telefono_celular;
                $trabajador->save();

                $user =  User::find($user_id);

                $user->primer_login = 'N';
                $user->cambio_contrasena = 'Y';
                $user->save();

            }else{
                /********************************************************/
                /*           CREAR  CONTACTO  comprobar si existe    ***/
                /******************************************************/

                $contacto = Contacto::firstOrNew(['id'=>$request->id]);

                $contacto->nombre = $request->nombre;
                $contacto->apellido = $request->apellido;
                $contacto->telefono = $request->telefono;
                $contacto->direccion = $request->direccion;
                $contacto->correo = $request->email;
                $contacto->region_id = $request->region_id;
                $contacto->comuna_id = $request->comuna_id;
                $contacto->parentesco = $request->parentesco;
                $contacto->otro_parentesco = $request->otro_parentesco;
                $contacto->trabajador_id = $trabajador->id;
                $contacto->save();
            }

            return response('success',200);

        }catch (Exception $exception){
            return response($exception,403);
        }
    }

    public function editar_contrasena()
    {
        return view('perfil.cambio_contrasena',  [
            'notificaciones'=>auth()->user()->unreadNotifications
            ]);
    }
    public function cambio_contrasena(Request $request){
        try{
            $request->validate([
                'password'=>'required'
            ]);

            $user_id = Auth::user()->id;
            $user =  User::find($user_id);

            $user->password = bcrypt($request->password);
            $user->cambio_contrasena = 'Y';
            $user->save();

            return response('success',200);

        }catch(Exception $exception){
            return response($exception,403);
        }
    }
}


