@extends('layouts.app')
@section('titulos')
    <div class="page-header">
        <div class="page-title">
            <h3>Buses</h3>
        </div>
    </div>
@endsection
@section('content')
    <!--begin::Content-->
   <x-base>

       <buses-create-component></buses-create-component>

   </x-base>

@endsection
