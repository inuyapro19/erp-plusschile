@extends('layouts.app')
@section('titulos')
    <div class="page-header">
        <div class="page-title">
            <h3>Crear Vacaciones</h3>
        </div>
    </div>
@endsection
@section('content')


<x-base>
    <vacaciones-create-component></vacaciones-create-component>
</x-base>




@endsection
