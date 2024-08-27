<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Licencia Medica</title>
</head>
<body>

    <p>
        Nueva licencia medica ingresada , para el trabajador :<br>
            RUT   :  {{$rut ?? ''}} <br>
            Nombre:  {{$nombre_completo ?? ''}} <br>
            Fecha inicio:  {{$fecha_inicio ?? ''}} <br>
            Fecha fin:   {{$fecha_fin ?? ''}} <br>
    </p>

</body>
</html>
