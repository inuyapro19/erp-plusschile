<?php

namespace App\Exports;

use App\Models\Vistas\TrabajadoresExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use App\Models\Trabajador;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class Trabajadores implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithColumnFormatting, WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {
        /*****************************************************/
        /**** Obtiene todos los trabajadores contratados ****/
        /***************************************************/

        $trabajadores = TrabajadoresExport::all();

        return $trabajadores;
    }

    public function headings(): array
    {
        return [
            '#',
            'CODIGO',
            'RUT',
            'NOMBRES',
            'APELLIDOS',
            'FECHA_NAC',
            'GRAD0_ESCOLARIDAD',
            'ESTADO_CIVIL',
            'TELEFONO_LOCAL',
            'TELEFONO_CELULAR',
            'CORREO_ELECTRONICO',
            'SEXO',
            'DIRECCION',
            'REGION_ID',
            'NOMBRE_REGION',
            'COMUNA_ID',
            'NOMBRE_COMUNA',
            'NACIONALIDAD_ID',
            'PERTENECE_A_PUEBLO_ORI',
            'PUEBLO_ORIGINARIO_ID',
            'POSEE_CARGA_FAMILIAR',
            'POSEE_DISCAPOCIDAD',
            'EMPLEADOR_ID',
            'NOMBRE_EMPLEADOR',
            'AREA_ID',
            'NOMBRE_AREA',
            'CARGO_ID',
            'NOMBRE_CARGO',
            'UBICACION_ID',
            'NOMBRE_UBICACION',
            'FECHA_INGRESO',
            'FECHA_ANTIGUIDAD',
            'FECHA_PRIMER_VENCIMIENTO',
            'FECHA_SEGUNDO_VENCIMIENTO',
            'CENTRO_COSTO',
            'TIPO_CONTROTO',
            'TIPO_JORNADA',
            'JORNADA_EXCEPCIONAL',
            'SALUD_ID',
            'ENTIDAD_DE_SALUD',
            'PREVISION_ID',
            'TIPO_ENTIDAD'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text with background color.
            1    => ['font' => ['bold' => true,'size'=>16], 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF00']]],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            // Add more columns as needed
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 20,
            // Add more columns as needed
        ];
    }
}
