
<div class="table-responsive">
    <table class="table table-striped table-condensed">
        <thead>
        <td>CÓDIGO TRABAJADOR</td>
        <td>RUT</td>
        <td>NOMBRE</td>
        <td>CARGO</td>
        <td>EMPLEADOR</td>
        <td>ESTADO</td>
        <td>ACCIONES</td>
        </thead>
        <tbody>
        @foreach($trabajadores as $trabajador)
            <tr>
                <td>{{$trabajador->codigo_trabajador}}</td>
                <td>{{$trabajador->rut}}</td>
                <td>{{$trabajador->FullName}}</td>
                <td>{{$trabajador->contrato->cargo != NULL ? $trabajador->contrato->cargo->nombre_cargo : '-' }}</td>
                <td>{{$trabajador->contrato->empleador != NULL ? $trabajador->contrato->empleador->nombre_empleador:'-'}}</td>
                <td>{{$trabajador->estado}}</td>
                <td>

                    <div class='btn-group'>
                        <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#historial-desc-{{$trabajador->id}}"><i class="fa fa-eye"></i></button>
                        <a href="{{route('formulario-reincorporacion',$trabajador->id)}}" class="btn btn-outline-primary"><i class="fa fa-edit"></i></a>
                    </div>

                </td>
            </tr>

        @endforeach
        </tbody>
    </table>


    {{$trabajadores->links('vendor.pagination.custom')}}

    @foreach($trabajadores as $modal)
        @include('trabajador.desvinculados.modal')
    @endforeach
</div>


    @push('styles')
        <!--  BEGIN CUSTOM STYLE FILE  -->
        <link href="{{asset('assets/css/elements/search.css')}}" rel="stylesheet" type="text/css" />
        <!--  END CUSTOM STYLE FILE  -->
    @endpush
    @push('scripts')
        <script src="{{asset('assets/js/elements/custom-search.js')}}"></script>
    @endpush

