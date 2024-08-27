<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Exportar ticket</title>
</head>
<body>
<table>
    <thead>
    <tr>
        <th>TICKET_ID</th>
        <th>NRO_TICKET</th>
        <th>BUS</th>
        <th>TITULO</th>
        <th>DESCRIPCION</th>

        <th>CATEGORIA</th>
        <th>REPORTADO_POR</th>
        <th>ASIGNADO_A</th>

        <th>FECHA_CREACION</th>
        <th>FECHA_ACTUALIZACION</th>
        <th>AREA_DESCRIPCION</th>
        <th>PRIORIDAD</th>
        <th>ESTADO</th>
        <th>ESTADO_VALIDACION</th>

    </tr>
    </thead>
    <tbody>
        @foreach($tickets as $ticket)
            <tr>
                <td>{{ $ticket->TICKET_ID }}</td>
                <td>{{ $ticket->NRO_TICKET }}</td>
                <td>{{ $ticket->BUS }}</td>
                <td>{{ $ticket->TITULO }}</td>
                <td>{{ $ticket->DESCRIPCION }}</td>

                <td>{{ $ticket->CATEGORIA }}</td>

                <td>{{ $ticket->REPORTADO_POR }}</td>
                <td>{{ $ticket->ASIGNADO_A }}</td>

                <td>{{ $ticket->FECHA_CREACION }}</td>
                <td>{{ $ticket->FECHA_ACTUALIZACION }}</td>


                <td>{{ $ticket->AREA_DESCRIPCION }}</td>
                <td>{{ $ticket->ESTADO }}</td>
                <td>{{ $ticket->PRIORIDAD }}</td>
                <td>{{ $ticket->ESTADO_VALIDACION }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>
