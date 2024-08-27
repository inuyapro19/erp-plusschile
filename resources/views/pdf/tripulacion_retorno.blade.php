<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Imprimir</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <style>
        *{
            margin: 0;
            padding: 0;
        }
        body{
            font-family: Arial, Helvetica, sans-serif;
            color: #000;
        }
        .border{
            border:1px solid #000000!important;
            padding: 2px;
        }

        .table th {
            padding: 0.75rem ;
            border: unset!important;
        }
        .table td  {
            padding: 0.75rem ;
            border-bottom: 1px dashed #DDDDDD!important;
        }
        td,p,tr{
            margin:0;
            padding: 0;
            font-size: 12px;
        }
        .linea {
            border-top: 1px solid black;
            height: 2px;
            max-width: 200px;
            padding: 0;
            margin: 50px auto 0 auto;
        }
        .centrado{
            text-align: center;
        }
        .bold{
            font-weight: bold;
            color: #333333;
        }
        .text-left{
            text-align: left;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <h1 class="text-center">REPORTE DE INCORPORACIONES</h1>
    <h4 class="text-left">Conductores</h4>
    <table class="table table-striped table-bordered mb-3">
        <thead>
        <tr>
            <th><div class="th-content">RUT</div></th>
            <th><div class="th-content">NOMBRE</div></th>
            <th><div class="th-content">CARGO</div></th>
            <th><div class="th-content th-heading">EMPRESA</div></th>
            <th><div class="th-content th-heading">FECHA INICIO</div></th>
            <th><div class="th-content th-heading">FECHA TERMINO</div></th>
            <th><div class="th-content">FECHA RETORNO</div></th>
            <th><div class="th-content">CONCEPTO</div></th>
        </tr>
        </thead>
        <tbody>
        @foreach($tripulacion_conductores as $retorno)
            <tr>
                <td class="bold">{{$retorno->RUT}}</td>
                <td><div class="td-content product-brand bold">{{$retorno->NOMBRE_COMPLETO}}</div></td>
                <td><div class="td-content product-invoice">{{$retorno->NOMBRE_CARGO}}</div></td>
                <td><div class="td-content pricing"><span class="">{{$retorno->NOMBRE_EMPLEADOR}}</span></div></td>
                <td>{{\Carbon\Carbon::parse($retorno->FECHA_INICIO)->format('d/m/Y')}}</td>
                <td>{{\Carbon\Carbon::parse($retorno->FECHA_TERMINO)->format('d/m/Y')}}</td>
                <td><div class="td-content pricing"><span class="">{{\Carbon\Carbon::parse($retorno->FECHA_RETORNO)->format('d/m/Y')}}</span></div></td>
                <td><div class="td-content bold">{{$retorno->TIPO}}</div></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <h4 class="text-left">Auxiliares</h4>
    <table class="table table-striped table-bordered mb-3">
        <thead>
        <tr>
            <th><div class="th-content">RUT</div></th>
            <th><div class="th-content">NOMBRE</div></th>
            <th><div class="th-content">CARGO</div></th>
            <th><div class="th-content th-heading">EMPRESA</div></th>
            <th><div class="th-content th-heading">FECHA INICIO</div></th>
            <th><div class="th-content th-heading">FECHA TERMINO</div></th>
            <th><div class="th-content">FECHA RETORNO</div></th>
            <th><div class="th-content">CONCEPTO</div></th>
        </tr>
        </thead>
        <tbody>
        @foreach($tripulacion_auxiliar as $retorno)
            <tr>
                <td class="bold">{{$retorno->RUT}}</td>
                <td><div class="td-content product-brand bold">{{$retorno->NOMBRE_COMPLETO}}</div></td>
                <td><div class="td-content product-invoice">{{$retorno->NOMBRE_CARGO}}</div></td>
                <td><div class="td-content pricing"><span class="">{{$retorno->NOMBRE_EMPLEADOR}}</span></div></td>
                <td>{{\Carbon\Carbon::parse($retorno->FECHA_INICIO)->format('d/m/Y')}}</td>
                <td>{{\Carbon\Carbon::parse($retorno->FECHA_TERMINO)->format('d/m/Y')}}</td>
                <td><div class="td-content pricing"><span class="">{{\Carbon\Carbon::parse($retorno->FECHA_RETORNO)->format('d/m/Y')}}</span></div></td>
                <td><div class="td-content bold">{{$retorno->TIPO}}</div></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>


</body>
</html>
