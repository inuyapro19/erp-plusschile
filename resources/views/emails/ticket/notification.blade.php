<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 15px;
        }

        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .table th {
            background-color: #f2f2f2;
            text-align: center;
        }
    </style>
</head>
<body>
<h1>Reporte del día del Departamento de {{$departamento}}</h1>
<p>A continuación se muestra el reporte del día:</p>

<table class="table">
    <thead>
    <tr>
        <th rowspan="2">FOLIO CHECKLIST</th>
        <th rowspan="2">NRO BUS</th>
        <th rowspan="2">PATENTE</th>
        <th rowspan="2">FECHA</th>
        <th colspan="9">ITEM CON INCIDENCIA</th>
    </tr>
    <tr>
        <th>NRO TICKET</th>
        <th>ITEM</th>
        <th>CATEGORÍA</th>
        <th>REPORTADO POR</th>
        <th>RESPUESTA</th>
        <th>VALOR</th>
        <th>OBSERVACIONES</th>
        <th>RESPUESTA ADICIONAL</th>
        <th>CRITICAL</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($tickets as $checklist)
        @php $rowSpan = count($checklist['items']); @endphp
        @foreach ($checklist['items'] as $index => $item)
            <tr>
                @if ($index == 0)
                    <td rowspan="{{ $rowSpan }}">{{ $checklist['folio'] }}</td>
                    <td rowspan="{{ $rowSpan }}">{{ $checklist['nro_bus'] }}</td>
                    <td rowspan="{{ $rowSpan }}">{{ $checklist['patente'] }}</td>
                    <td rowspan="{{ $rowSpan }}">{{ $checklist['fecha'] }}</td>
                @endif
                <td>{{ $item['nro_ticket'] }}</td>
                <td>{{ $item['item'] }}</td>
                <td>{{ $item['categoria']}}</td>
                <td>{{ $item['reportado_por'] }}</td>
                <td>{{ $item['respuesta']}}</td>
                <td>{{ $item['valor'] != 'null' ? $item['valor'] : '-' }}</td>
                <td>{{ $item['observaciones'] }}</td>
                <td>{{ $item['respuesta_adicional'] }}</td>
                <td>{{ $item['critical'] === 'approved with observation' ? 'Aprobado con observaciones' : 'Rechazado' }}</td>
            </tr>
        @endforeach
    @endforeach
    </tbody>
</table>



<p>Por favor, gestione estos tickets a la mayor brevedad posible.</p>
<p>Para más detalles del ticket y realizar la gestion debe ingresar al siguiente <a href="http://intranet.plusschile.cl"
                                                                                    style="color: blue; text-decoration: underline;">Enlance</a>.
</p>
<p>Saludos,</p>
<p>El Equipo de {{$departamento}}</p>
</body>
</html>
