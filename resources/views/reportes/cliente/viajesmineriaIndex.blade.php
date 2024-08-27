<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vitacora de clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style>
        /* Estilos para el header */
        header {
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Estilos para el logo */
        .logo {
            width: 200px;
            height: auto;
            margin-right: 10px;
        }

        /* Estilos para el texto */
        .texto {
            font-size: 20px;
            font-weight: bold;
        }

        /* Estilos para la fecha */
        .fecha {
            font-size: 16px;
            font-weight: lighter;
        }
    </style>
</head>
<body>
    <header class="container">
        <!-- Logo de pluss-->

        <img src="{{asset('images/logo-pluss-header.png')}}" alt="Logo" class="logo">
        <div class="texto">SERVICIO ESPECIAL: {{$cliente}}</div>
        <div class="fecha">{{$fecha}}</div>
    </header>
    <div class="container">
        <!---#, numero interno , patente , horario salida , origen destino , conductor 1 , conductor 2 , auxiliar-->
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Nº Interno</th>
                <th>P.P.U</th>
                <th>Horario salida</th>
                <th>Origen</th>
                <th>Destino</th>
                <th>Conductor 1</th>
                <th>Conductor 2</th>
                <th>Auxiliar</th>
            </tr>
            </thead>
            <tbody>
            @php
                $i = 1;
            @endphp
            @foreach($viajes as $viaje )
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{ $viaje->NRO_BUS }}</td>
                    <td>{{ $viaje->PATENTE }}</td>
                    <td>{{ $viaje->HORA_SALIDA }}</td>
                    <td>{{ $viaje->ORIGEN }}</td>
                    <td>{{$viaje->DESTINO}}</td>
                    <td>{{ $viaje->CONDUCTOR1 }} </br> {{'RUT: '.$viaje->RUT_CONDUCTOR1}}</td>
                    <td>{{ $viaje->CONDUCTOR2 }} </br> {{'RUT: '.$viaje->RUT_CONDUCTOR2}}</td>
                    <td>{{ $viaje->AUXILIAR }} </br> {{'RUT: '.$viaje->RUT_AUXILIAR}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
</body>
</html>
