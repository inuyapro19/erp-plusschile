<?php

namespace App\Imports;

use App\Models\Trabajador;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TrabajadorVacaciones implements ToCollection, WithHeadingRow
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
                    $vacaciones  = new \App\Models\TrabajadorVacacion();
                    $vacaciones->trabajador_id = $trabajador->id;
                    $vacaciones->dias_habiles_solicitados = $row['DIAS_HABILES_SOLICITADOS'];
                    $vacaciones->fecha_primer_dia = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['FECHA_PRIMER_DIA']);
                    $vacaciones->saldo_previo_vacaciones = $row['SALDO_PREVIO_VACACIONES'];
                    $vacaciones->saldo_despues_vacacaciones = $row['SALDO_DESPUES_VACACIONES'];
                    $vacaciones->dias_corridos_del_periodo_de_vac = $row['DIAS_CORRIDOS_DEL_PERIODO_DE_VAC'];
                    $vacaciones->fecha_ultimo_dia = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['FECHA_ULTIMO_DIA']);
                    $vacaciones->fecha_corte_calculo1 = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['FECHA_CORTE_CALCULO1']);
                    $vacaciones->fecha_corte_calculo2 = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['FECHA_CORTE_CALCULO2']);
                    $vacaciones->rut = $row['RUT'];

                    $vacaciones->estado = 'activo';
                    $vacaciones->save();

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
