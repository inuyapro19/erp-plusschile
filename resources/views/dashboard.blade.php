@extends('layouts.app')

@section('content')

    <div class="layout-px-spacing">


        <!-- CONTENT AREA -->
        <div class="row layout-top-spacing">
            <div id="tabsSimple" class="col-lg-12 col-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">

                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area">
                        <h4>Hola {{ucwords(Auth::user()->name).' '.ucwords(Auth::user()->apellidos)}}</h4><br>
                        <h4>Bienvenido al Sistema Intranet de PlussChile</h4>
                        @if(Session::has('success'))
                            <div class="alert alert-success">
                                Información cambiada exitosamente
                            </div>
                        @endif
                       {{-- <img src="{{asset('images/banner-votacion.jpg')}}" alt="" class=" mt-3 img-fluid">--}}
                    </div>
                </div>
            </div>


        </div>

        <!-- CONTENT AREA -->

    </div>

@endsection
