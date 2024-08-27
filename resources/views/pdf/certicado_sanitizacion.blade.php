<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Certificado de Sanitación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <style>
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
            max-width: 700px;
            margin: 0 auto;
        }

        header img {
           width: 200px;
            margin-right: 10px;
        }

        header span {
            font-size: 18px;
            font-weight: lighter;
        }

        h1 {
            text-align: center;
            margin-top: 50px;
            text-transform: uppercase;
            font-size: 22px;
        }

        p {
            margin: 20px auto;
            line-height: 1.5;
            max-width: 700px;
            text-align: justify;
            font-size:19px
        }

        table {
            margin: 0 auto;
            border-collapse: collapse;
        }

        td, th {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }
        .right-align {
            text-align: right;
        }
        .tabla-firma{
            margin-top: 50px;
            margin-left: auto;
            margin-right: auto;
            max-width: 700px;
            border: 1px solid #ccc;
        }

        .tabla-firma td:first-child {
            width: 100px;
        }
        .tabla-firma td:nth-child(2) {
            width: 300px;
        }

        .tabla-firma td:last-child {
            width: 150px;
        }

    </style>
</head>
<body>
    <header>
        <img src="{{asset('images/logo-pluss-header.png')}}" alt="Logo" class="logo">
        <span>{{$nro_folio}}</span>
    </header>
    <div class="container">
        <h1>Certificado de Sanitización de vehículo</h1>
        <!---ciudad fecha aliniados a la derecha --->
        <p class="right-align">Ciudad Santiago, {{$fecha_documento}}</p>
        <p>
            Mediante el presente, <strong>{{strtoupper($empleador)}}</strong>.
            RUT: {{$rut_empleador}}, certifica que el vehiculo individualizado en el presente fue
            sanitizado por la empresa mediante un limpador de doble acción, formulado con sales de amonio
            cuaternario para la limpieza y disminuacion de gérmenes y microorganismos indeseados.
            Aplicándose el producto al interior del bus en especial en los siguientes lugares:
            manillas de puertas, pasamanos, apoya brazos, apoya pies, puertas, baños, paqueteras, maletero, volante y tablero
            del bus.
        </p>

        <table>
            <tbody>
            <tr >
                <td>Placa Patente Única</td>
                <td>{{$nro_bus}} - {{$patente}}</td>
            </tr>
            <tr>
                <td>Fecha de Aplicación</td>
                <td>{{$fecha}}</td>
            </tr>
            <tr>
                <td>Hora de Aplicación</td>
                <td>{{$hora}}</td>
            </tr>
            </tbody>
        </table>

        <p>
            Se extiende el presente certificado para los fines que se estime conveniente.
        </p>
        <p>
            Sin otro particular, saluda atentamente.
        </p>

        <!-- tabla con nombre , CI , Cargo y firma -->
        <table class="tabla-firma">
            <tbody>
            <tr style="width: 20%">
                <td>Nombre</td>
                <td></td>
                <td rowspan="2"></td>
            </tr>
            <tr style="width: 50%">
                <td>Cargo</td>
                <td></td>

            </tr>
            <tr style="width: 30%">
                <td>CI</td>
                <td></td>
                <td>Firma</td>
            </tr>
            </tbody>
        </table>
    </div>



</body>
</html>
