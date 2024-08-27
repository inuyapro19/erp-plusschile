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
    <tr>
        <th>#</th>
        <th>CÓDIGO TRABAJADOR</th>
        <th>RUT</th>
        <th>PRIMER NOMBRE</th>
        <th>SEGUNDO NOMBRE</th>
        <th>PRIMER APELLIDO</th>
        <th>SEGUNDO APELLIDO</th>
        <th>FECHA DE NACIMIENTO</th>
        <th>GRADO ESCOLARIDAD</th>
        <th>ESTADO CIVIL</th>
        <th>TELEFONO LOCAL</th>
        <th>TELEFONO CELULAR</th>
        <th>EMAIL</th>
        <th>SEXO</th>
        <th>DIRECCION</th>
        <th>COMUNA ID</th>
        <th>COMUNA</th>
        <th>REGION ID</th>
        <th>REGION</th>
        <th>NACIONALIDAD_ID</th>
        <th>NACIONALIDAD</th>
        <th>PERTENECE A PUEBLO ORI</th>
        <th>PUEBLO_ORIGINARIO_ID</th>
        <th>PUEBLO ORIGINARIO</th>
        <th>POSEE CARGA FAMILIAR</th>
        <th>POSEE DISCAPACIDAD</th>
        <th>EMPLEADOR ID</th>
        <th>EMPLEADOR</th>
        <th>AREA ID</th>
        <th>AREA</th>
        <th>CARGO ID</th>
        <th>CARGO</th>
        <th>UBICACION ID</th>
        <th>UBICACION</th>
        <th>FECHA INGRESO</th>
        <th>FECHA ANTIGUIDAD</th>
        <th>FECHA PRIMER VENCIMIENTO</th>
        <th>FECHA SEGUNDO VENCIMIENTO</th>
        <th>CENTRO COSTO</th>
        <th>TIPO CONTRATO</th>
        <th>TIPO JORNADA</th>
        <th>JORNADA EXCEPCIONAL</th>
        <th>SALUD ID</th>
        <th>ENTIDAD DE SALUD</th>
        <th>PREVISION ID</th>
        <th>ENTIDAD PREVISIONAL</th>
    </tr>
    </thead>
    <tbody>
        @foreach($trabajadores as $trabajador)
            <tr>
               <td>{{ $trabajador->TRABAJADOR_ID }}</td>
                <td>{{ $trabajador->CODIGO_TRABAJADOR }}</td>
                <td>{{ $trabajador->RUT }}</td>
                <td>{{ $trabajador->PRIMER_NOMBRE }}</td>
                <td>{{ $trabajador->SEGUNDO_NOMBRE }}</td>
                <td>{{ $trabajador->PRIMER_APELLIDO }}</td>
                <td>{{ $trabajador->SEGUNDO_APELLIDO }}</td>
                <td>{{$trabajador->FECHA_NAC}}</td>
                <td>{{$trabajador->GRADO_ESCOLARIDAD}}</td>
                <td>{{$trabajador->ESTADO_CIVIL}}</td>
                <td>{{$trabajador->TELEFONO_LOCAL}}</td>
                <td>{{$trabajador->TELEFONO_CELULAR}}</td>
                <td>{{$trabajador->CORREO_ELECTRONICO}}</td>
                <td>{{$trabajador->SEXO}}</td>
                <td>{{$trabajador->DIRECCION}}</td>
                <td>{{$trabajador->COMUNA_ID}}</td>
                <td>{{$trabajador->NOMBRE_COMUNA}}</td>
                <td>{{$trabajador->REGION_ID}}</td>
                <td>{{$trabajador->NOMBRE_REGION}}</td>
                <td>{{$trabajador->NACIONALIDAD_ID}}</td>
                <td> Sin nacionalidad </td>
                <td>{{$trabajador->PERTENECE_A_PUEBLO_ORI}}</td>
                <td>{{$trabajador->PUEBLO_ORIGINARIO_ID}}</td>
                <td>Sin pueblo originario</td>
                <td>{{$trabajador->POSEE_CARGA_FAMILIAR}}</td>
                <td>{{$trabajador->POSEE_DISCAPACIDAD}}</td>
                <td>{{$trabajador->EMPLEADOR_ID}}</td>
                <td>{{$trabajador->NOMBRE_EMPLEADOR}}</td>
                <td>{{$trabajador->AREA_ID}}</td>
                <td>{{$trabajador->NOMBRE_AREA}}</td>
                <td>{{$trabajador->CARGO_ID}}</td>
                <td>{{$trabajador->NOMBRE_CARGO}}</td>
                <td>{{$trabajador->UBICACION_ID}}</td>
                <td>{{$trabajador->NOMBRE_UBICACION}}</td>
                <td>{{$trabajador->FECHA_INGRESO}}</td>
                <td>{{$trabajador->FECHA_ANTIGUIDAD}}</td>
                <td>{{$trabajador->FECHA_PRIMER_VENCIMIENTO}}</td>
                <td>{{$trabajador->FECHA_SEGUNDO_VENCIMIENTO}}</td>
                <td>{{$trabajador->CENTRO_COSTO}}</td>
                <td>{{$trabajador->TIPO_CONTRATO}}</td>
                <td>{{$trabajador->TIPO_JORNADA}}</td>
                <td>{{$trabajador->JORNADA_EXCEPCIONAL}}</td>
                <td>{{$trabajador->SALUD_ID}}</td>
                <td>{{$trabajador->ENTIDAD_DE_SALUD}}</td>
                <td>{{$trabajador->PREVISION_ID}}</td>
                <td>{{$trabajador->ENTIDAD_PREVISIONAL}}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
