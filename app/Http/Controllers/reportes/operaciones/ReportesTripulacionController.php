<?php

namespace App\Http\Controllers\reportes\operaciones;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Reportes\BusTripulantePeriodo;
use App\Models\Reportes\HistorialFolioViajes;
use App\Models\Reportes\TripulanteConcepto;
use App\Models\Reportes\ViajeMineria;
use App\Models\Reportes\ViajesBuses;
use App\Models\Reportes\ViajesHoy;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Vistas\HistorialTripulacion;

class ReportesTripulacionController extends Controller
{

    public function index()
    {
        return view('reportes.tripulacion.index',[
            'notificaciones'=>auth()->user()->unreadNotifications
        ]);
    }
    public function getHistorialTripilacion()
    {
        try {
            $ORDER_BY = \request()->input('ORDER_BY');
            $ORDER = \request()->input('ORDER');
            //TODOS O PAGINADOS
            $PAGINAR = \request()->input('OPTIONS');

            //return response()->json($PAGINAR, 200);

            if ($PAGINAR == 'TODOS') {
                $historial = HistorialTripulacion::filtros()
                    ->FechasEntre()
                    ->orderBy($ORDER_BY ?? 'ID_TRABAJADOR', $ORDER ?? 'ASC')
                    ->get();
            }else{
                $NUMBER = \request()->input('NUMBER_PAGES');
                $historial = HistorialTripulacion::filtros()
                    ->FechasEntre()
                    ->orderBy($ORDER_BY ?? 'ID_TRABAJADOR', $ORDER ?? 'ASC')
                    ->paginate($NUMBER);
            }

            //VALIDAR SI HAY DATOS
            /*if (count($historial) == 0) {
                return response()->json('No se encontraron datos', 404);
            }*/

            return response()->json($historial, 200);

        }   catch (\Throwable $th) {
            //throw $th;
            return response()->json($th->getMessage(), 500);
        }

    }
    public function imprimirHistorialTripulacion()
    {
        try {
            $ORDER_BY = \request()->input('ORDER_BY');
            $ORDER = \request()->input('ORDER');
            //TODOS O PAGINADOS
            $PAGINAR = \request()->input('OPTIONS');

            //return response()->json($PAGINAR, 200);

            if ($PAGINAR == 'TODOS') {
                $historial = HistorialTripulacion::filtros()
                    ->FechasEntre()
                    ->orderBy($ORDER_BY ?? 'ID_TRABAJADOR', $ORDER ?? 'ASC')
                    ->get();
            }else{
                $NUMBER = \request()->input('NUMBER_PAGES');
                $historial = HistorialTripulacion::filtros()
                    ->FechasEntre()
                    ->orderBy($ORDER_BY ?? 'ID_TRABAJADOR', $ORDER ?? 'ASC')
                    ->paginate($NUMBER);
            }

            //VALIDAR SI HAY DATOS
            /*if (count($historial) == 0) {
                return response()->json('No se encontraron datos', 404);
            }*/

            return view('reportes.tripulacion.imprimir',[
                'historial'=>$historial
            ]);

        }   catch (\Throwable $th) {
            //throw $th;
            return response()->json($th->getMessage(), 500);
        }

    }
    public function busesViaje()
    {

        return view('reportes.buses.index',[
            'notificaciones'=>auth()->user()->unreadNotifications
        ]);

    }

    public function getHistorialBusesViajes()
    {
        try {
            $ORDER_BY = \request()->input('ORDER_BY');
            $ORDER = \request()->input('ORDER');
            //TODOS O PAGINADOS
            $PAGINAR = \request()->input('OPTIONS');

            //return response()->json($PAGINAR, 200);

            if ($PAGINAR == 'TODOS') {
                $historial = ViajesBuses::filtros()
                    ->FechasEntre()
                    ->get();
            }else{
                $NUMBER = \request()->input('NUMBER_PAGES');
                $historial = ViajesBuses::filtros()
                    ->FechasEntre()
                    ->paginate($NUMBER);
            }

            //VALIDAR SI HAY DATOS
            /*if (count($historial) == 0) {
                return response()->json('No se encontraron datos', 404);
            }*/

            return response()->json($historial, 200);

        }   catch (\Throwable $th) {
            //throw $th;
            return response()->json($th->getMessage(), 500);
        }

    }

    //Imprimir

    public function imprimirHistorialBuses()
    {
        try {
            $ORDER_BY = \request()->input('ORDER_BY');
            $ORDER = \request()->input('ORDER');
            //TODOS O PAGINADOS
            $PAGINAR = \request()->input('OPTIONS');

            //return response()->json($PAGINAR, 200);

            if ($PAGINAR == 'TODOS') {
                $historial = ViajesBuses::filtros()
                    ->FechasEntre()
                    ->get();
            }else{
                $NUMBER = \request()->input('NUMBER_PAGES');
                $historial = ViajesBuses::filtros()
                    ->FechasEntre()
                    ->paginate($NUMBER);
            }

            return view('reportes.buses.imprimir',[
                'historial'=>$historial
            ]);

        }   catch (\Throwable $th) {
            //throw $th;
            return response()->json($th->getMessage(), 500);
        }
    }

