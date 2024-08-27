<?php

namespace App\Imports;

use App\Models\Trabajador;
use App\Models\TramiteLicenciaMedica;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Throwable;
class LicenciaImport  implements ToCollection, WithHeadingRow, WithEvents, SkipsOnError
{
    use Importable;

    public function collection(Collection $rows)
    {
        $exitosos = 0;
        $fallidos = 0;
        $filas_error = [];

        foreach ($rows as $row) {
            if (isset($row['RUT'])) {
                $trabajador = Trabajador::where('rut', '=', $row['RUT'])->first();
                Session::put('trabajador', $row['DIAS']);
                if ($trabajador) {
                    try {
                        $licencia = new TramiteLicenciaMedica();

                        $licencia = new TramiteLicenciaMedica();
                        $licencia->trabajador_id = $trabajador->id;
                        $licencia->rut = $row['RUT'];
                        $licencia->fecha_emision = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['FECHA_EMISION']);
                        $licencia->fecha_recepcion = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['FECHA_RECEPCION']);
                        $licencia->fecha_procesado = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['FECHA_PROCESADO']);
                        $licencia->fecha_inicio = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['FECHA_INICIO']);
                        $licencia->dias = $row['DIAS'];
                        $licencia->fecha_fin = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['FECHA_FIN']);
                        $licencia->medio = $row['MEDIO'] ?? '';
                        $licencia->motivo = $row['MOTIVO'] ?? '';
                        $licencia->tipo_licencia_medicas_id = $row['TIPO_LICENCIA_MEDICA_ID'];
                        $licencia->user_id = Auth::user()->id;
                        $licencia->estado = 'Iniciado';
                        $licencia->save();

                        $trabajador->condicion = $licencia->fecha_fin > now() ? 'licencia médica' : 'disponible';
                        $trabajador->save();
                        $exitosos++;
                    } catch (\Exception $exception) {
                        $fallidos++;
                        $filas_error[] = $row; // Almacena la fila que causó el error
                    }
                } else {
                    $fallidos++;
                    $filas_error[] = $row; // Almacena la fila que causó el error
                }
            } else {
                $fallidos++;
                $filas_error[] = $row; // Almacena la fila que causó el error
            }
        }

        Session::put('registros_exitosos', $exitosos);
        Session::put('registros_fallidos', $fallidos);
        Session::put('filas_error', $filas_error); // Almacena las filas con errores en la sesión
    }
    public function onError(Throwable $error)
    {
        //registralo en un archivo de log
        Log::channel('file')->info('Error en la importación', [
            'information' => 'La licencia medica del trabajador no puedo ser ingresada: '.$error->toJson(),
        ]);
    }



    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function (BeforeImport $event) {
                $totalRows = $event->getReader()->getTotalRows();

                if (!empty($totalRows)) {
                    Session::put('total_row', $totalRows);
                }
            }
        ];
    }
}
