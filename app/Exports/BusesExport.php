<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BusesExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $buses = DB::Select('select b.id, b.numero_bus, b.marca_chasis, b.modelo_chasis, b.numero_chasis, b.marca_carroceria, b.modelo_carroceria, b.numero_carroceria, b.patente, b.tipo_bus, b.tipo_servicio, b.numero_piso,
            anyo_bus, numero_asientos, numero_asiento_premium, numero_asiento_mixto, numero_asiento_cama, numero_asiento_semicama,
            numero_pantallas, numero_pantallas_premium, numero_pantallas_mixtos, numero_pantallas_cama, numero_pantallas_semicama,
            fecha_ultima_carga, tipo_pantalla, estado,nombre_empleador
            from buses b join empleadores e on b.empleador_id = e.id');

        return view('excel.buses',['buses'=>$buses]);
    }
}
