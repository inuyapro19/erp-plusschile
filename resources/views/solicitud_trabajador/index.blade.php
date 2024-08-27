
@extends('layouts.app')
@section('titulos')
    <div class="page-header">
        <div class="page-title">
            <h3>Mis solicitudes</h3>
        </div>
    </div>
@endsection
@section('content')
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Card-->
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Mis Solicitudes <a href="{{route('solicitud.trabajador.create')}}" class="btn btn-success btn-sm ml-5">Agregar</a></h4>
                        </div>
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <perfil-mis-solicitudes></perfil-mis-solicitudes>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->

        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->

@endsection
