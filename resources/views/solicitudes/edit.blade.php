@extends('layouts.app')
@section('titulos')
    <div class="page-header">
        <div class="page-title">
            <h4>Ingresar Solicitud  </h4>
        </div>
    </div>
@endsection
@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Card-->
                <div class="card">

                    <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            @include('flash-message')
                            {!! Form::model($solicitud, ['route' => ['solicitudes.update', $solicitud->id], 'method' => 'put','files'=>'true']) !!}

                            @include('solicitudes.field')

                            {!! Form::close() !!}
                        </div>
                </div>
                <!--end::Card body-->
        </div>
            <!--end::Card-->
        <!--end::Content container-->
    </div>
    <!--end::Content-->
@endsection
