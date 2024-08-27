@extends('layouts.app')

@section('content')
    <x-base>
        <x-card-component classCard="mt-3 p-2">
            <h3>Hola {{ucwords(Auth::user()->name).' '.ucwords(Auth::user()->apellidos)}}</h3>
            <h3>Bienvenido al Sistema Intranet de PlussChile</h3>
        </x-card-component>

        <div class="layout-px-spacing mt-5">

            <div class="row layout-top-spacing container d-flex flex-row justify-content-between">

                <div class="cuadros-widget">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="50"><!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M224 0c70.7 0 128 57.3 128 128s-57.3 128-128 128s-128-57.3-128-128S153.3 0 224 0zM209.1 359.2l-18.6-31c-6.4-10.7 1.3-24.2 13.7-24.2H224h19.7c12.4 0 20.1 13.6 13.7 24.2l-18.6 31 33.4 123.9 39.5-161.2c77.2 12 136.3 78.8 136.3 159.4c0 17-13.8 30.7-30.7 30.7H265.1 182.9 30.7C13.8 512 0 498.2 0 481.3c0-80.6 59.1-147.4 136.3-159.4l39.5 161.2 33.4-123.9z"/></svg>
                    <h4>Conductores</h4>
                    <span>{{$tripulacion_conductores_disponible->DISPONIBLE}} Disponibles</span>
                </div>

                <div class="cuadros-widget">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="50"><!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M224 0c70.7 0 128 57.3 128 128s-57.3 128-128 128s-128-57.3-128-128S153.3 0 224 0zM209.1 359.2l-18.6-31c-6.4-10.7 1.3-24.2 13.7-24.2H224h19.7c12.4 0 20.1 13.6 13.7 24.2l-18.6 31 33.4 123.9 39.5-161.2c77.2 12 136.3 78.8 136.3 159.4c0 17-13.8 30.7-30.7 30.7H265.1 182.9 30.7C13.8 512 0 498.2 0 481.3c0-80.6 59.1-147.4 136.3-159.4l39.5 161.2 33.4-123.9z"/></svg>
                    <h4>Auxiliares</h4>
                    <span>{{$tripulacion_auxiliares_disponible->DISPONIBLE}} Disponibles</span>
                </div>

                <div class="cuadros-widget">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="50"><!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M256 0C390.4 0 480 35.2 480 80V96l0 32c17.7 0 32 14.3 32 32v64c0 17.7-14.3 32-32 32l0 160c0 17.7-14.3 32-32 32v32c0 17.7-14.3 32-32 32H384c-17.7 0-32-14.3-32-32V448H160v32c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32l0-32c-17.7 0-32-14.3-32-32l0-160c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h0V96h0V80C32 35.2 121.6 0 256 0zM96 160v96c0 17.7 14.3 32 32 32H240V128H128c-17.7 0-32 14.3-32 32zM272 288H384c17.7 0 32-14.3 32-32V160c0-17.7-14.3-32-32-32H272V288zM112 400c17.7 0 32-14.3 32-32s-14.3-32-32-32s-32 14.3-32 32s14.3 32 32 32zm288 0c17.7 0 32-14.3 32-32s-14.3-32-32-32s-32 14.3-32 32s14.3 32 32 32zM352 80c0-8.8-7.2-16-16-16H176c-8.8 0-16 7.2-16 16s7.2 16 16 16H336c8.8 0 16-7.2 16-16z"/></svg>
                    <h4>Buses</h4>
                    <span>{{$buses_operativos->Cantidad}} Disponibles</span>
                </div>

                <div class="cuadros-widget">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="50"><!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M416 256s96-96 96-160c0-53-43-96-96-96s-96 43-96 96c0 29.4 20.2 65.5 42.1 96H320c-53 0-96 43-96 96s43 96 96 96h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H188.6c-6.2 9.6-12.6 18.8-19 27.2c-10.7 14.2-21.3 26.9-30 36.8H416c53 0 96-43 96-96s-43-96-96-96H320c-17.7 0-32-14.3-32-32s14.3-32 32-32h96zm0-128c-17.7 0-32-14.3-32-32s14.3-32 32-32s32 14.3 32 32s-14.3 32-32 32zM149.9 448c21.9-30.5 42.1-66.6 42.1-96c0-53-43-96-96-96s-96 43-96 96c0 64 96 160 96 160s3.5-3.5 9.2-9.6c.4-.4 .7-.8 1.1-1.2c3.3-3.5 7.1-7.8 11.4-12.8c.2-.2 .4-.4 .6-.6c9.4-10.8 20.7-24.6 31.6-39.8zM96 384c-17.7 0-32-14.3-32-32s14.3-32 32-32s32 14.3 32 32s-14.3 32-32 32z"/></svg>
                    <h4>Viajes</h4>
                    <span>{{$viajes_en_ruta->Cantidad}} en ruta</span>
                </div>
            </div>
        </div>
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
            <div class="col-xxl-6">
                <x-card-component classCard="mt-3 p-2" header="si"  title="Conductores">
                    <table class="table table-row-dashed align-middle gs-0 gy-3 my-0 ">
                        <thead>
                        <tr class="fs-7 fw-bold text-gray-400 border-bottom-0">
                            <th class="p-0 pb-3 min-w-175px text-start">Condición</th>
                            <th class="p-0 pb-3 min-w-175px text-start">Cantidad</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>DISPONIBLE</td>
                            <td><span class="badge badge-warning">{{$tripulacion_conductores->DISPONIBLE}}</span></td>
                        </tr>
                        <tr>
                            <td>DÍAS LIBRES</td>
                            <td><span class="badge badge-warning">{{$tripulacion_conductores->DIAS_LIBRES}}</span></td>
                        </tr>
                        <tr>
                            <td>VACACIONES</td>
                            <td><span class="badge badge-warning">{{$tripulacion_conductores->VACACIONES}}</span></td>
                        </tr>
                        <tr>
                            <td>FALLA</td>
                            <td><span class="badge badge-warning">{{$tripulacion_conductores->FALLA}}</span></td>
                        </tr>
                        <tr>
                            <td>LICENCIA MÉDICA</td>
                            <td><span class="badge badge-warning">{{$tripulacion_conductores->LICENCIA_MEDICA}}</span></td>
                        </tr>
                        <tr>
                            <td>EN RUTA</td>
                            <td><span class="badge badge-warning">{{$tripulacion_conductores->EN_RUTA}}</span></td>
                        </tr>
                        <tr>
                            <td>PERMISO ESPECIAL</td>
                            <td><span class="badge badge-warning">{{$tripulacion_conductores->PERMISO_ESPECIAL}}</span></td>
                        </tr>
                        </tbody>
                    </table>
                </x-card-component>
            </div>
            <div class="col-xxl-6">
                <x-card-component classCard="mt-3 p-2" header="si"  title="Auxiliares">
                    <table class="table table-row-dashed align-middle gs-0 gy-3 my-0 ">
                        <thead>
                        <tr class="fs-7 fw-bold text-gray-400 border-bottom-0">
                            <th class="p-0 pb-3 min-w-175px text-start">Condición</th>
                            <th class="p-0 pb-3 min-w-175px text-start">Cantidad</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>DISPONIBLE</td>
                            <td><span class="badge badge-warning">{{$tripulacion_axuliares->DISPONIBLE}}</span></td>
                        </tr>
                        <tr>
                            <td>DÍAS LIBRES</td>
                            <td><span class="badge badge-warning">{{$tripulacion_axuliares->DIAS_LIBRES}}</span></td>
                        </tr>
                        <tr>
                            <td>VACACIONES</td>
                            <td><span class="badge badge-warning">{{$tripulacion_axuliares->VACACIONES}}</span></td>
                        </tr>
                        <tr>
                            <td>FALLA</td>
                            <td><span class="badge badge-warning">{{$tripulacion_axuliares->FALLA}}</span></td>
                        </tr>
                        <tr>
                            <td>LICENCIA MÉDICA</td>
                            <td><span class="badge badge-warning">{{$tripulacion_axuliares->LICENCIA_MEDICA}}</span></td>
                        </tr>
                        <tr>
                            <td>EN RUTA</td>
                            <td><span class="badge badge-warning">{{$tripulacion_axuliares->EN_RUTA}}</span></td>
                        </tr>
                        <tr>
                            <td>PERMISO ESPECIAL</td>
                            <td><span class="badge badge-warning">{{$tripulacion_axuliares->PERMISO_ESPECIAL}}</span></td>
                        </tr>
                        </tbody>
                    </table>
                </x-card-component>
            </div>
        </div>
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
            <div class="col-xxl-12">
                <x-card-component classCard="mt-3 p-2" header="si"  title="Próximas Reincorporaciones">
                    <div class="table-responsive">
                        <table class="table table-row-dashed align-middle gs-0 gy-3 my-0 ">
                            <thead>
                            <tr class="fs-7 fw-bold text-gray-400 border-bottom-0">
                                <th><div class="th-content">RUT</div></th>
                                <th><div class="th-content">NOMBRE</div></th>
                                <th><div class="th-content">CARGO</div></th>
                                <th><div class="th-content th-heading">EMPRESA</div></th>
                                <th><div class="th-content">FECHA RETORNO</div></th>
                                <th><div class="th-content">TIPO</div></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tripulacion_retorno as $retorno)
                                <tr>
                                    <td>{{$retorno->RUT}}</td>
                                    <td><div class="td-content product-brand text-primary">{{$retorno->NOMBRE_COMPLETO}}</div></td>
                                    <td><div class="td-content product-invoice">{{$retorno->NOMBRE_CARGO}}</div></td>
                                    <td><div class="td-content pricing"><span class="">{{$retorno->NOMBRE_EMPLEADOR}}</span></div></td>
                                    <td><div class="td-content pricing"><span class="">{{$retorno->FECHA_TERMINO}}</span></div></td>
                                    <td><div class="td-content"><span class="badge badge-success">{{$retorno->TIPO}}</span></div></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </x-card-component>
            </div>
        </div>
    </x-base>


@endsection

@push('styles')

<style>
   .cuadros-widget{
    background-color: #fff;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
    width: 250px;
    justify-content: center;
    text-align: center;
    margin-bottom: 20px;
    transition: transform 0.3s ease-in-out;
}

.cuadros-widget:hover {
    transform: scale(1.05);
}

.cuadros-widget svg{
    width: 50px;
    color: #000;
    margin-bottom: 15px;
    transition: color 0.3s ease-in-out;
}

.cuadros-widget:hover svg {
    color: #007bff; /* Cambia el color al pasar el mouse */
}

.cuadros-widget h4 {
    font-size: 18px;
    margin-bottom: 10px;
    color: #333;
    transition: color 0.3s ease-in-out;
}

.cuadros-widget:hover h4 {
    color: #007bff; /* Cambia el color al pasar el mouse */
}

.cuadros-widget span {
    font-size: 16px;
    color: #666;
}


</style>
@endpush
