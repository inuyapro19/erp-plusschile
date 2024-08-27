<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>REPORTE DE VIAJES POR BUS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

</head>
<body>

    <div class="container">
        <h1>Reporte de viajes</h1>
        <table  class="table table-bordered" id="kt_customers_table">
            <thead>
            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                <th></th>
                <th>FECHA</th>
                <th>HORA</th>
                <th>DESTINO</th>
                <th>MONTO</th>
                <th>OBSERVACIONES</th>


            </tr>
            </thead>
            <tbody>
                @foreach($historial as $bus)
                    <tr>
                        <td></td>
                        <td>{{$bus->FECHA_VIAJE}}</td>
                        <td>{{$bus->HORA_SALIDA}}</td>
                        <td>{{$bus->DESTINO}}</td>
                        <td>{{$bus->MONTO_TOTAL}}</td>
                        <td>{{$bus->NOTA_VIAJE}}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>

</body>
</html>
