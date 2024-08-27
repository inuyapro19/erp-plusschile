@extends('layouts.app')
@section('titulos')
    <div class="page-header">
        <div class="page-title">
            <h3>Documentos</h3>
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
                                <h4>Documentos <a href="{{route('documento.create')}}" class="btn btn-success btn-sm ml-5">Agregar</a></h4>

                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area">
                        <documento-component></documento-component>
                    </div>
                </div>
            </div>
        </div>
        <!-- CONTENT AREA -->
    </div>

@endsection
