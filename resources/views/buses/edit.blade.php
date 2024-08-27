@extends('layouts.app')
@section('titulos')
    <div class="page-header">
        <div class="page-title">
            <h3>Buses</h3>
        </div>
    </div>
@endsection
@section('content')
    <x-base>
        <!--begin::Card-->
        <div class="card p-3">

            <!--begin::Card body-->
            <div class="card-body pt-0">
                <buses-create-component :id="{{$id}}" :edit="true"></buses-create-component>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </x-base>

@endsection
