@extends('layouts.app')
@section('titulos')
    <div class="page-header">
        <div class="page-title">
            <h3>Lista De Trabajadores</h3>
        </div>
    </div>
@endsection
@section('content')
    <x-base>
        <tabla-desvinculados></tabla-desvinculados>
    </x-base>
@endsection
