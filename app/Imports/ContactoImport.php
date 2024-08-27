<?php

namespace App\Imports;

use App\Models\Contacto;
use App\Models\Trabajador;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ContactoImport implements ToCollection
{
    /**
    * @param Collection $rows
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            /********************************************************/
            /*           CREAR  CONTACTO                         ***/
            /******************************************************/

            $trabajadores = Trabajador::where('rut','=',$row[0])->first();

            if (isset($trabajadores->id))
            {
                $contacto = new Contacto;
                $contacto->nombre = $row[1];
                $contacto->apellido = $row[2];
                $contacto->correo = $row[3];
                $contacto->telefono = $row[4];
                $contacto->direccion = $row[5];
                $contacto->region_id   = $row[7];
                $contacto->comuna_id = $row[6];
                $contacto->trabajador_id = $trabajadores->id;
                $contacto->parentesco = 'padre';
                $contacto->otro_parentesco ='';
                $contacto->save();
            }

        }
        return 'success';
    }
}
