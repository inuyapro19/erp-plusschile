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
        }

        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .table th {
            background-color: #f2f2f2;
            text-align: left;
        }
    </style>
</head>
<body>
<h1>Tickets Asignados</h1>

<p>Estimados,</p>
<p>A continuación, encontrará una lista de los tickets del bus nº
    <strong>{{$buses->numero_bus}}</strong> - <strong>{{$buses->patente}}</strong>,
    correspondientes al checklist con folio
    <strong>{{$folio}}</strong>, que se le han asignado:</p>


<table class="table">
    <thead>
    <tr>
        <th>Nro Ticket</th>
        <th>Título</th>
        <th>Descripción</th>
        <th>Prioridad</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($tickets as $ticket)
        <tr>
            <td>{{ $ticket->nro_ticket }}</td>
            <td>{{ $ticket->title }}</td>
            <td>{{ $ticket->description }}</td>
            <td>{{ $ticket->priority }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<p>Por favor, gestione estos tickets a la mayor brevedad posible.</p>
<p>Para más detalles del ticket y realizar la gestion debe ingresar al siguiente <a href="http://intranet.plusschile.cl"
                                                                                    style="color: blue; text-decoration: underline;">Enlance</a>.
</p>
<p>Saludos,</p>
<p>El Equipo de Calidad de Servicio</p>
</body>
</html>
