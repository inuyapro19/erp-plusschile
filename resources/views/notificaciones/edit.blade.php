@extends('layouts.app')
@section('titulos')
    <div class="page-header">
        <div class="page-title">
            <h4>Notificaciones </h4>
        </div>
    </div>
@endsection
@section('content')

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="card-header">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                        <h4>Notificaciones</h4>
                    </div>
                </div>
            </div>
            <!--begin::Card-->
            <div class="card pt-5">
                <div class="card-body pt-0">
                    <configuracion-notificaciones></configuracion-notificaciones>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
@endsection