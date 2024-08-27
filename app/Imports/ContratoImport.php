<?php

namespace App\Imports;

use App\Models\Contrato;
use App\Models\Trabajador;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ContratoImport implements ToCollection
{
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            /********************************************************/
            /*           CREAR  CONTRATO                         ***/
            /******************************************************/
            //$trabajador = Trabajador::where('rut','=',$row[12])->first();

            $contrato = Contrato::firstOrNew( ['trabajador_id'=>$row[0]]);

                $contrato->trabajador_id=$row[0];
                $contrato->ubicacion_id=$row[1];
                $contrato->fecha_ingreso =\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[2]);
                $contrato->fecha_antiguidad=\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[3]);
                $contrato->fecha_vencimiento_contrato=\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[4]);
                $contrato->fecha_segundo_vencimiento=\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[5]);
                $contrato->area_id=$row[6];
                $contrato->cargo_id=$row[7];
                $contrato->centro_costo=$row[8];
                $contrato->tipo_jornada=$row[9];
                $contrato->empleador_id=$row[10];
                $contrato->tipo_contrato=$row[11];

                $contrato->save();
        }
        return 'success';
    }
}
