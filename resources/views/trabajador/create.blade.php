@extends('layouts.app')
@section('titulos')
    <div class="page-header">
        <div class="page-title">
            <h3>Agregar Trabajador</h3>
        </div>
    </div>
@endsection
@section('content')
    <x-base>
        @hasanyrole('admin|asistente de rrhh|jefe de rrhh')
            @if($id != null)
                <index-component
                    :trabajador-id="{{$id}}"
                    :is-edit="true">
                </index-component>
            @else
                <index-component></index-component>
            @endif
        @else
            <p>No tienes permisos para crear un nuevo trabajador</p>
            @endhasanyrole
    </x-base>
@endsection


