<?php

namespace App\Imports;

use App\Models\Buses;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class BusesImport implements ToCollection
{
    /**
    * @param Collection $rows
    */
    public function collection(Collection $rows)
    {
        foreach($rows as $row){
            /********************************************************/
            /*               NUEVO BUS                       ***/
            /******************************************************/


            $buses = Buses::firstOrNew(['numero_bus'=>$row[0]]);

            $buses->numero_bus = $row[0];
            $buses->marca = $row[1];
            $buses->modelo = $row[2];
            $buses->marca_motor = $row[3];
            $buses->patente = $row[4];
            $buses->empleador_id = $row[5];
            $buses->anyo_bus = $row[6];
            $buses->numero_asientos = $row[7];
            $buses->numero_pantallas = $row[8];

            $buses->save();

        }

        return 'success';
    }
}