    public function getHistorialPorConceptos()
    {

        try {
            $ORDER_BY = \request()->input('ORDER_BY');
            $ORDER = \request()->input('ORDER');
            //TODOS O PAGINADOS
            $PAGINAR = \request()->input('OPTIONS');

            //return response()->json($PAGINAR, 200);

            if ($PAGINAR == 'TODOS') {
                $historial = TripulanteConcepto::filtros()
                    ->FechasEntre()
                    ->get();
            }else{
                $NUMBER = \request()->input('NUMBER_PAGES');
                $historial = TripulanteConcepto::filtros()
                    ->FechasEntre()
                    ->paginate($NUMBER);
            }

            //VALIDAR SI HAY DATOS
            /*if (count($historial) == 0) {
                return response()->json('No se encontraron datos', 404);
            }*/

            return response()->json($historial, 200);

        }   catch (\Throwable $th) {
            //throw $th;
            return response()->json($th->getMessage(), 500);
        }

    }

    public function getBusesPeridos()
    {

        try {
            $ORDER_BY = \request()->input('ORDER_BY');
            $ORDER = \request()->input('ORDER');
            //TODOS O PAGINADOS
            $PAGINAR = \request()->input('OPTIONS');

            //return response()->json($PAGINAR, 200);

            if ($PAGINAR == 'TODOS') {
                $historial = BusTripulantePeriodo::filtros()
                    ->FechasEntre()
                    ->get();
            }else{
                $NUMBER = \request()->input('NUMBER_PAGES');
                $historial = BusTripulantePeriodo::filtros()
                    ->FechasEntre()
                    ->paginate($NUMBER);
            }

            return response()->json($historial, 200);

        }   catch (\Throwable $th) {
            //throw $th;
            return response()->json($th->getMessage(), 500);
        }

    }

    public function getViajesMineria()
    {

        try {
            $ORDER_BY = \request()->input('ORDER_BY');
            $ORDER = \request()->input('ORDER');
            //TODOS O PAGINADOS
            $PAGINAR = \request()->input('OPTIONS');

            //return response()->json($PAGINAR, 200);
            //encuentra al cliente
            $cliente = Cliente::filtrosId()->first();

            if ($PAGINAR == 'TODOS') {
                $historial = ViajeMineria::filtros()
                    ->FechasEntre()
                    ->get();
            }else{
                $NUMBER = \request()->input('NUMBER_PAGES');
                $historial = ViajeMineria::filtros()
                    ->FechasEntre()
                    ->paginate($NUMBER);
            }

           //return response()->json($cliente, 200);

           return view('reportes.cliente.viajesmineriaIndex',[
                'viajes'=>$historial,
                'cliente'=>$cliente->nombre_cliente,
                //fecha de hoy en formato de fecha , miercoles , 12 de febrero de 2020
                'fecha'=>Carbon::now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY')
            ]);

        }   catch (\Throwable $th) {
            //throw $th;
            return response()->json($th->getMessage(), 500);
        }

    }

    public function getViajesFolio()
    {
        try {
            $ORDER_BY = \request()->input('ORDER_BY');
            $ORDER = \request()->input('ORDER');
            //TODOS O PAGINADOS
            $PAGINAR = \request()->input('OPTIONS');

            //return response()->json($PAGINAR, 200);

            if ($PAGINAR == 'TODOS') {
                $historial = HistorialFolioViajes::filtros()
                    ->FechasEntre()
                    ->get();
            }else{
                $NUMBER = \request()->input('NUMBER_PAGES');
                $historial = HistorialFolioViajes::filtros()
                    ->FechasEntre()
                    ->paginate($NUMBER);
            }

            return response()->json($historial, 200);

        }   catch (\Throwable $th) {
            //throw $th;
            return response()->json($th->getMessage(), 500);
        }

    }

    public function getViajesHoy()
    {

        try {
            $ORDER_BY = \request()->input('ORDER_BY');
            $ORDER = \request()->input('ORDER');
            //TODOS O PAGINADOS
            $PAGINAR = \request()->input('OPTIONS');

            //return response()->json($PAGINAR, 200);


            if ($PAGINAR == 'TODOS') {
                $historial = ViajesHoy::filtros()
                    ->get();
            }else{
                $NUMBER = \request()->input('NUMBER_PAGES');
                $historial = ViajeMineria::filtros()
                    ->paginate($NUMBER);
            }

            //return response()->json($cliente, 200);

            //exportar a excel
            return Excel::download(new ViajesHoyExport($historial), 'viajesHoy.xlsx');

        }   catch (\Throwable $th) {
            //throw $th;
            return response()->json($th->getMessage(), 500);
        }

    }

}
