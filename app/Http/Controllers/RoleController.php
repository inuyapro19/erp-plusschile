<?php

namespace App\Http\Controllers;

use App\Models\Trabajador;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    public function index(){
        return view('role.index');
    }

    public function asignar_roles(){
        return view('role.asignarRole');
    }

    public function asignar_roles_create(Request $request){
        try {

          $trabajador =  Trabajador::where('id','=',$request->trabajador_id)->first();


          $user = User::find($trabajador->user_id);

          if($request->accion_seleccionada == 'Asignar Rol'){
              $roles = json_decode($request->roles);
                foreach ($roles as $rol){
                    $user->assignRole($rol);
                }
          }

          if($request->accion_seleccionada == 'Remover rol'){
                $roles_remove = json_decode($request->roles);
                foreach ($roles_remove as $rol){
                    $user->removeRole($rol);
                }
          }

          return response($user);

        }catch (Exception $exception){
            return response($exception,422);
        }
    }

    public function getRoles(){
        try{
           $roles = Role::with('permissions')
               ->orderBy('name','asc')->get();

            return  response($roles,200);
        }catch (Exception $exception){
            return response($exception,403);
        }
    }
    public function getPermission(){
        try{
            $permission = Permission::with('roles')
                ->orderBy('id','asc')->paginate(100);

            return  response($permission,200);
        }catch (Exception $exception){
            return response($exception,403);
        }
    }

    // Funcion para obtener los roles los usuario
    public function rolesUsuario(){
        try{
            $roles = User::with('roles')
                ->whereHas('roles', function($query) {
                    $query->where('name', '<>', 'trabajador');
                    $query->where('name', '<>', 'Tripulante');
                })
                ->where('id','<>',1)
                ->orderBy('id','asc')
                ->paginate(20);

            return  response($roles,200);
        }catch (Exception $exception){
            return response($exception,403);
        }
    }


    public function create(){
        return view('role.create',[
            'notificaciones'=>auth()->user()->unreadNotifications
        ]);
    }


    public function store(Request $request,$id = 0){
        try{
            //* VALIDACIONES *//
            $request->validate(
                ['name'=>'required']
            );

            $role = Role::firstOrNew(['id'=>$id]);
            $role->name = $request->name;
            $role->guard_name = 'web';
            $role->save();

            $role->syncPermissions($request->permisos);
           /* if($request->editar>0){

                //$role->givePermissionTo($request->permisos);
            }else{
                $role->givePermissionTo($request->permisos);
            }*/

            return  response('success',200);
        }catch (Exception $exception){
            return response($exception,403);
        }
    }

    public function getRolebyId($id){
        try{

            $role = Role::find($id);
            return  response($role,200);

        }catch (Exception $exception){
            return response($exception,403);
        }
    }

    public function update(Request $request,$id){
        try{
            $request->validate(['name'=>'required']);
            $role = Role::find($id);
            $role->update([
                'name'=>$request->name,
                'guard_name'=>'web'
            ]);
            return  response('success',200);
        }catch (Exception $exception){
            return response($exception,403);
        }
    }

    public function destroy($id){
        try{
            $role = Role::find($id);
            $role->delete();
            return  response('success',200);
        }catch (Exception $exception){
            return response($exception,403);
        }
    }

}
