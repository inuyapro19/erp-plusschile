@extends('layouts.app')
@section('titulos')
    <div class="page-header">
        <div class="page-title">
            <h3>Haberes y descuentos</h3>
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
                <div class="card-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Haberes y descuentos </h4>
                        </div>
                    </div>
                </div>
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <haberes-index></haberes-index>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->

@endsection
