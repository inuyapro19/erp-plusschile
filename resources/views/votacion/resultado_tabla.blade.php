
<div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
            <td>RUT</td>
            <td>Nombre</td>
            <td>Cargo</td>
            <td>Cantidad de votos</td>
        </thead>
        <tbody>
        @foreach($lista as $usuarios)
            <tr>
                <td>{{$usuarios->rut}}</td>
                <td>{{$usuarios->name.' '.$usuarios->apellidos}}</td>
                <td>{{$usuarios->cargo}}</td>
                <td>
                   {{$usuarios->cantidad_votos}}
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>
</div>
