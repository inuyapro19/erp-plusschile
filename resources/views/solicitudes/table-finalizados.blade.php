<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
        <th>RUT</th>
        <th>Nombre</th>
        <th>Tipo Solicitud</th>
        <th>Fecha Termino Solicitud</th>
        <th>Estado</th>

        </thead>
        <tbody>
        @foreach($solicitudes as $solicitud)
            <tr>
                <td>{{$solicitud->trabajador->rut}}</td>
                <td>{{$solicitud->trabajador->primer_nombre .' '.$solicitud->trabajador->primer_apellido .' '.$solicitud->trabajador->segundo_apellido}}</td>
                <td>{{$solicitud->tipo_solicitud}}</td>
                <td>{{$solicitud->updated_at->format('d-m-Y')}}</td>
                <td><span class="shadow-none badge {{$solicitud->estado == 'pendiente' ? 'outline-badge-primary':'outline-badge-success'}}">{{$solicitud->estado}}</span></td>

            </tr>
        @endforeach
        </tbody>
    </table>
</div>
