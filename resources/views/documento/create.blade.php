@extends('layouts.app')
@section('titulos')
    <div class="page-header">
        <div class="page-title">
            <h3>Documento</h3>
        </div>
    </div>
@endsection
@section('content')


    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Card-->
            <div class="card p-3">

                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <Certificado_antiguidad :editar="false"></Certificado_antiguidad>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->

        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->

@endsection
