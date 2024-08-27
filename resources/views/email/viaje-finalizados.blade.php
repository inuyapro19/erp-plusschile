<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Viajes finalizados</title>
</head>
<body>
    <h1>Viajes finalizados</h1>
    <p>Los siguiente viajes han llegado a su destino y han finalizado</p>
    <table>
       <thead>
           <th>NRO VIAJE</th>
           <th>FECHA SALIDA</th>
           <th>FECHA LLEGADA</th>
           <th>ESTADO</th>
       </thead>
        <tbody>
            @foreach($viajes as $viaje)
                <tr>
                    <td>{{$viaje->nro_viaje}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
