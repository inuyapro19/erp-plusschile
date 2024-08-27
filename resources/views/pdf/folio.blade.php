<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Folio {{$folio->nro_folio}}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
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
            font-size: 15px;
        }
        td,p,tr{
            margin:0;
            padding: 0;
            font-size: 12px;
        }
        .table td, .table th {
            padding: 0.75rem ;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }
        .tabla-ventas{
            width: 100%;
            border-collapse: collapse;
            border:1px solid #000000!important;
            margin-top: 30px;
        }

        .tabla-ventas th{
            border: 1px solid #000!important;
            padding: 5px;
            text-align: center;
        }
        .tabla-ventas td{
            border: 1px solid #000!important;
            padding: 5px;
        }
        .tabla-ventas .text-right{
            text-align: right;
        }

    </style>
</head>
<body>
<div style="width:700px;padding:20px">
   <h3 style="font-size:18px;text-align:center"> COMPROBANTE DE AUTORIZACION DE DINERO PARA PEAJES</h3>
    <table style="width: 100%">
        <tr>
            <td>
                <span style="font-weight: bold;">BUSES PLUSSCHILE</span>
            </td>
            <td  style="text-align: right;font-weight: bold;font-size: 18px">
                &nbsp; N# {{$folio->nro_folio}}
            </td>
        </tr>
    </table>
   &nbsp; <table style="border:none;width:100%;margin-bottom:30px">

        <tr>
            <td> <span style="font-weight: bold;">VIAJE N:</span>     {{$folio->viaje->nro_viaje}}</td>
            <td><span style="font-weight: bold;">FECHA:</span>        {{$folio->viaje->fecha_viaje}}</td>
            <td><span style="font-weight: bold;">Ingresado por:</span>  {{$folio->user->name.' '.$folio->user->apellidos}}</td>
        </tr>

        <tr>
            <td> <span style="font-weight: bold;">Origen:</span>      {{$folio->viaje->origen->ciudad}}</td>
            <td> <span style="font-weight: bold;">HORA SALIDA:</span> {{$folio->viaje->hora_salida}}</td>
            <td> <span style="font-weight: bold;">Cantidad:</span>    ${{number_format($folio->monto_asignado,0,',','.')}}</td>
        </tr>

        <tr>
            <td>
                <span style="font-weight: bold;">Destino:</span>{{$folio->viaje->destino->ciudad}}
            </td>
            <td>   </td>
            <td>   </td>
        </tr>

        <tr>
            <td> <span style="font-weight: bold;">Bus:</span> {{$folio->viaje->bus->numero_bus}}</td>
            <td><span style="font-weight: bold;">Patente:</span> {{$folio->viaje->bus->patente}}</td>
            <td><span style="font-weight: bold;">Tipo servicio: </span> {{$folio->viaje->tipo_viaje}}</td>
        </tr>
    </table>

    <table style="border:none;width:60%">
        @foreach($folio->viaje->trabajadores as $trabajador)
            <tr>
                <td style="font-weight: bold;">{{ $trabajador->contrato->cargo->nombre_cargo == 'Conductor de Buses' ? 'Conductor: ' : 'Auxiliar: '  }}</td>
                <td>{{$trabajador->primer_nombre.' '.$trabajador->segundo_nombre.' '.$trabajador->primer_apellido.' '.$trabajador->segundo_apellido}}</td>
                <td><span style="font-weight: bold;">Rut: </span> {{$trabajador->rut}}</td>
                <td>   </td>
            </tr>
        @endforeach
    </table>


            <table  class="tabla-ventas">
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

    <div class="cuerpo" style="margin-top: 20px;margin-bottom: 150px">
        <table style="width: 100%;border: none;font-size: 12px;text-align: left;font-weight: bold">
            <tr>
                <td style="color:#000;">Observaciones:  </td>
                <td style="color: #fff">   </td>
                <td style="text-align: center">
                    {{$folio->viaje->nota_viaje}}
                </td>
            </tr>
        </table>
    </div>

    <div class="cuerpo" style="margin-top: 50px;margin-bottom: 200px">
        <table style="width: 100%;border: none;font-size: 12px;text-align: left;font-weight: bold">
            <tr>
                <td style="color:#000;text-align: center">
                    <div style="border: 1px solid #000;width: 150px;margin: -30px auto"></div>
                    Conductor
                </td>
                <td style="color: #000;text-align: center">
                    <div style="border: 1px solid #000;width: 150px;margin: -30px auto"></div>
                    Agente de venta Nº1
                </td>
                <td style="text-align: center">
                    <div style="border: 1px solid #000;width: 150px;margin: -30px auto"></div>
                    Agente de venta Nº2
                </td>
            </tr>
        </table>
    </div>

    <div class="cuerpo" style="margin-top: 20px;margin-bottom: 20px">
        <table style="width: 100%;border: none;font-size: 12px;text-align: left;font-weight: bold">
            <tr>
                <td style="color:#000;text-align: center">
                    <div style="border: 1px solid #000;width: 150px;margin: -30px auto"></div>
                    JEFE DE OPERACIONES
                </td>
                <td style="color: #000;text-align: center">
                    <div style="border: 1px solid #000;width: 150px;margin: -30px auto"></div>
                    Agente de venta Nº3
                </td>
                <td style="text-align: center">
                    <div style="border: 1px solid #000;width: 150px;margin: -30px auto"></div>
                    Agente de venta Nº4
                </td>
            </tr>
        </table>
    </div>



    <div style="width: 100%;height: 100px"></div>

</div>


</body>
</html>
