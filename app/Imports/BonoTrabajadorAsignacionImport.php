<?php

namespace App\Imports;

use App\Models\TrabajadorBono;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use mysql_xdevapi\Exception;

class BonoTrabajadorAsignacionImport implements ToCollection
{
    /**
    * @param Collection $collection
    */


    public function collection(Collection $rows)
    {
        try {
            foreach ($rows as $row){

                $trabajador_bono = new TrabajadorBono();

                $trabajador_bono->trabajador_id = $row[0];
                $trabajador_bono->bonos_id = $row[5];
                $trabajador_bono->mes = $row[6];
                $trabajador_bono->anyo = $row[7];
                $trabajador_bono->monto = $row[8];
                $trabajador_bono->estado = 'activo';
                $trabajador_bono->save();

            }

            return 'success';

        }catch (Exception $exception){
            return $exception;
        }

    }
}
