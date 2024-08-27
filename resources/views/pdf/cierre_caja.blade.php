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
        p{
            margin: 0;
            padding: 0;
            font-size: 18px;
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
    </style>
</head>
<body>
<div class="container mb-3">
    <h3 class="text-center">REPORTE DE LIQUIDACIÓN #{{$nro_folio}}</h3>

    <p>Fecha:  {{ \Carbon\Carbon::parse($fecha)->format('d/m/Y')}}</p>
    <p>Quién Liquida: {{ $usuario }}</p>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th><div class="th-content">TIPO</div></th>
            <th><div class="th-content">ITEM</div></th>
            <th><div class="th-content">FOLIO VIAJE/GASTO</div></th>
            <th><div class="th-content">NRO DOCUMENTO</div></th>
            <th><div class="th-content">MONTO ENTREGADO</div></th>
            <th><div class="th-content">DESCUENTOS</div></th>
            <th><div class="th-content">MONTO DEPOSITADO</div></th>
        </tr>
        </thead>
        <tbody>
        @foreach($cierre_cajas as $cierre_caja)
            <tr>
                <td>{{ $cierre_caja->TIPO }}</td>
                <td>{{ $cierre_caja->VIAJE_ID }}</td>
                <td>{{ $cierre_caja->NUMERO_DOCUMENTO }}</td>
                <td>{{ $cierre_caja->NRO_DOCUMENTO }}</td>
                <td>$ {{number_format($cierre_caja->MONTO,0,',','.') }}</td>
                <td>$ {{ number_format($cierre_caja->DESCUENTO,0,',','.') }}</td>
                <td>$ {{ number_format($cierre_caja->MONTO_DEPOSITADO,0,',','.') }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfooter>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>

                <td style="font-weight: bold">TOTAL DEPOSITADO</td>
                <td>$ {{number_format($totalGastos,0,',','.')}}</td>

            </tr>
        </tfooter>
    </table>

    <br/>
    <br/>
    <span style="text-align: center">FIRMA RESPONSABLE</span>
</div>


</body>
</html>

