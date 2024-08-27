<!DOCTYPE html>
<html>
<head>
    <title>VALE DE AUTORIZACIÓN DE SALIDA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
        }
        h1 {
            text-align: center;
            text-transform: uppercase;
            font-size: 22px;
            margin: 0;

        }
        span {
            font-size: 16px;
            font-weight: 600;
        }
        table {
            width: 100%;
            max-width: 1000px;
            margin:10px auto;
            border-collapse: collapse;
            text-align: left;

        }
        img {
            max-width: 200px;
            height: auto;
            margin-right: 10px;
        }
        th, td {
            border: 1px solid black;
            padding: 5px;
        }
        th {
            text-align: center;
            font-weight: bold;
        }
        td {
            vertical-align: top;
        }
        .texto-conductor{
            font-weight: bold;
            display: flex;
            text-transform: uppercase;
            width: 200px;
        }

    </style>
</head>
<body>
<table>
    <thead>
    <tr>
        <th colspan="10">
            <img src="{{asset('images/logo-pluss-header.png')}}" alt="Logo 1">
            <img src="{{asset('images/logo-pluss-header.png')}}" alt="Logo 2">
            <img src="{{asset('images/logo-pluss-header.png')}}" alt="Logo 3">
        </th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="8"><h1>Vale de autorización de salida</h1></td>
            <td colspan="2"><span>Folio</span> {{$folio}}</td>
        </tr>
        <tr>
            <td colspan="3"><span>PATENTE :</span> {{$patente}}</td>
            <td colspan="3"><span>Nº INTERNO:</span> {{$nro_bus}}</td>
            <td colspan="4"><span>FECHA:</span> {{$fecha_viaje}}</td>
        </tr>
        <tr>
            <td colspan="10"><span>HORARIO AUTORIZACION TALLER:</span> {{$hora_salida}}</td>
        </tr>
        <tr>
            <td>
                {{ $tipo == 'SALIDA A SERVICIO' ? 'X' : '' }}
            </td>
            <td>
                <span>SALIDA A SERVICIO</span>
            </td>
            <td>
                {{ $tipo == 'PRUEBA DE RUTA' ? 'X' : '' }}
            </td>
            <td>
                <span>PRUEBA DE RUTA</span>
            </td>
            <td>
                {{ $tipo == 'TRANSLADO A OTRA DEPENDENCIA' ? 'X' : '' }}
            </td>
            <td>
                <span>TRANSLADO A OTRA DEPENDENCIA</span>
            </td>
            <td>
                {{ $tipo == 'TRASLADO A TALLER EXTERNO' ? 'X' : '' }}
            </td>
            <td>
                <span>TRASLADO A TALLER EXTERNO</span>
            </td>
            <td>
                {{ $tipo == 'SALIDA DE EMERGENCIA' ? 'X' : '' }}
            </td>
            <td><span>SALIDA DE EMERGENCIA</span></td>
        </tr>
        @foreach($trabajadores as $index => $trabajador)
            <tr>
                <td c colspan="10">
                <span>
                    {{ $index < 2 ? 'CONDUCTOR Nº' . ($index + 1).' :           ' : 'AUXILIAR:           ' }}
                </span>
                    {{ $trabajador->primer_nombre }} {{ $trabajador->segundo_nombre }} {{ $trabajador->primer_apellido }} {{ $trabajador->segundo_apellido }}
                </td>
            </tr>
        @endforeach


        <tr>
            <td colspan="10"><span>OBSERVACIONES:</span></td>
        </tr>
        <tr>
            <td colspan="10">1</td>
        </tr>
        <tr>
            <td colspan="10">2</td>
        </tr>
<!-- PRIMERA FIRMA -->
        <tr>
            <td rowspan="4" colspan="2">
                <span>
                    PERSONAL QUE AUTORIZA
                </span>
            </td>
            <td colspan="6">
                <span>NOMBRE: </span>{{' '.$nombre_encargado}}
            </td>
            <td rowspan="3" colspan="2"></td>
        </tr>

        <tr>

            <td colspan="6">
                <span>CARGO: </span> {{' '.$cargo_encargado}}
            </td>

        </tr>

        <tr>

            <td colspan="6">
                <span>CI:</span> -
            </td>

        </tr>

        <tr>

            <td colspan="3" w>
                <span>FECHA:</span> {{$fecha_documento}}
            </td>
            <td colspan="3">
                <span>HORA:</span> {{$hora_documento}}
            </td>
            <td style="text-align: center" colspan="2">
                <span>FIRMA Y TIMBRE</span>
            </td>
        </tr>
    <!--FIN DE LA PRIMERA FIRMA-->
        <tr>
            <td rowspan="5" colspan="2">
                <span>GUARDIA</span>
            </td>
            <td colspan="6">
                <span>NOMBRE</span>
            </td>
            <td rowspan="4" colspan="2"></td>
        </tr>



        <tr>

            <td colspan="6">
                <span>CI:</span>
            </td>

        </tr>
        <tr>

            <td colspan="6">
                <span>SALIDA DEL VEHÍCULO:</span>
            </td>

        </tr>
        <tr>

            <td colspan="3">
                <span>FECHA:</span>
            </td>
            <td colspan="3">
                <span>HORA:</span>
            </td>

        </tr>
    <tr>
        <td colspan="3">

        </td>
        <td colspan="3">

        </td>
        <td  style="text-align: center" colspan="2">
            <span>FIRMA</span>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
