@extends('layouts.app')
@section('titulos')
    <div class="page-header">
        <div class="page-title">
            <h3>Votacion mejor compañero - {{ Auth::user()->name.' '.Auth::user()->apellidos }} </h3>
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
                                    Votacion mejor compañero <a href="{{route('votacion.categorias')}}" class="btn btn-success btn-sm">Volver</a>

                                </h4>

                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area">


                        {!! Form::open(['route' =>['votacion.busqueda',$clave],'class'=>'form-inline my-2 my-lg-0 justify-content-center','method'=>'post']) !!}

                            <div class="w-75 mb-5">
                                <input type="text" name="busqueda" class="w-75 form-control product-search br-30" id="input-search" placeholder="Buscar..." >
                                <button class="btn btn-primary" type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>

                                </button>
                            </div>

                        {!! Form::close() !!}

                        @include('votacion.tablas.tables')

                    </div>
                </div>
            </div>
        </div>
        <!-- CONTENT AREA -->
    </div>
@endsection
@push('styles')
    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link href="{{asset('assets/css/elements/search.css')}}" rel="stylesheet" type="text/css" />
    <!--  END CUSTOM STYLE FILE  -->
@endpush
@push('scripts')
    <script src="{{asset('assets/js/elements/custom-search.js')}}"></script>
@endpush
