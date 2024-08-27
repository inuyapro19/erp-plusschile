<?php

namespace App\Http\Controllers;

use App\Exports\BusesExport;
use App\Models\Buses;
use Illuminate\Http\Request;
use Excel;
use Illuminate\Support\Str;
use mysql_xdevapi\Exception;

class BusesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view('buses.index');
    }

    public function getBusesLista()
    {
        try {
            $buses = Buses::with(['empleador'])
                ->filtro()
                ->FiltroLike()
                ->estado()
                ->filtroId()
                ->get();

            return response($buses, 200);
        } catch (Exception $exception) {
            return response($exception, 422);
        }
    }

    public function getBuses($id = false)
    {
        try {
            // return response(\request('operador'));

            if (request('operador') == 'first') {
                //Si es ediccion de buses
                $buses = Buses::with(['empleador'])
                    ->filtro()
                    ->FiltroLike()
                    ->estado()
                    ->filtroId()
                    ->get();

            } else {

                $buses = Buses::with(['empleador'])
                    ->filtro()
                    ->FiltroLike()
                    ->estado()
                    ->filtroId()
                    ->accion();//si tiene id que sea first
            }

            if (request('edit') == 'si') {
                $buses = Buses::with(['empleador'])
                    ->filtro()
                    ->FiltroLike()
                    ->estado()
                    ->filtroId()
                    ->first();
            }
            // ddd($buses);
            return response(!empty($buses) ? $buses : 0, 200);

        } catch (Exception $exception) {
            return response($exception, 422);
        }
    }

    public function getBuses_tripulacion()
    {
        try {
            $buses = Buses::with(['trabajadores.contrato.cargo', 'trabajadores.contrato.ubicacion', 'trabajadores.contrato.empleador'])
                ->estado()
                ->get();

            return response($buses, 200);

        } catch (Exception $exception) {
            return response($exception, 403);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id = 0)
    {
        return view('buses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request, $id = 0)
    {
        try {

            $request->validate([
                'numero_bus' => 'required',
                'marca_chasis' => 'required',
                'modelo_chasis' => 'required',
                'marca_carroceria' => 'required',
                'modelo_carroceria' => 'required',
                'tipo_bus' => 'required',
                'patente' => 'required',
                'empleador_id' => 'required',
                'anyo_bus' => 'required',
                'numero_asientos' => 'required',
                'numero_asiento_premium' => 'required',
                'numero_asiento_mixto' => 'required',
                'numero_asiento_cama' => 'required',
                'numero_asiento_semicama' => 'required',
                'numero_pantallas' => 'required',
                'tipo_servicio' => 'required'
            ]);

            /***************************************************************/
            /*                CREAR O EDITAR BUS POR ID                   */
            /**************************************************************/
            $buses = Buses::firstOrNew(['id' => $id]);


            $buses->numero_bus = $request->input('numero_bus');
            $buses->marca_chasis = $request->input('marca_chasis');
            $buses->modelo_chasis = $request->input('modelo_chasis');
            $buses->numero_carroceria = $request->input('numero_carroceria');
            $buses->marca_carroceria = $request->input('marca_carroceria');
            $buses->modelo_carroceria = $request->input('modelo_carroceria');
            $buses->numero_carroceria = $request->input('numero_carroceria');
            $buses->patente = $request->input('patente');
            $buses->tipo_bus = $request->input('tipo_bus');
            $buses->numero_piso = $request->input('numero_piso');
            $buses->empleador_id = $request->input('empleador_id');
            $buses->anyo_bus = $request->input('anyo_bus');
            $buses->numero_asientos = $request->input('numero_asientos');
            $buses->numero_asiento_premium = $request->input('numero_asiento_premium');
            $buses->numero_asiento_mixto = $request->input('numero_asiento_mixto');
            $buses->numero_asiento_cama = $request->input('numero_asiento_cama');
            $buses->numero_asiento_semicama = $request->input('numero_asiento_semicama');
            $buses->tipo_pantalla = $request->input('tipo_pantalla');
            $buses->numero_pantallas = $request->input('numero_pantallas');
            $buses->numero_pantallas_premium = $request->input('numero_pantallas_premium');
            $buses->numero_pantallas_mixtos = $request->input('numero_pantallas_mixtos');
            $buses->numero_pantallas_cama = $request->input('numero_pantallas_cama');
            $buses->numero_pantallas_semicama = $request->input('numero_pantallas_semicama');
            $buses->fecha_ultima_carga = $request->input('fecha_ultima_carga');

            $buses->tipo_servicio = $request->input('tipo_servicio');
            $buses->estado = $request->has('estado') ? $request->input('estado') : 'Bus operativo';
            $buses->save();


            return response('success', 200);

        } catch (Exception $exception) {
            return response($exception, 403);
        }

    }



    public function destroy($id)
    {
        try {

            $buses = Buses::find($id);

            $buses->delete();

            return response('danger', 200);

        } catch (Exception $exception) {
            return response('danger', 403);
        }
    }

    public function cambio_estado(Request $request, $id = 0)
    {
        try {
            $buses = Buses::find($id);

            $buses->estado = request('estado');
            $buses->save();

            return response('success', 200);
        } catch (Exception $exception) {
            return response('danger', 403);
        }
    }

    public function export()
    {
        $archivo = Str::random(10) . rand(1, 9) . '.xlsx';
        return Excel::download(new BusesExport(), $archivo);
    }

}
