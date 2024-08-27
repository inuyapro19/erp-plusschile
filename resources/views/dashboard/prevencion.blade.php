@extends('layouts.app')

@section('content')
    <x-base>
        <x-card-component classCard="mt-3 p-2">
            <h3>Hola {{ucwords(Auth::user()->name).' '.ucwords(Auth::user()->apellidos)}}</h3>
            <h3>Bienvenido al Sistema Intranet de PlussChile</h3>
        </x-card-component>

        <card-resumen-component></card-resumen-component>

        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
            <div class="col-xxl-12">
                <bar-doble></bar-doble>
            </div>

        </div>
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
            <div class="col-xxl-6">

                <circle-chart url="/chartByItemWith" title="Gráfico de items con mayor incidencias"></circle-chart>

            </div>
            <div class="col-xxl-6">


                <circle-chart url="/chartByAreaWith" title="Gráficos de areas con mayor items con incidencias"></circle-chart>

            </div>
        </div>


    </x-base>
@endsection
