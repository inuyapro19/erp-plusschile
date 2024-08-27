<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lista de trabajadores</title>

</head>
<body>
<table>
    <thead>
    <tr style="background-color: #365244;color: #ffffff">
        <th>#</th>
        <th>RUT</th>
        <th>NOMBRE</th>
        <th>CARGO</th>
        <th>EMPLEADOR</th>
        <th>CODIGO BONO</th>
        <th>MES( NUMERICO )</th>
        <th>AÑO</th>
        <th>MONTO ASIGNADO</th>
    </tr>
    </thead>
    <tbody>
    @foreach($trabajadores as $trabajador)
        <tr>
            <td>{{$trabajador->ID_TRABAJADOR}}</td>
            <td>{{$trabajador->RUT}}</td>
            <td>{{$trabajador->NOMBRE_COMPLETO}}</td>
            <td>{{$trabajador->CARGO}}</td>
            <td>{{$trabajador->EMPLEADOR}}</td>
            <td>2525</td>
            <td>1</td>
            <td>{{date('Y')}}</td>
            <td>200000</td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>
