@extends('layouts.app')

@section('content')
    <x-base>
        <x-card-component classCard="mt-3 p-2">
            <h3>Hola {{ucwords(Auth::user()->name).' '.ucwords(Auth::user()->apellidos)}}</h3>
            <h3>Bienvenido al Sistema Intranet de PlussChile</h3>
        </x-card-component>
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
            <div class="col-xxl-6">
                <x-card-component classCard="p-2">
                    <h3 class="text-center">Calidad</h3>
                    <bar-chart></bar-chart>
                </x-card-component>
            </div>
            <div class="col-xxl-6">
                <x-card-component classCard="p-2">
                    <h3 class="text-center">Documentos</h3>
                    <bar-chart></bar-chart>
                </x-card-component>
            </div>
        </div>


    </x-base>
@endsection
