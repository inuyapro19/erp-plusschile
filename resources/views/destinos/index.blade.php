@extends('layouts.app')
@section('titulos')
    <div class="page-header">
        <div class="page-title">
            <h3>Destinos</h3>
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
                                <h4>Destinos</h4>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area">

                            <destinos-index></destinos-index>

                    </div>
                </div>
            </div>
        </div>
        <!-- CONTENT AREA -->
    </div>

@endsection
