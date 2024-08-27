@extends('layouts.app')
@section('titulos')
    <div class="page-header">
        <div class="page-title">
            <h3>Lista de sugerencia</h3>
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
                <div class="card-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Lista de Sugerencia</h4>
                        </div>
                    </div>
                </div>
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    @if(Session::has('success'))
                        <div class="alert alert-success">
                            {{Session::get('success')}}
                        </div>
                    @endif

                    @hasanyrole('admin|rrhh')
                    @include('sugerencia.table')
                    @else
                        <h4>No Tiene permiso para acceder a ruta</h4>
                        @endhasanyrole
                </div>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
        <!--end::Content container-->
    </div>
    <!--end::Content-->
@endsection
