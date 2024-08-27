@extends('layouts.app')
@section('titulos')
    <div class="page-header">
        <div class="page-title">
            <h3>Vacaciones</h3>
        </div>
    </div>
@endsection
@section('content')

   <x-base>
       <vacaciones-trabajadores-component></vacaciones-trabajadores-component>
   </x-base>

@endsection
