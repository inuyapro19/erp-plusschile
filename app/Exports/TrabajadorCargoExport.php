<?php

namespace App\Exports;


use App\Models\Vistas\TrabajadorCargo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class TrabajadorCargoExport implements FromView, WithColumnWidths,WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 20,
            'C'=>35,
            'D'=>45,
            'E'=>55
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true],'startColor'=>'ffddff'],
        ];
    }

    public function view() : view
    {
        $trabajador = TrabajadorCargo::Cargo()
                                        ->get();
        return view('excel.trabjadores_cargo',['trabajadores'=>$trabajador]);
    }
}
