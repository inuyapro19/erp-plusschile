
@extends('layouts.app')
@section('titulos')
    <div class="page-header">
        <div class="page-title">
            <h3>Ver Solicitud</h3>
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
                    <solicitud-edit :id="{{$id}}"></solicitud-edit>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->

        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
@endsection
