
@extends('layouts.app')
@section('titulos')
    <div class="page-header">
        <div class="page-title">
            <h3>Calendario</h3>
        </div>
    </div>
@endsection
@section('content')

    <div class="layout-px-spacing">
        <!-- CONTENT AREA -->
        <div class="row layout-top-spacing">
            <div id="tabsSimple" class="col-lg-12 col-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <h4>Calendario</h4>

                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area">
                        <calendario-index></calendario-index>
                    </div>
                </div>
            </div>
        </div>
        <!-- CONTENT AREA -->
    </div>

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Card-->
            <div class="card pt-5">

                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <calendario-index></calendario-index>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->

        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
@endsection
