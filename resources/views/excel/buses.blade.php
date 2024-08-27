<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BUSES</title>
</head>
<body>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>NRO BUS</th>
                <th>MARCA CHASIS</th>
                <th>MODELO CHASIS</th>
                <th>NUMERO CHASIS</th>
                <th>MARCA CARROCERIA</th>
                <th>MODELO CARROCERIA</th>
                <th>NUMERO CARROCERIA</th>
                <th>PATENTE</th>
                <th>TIPO BUS</th>
                <th>TIPO SERVICIO</th>
                <th>NUMERO PISO</th>
                <th>AÑO DEL BUS</th>
                <th>EMPLEADOR</th>
                <th>TOTAL NRO ASIENTOS</th>
                <th>NRO ASIENTOS PREMIUM</th>
                <th>NRO ASIENTO MIXTO</th>
                <th>NRO ASIENTO CAMA</th>
                <th>NRO ASIENTO SEMICAMA</th>
                <th>NRO TOTAL PANTALLAS</th>
                <th>NRO PANTALLAS PREMIUM</th>
                <th>NRO PANTALLAS MIXTO</th>
                <th>NRO PANTALLAS CAMA</th>
                <th>NRO PANTALLAS SEMICAMA</th>
                <th>FECHA DE ULTIMA CARGA</th>
                <th>TIPO PANTALLA</th>
                <th>ESTADO</th>
            </tr>
        </thead>
        <tbody>
             @foreach($buses as $bus)
                <tr>
                    <td>{{$bus->id}}</td>
                    <td>{{$bus->numero_bus}}</td>
                    <td>{{$bus->marca_chasis}}</td>
                    <td>{{$bus->modelo_chasis}}</td>
                    <td>{{$bus->numero_chasis}}</td>
                    <td>{{$bus->marca_carroceria}}</td>
                    <td>{{$bus->modelo_carroceria}}</td>
                    <td>{{$bus->numero_carroceria}}</td>
                    <td>{{$bus->patente}}</td>
                    <td>{{$bus->tipo_bus}}</td>
                    <td>{{$bus->tipo_servicio}}</td>
                    <td>{{$bus->numero_piso}}</td>
                    <td>{{$bus->anyo_bus}}</td>
                    <td>{{$bus->nombre_empleador}}</td>
                    <td>{{$bus->numero_asientos}}</td>
                    <td>{{$bus->numero_asiento_premium}}</td>
                    <td>{{$bus->numero_asiento_mixto}}</td>
                    <td>{{$bus->numero_asiento_cama}}</td>
                    <td>{{$bus->numero_asiento_semicama}}</td>
                    <td>{{$bus->numero_pantallas}}</td>
                    <td>{{$bus->numero_pantallas_premium}}</td>
                    <td>{{$bus->numero_pantallas_mixtos}}</td>
                    <td>{{$bus->numero_pantallas_cama}}</td>
                    <td>{{$bus->numero_pantallas_semicama}}</td>
                    <td>{{$bus->fecha_ultima_carga}}</td>
                    <td>{{$bus->tipo_pantalla}}</td>
                    <td>{{$bus->estado}}</td>
                </tr>
             @endforeach
        </tbody>
    </table>


</body>
</html>
