@extends('layouts.app')
@section('titulos')
    <div class="page-header">
        <div class="page-title">
            <h3>Editar Trabajador</h3>
        </div>
    </div>
@endsection
@section('content')

   <x-base>
       <index-component :id="{{$id}}" :editar="true"></index-component>
   </x-base>



@endsection
