<!DOCTYPE html>
<html dir="ltr">
<head>
    <title>Folio {{$folio->nro_folio}}</title>
    <meta charset="UTF-8">
    <style>
        *{
            margin: 0;
            padding: 0;
        }
        body{
            font-family: Arial, Helvetica, sans-serif;
            color: #000;
        }

        .container{
            max-width: 800px;
            margin: 20px auto;

        }
        .cabezera{
            margin: 50px 50px 10px 50px;
            text-align: left;
        }

        .cabezera h4{
            text-align: left;
            color: #000;
            margin: 0;
            padding: 0;
            font-size: 12px;
            width: 350px;
            font-weight: bolder;
        }
        .cabezera span{
            font-size: 11px;
            width: 250px;
            display: inline-block;
        }
        .titulo-mes {
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .titulo-mes .titulo{
            width: 500px;
            text-align: right;
        }
        .titulo-mes h2{
            font-size: 14px;
            display: inline-block;
            width: 100px;
            text-align: right;
        }
        .linea-doble{
            border: 1px #000 solid;
            height: 1px;
            width: 100%;
            margin: 10px 100px 10px 100px;
        }
        .datos-laborales{
            font-size: 10px;
            margin: 10px 100px 10px 100px;
            width: 100%;
        }
        .nombre{
            width: 100%;
        }
        .filas1{
            font-size: 10px;
            margin: 10px 100px 10px 100px;
            width: 100%;
        }
        .filas1 .columna1{
            display: inline-block;
            width: 325px;
        }
        .filas1 .columna1 span{
            display: inline-block;
            width: 45%;
        }
        .filas1 .columna2{
            display: inline-block;
            width: 325px;
        }
        .filas1 .columna2 span{
            display: inline-block;
            width: 45%;
        }
        .cuerpo{
            margin: 0px 50px 0px 50px;
            text-align: center;
        }
        .cuerpo table{
            margin: 0px 50px 0px 50px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div style="width:100%">
            <h2 style="text-align:center;font-size:15px"> COMPROBANTE DE AUTORIZACION DE DINERO PARA PEAJES</h2>
        </div>
        <div class="datos-laborales">
            <table style="border: none;width: 100%;text-align: left">
                <tr>
                    <td></td>
                    <td>BUSES PLUSSCHILE</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td> N# {{$folio->nro_folio}}</td>
                </tr>
            </table>
            <table style="border: none;width: 100%;text-align: left">
                <tr>
                    <td>VIAJE N:     {{$folio->viaje->nro_viaje}}</td>
                    <td>FECHA:        {{$folio->viaje->fecha_viaje}}</td>
                    <td>Ingresado por:  {{$folio->user->name.' '.$folio->user->apellidos}}</td>
                </tr>

                <tr>
                    <td> Origen:      {{$folio->viaje->origen->ciudad}}</td>
                    <td> HORA SALIDA: {{$folio->viaje->hora_salida}}</td>
                    <td> Cantidad:    ${{number_format($folio->monto_asignado,0,',','.')}}</td>
                </tr>
                <tr>
                    <td>
                        Destino:{{$folio->viaje->origen->ciudad}}
                    </td>
                    <td>   </td>
                    <td>   </td>
                </tr>

                <tr>
                    <td> Bus: {{$folio->viaje->bus->numero_bus}}</td>
                    <td>Patente: {{$folio->viaje->bus->patente}}</td>
                    <td>Tipo servicio: {{$folio->viaje->tipo_viaje}}</td>
                </tr>
            </table>

            <table style="border:none;width:60%">
                @foreach($folio->viaje->trabajadores as $trabajador)
                    <tr>
                        <td>Conductor: {{$trabajador->primer_nombre.' '.$trabajador->primer_apellido}}</td>
                        <td>Rut: {{$trabajador->rut}}</td>
                        <td>   </td>
                    </tr>
                @endforeach
            </table>

            <table  style="border: 0!important;width:100%;margin-top:20px">
                <thead>
                <tr>
                    <th>Nº</th>
                    <th>Nombre agente de ventas</th>
                    <th>Nº caja</th>
                    <th>Oficina</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Cantidad de dinero entregado</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Total Entregado</td>
                    <td></td>
                </tr>
                </tbody>

            </table>



        </div>

    </div>
</body>
</html>
