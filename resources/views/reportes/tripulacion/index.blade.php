@extends('layouts.app')
@section('titulos')
    <div class="page-header">
        <div class="page-title">
            <h3>Historial de Tripulantes</h3>
        </div>
    </div>
@endsection
@section('content')

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">


            <!-----Lista de trabajadores por tripulacion  - cargos -------->
            <reportes-sistema-index></reportes-sistema-index>

        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
@endsection
