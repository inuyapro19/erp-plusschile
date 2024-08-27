@extends('layouts.app')
@section('titulos')
    <div class="page-header">
        <div class="page-title">
            <h3>Categorias Votación</h3>
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
                                <h4>
                                    Categorias Votación
                                </h4>

                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area">
                        @if(Session::has('success'))
                            <div class="alert alert-success">
                                Su votación ha sido ingresada correctamente
                            </div>
                        @endif
                        <div class="row">
                            @if(Auth::user()->tpluss == 'Y' || Auth::user()->tpluss == 'V')
                                <div class="col-md-4 col-sm-12">
                                    @include('partial.cajas_categorias',
                                                   [
                                                     'nombre_categoria'=>'Transportes Pluss',
                                                     'categorias'=>'tpluss',
                                                     'color'=>Auth::user()->tpluss == 'Y' ? 'info':'secundary',
                                                     'estado'=>Auth::user()->tpluss
                                                    ])
                                </div>
                            @endif

                                @if(Auth::user()->administracion == 'Y' || Auth::user()->administracion == 'V')
                                    <div class="col-md-4 col-sm-12">
                                        @include('partial.cajas_categorias',[
                                           'nombre_categoria'=>'Administración',
                                           'categorias'=>'administracion',
                                            'color'=>Auth::user()->administracion == 'Y' ? 'info':'secundary',
                                           'estado'=>Auth::user()->administracion
                                           ])
                                    </div>
                                @endif

                                @if(Auth::user()->thcm == 'Y' || Auth::user()->thcm == 'V')
                                    <div class="col-md-4 col-sm-12">
                                        @include('partial.cajas_categorias',[
                                           'nombre_categoria'=>'Transportes Hugo Cikotovic Madariaga',
                                           'categorias'=>'thcm',
                                           'color'=>Auth::user()->thcm == 'Y' ? 'info':'secundary',
                                            'estado'=>Auth::user()->thcm])
                                    </div>
                                @endif

                                @if(Auth::user()->tgcm == 'Y' || Auth::user()->tgcm == 'V')
                                    <div class="col-md-4 col-sm-12">
                                        @include('partial.cajas_categorias',[
                                           'nombre_categoria'=>'Transportes Gaspar Cikotovic Madariaga',
                                           'categorias'=>'tgcm',
                                            'color'=>Auth::user()->tgcm == 'Y' ? 'info':'secundary',
                                            'estado'=>Auth::user()->tgcm
                                           ])
                                    </div>
                                @endif

                                @if(Auth::user()->tdcm == 'Y' || Auth::user()->tdcm == 'V')
                                    <div class="col-md-4 col-sm-12">
                                        @include('partial.cajas_categorias',[
                                           'nombre_categoria'=>'Transportes Dusan Cikutovic Madariaga',
                                           'categorias'=>'tdcm',
                                          'color'=>Auth::user()->tdcm == 'Y' ? 'info':'secundary',
                                            'estado'=>Auth::user()->tdcm
                                           ])
                                    </div>
                                @endif

                                @if(Auth::user()->bgcm == 'Y' || Auth::user()->bgcm == 'V')
                                    <div class="col-md-4 col-sm-12">
                                        @include('partial.cajas_categorias',[
                                           'nombre_categoria'=>'Buses Gaspar Cikutovic Madariaga',
                                           'categorias'=>'bgcm',
                                            'color'=>Auth::user()->bgcm == 'Y' ? 'info':'secundary',
                                            'estado'=>Auth::user()->bgcm
                                           ])
                                    </div>
                                @endif

                                @if(Auth::user()->gcm == 'Y' || Auth::user()->gcm == 'V')
                                    <div class="col-md-4 col-sm-12">
                                        @include('partial.cajas_categorias',[
                                           'nombre_categoria'=>'GCM',
                                           'categorias'=>'gcm',
                                           'color'=>Auth::user()->gcm == 'Y' ? 'info':'secundary',
                                             'estado'=>Auth::user()->gcm
                                           ])
                                    </div>
                                @endif

                                @if(Auth::user()->turis == 'Y' || Auth::user()->turis == 'V')
                                    <div class="col-md-4 col-sm-12">
                                        @include('partial.cajas_categorias',[
                                           'nombre_categoria'=>'Turis Norte',
                                           'categorias'=>'turis',
                                             'color'=>Auth::user()->turis == 'Y' ? 'info':'secundary',
                                             'estado'=>Auth::user()->turis
                                           ])
                                    </div>
                                @endif

                                @if(Auth::user()->mantencion == 'Y' || Auth::user()->mantencion == 'V')
                                    <div class="col-md-4 col-sm-12">
                                        @include('partial.cajas_categorias',[
                                           'nombre_categoria'=>'Mantención',
                                           'categorias'=>'mantencion',
                                            'color'=>Auth::user()->mantencion == 'Y' ? 'info':'secundary',
                                            'estado'=>Auth::user()->mantencion
                                           ])
                                    </div>
                                @endif

                                @if(Auth::user()->servicios_generales == 'Y' || Auth::user()->servicios_generales == 'V')
                                    <div class="col-md-4 col-sm-12">
                                        @include('partial.cajas_categorias',[
                                           'nombre_categoria'=>'Servicios Generales',
                                           'categorias'=>'servicios_generales',
                                            'color'=>Auth::user()->servicios_generales == 'Y' ? 'info':'secundary',
                                            'estado'=>Auth::user()->servicios_generales
                                           ])
                                    </div>
                                @endif

                                @if(Auth::user()->agentes_ventas == 'Y' || Auth::user()->agentes_ventas == 'V')
                                    <div class="col-md-4 col-sm-12">
                                        @include('partial.cajas_categorias',[
                                           'nombre_categoria'=>'Agentes de Ventas',
                                           'categorias'=>'agentes_ventas',
                                          'color'=>Auth::user()->agentes_ventas == 'Y' ? 'info':'secundary',
                                            'estado'=>Auth::user()->agentes_ventas
                                           ])
                                    </div>
                                @endif


                                @if(Auth::user()->plussmineria == 'Y' || Auth::user()->plussmineria == 'V')
                                    <div class="col-md-4 col-sm-12">
                                        @include('partial.cajas_categorias',[
                                           'nombre_categoria'=>'Pluss Minería',
                                           'categorias'=>'plussmineria',
                                           'color'=>Auth::user()->plussmineria == 'Y' ? 'info':'secundary',
                                           'estado'=>Auth::user()->plussmineria
                                           ])
                                    </div>
                                @endif


                        </div>





                    </div>
                </div>
            </div>
        </div>
        <!-- CONTENT AREA -->
    </div>
@endsection
@push('styles')
    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link href="{{asset('assets/css/elements/infobox.css')}}" rel="stylesheet" type="text/css" />
    <!--  END CUSTOM STYLE FILE  -->
@endpush
