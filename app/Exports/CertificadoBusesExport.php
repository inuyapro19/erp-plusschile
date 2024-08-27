<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class CertificadoBusesExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $certificados = DB::Select('select bc.id, bc.bus_id, bc.fecha_emision, bc.fecha_vencimiento, bc.tipo_certificado, bc.compania, bc.municipalidad,
        bc.nro_certificado, bc.fecha_inicio_vehiculo, bc.fecha_vencimiento_vehiculo, bc.fecha_inicio_servicio,
        bc.fecha_vencimiento_servicio, bc.estado,  b.numero_bus,  b.patente
        from bus_certificados bc join buses b on b.id = bc.bus_id;');

        return view('excel.certificado_bus',['certificados'=>$certificados]);
    }
}
