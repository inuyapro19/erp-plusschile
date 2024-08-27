<?php

namespace App\Imports;

use App\Models\Trabajador;
use App\Models\TramiteLicenciaMedica;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;


class GestionTripulacion implements ToCollection , WithHeadingRow
{
    /**
    * @param Collection $collection
    */

    use Importable;

    public function collection(Collection $rows)
    {
        try {
            $email = [];
            $contador = 0;
            $contador_error = 0;
            foreach ($rows as $row) {
                $trabajador = Trabajador::where('rut', '=', $row['RUT'])->first();
                if ($trabajador){
                    $gestion  = new \App\Models\GestionTripulacion();
                    $gestion->trabajador_id = $trabajador->id;
                    $gestion->tipo = $row['TIPO'];
                    $gestion->fecha_inicial = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['FECHA_INICIO']);
                    $gestion->fecha_termino = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['FECHA_TERMINO']);

                    $gestion->numero_dias = $row['DIAS'];
                    $gestion->fecha_retorno = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['FECHA_RETORNO']);

                    $gestion->estado = 'EN CURSO';
                    $gestion->save();

                    /*$trabajador->condicion = 'licencia médica';
                    $trabajador->save();
                    $email[] = $trabajador;*/
                }
            }

            return [
                'total_agregados' => $contador,
                'total_errores' => $contador_error
            ];

        } catch (\Exception $exception) {
            return $exception;
        }
    }


}
