
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Comprobante vacaciones</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <style>
        .border{
            border:1px solid #000000!important;
            padding: 2px;
        }
        td,p,tr{
            margin:0;
            padding: 0;
            font-size: 12px;
        }
    </style>
</head>
<body>
{!!  $documento !!}
 {{-- <div class="container-fluid border py-2 px-2">

           <table class="table table-bordered ">
               <tr class="border">
                   <td colspan="3"></td>
                   <td colspan="3"></td>
                   <td colspan="3"></td>
                   <td colspan="3"></td>
                   <td colspan="2"><p style="text-align: center">COMPROBANTE VACACIONES</p> </td>

               </tr>

               <tr class="border">
                   <td colspan="3"></td>
                   <td colspan="3"></td>
                   <td colspan="3"></td>
                   <td colspan="3"></td>
                   <td><p style="text-align: center">Versión: 1</p></td>
                   <td><p style="text-align: center">Código: DRH – F-03</p></td>
               </tr>
               <tr class="border">
                   <td colspan="3"></td>
                   <td colspan="3"></td>
                   <td colspan="3"></td>
                   <td colspan="3"></td>
                   <td colspan="2"> <p style="text-align: center">Fecha Versión : 08/08/2016</p></td>

               </tr>
           </table>
           <p style="text-align: center;font-weight: bold;text-decoration: underline;margin-bottom: 30px">COMPROBANTE SOLICITUD DE VACACIONES  </p>

           <table class="table table-bordered border">
               <tr>
                   <td>Nombre Trabajador </td>
                   <td>%nombre%</td>
                   <td colspan="2">%apellidos%</td>
               </tr>
               <tr>
                   <td>Rut</td>
                   <td>%rut%</td>
                   <td>Cargo:    </td>

                   <td>%cargo%</td>
               </tr>
               <tr>
                   <td>Empleador</td>
                   <td colspan="3">%empleador%</td>
               </tr>
               <tr>
                   <td>Días Hábiles Solicitados </td>

                   <td>%dias_habiles_solicitados%</td>
                   <td>Días Corridos del Periodo de Vac.  </td>

                   <td>%dias_corrido_perido%</td>
               </tr>
               <tr>
                   <td>Fecha Primer Día</td>
                   <td>%fecha_primer_dia%</td>
                   <td> Fecha Ultimo Día </td>
                   <td>%fecha_ultimo_dia%</td>
               </tr>
               <tr>
                   <td>Saldo Previo Vacaciones</td>
                   <td>%saldo_previo_vacaciones%</td>
                   <td>Fecha Corte Calculo</td>
                   <td>%fecha_corte_calculo%</td>
               </tr>
               <tr>
                   <td>Saldo Después de Vacacaciones </td>
                   <td>%saldo_despues_vacaciones%</td>
                   <td>Fecha Corte Calculo</td>
                   <td>%fecha_corte_calculo%</td>
               </tr>
           </table>

           <table class="table" border="0" style="border: none;margin-top: 50px">
               <tr>
                   <td></td>
                   <td>
                       <div class="border-top"></div>
                       <br>
                       <p class="text-center">Autorización Jefe Directo <br> Nombre y Firma </p>

                   </td>
                   <td></td>
                   <td></td>
                   <td>
                       <div class="border-top"></div>
                       <br>
                       <p class="text-center">Firma Trabajador</p>
                   </td>
                   <td></td>
               </tr>
           </table>
      <table class="table">
          <tr>
              <td> VºBº RRHH	</td>
              <td></td>
              <td>Fecha Recepción</td>
              <td></td>
          </tr>
      </table>

      <p class="text-left">Observaciones</p>
        <div class="border" style="width: 100%;height: 150px">

        </div>

  </div>--}}
</body>
</html>
