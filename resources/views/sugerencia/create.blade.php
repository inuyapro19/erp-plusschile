@extends('layouts.app')
@section('titulos')
    <div class="page-header">
        <div class="page-title">
            <h3>Ingresar Sugerencia</h3>
        </div>
    </div>
@endsection
@section('content')



    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Card-->
            <div class="card">
                <div class="card-header">
                    <h3>Ingresar Sugerencia</h3>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <div class="alert alert-warning">
                        <p>
                            NOTA: No se considerarán los formularios que presenten lo siguiente:</p>
                        <ul>
                            <li>Aquellos formularios que discriminen o menoscaben a compañeros de trabajo o personas (personal de la empresa , personal externo o de empresas prestadoras de servicios).</li>
                            <li>Aquellas sugerencias que de acuerdo a la revisión y análisis del formulario implique más riesgo para la operación y áreas de trabajo.</li>
                            <li>Aquellos formularios que hayan sido completados con letra ilegibles que no pueda ser comprendido en su totalidad o que dé a interpretaciones.</li>
                            <li>Aquellos formularios que contengan insultos, garabatos, dibujos, obscenidades y/o groserías.</li>
                        </ul>




                    </div>
                    @include('flash-message')
                    {!! Form::open(['route' => 'sugerencia.store','files'=>'true']) !!}

                    @include('sugerencia.field')

                    {!! Form::close() !!}
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->

        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->

@endsection
