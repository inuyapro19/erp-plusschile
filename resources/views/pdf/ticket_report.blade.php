<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Diario de Ticket</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<h1>Reporte Diario de Tickets</h1>
<table class="table">
    <thead>
    <tr>
        <th>N° de Lista de Verificación</th>
        <th>N° INTERNO</th>
        <th>PLACA PATENTE</th>
        <th>Fecha Inspección</th>
        <th>Hora de chequeo</th>
        <th>Estado del Vehículo</th>
        <th>Condición Sub-Estándar</th>
        <th>Tickets Abiertos</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($tickets as $ticket)
        <tr>
            <td>{{ $ticket->{'N° de Lista de Verificación'} }}</td>
            <td>{{ $ticket->{'N° INTERNO'} }}</td>
            <td>{{ $ticket->{'PLACA PATENTE'} }}</td>
            <td>{{ $ticket->{'Fecha Inspección'} }}</td>
            <td>{{ $ticket->{'Hora de chequeo'} }}</td>
            <td>{{ $ticket->{'Estado del Vehículo'} }}</td>
            <td>{{ $ticket->{'Condición Sub-Estándar'} }}</td>
            <td>{{ $ticket->{'Tickets Abiertos'} }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
