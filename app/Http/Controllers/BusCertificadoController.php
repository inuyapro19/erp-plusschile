<?php

namespace App\Http\Controllers;

use App\Models\BusCertificado;
use App\Models\CertificadoRecorrido;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use mysql_xdevapi\Exception;

class BusCertificadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('certificados_buses.index',[
            'notificaciones'=>auth()->user()->unreadNotifications
        ]);
    }

    public function getCertificadosBuses(){
        try {

            $certificados = BusCertificado::with(['bus','certificadoRecorrido.destino','certificadoRecorrido.origen'])
                                            ->filtros()
                                            ->FiltroRelacionNumeroBus()
                                            ->FiltroRelacionPatente()
                                            ->orderBy('id','desc')
                                            ->get();

            return response($certificados,200);
        }catch (Exception $exception){
            return response($exception,422);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('certificados_buses.create',[
            'notificaciones'=>auth()->user()->unreadNotifications
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
                'bus_id',
                'fecha_emision',
                'tipo_certificado'
            ]);

            $tipo_certificado = $request->tipo_certificado;

            if ($request->hasFile('certificado_pdf')){
                $file = $request->file('certificado_pdf');
                $filename =  Str::random(10).rand(1,9).'.pdf';
                $file->move('upload/certificados_buses/', $filename);
            }

           if ($tipo_certificado == 'REVISION TECNICA + CERTIFICADO DE GASES'){
               //solo crear nuevo
               BusCertificado::create([
                   'bus_id'=>$request->input('bus_id'),
                   'fecha_emision'=>$request->fecha_emision,
                   'fecha_vencimiento'=>$request->fecha_vencimiento,
                   'tipo_certificado'=>'REVISION TECNICA',
                   'certificado_pdf'=>$filename,
                   'estado'=>'VALIDO'
               ]);

               BusCertificado::create([
                   'bus_id'=>$request->input('bus_id'),
                   'fecha_emision'=>$request->fecha_emision,
                   'fecha_vencimiento'=>$request->fecha_vencimiento,
                   'tipo_certificado'=>'CERTIFICADO DE GASES',
                   'certificado_pdf'=>$filename,
                   'estado'=>'VALIDO'
               ]);
           }

            if ($tipo_certificado == 'SEGUROS SOAP'){
                //solo crear nuevo
                BusCertificado::create([
                    'bus_id'=>$request->input('bus_id'),
                    'fecha_emision'=>$request->fecha_emision,
                    'fecha_vencimiento'=>$request->fecha_vencimiento,
                    'tipo_certificado'=>'SEGUROS SOAP',
                    'compania'=>$request->compania_seguro,
                    'certificado_pdf'=>$filename,
                    'estado'=>'VALIDO'
                ]);
            }

            if ($tipo_certificado == 'PERMISO CIRCULACION'){
                //solo crear nuevo
                BusCertificado::create([
                    'bus_id'=>$request->input('bus_id'),
                    'fecha_emision'=>$request->fecha_emision,
                    'fecha_vencimiento'=>$request->fecha_vencimiento,
                    'tipo_certificado'=>'PERMISO CIRCULACION',
                    'municipalidad'=>$request->municipalidad,
                    'certificado_pdf'=>$filename,
                    'estado'=>'VALIDO'
                ]);
            }

            if ($tipo_certificado == 'CERTIFICADO SERVICIO ESPECIAL'){
                //solo crear nuevo
                BusCertificado::create([
                    'bus_id'=>$request->input('bus_id'),
                    'fecha_emision'=>$request->fecha_emision,
                    'fecha_vencimiento'=>$request->fecha_vencimiento,
                    'tipo_certificado'=>'CERTIFICADO SERVICIO ESPECIAL',
                    'certificado_pdf'=>$filename,
                    'estado'=>'VALIDO'
                ]);
            }


            if ($tipo_certificado == 'CARTÓN DE RECORRIDO'){

              //return response($request->recorrido);

                //solo crear nuevo
              $bus_certificado =  BusCertificado::create([
                    'bus_id'=>$request->input('bus_id'),
                    'fecha_emision'=>$request->fecha_emision,
                    'fecha_vencimiento'=>$request->fecha_vencimiento,
                    'tipo_certificado'=>'CARTÓN DE RECORRIDO',
                      'nro_certificado'=>$request->nro_certificado,
                      'fecha_inicio_vehiculo'=>$request->fecha_inicio_vehiculo,
                      'fecha_vencimiento_vehiculo'=>$request->fecha_vencimiento_vehiculo,
                      'fecha_inicio_servicio'=>$request->fecha_inicio_servicio,
                      'fecha_vencimiento_servicio'=>$request->fecha_vencimiento_servicio,
                    'certificado_pdf'=>$filename,
                    'estado'=>'VALIDO'
                ]);



                $recorridos = json_decode($request->recorridos);

                foreach ($recorridos as $recorrido )
                {
                    foreach($recorrido as $item)
                    {
                        CertificadoRecorrido::create([
                            'bus_certificado_id'=>$bus_certificado->id,
                            'origen_id'=>$item->origen_id,
                            'destino_id'=>$item->destino_id,
                            'recorrido_tramo_ida'=>$item->trazado_principal_ida,
                            'recorrido_tramo_vuelta'=>$item->trazado_principal_regreso
                        ]);
                    }
                }

            }
           return response('success',200);

        }catch (\Exception $exception){
            return response($exception,422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BusCertificado  $busCertificado
     * @return \Illuminate\Http\Response
     */
    public function show(BusCertificado $busCertificado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BusCertificado  $busCertificado
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('certificados_buses.edit',[
            'notificaciones'=>auth()->user()->unreadNotifications
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BusCertificado  $busCertificado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BusCertificado $busCertificado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BusCertificado  $busCertificado
     * @return \Illuminate\Http\Response
     */
    public function destroy(BusCertificado $busCertificado)
    {
        //
    }
}
