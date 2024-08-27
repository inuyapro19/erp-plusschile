{{--<div class="infobox-2">
    <div class="info-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
    </div>
    <h5 class="info-heading">{{$nombre_categoria}}</h5>

    <a class="info-link" href="{{route('votacion.lista',isset($categorias) ? $categorias : '' )}}">Ir a Votar <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></a>
</div>--}}

<div class="card text-white bg-{{$color}} mb-3" style="max-width: 18rem;">
    <div class="card-header">{{$nombre_categoria}}</div>
    <div class="card-body">
        @if($estado == 'Y')

            @role('trabajador')
                <a  href="{{route('votacion.lista',isset($categorias) ? $categorias : '' )}}" class="btn btn-success btn-sm">Ir a votar</a>
            @endrole

            @role('admin')
                <a  href="{{route('resultado_votacion',isset($categorias) ? $categorias : '' )}}" class="btn btn-success btn-sm">Ver Resultados</a>
            @endrole
        @else
            <a  href="#" onclick="alert('Usted ya voto en esta categoría')" class="btn btn-default btn-sm">Ir a votar</a>
        @endif
    </div>
</div>
