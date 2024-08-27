<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Exportar checklist</title>
</head>
<body>
<table>
    <thead>
    <tr>
        <th>CHECKLIST_ID</th>
        <th>TIPO_SERVICIO</th>
        <th>CATEGORIA</th>
        <th>USER_ID</th>
        <th>BUS_ID</th>
        <th>NRO_BUS</th>
        <th>PATENTE</th>
        <th>BUS</th>
        <th>OBSERVACIONES</th>
        <th>FECHA</th>
        <th>HORA_SALIDA</th>
        <th>DESTINO_ID</th>
        <th>DESTINO</th>
        <th>NOMBRE_USUARIO</th>
        <th>FOLIO</th>
        <th>STATUS</th>
        <th>SIGNED_STATUS</th>
        <th>FECHA_CREACION</th>
        <th>FECHA_ACTUALIZACION</th>
    </tr>
    </thead>
    <tbody>
    @foreach($checklists as $checklist)
        <tr>
            <td>{{ $checklist->CHECKLIST_ID }}</td>
            <td>{{ $checklist->TIPO_SERVICIO }}</td>
            <td>{{ $checklist->CATEGORIA }}</td>
            <td>{{ $checklist->USER_ID }}</td>
            <td>{{ $checklist->BUS_ID }}</td>
            <td>{{ $checklist->NRO_BUS }}</td>
            <td>{{ $checklist->PATENTE }}</td>
            <td>{{ $checklist->BUS }}</td>
            <td>{{ $checklist->OBSERVACIONES }}</td>
            <td>{{ $checklist->FECHA }}</td>
            <td>{{ $checklist->HORA_SALIDA }}</td>
            <td>{{ $checklist->DESTINO_ID }}</td>
            <td>{{ $checklist->DESTINO }}</td>
            <td>{{ $checklist->NOMBRE_USUARIO }}</td>
            <td>{{ $checklist->FOLIO }}</td>
            <td>{{ $checklist->STATUS }}</td>
            <td>{{ $checklist->SIGNED_STATUS }}</td>
            <td>{{ $checklist->FECHA_CREACION }}</td>
            <td>{{ $checklist->FECHA_ACTUALIZACION }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
