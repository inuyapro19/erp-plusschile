<?php
namespace App\Traits;

use App\Models\Trabajador;
use App\Models\User;
use Illuminate\Http\Request;

trait ManagesTrabajadores
{

    public function createUser(Request $request)
    {
        /********************************************************/
        /*               NUEVO USUARIO                       ***/
        /******************************************************/
        $user = new User();
        $user->rut = $request->rut;
        $user->name = $request->primer_nombre;
        $user->apellidos = $request->primer_apellido;
        $user->email = $request->correo;

        /*         Contraseña de temporal           */
        $user->password = bcrypt('pluss2021'); //settear desde setting o paramentros

        $user->primer_login = 'Y';
        $user->cambio_contrasena = 'N';
        $user->oficina_id = 17;

        $user->save();
        /********************************************************/
        /*            ASIGNAR  ROL TRABAJADOR                ***/
        /******************************************************/
        $user->assignRole('trabajador');

        return $user;
    }
    public function createTrabajador(Request $request, User $user)
    {
        $trabajador = new Trabajador();
        $this->assignTrabajadorProperties($trabajador, $request, $user);
        $trabajador->save();

        return $trabajador;
    }

    public function updateTrabajador(Trabajador $trabajador, Request $request)
    {
        $this->assignTrabajadorProperties($trabajador, $request);
        $trabajador->save();

        return $trabajador;
    }

    private function assignTrabajadorProperties(Trabajador $trabajador, Request $request, User $user)
    {
        $trabajador->rut = $request->input('rut');
        $trabajador->primer_nombre = $request->input('primer_nombre');
        $trabajador->segundo_nombre = $request->input('segundo_nombre'); // Si aplica
        $trabajador->primer_apellido = $request->input('primer_apellido');
        $trabajador->segundo_apellido = $request->input('segundo_apellido'); // Si aplica
        $trabajador->fecha_nacimiento = $request->input('fecha_nac');
        $trabajador->sexo = $request->input('sexo');
        $trabajador->grado_escolaridad = $request->input('grado_escolaridad');
        $trabajador->estado_civil = $request->input('estado_civil');
        $trabajador->telefono_local = $request->input('telefono_local');
        $trabajador->telefono_celular = $request->input('telefono_celular');
        $trabajador->correo_electronico = $request->input('correo');
        $trabajador->direccion = $request->input('direccion');
        $trabajador->user_id = $user->id;
        $trabajador->region_id = $request->input('region_id');
        $trabajador->comuna_id = $request->input('comuna_id');
        $trabajador->nacionalidad_id = $request->input('nacionalidad');
        $trabajador->pertenece_pueblo_originario = $request->input('pertenece_pueblo_originario');
        $trabajador->pueblo_originario_id = $request->input('pueblo_originario_id') > 0 ? $request->input('pueblo_originario_id') : null;
        $trabajador->tiene_familia = $request->input('carga_familiar');
        $trabajador->tiene_discapacidad = $request->input('tiene_alguna_discapacidad');
        $trabajador->estado = 'contratado';
        $trabajador->condicion = 'disponible';

    }


}
