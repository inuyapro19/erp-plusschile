<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{

    public function getCliente(){
        try {
           $clientes = Cliente::all();
           return response($clientes,200);
        }catch (\Exception $exception){
            return response($exception,422);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('clientes.index',
            [
                'notificaciones'=>auth()->user()->unreadNotifications
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id = false)
    {
        try {
            /*  nuevo cliente o actualizar cliente  */
           $cliente =  Cliente::firstOrNew(['id'=>$id]);

            $cliente->nombre_cliente = $request->nombre_cliente;
            $cliente->save();

            return response('success',200);

        }catch (\Exception $exception){

            return response($exception,422);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cliente $cliente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $cliente = Cliente::find($id);

            $cliente->delete();

            return response('success',200);

        }catch (\Exception $exception){
            return response('error',422);
        }
    }
}
