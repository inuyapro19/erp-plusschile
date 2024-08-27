<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    //

    public function getUserLogeado()
    {
        try {
          $usuario = User::with(['roles'])
                            ->find(auth()->user()->id);
            return response($usuario,200);
        }catch (\Exception $exception){
            return response($exception,422);
        }
    }


    //asignar masivamente roles a usuarios

   public  function assignTripulanteRole() {
        // Obtén los usuarios con el cargo de 'auxiliar de buses' o 'conductor de buses'
        $users = DB::table('trabajadores as u')
            ->join('contrato as c', 'u.id', '=', 'c.trabajador_id')
            ->join('cargos as c2', 'c.cargo_id', '=', 'c2.id')
            ->where('u.estado', 'contratado')
            ->whereIn('c2.nombre_cargo', ['auxiliar de buses', 'conductor de buses'])
            ->select('u.user_id')
            ->get()
            ->pluck('user_id');

        // Obtén el rol 'Tripulante'
        $role = Role::where('name', 'Tripulante')->first();

        // Asigna el rol 'Tripulante' a cada usuario
        foreach ($users as $userId) {
            $user = User::find($userId);
            if ($user && !$user->hasRole('Tripulante')) {
                $user->assignRole($role);
            }
        }

        return response('Roles asignados correctamente', 200);
    }




}
