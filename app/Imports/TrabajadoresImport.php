<?php

namespace App\Imports;

use App\Models\Trabajador;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
//use Maatwebsite\Excel\Concerns\ToModel;

use Illuminate\Support\Collection;
//use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;


class TrabajadoresImport implements ToCollection
{


    /**
     * @param Collection $rows
     */
    public function  collection(Collection $rows)
    {

        //$trabajador;

        foreach ($rows as $row) {

            /********************************************************/
            /*               NUEVO USUARIO                       ***/
            /******************************************************/

            $user =  User::firstOrNew(['rut'=>$row[1]]);
            /*$user->rut = $row[1];
            $user->name = $row[2];
            $user->apellidos = $row[4];
            $user->email = $row[8];*/

            /*         Contraseña de temporal           */
            /*$user->password = bcrypt('pluss2021'); //settear desde setting o paramentros
            $user->primer_login = 'Y';
            $user->cambio_contrasena = 'N';

            $user->save();*/

            /*    Asignar rol de trabajador    */
            $user->assignRole('trabajador');

            /********************************************************/
            /*               NUEVO USUARIO                       ***/
            /******************************************************/
            $trabajador =  Trabajador::firstOrNew(['rut'=>$row[1]]);

            $trabajador->rut = $row[1];
            $trabajador->primer_nombre = $row[2];
            $trabajador->segundo_nombre = $row[3] ?? null;
            $trabajador->primer_apellido = $row[4];
            $trabajador->segundo_apellido = $row[5] ?? null;
           /* $trabajador->telefono_local = $row[6] ?? '999999999';
            $trabajador->telefono_celular = $row[7] ?? '999999999';
            $trabajador->correo = $row[8] ?? 'cambiar_correo@correo.cl';*/
            $trabajador->fecha_nac = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[6]);
            $trabajador->estado_civil = $row[7];
            $trabajador->sexo = $row[8] ;//== 'M' ? 'masculino':'femenino';
            //$trabajador->grado_escolaridad = $row[12];
            $trabajador->direccion = $row[9];
            $trabajador->comuna_id = $row[10];
            $trabajador->region_id = $row[11];
            $trabajador->nacionalidad_id = $row[12];
           /* $trabajador->pertenece_pueblo_originario = $row[17] ?? 'no';
            $trabajador->pueblo_originario_id = $row[18] ?? null;
            $trabajador->tiene_familia = $row[19] ?? 'no';
            $trabajador->tiene_discapacidad = $row[20] ?? 'no';*/
            $trabajador->user_id = $user->id;
            $trabajador->estado = $row[14];
            $trabajador->estado = $row[15];

            $trabajador->save();

        }
        return 'success';
    }
}
