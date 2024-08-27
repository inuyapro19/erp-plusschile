@extends('layouts.app')
@section('titulos')
    <div class="page-header">
        <div class="page-title">
            <h3>Lista de viajes</h3>
        </div>
    </div>
@endsection

@section('content')
    <x-base>
        <viajes-index :finalizados="false" :role="{{Auth()->user()->roles}}" ></viajes-index>
    </x-base>
@endsection
