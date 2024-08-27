@extends('layouts.app')
@section('titulos')
    <div class="page-header">
        <div class="page-title">
            <h3>Certificados Buses</h3>
        </div>
    </div>
@endsection
@section('content')

 <x-base>
     <buses-certificados-index-component></buses-certificados-index-component>
 </x-base>


@endsection
