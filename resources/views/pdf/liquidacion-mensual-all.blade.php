<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LIQUIDACION MENSUAL</title>
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
            margin: 0 auto;
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
        .page_break { page-break-before: always; }
    </style>
</head>

<body>
@foreach($data as $datos)
<div class="container">
    <div class="cabezera">
        <h4>Empres</h4>
        <span>rut</span> <span>Direccion</span>
    </div>
    <div class="titulo-mes">
        <h2 class="titulo">LIQUIDACION DE REMUNERACIONES</h2> <h2>JULIO</h2>  <h2>2022</h2>
    </div>
    <div class="linea-doble"></div>
    <div class="datos-laborales">
        <div class="nombre">
            <span>NOMBRE: <span style="font-weight: bold">PEDRO ARAYA DIAZ</span></span>
        </div>
        <table style="border: none;width: 100%;text-align: left">
            <tr>
                <td>RUT:</td>

                <td>16581137-8</td>
                <td></td>
                <td></td>
                <td>TIPO CONTRATO:</td>
                <td>INDEFINIDO</td>
            </tr>
            <tr>
                <td>CARGO:</td>
                <td>PRO</td>
                <td></td>
                <td></td>
                <td>FECHA INGRESO:</td>
                <td>OCHO</td>
            </tr>

        </table>
        <table style="width: 100%;border: none">
            <tr>
                <td>D/TRABAJADOS:</td>
                <td>30</td>
                <td>A.F.P</td>
                <td>AFP 6666</td>
                <td>INST.SALUD:</td>
                <td>FONASA 0.0</td>
            </tr>
        </table>
    </div>

    <div class="linea-doble"></div>
    <div class="cuerpo">
        <table style="width: 100%;border: none;font-size: 14px">
            <tr>
                <td style="font-weight: bold">DETALLES DE HABERES</td>
                <td style="font-weight: bold">DETALLE DE DESCUENTOS</td>
            </tr>
        </table>
    </div>
    <div class="linea-doble"></div>
    <div class="cuerpo">
        <table style="width: 100%;border: none;font-size: 12px;text-align: left">
            <tr>
                <td>
                    <!--HABERES-->
                    <table style="width: 100%;text-align: left">
                        <tr>
                            <td>SUELDO BASE</td>
                            <td>2000000</td>
                        </tr>
                        <!--BONOS-->
                        <tr>
                            <td>BONOS</td>
                            <td>661,000</td>
                        </tr>
                        <tr>
                            <td>BONOS</td>
                            <td>661,000</td>
                        </tr>
                        <!--FIN BONOS--->
                        <tr>
                            <td>GRATIF. MENSUAL</td>
                            <td>661,000</td>
                        </tr>
                    </table>
                    <!--HABERES-->
                    <table style="width: 100%;text-align: left">
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <!--BONOS-->
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>BONOS</td>
                            <td>661,000</td>
                        </tr>
                        <!--FIN BONOS--->
                        <tr>
                            <td>GRATIF. MENSUAL</td>
                            <td>661,000</td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table style="width: 100%;text-align: left">
                        <tr>
                            <td>T.FONDO PENSION</td>
                            <td>661,000</td>
                        </tr>
                        <tr>
                            <td>APORTE SALUD</td>
                            <td>661,000</td>
                        </tr>
                        <tr>
                            <td>T.LEYES SOCIALES</td>
                            <td>661,000</td>
                        </tr>
                    </table>
                    <table style="width: 100%;text-align: left">
                        <tr>
                            <td>T.FONDO PENSION</td>
                            <td>661,000</td>
                        </tr>
                        <tr>
                            <td>APORTE SALUD</td>
                            <td>661,000</td>
                        </tr>
                        <tr>
                            <td>T.LEYES SOCIALES</td>
                            <td>661,000</td>
                        </tr>
                    </table>
                </td>

            </tr>
        </table>

        <table style="margin-top:150px;width: 100%;border: none;font-size: 12px;text-align: left;font-weight: bold">
            <tr>
                <td>TOTAL HABERES</td>
                <td>1,070,240</td>
                <td>TOTAL DESCUENTOS</td>
                <td>334,162</td>
            </tr>
        </table>



    </div>
    <div class="linea-doble" style="margin-top: 150px"></div>
    <div class="cuerpo">
        <table style="width: 100%;border: none;font-size: 12px;text-align: left;font-weight: bold">
            <tr>
                <td style="color: #fff">TOTAL HABERES PRUEBAS</td>
                <td STYLE="color: #fff">TOTAL HABERES</td>
                <td>LIQUIDO A PAGAR</td>
                <td>334,162</td>
            </tr>
        </table>
    </div>
    <div class="linea-doble" ></div>
    <div class="cuerpo">
        <table style="width: 100%;border: none;font-size: 12px;text-align: left;font-weight: bold">
            <tr>
                <td>Certifico que he recibido</td>
                <td>la suma de:</td>
                <td style="font-weight: bold">736,078</td>
                <td style="font-weight: bold">setenciento treinta y siete mil setenta y ocho</td>
            </tr>
        </table>
        <p style="display: block;max-width: 600px;font-size: 12px;text-align: left;margin-left: 50px;margin-top: 15px">
            a mi entera satisfaccion y no tengo cargo ni cobro alguno posterior que hacer,<br>
            por ninguno de los conceptos comprendidos en esta liquidacion
        </p>
    </div>
    <div class="cuerpo" style="margin-top: 20px;margin-bottom: 50px">
        <table style="width: 100%;border: none;font-size: 12px;text-align: left;font-weight: bold">
            <tr>
                <td style="color:#fff;">  a mi entera satisfaccion y no tengo cargo</td>
                <td style="color: #fff">  a mi entera satisfaccion y </td>
                <td style="text-align: center">
                    <div style="border: 1px solid #000;width: 150px;margin: -10px auto"></div>
                    RECIBE CONFORME
                </td>
            </tr>
        </table>
    </div>
</div>

<div class="page_break"></div>

@endforeach
</body>
</html>
