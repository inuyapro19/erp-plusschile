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
        <h1>Reporte de Tripulacion</h1>
        <table  class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
            <thead>
            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                <th></th>
                <th>RUT</th>
                <th>NOMBRE</th>
                <th>CARGO</th>
                <th>BUS</th>
                <th>TIPO</th>
                <th>Fecha</th>
            </tr>
            </thead>
            <tbody>
                @foreach($historial as $tripulacion)
                    <tr>
                        <td></td>
                        <td>{{$tripulacion->RUT}}</td>
                        <td>{{$tripulacion->NOMBRE_COMPLETO}}</td>
                        <td>{{$tripulacion->CARGO}}</td>
                        <td>{{$tripulacion->BUS}}</td>
                        <td>{{$tripulacion->TIPO}}</td>
                        <td>{{\Carbon\Carbon::parse($tripulacion->FECHA_INICIO)->format('d-m-Y')}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>
