@extends('layouts.app')
@section('titulos')
    <div class="page-header">
        <div class="page-title">
            <h3>Roles y Permisos</h3>
        </div>
    </div>
@endsection
@section('content')
  <x-base>
      <roles-asignar-component></roles-asignar-component>
  </x-base>
@endsection

