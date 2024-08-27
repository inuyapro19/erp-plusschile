@extends('layouts.app')
@section('titulos')
    <div class="page-header">
        <div class="page-title">
            <h3>Editar Información</h3>
        </div>
    </div>
@endsection
@section('content')



  <x-base>
      <perfil-trabajador :rut="'{{$rut}}'"></perfil-trabajador>
  </x-base>



@endsection

