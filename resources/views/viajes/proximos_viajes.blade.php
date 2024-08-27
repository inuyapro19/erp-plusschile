<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Próximo viajes</title>
</head>
<body>

    <div class="container mt-5">
        <h1>Próximo viajes</h1>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>FECHA SALIDA</th>
                    <th>HORA</th>
                    <th>Nº VIAJE</th>
                    <th>BUS</th>
                    <th>DESTINO</th>
                </tr>
            </thead>
            <tbody>
                @foreach($viajes as $viaje)
                    <tr>
                        <td>{{$viaje->FECHA_VIAJE }}</td>
                        <td>{{ $viaje->HORA_SALIDA }}</td>
                        <td>{{ $viaje->NRO_VIAJE }}</td>
                        <td>{{ $viaje->NRO_BUS }}</td>
                        <td>{{ $viaje->DESTINO }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>
