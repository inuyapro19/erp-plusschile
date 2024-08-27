@extends('layouts.app')
@section('titulos')
    <div class="page-header">
        <div class="page-title">
            <h3>Jefes de maquinas</h3>
        </div>
    </div>
@endsection
@section('content')
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Card-->
            <div class="card pt-5">
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <jefe-maquina></jefe-maquina>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->

        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->



@endsection
