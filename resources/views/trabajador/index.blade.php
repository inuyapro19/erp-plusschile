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
    @hasanyrole('admin|jefe de rrhh|asistente de rrhh')
        <trabajores-tabla-component :filtros="'{{$roles}}'" ></trabajores-tabla-component>
    @else
        No tiene permiso para ver los trabajadores
   @endhasanyrole
</x-base>




@endsection

