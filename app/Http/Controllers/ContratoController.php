<?php

namespace App\Http\Controllers;

use App\Models\Con1trato;
use App\Models\Contrato;
use Illuminate\Http\Request;

class ContratoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    public function getContrato($id)
    {
       // dd($id);
       $contrato = Contrato::where('trabajador_id','=',(int)$id)->first();
       // dd($contrato);
       return response($contrato,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }


    public function edit($id)
    {
        /********************************/
       /* Devuelve Datos Contractuales */
        /*******************************/
        $contrato = Contrato::find($id);
        return view('contrato.edit',
            ['contrato'=>$contrato]
        );
    }


    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
