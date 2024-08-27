<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <th>Tipo Mensaje</th>
            <th>Area</th>
            <th>Area Operaciol</th>
            <th>Reclamo / sugerencia/ felicitaciones</th>
            <th>Propuesta</th>
            <th>Mejoras</th>
            <th>fecha</th>
            <th>Estado</th>
        </thead>
        <tbody>
        @foreach($sugerencia as $solicitud)
            <tr>
                <td>{{$solicitud->tipo_reclamo}}</td>
                <td>{{$solicitud->areas->descripcion_area }}</td>
                <td>{{$solicitud->area_operacion}}</td>
                <td>{{$solicitud->mensaje_descripcion}}</td>
                <td>{{$solicitud->mensaje_propuestas}}</td>
                <td>{{$solicitud->mensaje_de_mejoras}}</td>
                <td>{{$solicitud->created_at->format('d-m-Y')}}</td>
                <td>{{$solicitud->estado}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

