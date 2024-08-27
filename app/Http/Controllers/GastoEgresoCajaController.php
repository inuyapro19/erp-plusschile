<?php

namespace App\Http\Controllers;

use App\Models\GastoEgresoCaja;
use App\Models\Reportes\FolioEgresoCajas;
use App\Models\Vistas\GastoCajaView;
use App\Models\Vistas\ReporteCierreCaja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GastoEgresoCajaController extends Controller
{

    public function index()
    {
        return view('caja.index', [
            'notificaciones'=>auth()->user()->unreadNotifications,
        ]);
    }

    public function getGastoCaja()
    {
        try{
            $gastoEgresoCajas = GastoCajaView::filtros()
                ->where('USER_ID', Auth::user()->id)
                ->paginate(10);
            return response()->json($gastoEgresoCajas, 200);
        }catch (\Exception $e){
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }

    }

    public function store(Request $request,$id = 0)
    {
        try{
            //validaciones
            $request->validate([
                'fecha' => 'required',
                'nro_documento' => 'required',
                'monto' => 'required',
                'empleador_id' => 'required',
                'trabajador_id' => 'required',
            ]);

            $gastoEgresoCaja = GastoEgresoCaja::firstOrNew(['id' => $id]);

            $gastoEgresoCaja->fecha = $request->fecha;
            $gastoEgresoCaja->nro_documento = $request->nro_documento ?? '';
            $gastoEgresoCaja->monto = $request->monto ?? 0;
            $gastoEgresoCaja->observacion = $request->observacion ?? '';
            $gastoEgresoCaja->empleador_id = $request->empleador_id;
            $gastoEgresoCaja->trabajador_id = $request->trabajador_id;
            $gastoEgresoCaja->user_id = Auth::user()->id;

            $gastoEgresoCaja->save();

            return response()->json('success', 200);
        }catch (\Exception $e){
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id){
        try{
            $gastoEgresoCaja = GastoEgresoCaja::find($id);
            $gastoEgresoCaja->delete();
            return response()->json('success', 200);
        }catch (\Exception $e){
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    //CIERRE DE CAJA
    public function cierreCaja(){
        try{
            $fecha = \request('fecha');
            $gastoEgresoCajas = ReporteCierreCaja::where('FECHA', $fecha)
                ->where('USER_ID', Auth::user()->id)
                ->orderBy('TIPO','DESC')
                ->get();
            //guardar folio en tabla FolioEgresoCajas
            $folioEgresoCaja = new FolioEgresoCajas();

            $folio = FolioEgresoCajas::orderBy('id', 'desc')->first();

            //GENERAR EL FOLIO DE EGRESO DE CAJA
            $folioEgresoCaja->nro_folio = str_pad($folio->id+1,6, "0", STR_PAD_LEFT);
            $folioEgresoCaja->fecha = date('Y-m-d');
            $folioEgresoCaja->user_id = Auth::user()->id;
            $folioEgresoCaja->save();


            //total de gastos
            $totalGastos = $gastoEgresoCajas->sum('MONTO_DEPOSITADO');
            return view('pdf.cierre_caja', [
                'cierre_cajas' => $gastoEgresoCajas,
                'usuario'=>Auth::user()->name .' '. Auth::user()->apellidos,
                 'nro_folio'=>$folioEgresoCaja->nro_folio,
                 'fecha'=>$fecha,
                'totalGastos'=>$totalGastos,
                'notificaciones'=>auth()->user()->unreadNotifications,
            ]);
        }catch (\Exception $e){
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }


}
