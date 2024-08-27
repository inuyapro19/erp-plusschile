<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DIAS LIBRES</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
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
        table{
            max-width:750px!important
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
    </style>
</head>
<body>
<div style="width:700px;padding:20px">
    <h3 style="font-size:12px;text-align:left;font-weight: bold">{{$gestion->EMPLEADOR}}</h3>
    <table style="border:none;width:100%;margin-bottom:30px;width: 100%">
        <tr>
            <td><span style="font-weight: bold">Fono:</span> +562 26419926</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Manuel rengifo 1230</td>
            <td></td>
            <td><span style="font-weight: bold">Nº FOLIO:</span> {{$gestion->GESTION_ID}}</td>
        </tr>
    </table>
    <h3 style="font-size:15px;text-align:center">REGISTRO DE DESCANSO</h3>
    <h3 style="font-size:15px;text-align:center">CONDUCTORES Y AUXILIARES</h3>

    &nbsp; <table style="border:none;width:100%;margin-bottom:30px">
        <tr>
            <td><span style="font-weight: bold"> TRABAJADOR:</span> {{$gestion->NOMBRE_COMPLETO}}</td>

        </tr>
        <tr>
            <td> <span style="font-weight: bold">Nº RUN:</span> {{$gestion->RUT}}</td>
            <td><span style="font-weight: bold">CARGO:</span> {{$gestion->CARGO}}</td>
        </tr>
        <tr>
            <td> <span style="font-weight: bold">FECHA INICIO: </span> {{  \Carbon\Carbon::parse($gestion->FECHA_INICIAL)->format('d/m/Y') }}</td>
            <td><span style="font-weight: bold"> FECHA FIN: </span> {{ \Carbon\Carbon::parse($gestion->FECHA_TERMINO)->format('d/m/Y') }}</td>
            <td> <span style="font-weight: bold">Dias:</span> {{$gestion->NUMERO_DIAS}}</td>
        </tr>



    </table>

    <table style="width: 100%;margin-top: 50px">
        <tr>
            <td>
                <span style="font-weight: bold">FECHA EN QUE DEBE INCORPORARSE:</span> {{ \Carbon\Carbon::parse($gestion->FECHA_RETORNO)->format('d/m/Y') }}
            </td>
            <td>
                <div class="centrado">

                    <div class="linea"></div>
                    <p>Firma trabajador</p>
                </div>
            </td>
            <td>   </td>
        </tr>
    </table>

  <table style="border:none;width:100%;margin-bottom:30px;margin-top: 100px">
      <tr>
          <td>
              <span style="font-weight: bold"> SE DEJA CONSTACIA QUE EL <br>TRABAJADOR SE REINCORPORA A <br> LABORES EL DIA:</span>
          </td>
          <td>
              <div class="linea" style="width: 150px;"></div>
          </td>
          <td>
              <div class="centrado">
                  <div class="linea" style="width: 150px"></div>
                  <p>Firma trabajador</p>
              </div>
          </td>
      </tr>
  </table>

    &nbsp; <table style="border:none;width:100%;margin-bottom:30px">
            <tr>
                <td>NOTAS:</td>
                <td>
                    <p style="color: #fff;margin-bottom: 0">Hola</p>
                    <div class="linea" style="width: 600px!important;margin: 10px!important;"></div>
                </td>

            </tr>
      </table>
    <table style="border:none;width:100%;margin-bottom:30px;margin-top: 100px">
        <tr>
            <td>{{$fecha_hoy}}</td>
            <td>{{$hora_actual}}</td>
            <td>
                <div class="centrado">
                    <div class="linea" style="width: 150px"></div>
                    <p>{{$username}}</p>
                </div>
            </td>
        </tr>
    </table>


</div>


</body>
</html>

