create view auxiliares_status_view as
select (select count(0)
        from (`erppluss`.`trabajadores` `tr` join `erppluss`.`contrato` `c` on ((`tr`.`id` = `c`.`trabajador_id`)))
        where ((`c`.`cargo_id` = 2) and (`tr`.`condicion` = 'disponible')))       AS `DISPONIBLE`,
       (select count(0)
        from (`erppluss`.`trabajadores` `tr` join `erppluss`.`contrato` `c` on ((`tr`.`id` = `c`.`trabajador_id`)))
        where ((`c`.`cargo_id` = 2) and (`tr`.`condicion` = 'dias libre')))       AS `DIAS_LIBRES`,
       (select count(0)
        from (`erppluss`.`trabajadores` `tr` join `erppluss`.`contrato` `c` on ((`tr`.`id` = `c`.`trabajador_id`)))
        where ((`c`.`cargo_id` = 2) and (`tr`.`condicion` = 'vacaciones')))       AS `VACACIONES`,
       (select count(0)
        from (`erppluss`.`trabajadores` `tr` join `erppluss`.`contrato` `c` on ((`tr`.`id` = `c`.`trabajador_id`)))
        where ((`c`.`cargo_id` = 2) and (`tr`.`condicion` = 'falla')))            AS `FALLA`,
       (select count(0)
        from (`erppluss`.`trabajadores` `tr` join `erppluss`.`contrato` `c` on ((`tr`.`id` = `c`.`trabajador_id`)))
        where ((`c`.`cargo_id` = 2) and (`tr`.`condicion` = 'licencia médica')))  AS `LICENCIA_MEDICA`,
       (select count(0)
        from (`erppluss`.`trabajadores` `tr` join `erppluss`.`contrato` `c` on ((`tr`.`id` = `c`.`trabajador_id`)))
        where ((`c`.`cargo_id` = 2) and (`tr`.`condicion` = 'en ruta')))          AS `EN_RUTA`,
       (select count(0)
        from (`erppluss`.`trabajadores` `tr` join `erppluss`.`contrato` `c` on ((`tr`.`id` = `c`.`trabajador_id`)))
        where ((`c`.`cargo_id` = 2) and (`tr`.`condicion` = 'permiso especial'))) AS `PERMISO_ESPECIAL`;

create view bonos_view as
select `erppluss`.`bono_haberes`.`id`                   AS `ID`,
       `erppluss`.`bono_haberes`.`descripcion`          AS `DESCRIPCION`,
       `erppluss`.`bono_haberes`.`monto`                AS `MONTO`,
       `erppluss`.`bono_haberes`.`tipo`                 AS `TIPO`,
       `erppluss`.`bono_haberes`.`clasificacion`        AS `CLASIFICACION`,
       `erppluss`.`bono_haberes`.`aplica_gratificacion` AS `APLICA_GRATIFICACION`,
       `erppluss`.`bono_haberes`.`aplica_hora_extra`    AS `APLICA_HORA_EXTRA`,
       `erppluss`.`bono_haberes`.`aplica_anticipable`   AS `APLICA_ANTICIPABLE`,
       `erppluss`.`bono_haberes`.`estado`               AS `ESTADO`
from `erppluss`.`bono_haberes`
where (`erppluss`.`bono_haberes`.`categoria` = 'BONOS');

create view buses_view as
select `b`.`id`                        AS `ID`,
       `b`.`marca_chasis`              AS `MARCA_CHASIS`,
       `b`.`modelo_chasis`             AS `MODELO_CHASIS`,
       `b`.`numero_carroceria`         AS `NUMERO_CARROCERIA`,
       `b`.`marca_carroceria`          AS `MARCA_CARROCERIA`,
       `b`.`modelo_carroceria`         AS `MODELO_CARROCERIA`,
       `b`.`patente`                   AS `PATENTE`,
       `b`.`tipo_bus`                  AS `TIPO_BUS`,
       `b`.`numero_piso`               AS `NUMERO_PISO`,
       `b`.`empleador_id`              AS `EMPLEADOR_ID`,
       `e`.`nombre_empleador`          AS `NOMBRE_EMPLEADOR`,
       `b`.`anyo_bus`                  AS `ANYO_BUS`,
       `b`.`numero_asientos`           AS `NUMERO_ASIENTOS`,
       `b`.`numero_asiento_premium`    AS `NUMERO_ASIENTO_PREMIUM`,
       `b`.`numero_asiento_mixto`      AS `NUMERO_ASIENTO_MIXTO`,
       `b`.`numero_asiento_cama`       AS `NUMERO_ASIENTO_CAMA`,
       `b`.`numero_asiento_semicama`   AS `NUMERO_ASIENTO_SEMICAMA`,
       `b`.`numero_pantallas`          AS `NUMERO_PANTALLAS`,
       `b`.`numero_pantallas_premium`  AS `NUMERO_PANTALLAS_PREMIUM`,
       `b`.`numero_pantallas_mixtos`   AS `NUMERO_PANTALLAS_MIXTOS`,
       `b`.`numero_pantallas_cama`     AS `NUMERO_PANTALLAS_CAMA`,
       `b`.`numero_pantallas_semicama` AS `NUMERO_PANTALLAS_SEMICAMA`,
       `b`.`fecha_ultima_carga`        AS `FECHA_ULTIMA_CARGA`,
       `b`.`tipo_servicio`             AS `TIPO_SERVICIO`,
       `b`.`tipo_pantalla`             AS `TIPO_PANTALLA`,
       `b`.`estado`                    AS `ESTADO`
from (`erppluss`.`buses` `b` join `erppluss`.`empleadores` `e` on ((`b`.`empleador_id` = `e`.`id`)));

create view bustripulanteperiodos as
select `v`.`id`                                                                                                    AS `VIAJE_id`,
       `v`.`nro_viaje`                                                                                             AS `NRO_VIAJE`,
       `b`.`id`                                                                                                    AS `BUS_id`,
       `b`.`numero_bus`                                                                                            AS `NRO_BUS`,
       group_concat((case
                         when ((`tv`.`tipo_tripulante` = 'CONDUCTOR_UNO') and (`tv`.`orden` = 1))
                             then `tv`.`trabajador_id` end) separator
                    ',')                                                                                           AS `CONDUCTOR1_ID`,
       group_concat((case
                         when ((`tv`.`tipo_tripulante` = 'CONDUCTOR_UNO') and (`tv`.`orden` = 1)) then concat(
                                 `t`.`primer_nombre`, ' ', `t`.`segundo_nombre`, ' ', `t`.`primer_apellido`, ' ',
                                 `t`.`segundo_apellido`) end) separator
                    ',')                                                                                           AS `CONDUCTOR1`,
       group_concat((case
                         when ((`tv`.`tipo_tripulante` = 'CONDUCTOR_DOS') and (`tv`.`orden` = 2))
                             then `tv`.`trabajador_id` end) separator
                    ',')                                                                                           AS `CONDUCTOR2_ID`,
       group_concat((case
                         when ((`tv`.`tipo_tripulante` = 'CONDUCTOR_DOS') and (`tv`.`orden` = 2)) then concat(
                                 `t`.`primer_nombre`, ' ', `t`.`segundo_nombre`, ' ', `t`.`primer_apellido`, ' ',
                                 `t`.`segundo_apellido`) end) separator
                    ',')                                                                                           AS `CONDUCTOR2`,
       group_concat((case when (`tv`.`tipo_tripulante` = 'AUXILIAR') then `tv`.`trabajador_id` end) separator
                    ',')                                                                                           AS `AUXILIAR_ID`,
       group_concat((case
                         when (`tv`.`tipo_tripulante` = 'AUXILIAR') then concat(`t`.`primer_nombre`, ' ',
                                                                                `t`.`segundo_nombre`, ' ',
                                                                                `t`.`primer_apellido`, ' ',
                                                                                `t`.`segundo_apellido`) end) separator
                    ',')                                                                                           AS `AUXILIAR`,
       group_concat((case when (`tv`.`tipo_tripulante` = 'CONDUCTOR_UNO_REEMPLAZO') then `tv`.`trabajador_id` end)
                    separator
                    ',')                                                                                           AS `CONDUCTOR1_REEMPLAZO_ID`,
       group_concat((case
                         when (`tv`.`tipo_tripulante` = 'CONDUCTOR_UNO_REEMPLAZO') then concat(`t`.`primer_nombre`, ' ',
                                                                                               `t`.`segundo_nombre`,
                                                                                               ' ',
                                                                                               `t`.`primer_apellido`,
                                                                                               ' ',
                                                                                               `t`.`segundo_apellido`) end)
                    separator
                    ',')                                                                                           AS `CONDUCTOR1_REEMPLAZO`,
       group_concat((case when (`tv`.`tipo_tripulante` = 'CONDUCTOR_DOS_REEMPLAZO') then `tv`.`trabajador_id` end)
                    separator
                    ',')                                                                                           AS `CONDUCTOR2_REEMPLAZO_ID`,
       group_concat((case
                         when (`tv`.`tipo_tripulante` = 'CONDUCTOR_DOS_REEMPLAZO') then concat(`t`.`primer_nombre`, ' ',
                                                                                               `t`.`segundo_nombre`,
                                                                                               ' ',
                                                                                               `t`.`primer_apellido`,
                                                                                               ' ',
                                                                                               `t`.`segundo_apellido`) end)
                    separator
                    ',')                                                                                           AS `CONDUCTOR2_REEMPLAZO`,
       group_concat((case when (`tv`.`tipo_tripulante` = 'AUXILIAR_REEMPLAZO') then `tv`.`trabajador_id` end) separator
                    ',')                                                                                           AS `AUXILIAR_REEMPLAZO_ID`,
       group_concat((case
                         when (`tv`.`tipo_tripulante` = 'AUXILIAR_REEMPLAZO') then concat(`t`.`primer_nombre`, ' ',
                                                                                          `t`.`segundo_nombre`, ' ',
                                                                                          `t`.`primer_apellido`, ' ',
                                                                                          `t`.`segundo_apellido`) end)
                    separator
                    ',')                                                                                           AS `AUXILIAR_REEMPLAZO`,
       `d`.`ciudad`                                                                                                AS `DESTINO`,
       `v`.`fecha_viaje`                                                                                           AS `FECHA_SALIDA`
from ((((`erppluss`.`trabajador_viajes` `tv` join `erppluss`.`trabajadores` `t`
         on ((`tv`.`trabajador_id` = `t`.`id`))) join `erppluss`.`viajes` `v`
        on ((`tv`.`viaje_id` = `v`.`id`))) join `erppluss`.`buses` `b`
       on ((`v`.`buses_id` = `b`.`id`))) join `erppluss`.`destinos` `d` on ((`v`.`destino_id` = `d`.`id`)))
group by `v`.`id`;

create view check_list_calidad as
select `c`.`id`         AS `CHECKLIST_ID`,
       `cc`.`name`      AS `CATEGORIA`,
       `c`.`user_id`    AS `USER_ID`,
       `c`.`bus_id`     AS `BUS_ID`,
       `b`.`numero_bus` AS `NRO_BUS`,
       `b`.`patente`    AS `PATENTE`,
       `u`.`name`       AS `NOMBRE_USUARIO`,
       `u`.`apellidos`  AS `APELLIDOS_USUARIO`,
       `c`.`folio`      AS `FOLIO`,
       `c`.`status`     AS `STATUS`,
       `c`.`created_at` AS `FECHA_CREACION`,
       `c`.`updated_at` AS `FECHA_ACTUALIZACION`
from (((`erppluss`.`checklists` `c` join `erppluss`.`checklist_categories` `cc`
        on ((`c`.`category_id` = `cc`.`id`))) join `erppluss`.`buses` `b`
       on ((`c`.`bus_id` = `b`.`id`))) join `erppluss`.`users` `u` on ((`c`.`user_id` = `u`.`id`)))
where (`cc`.`name` = 'Calidad');

create view comision_view as
select `erppluss`.`bono_haberes`.`id`                   AS `ID`,
       `erppluss`.`bono_haberes`.`descripcion`          AS `DESCRIPCION`,
       `erppluss`.`bono_haberes`.`monto`                AS `MONTO`,
       `erppluss`.`bono_haberes`.`aplica_gratificacion` AS `APLICA_GRATIFICACION`,
       `erppluss`.`bono_haberes`.`aplica_hora_extra`    AS `APLICA_HORA_EXTRA`,
       `erppluss`.`bono_haberes`.`estado`               AS `ESTADO`
from `erppluss`.`bono_haberes`
where (`erppluss`.`bono_haberes`.`categoria` = 'COMISIONES');

create view conductores_status_view as
select (select count(0)
        from (`erppluss`.`trabajadores` `tr` join `erppluss`.`contrato` `c` on ((`tr`.`id` = `c`.`trabajador_id`)))
        where ((`c`.`cargo_id` = 3) and (`tr`.`condicion` = 'disponible')))       AS `DISPONIBLE`,
       (select count(0)
        from (`erppluss`.`trabajadores` `tr` join `erppluss`.`contrato` `c` on ((`tr`.`id` = `c`.`trabajador_id`)))
        where ((`c`.`cargo_id` = 3) and (`tr`.`condicion` = 'dias libre')))       AS `DIAS_LIBRES`,
       (select count(0)
        from (`erppluss`.`trabajadores` `tr` join `erppluss`.`contrato` `c` on ((`tr`.`id` = `c`.`trabajador_id`)))
        where ((`c`.`cargo_id` = 3) and (`tr`.`condicion` = 'vacaciones')))       AS `VACACIONES`,
       (select count(0)
        from (`erppluss`.`trabajadores` `tr` join `erppluss`.`contrato` `c` on ((`tr`.`id` = `c`.`trabajador_id`)))
        where ((`c`.`cargo_id` = 3) and (`tr`.`condicion` = 'falla')))            AS `FALLA`,
       (select count(0)
        from (`erppluss`.`trabajadores` `tr` join `erppluss`.`contrato` `c` on ((`tr`.`id` = `c`.`trabajador_id`)))
        where ((`c`.`cargo_id` = 3) and (`tr`.`condicion` = 'licencia médica')))  AS `LICENCIA_MEDICA`,
       (select count(0)
        from (`erppluss`.`trabajadores` `tr` join `erppluss`.`contrato` `c` on ((`tr`.`id` = `c`.`trabajador_id`)))
        where ((`c`.`cargo_id` = 3) and (`tr`.`condicion` = 'en ruta')))          AS `EN_RUTA`,
       (select count(0)
        from (`erppluss`.`trabajadores` `tr` join `erppluss`.`contrato` `c` on ((`tr`.`id` = `c`.`trabajador_id`)))
        where ((`c`.`cargo_id` = 3) and (`tr`.`condicion` = 'permiso especial'))) AS `PERMISO_ESPECIAL`;

create view descuentos_view as
select `erppluss`.`bono_haberes`.`id`          AS `ID`,
       `erppluss`.`bono_haberes`.`descripcion` AS `DESCRIPCION`,
       `erppluss`.`bono_haberes`.`monto`       AS `MONTO`,
       `erppluss`.`bono_haberes`.`estado`      AS `ESTADO`
from `erppluss`.`bono_haberes`
where (`erppluss`.`bono_haberes`.`categoria` = 'DESCUENTOS');

create view documento_entregado_viaje as
select `v`.`id`                                                             AS `VIAJE_ID`,
       `v`.`nro_viaje`                                                      AS `NUMERO_VIAJE`,
       concat(`b`.`numero_bus`, ' - ', `b`.`patente`)                       AS `BUS`,
       (select group_concat(`erppluss`.`monto_asignacion_peajes`.`nro_folio` separator ',')
        from `erppluss`.`monto_asignacion_peajes`
        where (`erppluss`.`monto_asignacion_peajes`.`viaje_id` = `v`.`id`)) AS `FOLIOS`,
       (select group_concat(concat(`t`.`primer_nombre`, ' ', `t`.`segundo_nombre`, ' ', `t`.`primer_apellido`, ' ',
                                   `t`.`segundo_apellido`) separator '</br>')
        from (`erppluss`.`trabajador_viajes` join `erppluss`.`trabajadores` `t`
              on ((`erppluss`.`trabajador_viajes`.`trabajador_id` = `t`.`id`)))
        where (`erppluss`.`trabajador_viajes`.`viaje_id` = `v`.`id`))       AS `TRIPULACION`,
       `d`.`id`                                                             AS `DESTINO_ID`,
       `d`.`ciudad`                                                         AS `CIUDAD_DESTINO`,
       `o`.`id`                                                             AS `ORIGEN_ID`,
       `o`.`ciudad`                                                         AS `CIUDAD_ORIGEN`,
       `v`.`fecha_viaje`                                                    AS `FECHA_SALIDA`,
       `v`.`fecha_llegada`                                                  AS `FECHA_LLEGADA`,
       (select `erppluss`.`documento_entragados`.`nro_doc`
        from `erppluss`.`documento_entragados`
        where ((`erppluss`.`documento_entragados`.`tipo` = 'checklist mantención') and
               (`erppluss`.`documento_entragados`.`viaje_id` = `v`.`id`)))  AS `NRO_DOCUMENTO_CHECK_LIST`,
       (select `erppluss`.`documento_entragados`.`nro_doc`
        from `erppluss`.`documento_entragados`
        where ((`erppluss`.`documento_entragados`.`tipo` = 'hoja de recorridos') and
               (`erppluss`.`documento_entragados`.`viaje_id` = `v`.`id`)))  AS `NRO_DOCUMENTO_HOJA_RUTA`,
       (select `erppluss`.`documento_entragados`.`estado`
        from `erppluss`.`documento_entragados`
        where ((`erppluss`.`documento_entragados`.`tipo` = 'checklist mantención') and
               (`erppluss`.`documento_entragados`.`viaje_id` = `v`.`id`)))  AS `ESTADO_CHECK_LIST`,
       (select `erppluss`.`documento_entragados`.`estado`
        from `erppluss`.`documento_entragados`
        where ((`erppluss`.`documento_entragados`.`tipo` = 'checklist mantención') and
               (`erppluss`.`documento_entragados`.`viaje_id` = `v`.`id`)))  AS `ESTADO_HOJA_RUTA`,
       (select `erppluss`.`documento_entragados`.`id`
        from `erppluss`.`documento_entragados`
        where ((`erppluss`.`documento_entragados`.`tipo` = 'checklist mantención') and
               (`erppluss`.`documento_entragados`.`viaje_id` = `v`.`id`)))  AS `ID_CHECK_LIST`,
       (select `erppluss`.`documento_entragados`.`id`
        from `erppluss`.`documento_entragados`
        where ((`erppluss`.`documento_entragados`.`tipo` = 'hoja de recorridos') and
               (`erppluss`.`documento_entragados`.`viaje_id` = `v`.`id`)))  AS `ID_HOJA_RECORRIDO`,
       (select `erppluss`.`documento_entragados`.`tripulacion_id`
        from `erppluss`.`documento_entragados`
        where ((`erppluss`.`documento_entragados`.`tipo` = 'checklist mantención') and
               (`erppluss`.`documento_entragados`.`viaje_id` = `v`.`id`)))  AS `TRIPULACION_ID`
from (((`erppluss`.`viajes` `v` join `erppluss`.`destinos` `d`
        on ((`v`.`destino_id` = `d`.`id`))) join `erppluss`.`destinos` `o`
       on ((`v`.`origen_id` = `o`.`id`))) join `erppluss`.`buses` `b` on ((`v`.`buses_id` = `b`.`id`)))
order by `v`.`id` desc;

create view gastos_egreso_cajas_view as
select `gec`.`id`                                  AS `ID_GASTO_EGRESO_CAJA`,
       `gec`.`fecha`                               AS `FECHA_EGRESO`,
       `gec`.`nro_documento`                       AS `NRO_DOCUMENTO`,
       `gec`.`monto`                               AS `MONTO`,
       `gec`.`observacion`                         AS `OBSERVACION`,
       `gec`.`empleador_id`                        AS `EMPLEADOR_ID`,
       `e`.`nombre_empleador`                      AS `EMPLEADOR`,
       `gec`.`trabajador_id`                       AS `TRABAJADOR_ID`,
       concat(`t`.`primer_nombre`, ' ', `t`.`segundo_nombre`, ' ', `t`.`primer_apellido`, ' ',
              `t`.`segundo_apellido`)              AS `NOMBRE_COMPLETO`,
       `gec`.`user_id`                             AS `USER_ID`,
       concat(`u`.`name`, ' ', `u`.`apellidos`)    AS `USER_NAME`,
       (select concat(`t`.`primer_nombre`, ' ', `t`.`segundo_nombre`, ' ', `t`.`primer_apellido`, ' ',
                      `t`.`segundo_apellido`)
        from `erppluss`.`trabajadores` `t`
        where (`t`.`id` = `gec`.`autorizados_id`)) AS `AUTORIZADO_POR`
from (((`erppluss`.`gastos_egreso_cajas` `gec` join `erppluss`.`empleadores` `e`
        on ((`e`.`id` = `gec`.`empleador_id`))) join `erppluss`.`trabajadores` `t`
       on ((`t`.`id` = `gec`.`trabajador_id`))) join `erppluss`.`users` `u` on ((`u`.`id` = `gec`.`user_id`)))
order by `gec`.`id` desc;

create view gestion_gasto_viaje_view as
select `v`.`id`                                                             AS `VIAJE_ID`,
       `v`.`nro_viaje`                                                      AS `NUMERO_VIAJE`,
       (select group_concat(`erppluss`.`monto_asignacion_peajes`.`nro_folio` separator ',')
        from `erppluss`.`monto_asignacion_peajes`
        where (`erppluss`.`monto_asignacion_peajes`.`viaje_id` = `v`.`id`)) AS `FOLIOS`,
       (select group_concat(concat(`t`.`primer_nombre`, ' ', `t`.`segundo_nombre`, ' ', `t`.`primer_apellido`, ' ',
                                   `t`.`segundo_apellido`) separator '</br>')
        from (`erppluss`.`trabajador_viajes` join `erppluss`.`trabajadores` `t`
              on ((`erppluss`.`trabajador_viajes`.`trabajador_id` = `t`.`id`)))
        where (`erppluss`.`trabajador_viajes`.`viaje_id` = `v`.`id`))       AS `TRIPULACION`,
       (select `erppluss`.`monto_viajes`.`id`
        from `erppluss`.`monto_viajes`
        where (`erppluss`.`monto_viajes`.`viaje_id` = `v`.`id`))            AS `MONTO_VIAJE_ID`,
       (select `erppluss`.`monto_viajes`.`responsable_id`
        from `erppluss`.`monto_viajes`
        where (`erppluss`.`monto_viajes`.`viaje_id` = `v`.`id`))            AS `RESPONSABLE_ID`,
       (select `erppluss`.`monto_viajes`.`monto_total`
        from `erppluss`.`monto_viajes`
        where (`erppluss`.`monto_viajes`.`viaje_id` = `v`.`id`))            AS `MONTO_TOTAL`,
       `d`.`id`                                                             AS `DESTINO_ID`,
       `d`.`ciudad`                                                         AS `CIUDAD_DESTINO`,
       `o`.`id`                                                             AS `ORIGEN_ID`,
       `o`.`ciudad`                                                         AS `CIUDAD_ORIGEN`,
       `v`.`fecha_viaje`                                                    AS `FECHA_SALIDA`,
       `v`.`fecha_llegada`                                                  AS `FECHA_LLEGADA`,
       (select `erppluss`.`monto_viajes`.`estado`
        from `erppluss`.`monto_viajes`
        where (`erppluss`.`monto_viajes`.`viaje_id` = `v`.`id`))            AS `ESTADO_CONCILIACION`
from (((`erppluss`.`viajes` `v` join `erppluss`.`destinos` `d`
        on ((`v`.`destino_id` = `d`.`id`))) join `erppluss`.`destinos` `o`
       on ((`v`.`origen_id` = `o`.`id`))) join `erppluss`.`buses` `b` on ((`v`.`buses_id` = `b`.`id`)))
order by `v`.`id`;

create view gestion_trabajador_dias_libres as
select `t`.`id`                       AS `IDENTIFICADOR`,
       `t`.`rut`                      AS `RUT`,
       concat(`t`.`primer_nombre`, ' ', `t`.`segundo_nombre`, ' ', `t`.`primer_apellido`, ' ',
              `t`.`segundo_apellido`) AS `NOMBRE_COMPLETO`,
       `gt`.`tipo`                    AS `TIPO`,
       `gt`.`id`                      AS `GESTION_ID`,
       `gt`.`fecha_inicial`           AS `FECHA_INICIAL`,
       `gt`.`fecha_termino`           AS `FECHA_TERMINO`,
       `gt`.`fecha_retorno`           AS `FECHA_RETORNO`,
       `gt`.`numero_dias`             AS `NUMERO_DIAS`,
       `c2`.`id`                      AS `CARGO_ID`,
       `c2`.`nombre_cargo`            AS `CARGO`,
       `e`.`id`                       AS `EMPLEADOR_ID`,
       `e`.`nombre_empleador`         AS `EMPLEADOR`
from ((((`erppluss`.`trabajadores` `t` join `erppluss`.`gestion_trabajadores` `gt`
         on ((`t`.`id` = `gt`.`trabajador_id`))) join `erppluss`.`contrato` `c`
        on ((`t`.`id` = `c`.`trabajador_id`))) join `erppluss`.`empleadores` `e`
       on ((`c`.`empleador_id` = `e`.`id`))) join `erppluss`.`cargos` `c2` on ((`c`.`cargo_id` = `c2`.`id`)))
where (`gt`.`tipo` = 'dias libre')
order by `gt`.`id`;

create view gestion_trabajador_inasistencia as
select `gt`.`id`              AS `GESTION_INDENTI`,
       `t`.`id`               AS `TRABAJADOR_IDENTI`,
       `t`.`rut`              AS `RUT`,
       `t`.`primer_nombre`    AS `PRIMER_NOMBRE`,
       `t`.`segundo_nombre`   AS `SEGUNDO_NOMBRE`,
       `t`.`primer_apellido`  AS `PRIMER_APELLIDO`,
       `t`.`segundo_apellido` AS `SEGUNDO_APELLIDO`,
       `c2`.`nombre_cargo`    AS `CARGO`,
       `e`.`nombre_empleador` AS `EMPLEADOR`,
       `gt`.`tipo`            AS `TIPO`,
       `gt`.`fecha_inicial`   AS `FECHA_INICIAL`,
       `gt`.`fecha_termino`   AS `FECHA_TERMINO`,
       `gt`.`numero_dias`     AS `NUMERO_DIAS`,
       `gt`.`estado`          AS `ESTADO`
from ((((`erppluss`.`trabajadores` `t` join `erppluss`.`gestion_trabajadores` `gt`
         on ((`t`.`id` = `gt`.`trabajador_id`))) join `erppluss`.`contrato` `c`
        on ((`t`.`id` = `c`.`trabajador_id`))) join `erppluss`.`cargos` `c2`
       on ((`c`.`cargo_id` = `c2`.`id`))) join `erppluss`.`empleadores` `e` on ((`c`.`empleador_id` = `e`.`id`)))
where (`gt`.`tipo` = 'falla')
order by `gt`.`id` desc;

create view gestion_tripulaciones as
select `gt`.`id`                      AS `GESTION_INDENTI`,
       `t`.`id`                       AS `TRABAJADOR_IDENTI`,
       `t`.`rut`                      AS `RUT`,
       concat(`t`.`primer_nombre`, ' ', `t`.`segundo_nombre`, ' ', `t`.`primer_apellido`, ' ',
              `t`.`segundo_apellido`) AS `NOMBRE_COMPLETO`,
       `c2`.`id`                      AS `CARGO_ID`,
       `c2`.`nombre_cargo`            AS `CARGO`,
       `e`.`id`                       AS `EMPLEADOR_ID`,
       `e`.`nombre_empleador`         AS `EMPLEADOR`,
       `gt`.`tipo`                    AS `TIPO`,
       `gt`.`fecha_inicial`           AS `FECHA_INICIAL`,
       `gt`.`fecha_termino`           AS `FECHA_TERMINO`,
       `gt`.`fecha_retorno`           AS `FECHA_RETORNO`,
       `gt`.`numero_dias`             AS `NUMERO_DIAS`,
       `gt`.`estado`                  AS `ESTADO`
from ((((`erppluss`.`trabajadores` `t` join `erppluss`.`gestion_trabajadores` `gt`
         on ((`t`.`id` = `gt`.`trabajador_id`))) join `erppluss`.`contrato` `c`
        on ((`t`.`id` = `c`.`trabajador_id`))) join `erppluss`.`cargos` `c2`
       on ((`c`.`cargo_id` = `c2`.`id`))) join `erppluss`.`empleadores` `e` on ((`c`.`empleador_id` = `e`.`id`)))
where (`c`.`cargo_id` in (2, 3))
order by `gt`.`id` desc;

create view haberes_no_imponinles_view as
select `erppluss`.`bono_haberes`.`id`                  AS `ID`,
       `erppluss`.`bono_haberes`.`descripcion`         AS `DESCRIPCION`,
       `erppluss`.`bono_haberes`.`monto`               AS `MONTO`,
       `erppluss`.`bono_haberes`.`aplica_proporcional` AS `APLICA_PROPORCIONAL`,
       `erppluss`.`bono_haberes`.`estado`              AS `ESTADO`
from `erppluss`.`bono_haberes`
where (`erppluss`.`bono_haberes`.`categoria` = 'HABERES NO IMPONIBLES');

create view historial_viajes_folio as
select `v`.`id`            AS `VIAJE_ID`,
       `v`.`nro_viaje`     AS `NUMERO_VIAJE`,
       `b`.`id`            AS `BUS_ID`,
       `b`.`numero_bus`    AS `NUMERO_BUS`,
       `b`.`patente`       AS `PATENTE`,
       `d`.`id`            AS `DESTINO_ID`,
       `d`.`ciudad`        AS `CIUDAD_DESTINO`,
       `o`.`id`            AS `ORIGEN_ID`,
       `o`.`ciudad`        AS `CIUDAD_ORIGEN`,
       `v`.`fecha_viaje`   AS `FECHA_SALIDA`,
       `v`.`fecha_llegada` AS `FECHA_LLEGADA`,
       `map`.`id`          AS `FOLIO_ID`,
       `map`.`nro_folio`   AS `NRO_FOLIO`
from ((((`erppluss`.`viajes` `v` join `erppluss`.`destinos` `d`
         on ((`v`.`destino_id` = `d`.`id`))) join `erppluss`.`destinos` `o`
        on ((`v`.`origen_id` = `o`.`id`))) join `erppluss`.`buses` `b`
       on ((`v`.`buses_id` = `b`.`id`))) join `erppluss`.`monto_asignacion_peajes` `map`
      on ((`v`.`id` = `map`.`viaje_id`)))
order by `v`.`id`;

-- comment on column historial_viajes_folio.NRO_FOLIO not supported: numero de folio autoincrementado en cada viaje

create view hora_extra_view as
select `erppluss`.`bono_haberes`.`id`                   AS `ID`,
       `erppluss`.`bono_haberes`.`descripcion`          AS `DESCRIPCION`,
       `erppluss`.`bono_haberes`.`factor`               AS `FACTOR`,
       `erppluss`.`bono_haberes`.`aplica_gratificacion` AS `APLICA_GRATIFICACION`,
       `erppluss`.`bono_haberes`.`estado`               AS `ESTADO`
from `erppluss`.`bono_haberes`
where (`erppluss`.`bono_haberes`.`categoria` = 'HORAS EXTRAS');

create view licencias_medicas_trabajador as
select `t`.`id`                                 AS `TRABAJADOR_ID`,
       `t`.`rut`                                AS `RUT`,
       concat(`t`.`primer_nombre`, ' ', `t`.`segundo_nombre`, ' ', `t`.`primer_apellido`, ' ',
              `t`.`segundo_apellido`)           AS `NOMBRE_COMPLETO`,
       `c2`.`nombre_cargo`                      AS `CARGO`,
       `c2`.`id`                                AS `CARGO_ID`,
       `t`.`condicion`                          AS `CONDICION_LICENCIA`,
       `e`.`id`                                 AS `EMPLEADOR_ID`,
       `e`.`nombre_empleador`                   AS `EMPLEADOR`,
       `tlm`.`id`                               AS `LICENCIA_ID`,
       `tlm`.`fecha_emision`                    AS `FECHA_EMISION`,
       `tlm`.`fecha_recepcion`                  AS `FECHA_RECEPCION`,
       `tlm`.`fecha_procesado`                  AS `FECHA_PROCESADO`,
       `tlm`.`fecha_inicio`                     AS `FECHA_INICIO`,
       `tlm`.`dias`                             AS `DIAS`,
       `tlm`.`fecha_fin`                        AS `FECHA_FIN`,
       `tlm`.`medio`                            AS `MEDIO`,
       `tlm`.`motivo`                           AS `MOTIVO`,
       `tlm`.`tipo_licencia_medicas_id`         AS `TIPO_LICENCIA_MEDICA_ID`,
       `m`.`nombre_licencia`                    AS `NOMBRE_LICENCIA`,
       `u2`.`nombre_ubicacion`                  AS `UBICACION`,
       `u2`.`id`                                AS `UBICACION_ID`,
       `tlm`.`estado`                           AS `ESTADO_LICENCIA`,
       concat(`u`.`name`, ' ', `u`.`apellidos`) AS `INGRESADO_POR`
from (((((((`erppluss`.`trabajadores` `t` join `erppluss`.`tramite_licencia_medicas` `tlm`
            on ((`t`.`id` = `tlm`.`trabajador_id`))) join `erppluss`.`contrato` `c`
           on ((`t`.`id` = `c`.`trabajador_id`))) join `erppluss`.`cargos` `c2`
          on ((`c`.`cargo_id` = `c2`.`id`))) join `erppluss`.`empleadores` `e`
         on ((`c`.`empleador_id` = `e`.`id`))) join `erppluss`.`ubicaciones` `u2`
        on ((`c`.`ubicacion_id` = `u2`.`id`))) join `erppluss`.`tipo_licencia_medicas` `m`
       on ((`tlm`.`tipo_licencia_medicas_id` = `m`.`id`))) join `erppluss`.`users` `u`
      on ((`tlm`.`user_id` = `u`.`id`)))
order by `tlm`.`id` desc;

create view liquidacion_trabajador_view as
select `t`.`id`                       AS `TRABAJADOR_ID`,
       `t`.`rut`                      AS `RUT`,
       concat(`t`.`primer_nombre`, ' ', `t`.`segundo_nombre`, ' ', `t`.`primer_apellido`, ' ',
              `t`.`segundo_apellido`) AS `NOMBRE_COMPLETO`,
       `c`.`empleador_id`             AS `EMPLEADOR_ID`,
       `e`.`nombre_empleador`         AS `NOMBRE_EMPLEADOR`,
       `c2`.`id`                      AS `CARGO_ID`,
       `c2`.`nombre_cargo`            AS `CARGO`,
       `lt`.`id`                      AS `LIQUIDACION_ID`,
       `lt`.`total_haberes`           AS `TOTAL_HABERES`,
       `lt`.`total_descuentos`        AS `TOTAL_DESCUENTOS`,
       `lt`.`total_a_pagar`           AS `TOTAL_A_PAGAR`,
       `lt`.`resumen_detalle`         AS `RESUMEN_DETALLE`,
       `lt`.`mes`                     AS `MES`,
       `lt`.`year`                    AS `YEAR`,
       `lt`.`estado`                  AS `ESTADO_LIQUIDACION`
from ((((`erppluss`.`trabajadores` `t` join `erppluss`.`contrato` `c`
         on ((`t`.`id` = `c`.`trabajador_id`))) join `erppluss`.`empleadores` `e`
        on ((`c`.`empleador_id` = `e`.`id`))) join `erppluss`.`cargos` `c2`
       on ((`c`.`cargo_id` = `c2`.`id`))) join `erppluss`.`liquidacion_trabajador` `lt`
      on ((`c`.`trabajador_id` = `lt`.`trabajador_id`)));

create view montos_entregados_view as
select `me`.`id`               AS `MONTO_ENTREGADO_ID`,
       `me`.`monto_entregado`  AS `MONTO_ENTREGADOS`,
       `me`.`fecha_entrega`    AS `FECHA_ENTREGA`,
       `me`.`estado`           AS `ESTADO_MONTO`,
       `map`.`id`              AS `FOLIO_ID`,
       `map`.`nro_folio`       AS `NRO_FOLIO`,
       `map`.`monto_asignado`  AS `MONTO_ASIGNADO`,
       `map`.`id`              AS `VIAJE_ID`,
       `v`.`nro_viaje`         AS `NRO_VIAJE`,
       `v`.`estado`            AS `ESTADO_VIAJE`,
       `u`.`id`                AS `USER_ID`,
       `u`.`name`              AS `NOMBRE`,
       `u`.`apellidos`         AS `APELLIDOS`,
       `u2`.`nombre_ubicacion` AS `UBICACION`
from ((((((`erppluss`.`monto_entregados` `me` join `erppluss`.`monto_asignacion_peajes` `map`
           on ((`me`.`monto_asignacion_peajes_id` = `map`.`id`))) join `erppluss`.`viajes` `v`
          on ((`map`.`viaje_id` = `v`.`id`))) join `erppluss`.`users` `u`
         on ((`me`.`user_id` = `u`.`id`))) join `erppluss`.`trabajadores` `t`
        on ((`u`.`id` = `t`.`user_id`))) join `erppluss`.`contrato` `c`
       on ((`t`.`id` = `c`.`trabajador_id`))) join `erppluss`.`ubicaciones` `u2` on ((`c`.`ubicacion_id` = `u2`.`id`)))
where ((`v`.`estado` = 'EN RUTA') or (`v`.`estado` = 'EN ORIGEN'));

-- comment on column montos_entregados_view.NRO_FOLIO not supported: numero de folio autoincrementado en cada viaje

create view reporte_cierre_caja_view as
select 'NUMERO DE VIAJE'                                                               AS `TIPO`,
       `v`.`id`                                                                        AS `VIAJE_ID`,
       `v`.`nro_viaje`                                                                 AS `ITEM`,
       `mt`.`nro_folio`                                                                AS `NUMERO_DOCUMENTO`,
       (select `de`.`nro_doc`
        from `erppluss`.`documento_entragados` `de`
        where ((`de`.`viaje_id` = `v`.`id`) and (`de`.`tipo` = 'hoja de recorridos'))) AS `NRO_DOCUMENTO`,
       `mt`.`fecha`                                                                    AS `FECHA`,
       `mt`.`monto_asignado`                                                           AS `MONTO`,
       `mt`.`monto_asignado`                                                           AS `MONTO_DEPOSITADO`,
       0                                                                               AS `DESCUENTO`,
       `u`.`id`                                                                        AS `USER_ID`,
       concat(`u`.`name`, ' ', `u`.`apellidos`)                                        AS `USER_NAME`
from ((`erppluss`.`monto_asignacion_peajes` `mt` join `erppluss`.`viajes` `v`
       on ((`v`.`id` = `mt`.`viaje_id`))) join `erppluss`.`users` `u` on ((`mt`.`user_id` = `u`.`id`)))
union all
select 'EGRESO'                                 AS `TIPO`,
       '-'                                      AS `VIAJE_ID`,
       '-'                                      AS `ITEM`,
       `gec`.`id`                               AS `NUMERO_DOCUMENTO`,
       `gec`.`nro_documento`                    AS `NRO_DOCUMENTO`,
       `gec`.`fecha`                            AS `FECHA`,
       0                                        AS `MONTO`,
       0                                        AS `MONTO_DEPOSITADO`,
       `gec`.`monto`                            AS `DESCUENTO`,
       `u`.`id`                                 AS `USER_ID`,
       concat(`u`.`name`, ' ', `u`.`apellidos`) AS `USER_NAME`
from (`erppluss`.`gastos_egreso_cajas` `gec` join `erppluss`.`users` `u` on ((`gec`.`user_id` = `u`.`id`)));

create view ruta_pasaje_venta_view as
select `rp`.`id`               AS `ID_PASAJE`,
       `rp`.`numero_documento` AS `NRO_DOCUMENTO`,
       `rp`.`monto`            AS `MONTO`,
       `rp`.`fecha`            AS `FECHA_VENTA`,
       `rp`.`viaje_id`         AS `VIAJE_ID`,
       `v`.`nro_viaje`         AS `NRO_VIAJE`,
       `v`.`fecha_viaje`       AS `fecha_viaje`,
       `v`.`destino_id`        AS `DESTINO_ID`,
       `d`.`ciudad`            AS `CIUDAD_DESTINO`,
       `v`.`origen_id`         AS `ORIGEN_ID`,
       `o`.`ciudad`            AS `CIUDAD_ORIGEN`
from (((`erppluss`.`ruta_pasaje_ventas` `rp` join `erppluss`.`viajes` `v`
        on ((`rp`.`viaje_id` = `v`.`id`))) join `erppluss`.`destinos` `o`
       on ((`v`.`origen_id` = `o`.`id`))) join `erppluss`.`destinos` `d` on ((`v`.`destino_id` = `d`.`id`)));

create view trabajador_bonos as
select `bt`.`id`                      AS `BONO_TRABAJADOR_ID`,
       `t`.`id`                       AS `TRABAJADOR_ID`,
       `t`.`rut`                      AS `RUT`,
       concat(`t`.`primer_nombre`, ' ', `t`.`segundo_nombre`, ' ', `t`.`primer_apellido`, ' ',
              `t`.`segundo_apellido`) AS `NOMBRE_COMPLETO`,
       `bh`.`id`                      AS `BONOS_ID`,
       `bh`.`descripcion`             AS `DESCRIPCION`,
       `bh`.`categoria`               AS `CATEGORIA`,
       `bh`.`factor`                  AS `FACTOR`,
       `bh`.`monto`                   AS `MONTO_PRE`,
       `bt`.`monto`                   AS `MONTO_MOD`,
       `bh`.`tipo`                    AS `TIPO`,
       `bh`.`clasificacion`           AS `CLASIFICACION`,
       `bh`.`estado`                  AS `ESTADO_BONO`,
       `bt`.`mes`                     AS `MES`,
       `bt`.`anyo`                    AS `ANYO`,
       `bt`.`estado`                  AS `ESTADO_ASIGNACION`
from ((`erppluss`.`trabajadores` `t` join `erppluss`.`bono_trabajador` `bt`
       on ((`t`.`id` = `bt`.`trabajador_id`))) join `erppluss`.`bono_haberes` `bh` on ((`bt`.`bonos_id` = `bh`.`id`)))
order by `bt`.`id` desc;

create view trabajador_cargo_bono as
select `t`.`id`                       AS `ID_TRABAJADOR`,
       `t`.`rut`                      AS `RUT`,
       concat(`t`.`primer_nombre`, ' ', `t`.`segundo_nombre`, ' ', `t`.`primer_apellido`, ' ',
              `t`.`segundo_apellido`) AS `NOMBRE_COMPLETO`,
       `c2`.`id`                      AS `ID_CARGO`,
       `c2`.`nombre_cargo`            AS `CARGO`,
       `e`.`id`                       AS `ID_EMPLEADOR`,
       `e`.`nombre_empleador`         AS `EMPLEADOR`
from (((`erppluss`.`trabajadores` `t` join `erppluss`.`contrato` `c`
        on ((`t`.`id` = `c`.`trabajador_id`))) join `erppluss`.`cargos` `c2`
       on ((`c`.`cargo_id` = `c2`.`id`))) join `erppluss`.`empleadores` `e` on ((`c`.`empleador_id` = `e`.`id`)))
order by `c2`.`nombre_cargo`;

create view trabajadores_autorizadores as
select `a`.`id` AS `TRABAJADOR_ID`, concat(`t`.`primer_nombre`, ' ', `t`.`primer_apellido`) AS `NOMBRE`
from (`erppluss`.`trabajadores` `t` join `erppluss`.`autorizadores` `a` on ((`a`.`trabajador_id` = `t`.`id`)))
where (`a`.`estado` = '0');

create view trabajadores_desvinculados as
select `t`.`rut`                      AS `RUT`,
       `t`.`id`                       AS `TRABAJADOR_ID`,
       `t`.`codigo_trabajador`        AS `CODIGO_TRABAJADOR`,
       concat(`t`.`primer_nombre`, ' ', `t`.`segundo_nombre`, ' ', `t`.`primer_apellido`, ' ',
              `t`.`segundo_apellido`) AS `NOMBRE_COMPLETO`,
       `t`.`estado`                   AS `ESTADOS_TRABAJADOR`,
       `hd`.`fecha_desvinculacion`    AS `FECHA_DESVINCULACION`,
       `hd`.`causal_de_hecho`         AS `MOTIVO_DESVINCULACION`,
       `hd`.`motivo_interno_empresa`  AS `OBSERVACION_DESVINCULACION`,
       `hd`.`motivo_id`               AS `MOTIVO_ID`,
       `mt`.`codigo`                  AS `CODIGO`,
       `mt`.`descripcion`             AS `DESCRIPCION`
from ((`erppluss`.`trabajadores` `t` left join `erppluss`.`historial_desvinculaciones` `hd`
       on ((`hd`.`trabajador_id` = `t`.`id`))) left join `erppluss`.`movimiento_trabajadores` `mt`
      on ((`hd`.`motivo_id` = `mt`.`id`)))
where (`t`.`estado` = 'desvinculado');

create view trabajadores_view as
select `t`.`id`                       AS `TRABAJADOR_ID`,
       `t`.`codigo_trabajador`        AS `CODIGO_TRABAJADOR`,
       `t`.`rut`                      AS `RUT`,
       concat(`t`.`primer_nombre`, ' ', `t`.`segundo_nombre`, ' ', `t`.`primer_apellido`, ' ',
              `t`.`segundo_apellido`) AS `NOMBRE_COMPLETO`,
       `c2`.`id`                      AS `CARGO_ID`,
       `c2`.`nombre_cargo`            AS `CARGO`,
       `e`.`id`                       AS `EMPLEADOR_ID`,
       `e`.`nombre_empleador`         AS `EMPLEADOR`,
       `u`.`id`                       AS `UBICACION_ID`,
       `u`.`nombre_ubicacion`         AS `UBICACION`,
       `t`.`estado`                   AS `ESTADO_TRABAJADOR`,
       `t`.`condicion`                AS `CONDICION_TRABAJADOR`
from ((((`erppluss`.`trabajadores` `t` join `erppluss`.`contrato` `c`
         on ((`t`.`id` = `c`.`trabajador_id`))) join `erppluss`.`cargos` `c2`
        on ((`c`.`cargo_id` = `c2`.`id`))) join `erppluss`.`empleadores` `e`
       on ((`c`.`empleador_id` = `e`.`id`))) join `erppluss`.`ubicaciones` `u` on ((`c`.`ubicacion_id` = `u`.`id`)));

create view trabajadores_view_export as
select `t`.`id`                                                   AS `ID_TRABAJADOR`,
       `t`.`codigo_trabajador`                                    AS `CODIGO`,
       `t`.`rut`                                                  AS `RUT`,
       concat(`t`.`primer_nombre`, ' ', `t`.`segundo_nombre`)     AS `NOMBRES`,
       concat(`t`.`primer_apellido`, ' ', `t`.`segundo_apellido`) AS `APELLIDOS`,
       `t`.`fecha_nac`                                            AS `FECHA_NAC`,
       `t`.`grado_escolaridad`                                    AS `GRAD0_ESCOLARIDAD`,
       `t`.`estado_civil`                                         AS `ESTADO_CIVIL`,
       `t`.`telefono_local`                                       AS `TELEFONO_LOCAL`,
       `t`.`telefono_celular`                                     AS `TELEFONO_CELULAR`,
       `t`.`correo`                                               AS `CORREO_ELECTRONICO`,
       `t`.`sexo`                                                 AS `SEXO`,
       `t`.`direccion`                                            AS `DIRECCION`,
       `t`.`region_id`                                            AS `REGION_ID`,
       `r`.`nombre_region`                                        AS `NOMBRE_REGION`,
       `t`.`comuna_id`                                            AS `COMUNA_ID`,
       `cm`.`nombre_comuna`                                       AS `NOMBRE_COMUNA`,
       `t`.`nacionalidad_id`                                      AS `NACIONALIDAD_ID`,
       `t`.`pertenece_pueblo_originario`                          AS `PERTENECE_A_PUEBLO_ORI`,
       `t`.`pueblo_originario_id`                                 AS `PUEBLO_ORIGINARIO_ID`,
       `t`.`tiene_familia`                                        AS `POSEE_CARGA_FAMILIAR`,
       `t`.`tiene_discapacidad`                                   AS `POSEE_DISCAPOCIDAD`,
       `c`.`empleador_id`                                         AS `EMPLEADOR_ID`,
       `e`.`nombre_empleador`                                     AS `NOMBRE_EMPLEADOR`,
       `c`.`area_id`                                              AS `AREA_ID`,
       `a`.`descripcion_area`                                     AS `NOMBRE_AREA`,
       `c`.`cargo_id`                                             AS `CARGO_ID`,
       `c2`.`nombre_cargo`                                        AS `NOMBRE_CARGO`,
       `c`.`ubicacion_id`                                         AS `UBICACION_ID`,
       `u`.`nombre_ubicacion`                                     AS `NOMBRE_UBICACION`,
       `c`.`fecha_ingreso`                                        AS `FECHA_INGRESO`,
       `c`.`fecha_antiguidad`                                     AS `FECHA_ANTIGUIDAD`,
       `c`.`fecha_vencimiento_contrato`                           AS `FECHA_PRIMER_VENCIMIENTO`,
       `c`.`fecha_segundo_vencimiento`                            AS `FECHA_SEGUNDO_VENCIMIENTO`,
       `c`.`centro_costo`                                         AS `CENTRO_COSTO`,
       `c`.`tipo_contrato`                                        AS `TIPO_CONTROTO`,
       `c`.`tipo_jornada`                                         AS `TIPO_JORNADA`,
       `c`.`jornada_excepcional`                                  AS `JORNADA_EXCEPCIONAL`,
       `s`.`id`                                                   AS `SALUD_ID`,
       `s`.`nombre_salud`                                         AS `ENTIDAD_DE_SALUD`,
       `pt`.`id`                                                  AS `PREVISION_ID`,
       `pt`.`tipo_entidad`                                        AS `TIPO_ENTIDAD`
from (((((((((`erppluss`.`trabajadores` `t` join `erppluss`.`contrato` `c`
              on ((`t`.`id` = `c`.`trabajador_id`))) left join `erppluss`.`empleadores` `e`
             on ((`c`.`empleador_id` = `e`.`id`))) left join `erppluss`.`areas` `a`
            on ((`c`.`area_id` = `a`.`id`))) left join `erppluss`.`cargos` `c2`
           on ((`c`.`cargo_id` = `c2`.`id`))) left join `erppluss`.`regiones` `r`
          on ((`t`.`region_id` = `r`.`id`))) left join `erppluss`.`comunas` `cm`
         on ((`t`.`comuna_id` = `cm`.`id`))) left join `erppluss`.`ubicaciones` `u`
        on ((`c`.`ubicacion_id` = `u`.`id`))) left join `erppluss`.`salud` `s`
       on ((`c`.`salud_id` = `s`.`id`))) left join `erppluss`.`prevision_trabajadores` `pt`
      on ((`t`.`id` = `pt`.`trabajador_id`)))
where (`t`.`estado` = 'contratado');

create view tramo_viajes_view as
select `t`.`id`         AS `ID_TRAMO`,
       `t`.`origen_id`  AS `ORIGEN_ID`,
       `d`.`ciudad`     AS `CIUDAD_ORIGEN`,
       `t`.`destino_id` AS `DESTINO_ID`,
       `o`.`ciudad`     AS `CIUDAD_DESTINO`,
       `t`.`horas`      AS `HORAS_VIAJE`,
       `t2`.`id`        AS `TRAMO_ID`,
       `t2`.`tramo`     AS `TRAMO_ESPACIAL`
from (((`erppluss`.`tramo_viajes` `t` join `erppluss`.`destinos` `d`
        on ((`t`.`origen_id` = `d`.`id`))) join `erppluss`.`destinos` `o`
       on ((`t`.`destino_id` = `o`.`id`))) join `erppluss`.`tramos` `t2` on ((`t`.`tramo_id` = `t2`.`id`)));

create view tripulacion_retornos as
select `t`.`rut`                                                    AS `RUT`,
       concat(`t`.`primer_nombre`, ' ', `t`.`segundo_nombre`, ' ', `t`.`primer_apellido`, ' ',
              `t`.`segundo_apellido`)                               AS `NOMBRE_COMPLETO`,
       `tr`.`trabajador_id`                                         AS `trabajador_id`,
       `e`.`nombre_empleador`                                       AS `NOMBRE_EMPLEADOR`,
       `c4`.`nombre_cargo`                                          AS `NOMBRE_CARGO`,
       date_format((`tr`.`fecha_fin` + interval 1 day), '%d-%m-%Y') AS `FECHA_TERMINO`,
       'LICENCIA MEDICA'                                            AS `TIPO`
from ((((`erppluss`.`tramite_licencia_medicas` `tr` join `erppluss`.`trabajadores` `t`
         on ((`tr`.`trabajador_id` = `t`.`id`))) join `erppluss`.`contrato` `c`
        on ((`t`.`id` = `c`.`trabajador_id`))) join `erppluss`.`empleadores` `e`
       on ((`c`.`empleador_id` = `e`.`id`))) join `erppluss`.`cargos` `c4` on ((`c`.`cargo_id` = `c4`.`id`)))
where (((`tr`.`fecha_fin` + interval 1 day) = curdate()) and (`c`.`cargo_id` in (2, 3)))
union all
select `t2`.`rut`                                                          AS `RUT`,
       concat(`t2`.`primer_nombre`, ' ', `t2`.`segundo_nombre`, ' ', `t2`.`primer_apellido`, ' ',
              `t2`.`segundo_apellido`)                                     AS `NOMBRE_COMPLETO`,
       `tv`.`trabajador_id`                                                AS `trabajador_id`,
       `e2`.`nombre_empleador`                                             AS `NOMBRE_EMPLEADOR`,
       `c5`.`nombre_cargo`                                                 AS `NOMBRE_CARGO`,
       date_format((`tv`.`fecha_ultimo_dia` + interval 1 day), '%d-%m-%Y') AS `FECHA_TERMINO`,
       'VACACIONES'                                                        AS `TIPO`
from ((((`erppluss`.`trabajador_vacaciones` `tv` join `erppluss`.`trabajadores` `t2`
         on ((`t2`.`id` = `tv`.`trabajador_id`))) join `erppluss`.`contrato` `c2`
        on ((`t2`.`id` = `c2`.`trabajador_id`))) join `erppluss`.`empleadores` `e2`
       on ((`c2`.`empleador_id` = `e2`.`id`))) join `erppluss`.`cargos` `c5` on ((`c2`.`cargo_id` = `c5`.`id`)))
where (((`tv`.`fecha_ultimo_dia` + interval 1 day) = curdate()) and (`c2`.`cargo_id` in (2, 3)))
union all
select `t3`.`rut`                                                       AS `RUT`,
       concat(`t3`.`primer_nombre`, ' ', `t3`.`segundo_nombre`, ' ', `t3`.`primer_apellido`, ' ',
              `t3`.`segundo_apellido`)                                  AS `NOMBRE_COMPLETO`,
       `gt`.`trabajador_id`                                             AS `trabajador_id`,
       `e3`.`nombre_empleador`                                          AS `NOMBRE_EMPLEADOR`,
       `c6`.`nombre_cargo`                                              AS `NOMBRE_CARGO`,
       date_format((`gt`.`fecha_termino` + interval 1 day), '%d-%m-%Y') AS `FECHA_TERMINO`,
       'DIAS LIBRE'                                                     AS `TIPO`
from ((((`erppluss`.`gestion_trabajadores` `gt` join `erppluss`.`trabajadores` `t3`
         on ((`gt`.`trabajador_id` = `t3`.`id`))) join `erppluss`.`contrato` `c3`
        on ((`t3`.`id` = `c3`.`trabajador_id`))) join `erppluss`.`empleadores` `e3`
       on ((`c3`.`empleador_id` = `e3`.`id`))) join `erppluss`.`cargos` `c6` on ((`c3`.`cargo_id` = `c6`.`id`)))
where (((`gt`.`fecha_termino` + interval 1 day) = curdate()) and (`gt`.`tipo` = 'dias libre') and
       (`c3`.`cargo_id` in (2, 3)));

create view tripulacion_retornos_fechas as
select `t`.`rut`                                                    AS `RUT`,
       concat(`t`.`primer_nombre`, ' ', `t`.`segundo_nombre`, ' ', `t`.`primer_apellido`, ' ',
              `t`.`segundo_apellido`)                               AS `NOMBRE_COMPLETO`,
       `tr`.`trabajador_id`                                         AS `trabajador_id`,
       `e`.`nombre_empleador`                                       AS `NOMBRE_EMPLEADOR`,
       `c4`.`nombre_cargo`                                          AS `NOMBRE_CARGO`,
       `tr`.`fecha_inicio`                                          AS `FECHA_INICIO`,
       `tr`.`fecha_fin`                                             AS `FECHA_TERMINO`,
       date_format((`tr`.`fecha_fin` + interval 1 day), '%d-%m-%Y') AS `FECHA_RETORNO`,
       'LICENCIA MEDICA'                                            AS `TIPO`
from ((((`erppluss`.`tramite_licencia_medicas` `tr` join `erppluss`.`trabajadores` `t`
         on ((`tr`.`trabajador_id` = `t`.`id`))) join `erppluss`.`contrato` `c`
        on ((`t`.`id` = `c`.`trabajador_id`))) join `erppluss`.`empleadores` `e`
       on ((`c`.`empleador_id` = `e`.`id`))) join `erppluss`.`cargos` `c4` on ((`c`.`cargo_id` = `c4`.`id`)))
where (`c`.`cargo_id` in (2, 3))
union all
select `t2`.`rut`                                                          AS `RUT`,
       concat(`t2`.`primer_nombre`, ' ', `t2`.`segundo_nombre`, ' ', `t2`.`primer_apellido`, ' ',
              `t2`.`segundo_apellido`)                                     AS `NOMBRE_COMPLETO`,
       `tv`.`trabajador_id`                                                AS `trabajador_id`,
       `e2`.`nombre_empleador`                                             AS `NOMBRE_EMPLEADOR`,
       `c5`.`nombre_cargo`                                                 AS `NOMBRE_CARGO`,
       `tv`.`fecha_primer_dia`                                             AS `FECHA_INICIO`,
       `tv`.`fecha_ultimo_dia`                                             AS `FECHA_TERMINO`,
       date_format((`tv`.`fecha_ultimo_dia` + interval 1 day), '%d-%m-%Y') AS `FECHA_RETORNO`,
       'VACACIONES'                                                        AS `TIPO`
from ((((`erppluss`.`trabajador_vacaciones` `tv` join `erppluss`.`trabajadores` `t2`
         on ((`t2`.`id` = `tv`.`trabajador_id`))) join `erppluss`.`contrato` `c2`
        on ((`t2`.`id` = `c2`.`trabajador_id`))) join `erppluss`.`empleadores` `e2`
       on ((`c2`.`empleador_id` = `e2`.`id`))) join `erppluss`.`cargos` `c5` on ((`c2`.`cargo_id` = `c5`.`id`)))
where (`c2`.`cargo_id` in (2, 3))
union all
select `t3`.`rut`                      AS `RUT`,
       concat(`t3`.`primer_nombre`, ' ', `t3`.`segundo_nombre`, ' ', `t3`.`primer_apellido`, ' ',
              `t3`.`segundo_apellido`) AS `NOMBRE_COMPLETO`,
       `gt`.`trabajador_id`            AS `trabajador_id`,
       `e3`.`nombre_empleador`         AS `NOMBRE_EMPLEADOR`,
       `c6`.`nombre_cargo`             AS `NOMBRE_CARGO`,
       `gt`.`fecha_inicial`            AS `FECHA_INICIO`,
       `gt`.`fecha_termino`            AS `FECHA_TERMINO`,
       `gt`.`fecha_retorno`            AS `FECHA_RETORNO`,
       'DIAS LIBRE'                    AS `TIPO`
from ((((`erppluss`.`gestion_trabajadores` `gt` join `erppluss`.`trabajadores` `t3`
         on ((`gt`.`trabajador_id` = `t3`.`id`))) join `erppluss`.`contrato` `c3`
        on ((`t3`.`id` = `c3`.`trabajador_id`))) join `erppluss`.`empleadores` `e3`
       on ((`c3`.`empleador_id` = `e3`.`id`))) join `erppluss`.`cargos` `c6` on ((`c3`.`cargo_id` = `c6`.`id`)))
where ((`gt`.`tipo` = 'dias libre') and (`c3`.`cargo_id` in (2, 3)));

create view tripulacion_vacaciones as
select `t`.`id`                                AS `ID_TRABAJADOR`,
       `t`.`rut`                               AS `RUT`,
       concat(`t`.`primer_nombre`, ' ', `t`.`segundo_nombre`, ' ', `t`.`primer_apellido`, ' ',
              `t`.`segundo_apellido`)          AS `NOMBRE_COMPLETO`,
       `tv`.`id`                               AS `VACACIONES_ID`,
       `tv`.`dias_habiles_solicitados`         AS `DIAS_HABILES_SOLICITADO`,
       `tv`.`fecha_primer_dia`                 AS `FECHA_PRIMER_DIA`,
       `tv`.`saldo_previo_vacaciones`          AS `SALDO_PREVIO_VACACIONES`,
       `tv`.`saldo_despues_vacacaciones`       AS `SALDO_DESPUES_VACACIONES`,
       `tv`.`dias_corridos_del_periodo_de_vac` AS `DIAS_CORRIDO_DEL_PERIODO_VACACIONES`,
       `tv`.`fecha_ultimo_dia`                 AS `FECHA_ULTIMO_DIA`,
       `tv`.`fecha_corte_calculo1`             AS `FECHA_CALCULO_CORTE_1`,
       `tv`.`fecha_corte_calculo2`             AS `FECHA_CORTE_2`,
       `tv`.`estado`                           AS `ESTADO_VACACIONES`,
       `c`.`empleador_id`                      AS `EMPLEADOR_ID`,
       `e`.`nombre_empleador`                  AS `NOMBRE_EMPLEADOR`
from (((`erppluss`.`trabajadores` `t` join `erppluss`.`trabajador_vacaciones` `tv`
        on ((`t`.`id` = `tv`.`trabajador_id`))) join `erppluss`.`contrato` `c`
       on ((`t`.`id` = `c`.`trabajador_id`))) join `erppluss`.`empleadores` `e` on ((`c`.`empleador_id` = `e`.`id`)));

create view tripulaciones as
select `t`.`rut`              AS `RUT`,
       `t`.`primer_nombre`    AS `primer_nombre`,
       `t`.`segundo_nombre`   AS `segundo_nombre`,
       `t`.`primer_apellido`  AS `primer_apellido`,
       `t`.`segundo_apellido` AS `segundo_apellido`,
       `e`.`nombre_empleador` AS `nombre_empleador`,
       `c2`.`nombre_cargo`    AS `nombre_cargo`,
       `u`.`nombre_ubicacion` AS `nombre_ubicacion`,
       `t`.`condicion`        AS `condicion`
from ((((`erppluss`.`trabajadores` `t` join `erppluss`.`contrato` `c`
         on ((`t`.`id` = `c`.`trabajador_id`))) join `erppluss`.`empleadores` `e`
        on ((`c`.`empleador_id` = `e`.`id`))) join `erppluss`.`cargos` `c2`
       on ((`c`.`cargo_id` = `c2`.`id`))) join `erppluss`.`ubicaciones` `u` on ((`c`.`ubicacion_id` = `u`.`id`)))
where (`c`.`cargo_id` in (2, 3));

create view tripulaciones_view as
select `t`.`id`                       AS `TRABAJADOR_ID`,
       `t`.`rut`                      AS `RUT`,
       concat(`t`.`primer_nombre`, ' ', `t`.`segundo_nombre`, ' ', `t`.`primer_apellido`, ' ',
              `t`.`segundo_apellido`) AS `NOMBRE_COMPLETO`,
       `t`.`direccion`                AS `DIRECCION`,
       `t`.`telefono_celular`         AS `TELEFONO_CELULAR`,
       `c`.`fecha_ingreso`            AS `FECHA_INGRESO`,
       `e`.`id`                       AS `EMPLEADOR_ID`,
       `e`.`nombre_empleador`         AS `EMPLEADOR`,
       `c2`.`id`                      AS `CARGO_ID`,
       `c2`.`nombre_cargo`            AS `CARGO`,
       `t`.`ubicacion_actual`         AS `UBICACION_ACTUAL`,
       `t`.`condicion`                AS `CONDICION`,
       (select `tr`.`fecha_fin`
        from `erppluss`.`tramite_licencia_medicas` `tr`
        where (`t`.`id` = `tr`.`trabajador_id`)
        order by `tr`.`id` desc
        limit 1)                      AS `FECHA_FINAL_LICENCIA`,
       (select `tv`.`fecha_ultimo_dia`
        from `erppluss`.`trabajador_vacaciones` `tv`
        where (`t`.`id` = `tv`.`trabajador_id`)
        order by `tv`.`id` desc
        limit 1)                      AS `FECHA_FINAL_VACACIONES`
from ((((`erppluss`.`trabajadores` `t` join `erppluss`.`contrato` `c`
         on ((`t`.`id` = `c`.`trabajador_id`))) join `erppluss`.`empleadores` `e`
        on ((`c`.`empleador_id` = `e`.`id`))) join `erppluss`.`cargos` `c2`
       on ((`c`.`cargo_id` = `c2`.`id`))) join `erppluss`.`ubicaciones` `u` on ((`c`.`ubicacion_id` = `u`.`id`)))
where (`c`.`cargo_id` in (2, 3));

create view tripulacionviaje as
select `tv`.`id`                                                                                                AS `id`,
       `tv`.`trabajador_id`                                                                                     AS `trabajador_id`,
       `tv`.`trabajador_reemplazo_id`                                                                           AS `trabajador_reemplazo_id`,
       `tv`.`viaje_id`                                                                                          AS `viaje_id`,
       `tv`.`motivo`                                                                                            AS `motivo`,
       `tv`.`tipo_tripulante`                                                                                   AS `tipo_tripulante`,
       `tv`.`orden`                                                                                             AS `orden`,
       `tv`.`estado`                                                                                            AS `estado`,
       concat_ws(' ', `t`.`primer_nombre`, `t`.`segundo_nombre`, `t`.`primer_apellido`,
                 `t`.`segundo_apellido`)                                                                        AS `NOMBRE_COMPLETO`
from ((`erppluss`.`trabajador_viajes` `tv` join `erppluss`.`trabajadores` `t`
       on ((`tv`.`trabajador_id` = `t`.`id`))) join `erppluss`.`viajes` `v` on ((`tv`.`viaje_id` = `v`.`id`)));

create view tripulanteconcepto as
select `t`.`id`                       AS `ID_TRABAJADOR`,
       `t`.`rut`                      AS `RUT`,
       concat(`t`.`primer_nombre`, ' ', `t`.`segundo_nombre`, ' ', `t`.`primer_apellido`, ' ',
              `t`.`segundo_apellido`) AS `NOMBRE_COMPLETO`,
       `c2`.`nombre_cargo`            AS `CARGO`,
       `tlm`.`fecha_inicio`           AS `FECHA_INICIO`,
       `tlm`.`fecha_fin`              AS `FECHA_FIN`,
       `tlm`.`dias`                   AS `DIAS`,
       'LICENCIA MEDICA'              AS `TIPO`
from (((`erppluss`.`trabajadores` `t` join `erppluss`.`contrato` `c`
        on ((`t`.`id` = `c`.`trabajador_id`))) join `erppluss`.`cargos` `c2`
       on ((`c`.`cargo_id` = `c2`.`id`))) join `erppluss`.`tramite_licencia_medicas` `tlm`
      on ((`t`.`id` = `tlm`.`trabajador_id`)))
where (`c2`.`id` between 2 and 3)
union
select `t`.`id`                         AS `ID_TRABAJADOR`,
       `t`.`rut`                        AS `RUT`,
       concat(`t`.`primer_nombre`, ' ', `t`.`segundo_nombre`, ' ', `t`.`primer_apellido`, ' ',
              `t`.`segundo_apellido`)   AS `NOMBRE_COMPLETO`,
       `c2`.`nombre_cargo`              AS `CARGO`,
       `tva`.`fecha_primer_dia`         AS `FECHA_INICIO`,
       `tva`.`fecha_ultimo_dia`         AS `FECHA_FIN`,
       `tva`.`dias_habiles_solicitados` AS `DIAS`,
       'VACACIONES'                     AS `TIPO`
from (((`erppluss`.`trabajadores` `t` join `erppluss`.`contrato` `c`
        on ((`t`.`id` = `c`.`trabajador_id`))) join `erppluss`.`cargos` `c2`
       on ((`c`.`cargo_id` = `c2`.`id`))) join `erppluss`.`trabajador_vacaciones` `tva`
      on ((`t`.`id` = `tva`.`trabajador_id`)))
where (`c2`.`id` between 2 and 3)
union
select `t`.`id`                       AS `ID_TRABAJADOR`,
       `t`.`rut`                      AS `RUT`,
       concat(`t`.`primer_nombre`, ' ', `t`.`segundo_nombre`, ' ', `t`.`primer_apellido`, ' ',
              `t`.`segundo_apellido`) AS `NOMBRE_COMPLETO`,
       `c2`.`nombre_cargo`            AS `CARGO`,
       `tlm`.`fecha_inicial`          AS `FECHA_INICIO`,
       `tlm`.`fecha_termino`          AS `FECHA_FIN`,
       `tlm`.`numero_dias`            AS `DIAS`,
       'DIAS LIBRES'                  AS `TIPO`
from (((`erppluss`.`trabajadores` `t` join `erppluss`.`contrato` `c`
        on ((`t`.`id` = `c`.`trabajador_id`))) join `erppluss`.`cargos` `c2`
       on ((`c`.`cargo_id` = `c2`.`id`))) join `erppluss`.`gestion_trabajadores` `tlm`
      on ((`t`.`id` = `tlm`.`trabajador_id`)))
where ((`tlm`.`tipo` = 'dias libre') and (`c2`.`id` between 2 and 3))
union
select `t`.`id`                       AS `ID_TRABAJADOR`,
       `t`.`rut`                      AS `RUT`,
       concat(`t`.`primer_nombre`, ' ', `t`.`segundo_nombre`, ' ', `t`.`primer_apellido`, ' ',
              `t`.`segundo_apellido`) AS `NOMBRE_COMPLETO`,
       `c2`.`nombre_cargo`            AS `CARGO`,
       `tlm`.`fecha_inicial`          AS `FECHA_INICIO`,
       `tlm`.`fecha_termino`          AS `FECHA_FIN`,
       `tlm`.`numero_dias`            AS `DIAS`,
       'FALLAS'                       AS `TIPO`
from (((`erppluss`.`trabajadores` `t` join `erppluss`.`contrato` `c`
        on ((`t`.`id` = `c`.`trabajador_id`))) join `erppluss`.`cargos` `c2`
       on ((`c`.`cargo_id` = `c2`.`id`))) join `erppluss`.`gestion_trabajadores` `tlm`
      on ((`t`.`id` = `tlm`.`trabajador_id`)))
where ((`tlm`.`tipo` = 'falla') and (`c2`.`id` between 2 and 3))
union
select `t`.`id`                       AS `ID_TRABAJADOR`,
       `t`.`rut`                      AS `RUT`,
       concat(`t`.`primer_nombre`, ' ', `t`.`segundo_nombre`, ' ', `t`.`primer_apellido`, ' ',
              `t`.`segundo_apellido`) AS `NOMBRE_COMPLETO`,
       `c2`.`nombre_cargo`            AS `CARGO`,
       `tlm`.`fecha_inicial`          AS `FECHA_INICIO`,
       `tlm`.`fecha_termino`          AS `FECHA_FIN`,
       `tlm`.`numero_dias`            AS `DIAS`,
       'PERMISO ESPECIAL'             AS `TIPO`
from (((`erppluss`.`trabajadores` `t` join `erppluss`.`contrato` `c`
        on ((`t`.`id` = `c`.`trabajador_id`))) join `erppluss`.`cargos` `c2`
       on ((`c`.`cargo_id` = `c2`.`id`))) join `erppluss`.`gestion_trabajadores` `tlm`
      on ((`t`.`id` = `tlm`.`trabajador_id`)))
where ((`tlm`.`tipo` = 'permiso especial') and (`c2`.`id` between 2 and 3));

create view viajemineria as
select `v`.`id`                                                                                         AS `VIAJE_id`,
       `v`.`nro_viaje`                                                                                  AS `NRO_VIAJE`,
       `b`.`id`                                                                                         AS `BUS_id`,
       `b`.`numero_bus`                                                                                 AS `NRO_BUS`,
       `b`.`patente`                                                                                    AS `PATENTE`,
       `v`.`tipo_viaje`                                                                                 AS `TIPO_VIAJE`,
       group_concat((case when ((`tv`.`tipo_tripulante` = 'CONDUCTOR_UNO') and (`tv`.`orden` = 1)) then `t`.`rut` end)
                    separator
                    ',')                                                                                AS `RUT_CONDUCTOR1`,
       group_concat((case
                         when ((`tv`.`tipo_tripulante` = 'CONDUCTOR_UNO') and (`tv`.`orden` = 1)) then concat(
                                 `t`.`primer_nombre`, ' ', `t`.`segundo_nombre`, ' ', `t`.`primer_apellido`, ' ',
                                 `t`.`segundo_apellido`) end) separator ',')                            AS `CONDUCTOR1`,
       group_concat((case when ((`tv`.`tipo_tripulante` = 'CONDUCTOR_DOS') and (`tv`.`orden` = 2)) then `t`.`rut` end)
                    separator
                    ',')                                                                                AS `RUT_CONDUCTOR2`,
       group_concat((case
                         when ((`tv`.`tipo_tripulante` = 'CONDUCTOR_DOS') and (`tv`.`orden` = 2)) then concat(
                                 `t`.`primer_nombre`, ' ', `t`.`segundo_nombre`, ' ', `t`.`primer_apellido`, ' ',
                                 `t`.`segundo_apellido`) end) separator ',')                            AS `CONDUCTOR2`,
       group_concat((case when (`tv`.`tipo_tripulante` = 'AUXILIAR') then `t`.`rut` end) separator
                    ',')                                                                                AS `RUT_AXULIAR`,
       group_concat((case
                         when (`tv`.`tipo_tripulante` = 'AUXILIAR') then concat(`t`.`primer_nombre`, ' ',
                                                                                `t`.`segundo_nombre`, ' ',
                                                                                `t`.`primer_apellido`, ' ',
                                                                                `t`.`segundo_apellido`) end) separator
                    ',')                                                                                AS `AUXILIAR`,
       `d`.`ciudad`                                                                                     AS `DESTINO`,
       `d2`.`ciudad`                                                                                    AS `ORIGEN`,
       `v`.`fecha_viaje`                                                                                AS `FECHA_SALIDA`,
       `v`.`hora_salida`                                                                                AS `HORA_SALIDA`,
       `c`.`id`                                                                                         AS `CLIENTE_ID`,
       `c`.`nombre_cliente`                                                                             AS `CLIENTE`
from ((((((`erppluss`.`trabajador_viajes` `tv` join `erppluss`.`trabajadores` `t`
           on ((`tv`.`trabajador_id` = `t`.`id`))) join `erppluss`.`viajes` `v`
          on ((`tv`.`viaje_id` = `v`.`id`))) join `erppluss`.`buses` `b`
         on ((`v`.`buses_id` = `b`.`id`))) join `erppluss`.`destinos` `d2`
        on ((`v`.`origen_id` = `d2`.`id`))) join `erppluss`.`destinos` `d`
       on ((`v`.`destino_id` = `d`.`id`))) join `erppluss`.`clientes` `c` on ((`v`.`cliente_id` = `c`.`id`)))
where (`v`.`tipo_viaje` = 'servicio en mineria')
group by `v`.`id`;

create view viajes_proximos as
select `b`.`id`                                AS `BUS_ID`,
       `v`.`id`                                AS `VIAJE_ID`,
       `v`.`nro_viaje`                         AS `NRO_VIAJE`,
       `b`.`numero_bus`                        AS `NRO_BUS`,
       `d`.`ciudad`                            AS `DESTINO`,
       `d2`.`ciudad`                           AS `ORIGEN`,
       concat(substr(`v`.`fecha_viaje`, 9, 2), '/', substr(`v`.`fecha_viaje`, 6, 2), '/',
              substr(`v`.`fecha_viaje`, 1, 4)) AS `FECHA_VIAJE`,
       `v`.`hora_salida`                       AS `HORA_SALIDA`,
       `v`.`fecha_llegada`                     AS `FECHA_LLEGADA`,
       `v`.`hora_llegada`                      AS `HORA_LLEGADA`,
       `mv`.`monto_total`                      AS `MONTO_TOTAL`,
       `v`.`nota_viaje`                        AS `NOTA_VIAJE`
from ((((`erppluss`.`viajes` `v` join `erppluss`.`buses` `b`
         on ((`v`.`buses_id` = `b`.`id`))) join `erppluss`.`destinos` `d`
        on ((`v`.`destino_id` = `d`.`id`))) join `erppluss`.`destinos` `d2`
       on ((`v`.`origen_id` = `d2`.`id`))) join `erppluss`.`monto_viajes` `mv` on ((`v`.`id` = `mv`.`viaje_id`)))
where (`v`.`fecha_viaje` = curdate())
order by `v`.`fecha_viaje` desc, `v`.`hora_salida` desc;

create view viajes_realizados as
select `b`.`id`                                       AS `BUS_ID`,
       `v`.`id`                                       AS `VIAJE_ID`,
       `v`.`nro_viaje`                                AS `NRO_VIAJE`,
       concat(`b`.`numero_bus`, ' - ', `b`.`patente`) AS `PATENTE`,
       `d`.`ciudad`                                   AS `DESTINO`,
       `d2`.`ciudad`                                  AS `ORIGEN`,
       `v`.`fecha_viaje`                              AS `FECHA_VIAJE`,
       `v`.`hora_salida`                              AS `HORA_SALIDA`,
       `v`.`fecha_llegada`                            AS `FECHA_LLEGADA`,
       `v`.`hora_llegada`                             AS `HORA_LLEGADA`,
       `mv`.`monto_total`                             AS `MONTO_TOTAL`,
       `v`.`nota_viaje`                               AS `NOTA_VIAJE`
from ((((`erppluss`.`viajes` `v` join `erppluss`.`buses` `b`
         on ((`v`.`buses_id` = `b`.`id`))) join `erppluss`.`destinos` `d`
        on ((`v`.`destino_id` = `d`.`id`))) join `erppluss`.`destinos` `d2`
       on ((`v`.`origen_id` = `d2`.`id`))) join `erppluss`.`monto_viajes` `mv` on ((`v`.`id` = `mv`.`viaje_id`)))
order by `v`.`fecha_viaje` desc, `v`.`hora_salida` desc;

create view viajes_tripulacion_view as
select `v`.`id`                                                                                 AS `VIAJE_ID`,
       `v`.`nro_viaje`                                                                          AS `NUMERO_VIAJE`,
       `v`.`fecha_viaje`                                                                        AS `FECHA_VIAJE`,
       `v`.`hora_salida`                                                                        AS `HORA_SALIDA`,
       `v`.`fecha_llegada`                                                                      AS `FECHA_LLEGADA`,
       `v`.`hora_llegada`                                                                       AS `HORA_LLEGADA`,
       `v`.`tipo_viaje`                                                                         AS `TIPO_VIAJE`,
       `v`.`estado`                                                                             AS `ESTADO`,
       `b`.`id`                                                                                 AS `BUS_ID`,
       concat(`b`.`numero_bus`, ' - ', `b`.`patente`)                                           AS `BUS`,
       `v`.`origen_id`                                                                          AS `ORIGEN_ID`,
       (select `d`.`ciudad` from `erppluss`.`destinos` `d` where (`d`.`id` = `v`.`origen_id`))  AS `CIUDAD_ORIGEN`,
       `v`.`destino_id`                                                                         AS `DESTINO_ID`,
       (select `d`.`ciudad` from `erppluss`.`destinos` `d` where (`d`.`id` = `v`.`destino_id`)) AS `CIUDAD_DESTINO`,
       (select group_concat(concat(`t`.`rut`, '-', `t`.`primer_nombre`, ' ', `t`.`segundo_nombre`, ' ',
                                   `t`.`primer_apellido`, ' ', `t`.`segundo_nombre`) separator '</br>')
        from (`erppluss`.`trabajador_viajes` `tv` join `erppluss`.`trabajadores` `t`
              on ((`tv`.`trabajador_id` = `t`.`id`)))
        where (`v`.`id` = `tv`.`viaje_id`))                                                     AS `TRIPULACION`
from (`erppluss`.`viajes` `v` join `erppluss`.`buses` `b` on ((`v`.`buses_id` = `b`.`id`)));

create view viajes_view as
select `erppluss`.`viajes`.`id`               AS `ID`,
       `erppluss`.`viajes`.`nro_viaje`        AS `NRO_VIAJE`,
       `erppluss`.`viajes`.`buses_id`         AS `BUSES_ID`,
       `erppluss`.`viajes`.`origen_id`        AS `ORIGEN_ID`,
       `erppluss`.`viajes`.`destino_id`       AS `DESTINO_ID`,
       `erppluss`.`viajes`.`viaje_especial`   AS `VIAJE_ESPECIAL`,
       `erppluss`.`viajes`.`destino_especial` AS `DESTINO_ESPECIAL`,
       `erppluss`.`viajes`.`origen_especial`  AS `ORIGEN_ESPECIAL`,
       `erppluss`.`viajes`.`fecha_viaje`      AS `FECHA_VIAJE`,
       `erppluss`.`viajes`.`hora_salida`      AS `HORA_SALIDA`,
       `erppluss`.`viajes`.`hora_llegada`     AS `HORA_LLEGADA`,
       `erppluss`.`viajes`.`fecha_llegada`    AS `FECHA_LLEGADA`,
       `erppluss`.`viajes`.`nota_viaje`       AS `NOTA_VIAJE`,
       `erppluss`.`viajes`.`notificacion`     AS `NOTIFICACION`,
       `erppluss`.`viajes`.`cliente_id`       AS `CLIENTE_ID`,
       `erppluss`.`viajes`.`empleador_id`     AS `EMPLEADOR_ID`,
       `erppluss`.`viajes`.`tipo_viaje`       AS `TIPO_VIAJE`,
       `erppluss`.`viajes`.`estado`           AS `ESTADO`
from `erppluss`.`viajes`;

create view viajeshoy as
select `v`.`nro_viaje`                                                                                  AS `NRO_VIAJE`,
       `v`.`fecha_viaje`                                                                                AS `FECHA_VIAJE`,
       `v`.`hora_salida`                                                                                AS `HORA_SALIDA`,
       `v`.`hora_llegada`                                                                               AS `HORA_LLEGADA`,
       `b`.`id`                                                                                         AS `BUS_id`,
       `b`.`numero_bus`                                                                                 AS `NRO_BUS`,
       `v`.`origen_id`                                                                                  AS `ORIGEN_ID`,
       `v`.`destino_id`                                                                                 AS `DESTINO_ID`,
       `d`.`ciudad`                                                                                     AS `DESTINO`,
       `o`.`ciudad`                                                                                     AS `ORIGEN`,
       group_concat((case when ((`tv`.`tipo_tripulante` = 'CONDUCTOR_UNO') and (`tv`.`orden` = 1)) then `t`.`rut` end)
                    separator
                    ',')                                                                                AS `RUT_CONDUCTOR1`,
       group_concat((case
                         when ((`tv`.`tipo_tripulante` = 'CONDUCTOR_UNO') and (`tv`.`orden` = 1)) then concat(
                                 `t`.`primer_nombre`, ' ', `t`.`segundo_nombre`, ' ', `t`.`primer_apellido`, ' ',
                                 `t`.`segundo_apellido`) end) separator ',')                            AS `CONDUCTOR1`,
       group_concat((case when ((`tv`.`tipo_tripulante` = 'CONDUCTOR_DOS') and (`tv`.`orden` = 2)) then `t`.`rut` end)
                    separator
                    ',')                                                                                AS `RUT_CONDUCTOR2`,
       group_concat((case
                         when ((`tv`.`tipo_tripulante` = 'CONDUCTOR_DOS') and (`tv`.`orden` = 2)) then concat(
                                 `t`.`primer_nombre`, ' ', `t`.`segundo_nombre`, ' ', `t`.`primer_apellido`, ' ',
                                 `t`.`segundo_apellido`) end) separator ',')                            AS `CONDUCTOR2`,
       group_concat((case when (`tv`.`tipo_tripulante` = 'AUXILIAR') then `t`.`rut` end) separator
                    ',')                                                                                AS `RUT_AXULIAR`,
       group_concat((case
                         when (`tv`.`tipo_tripulante` = 'AUXILIAR') then concat(`t`.`primer_nombre`, ' ',
                                                                                `t`.`segundo_nombre`, ' ',
                                                                                `t`.`primer_apellido`, ' ',
                                                                                `t`.`segundo_apellido`) end) separator
                    ',')                                                                                AS `AUXILIAR`,
       group_concat((case when (`tv`.`tipo_tripulante` = 'CONDUCTOR_UNO_REEMPLAZO') then `tv`.`trabajador_id` end)
                    separator
                    ',')                                                                                AS `CONDUCTOR1_REEMPLAZO_ID`,
       group_concat((case
                         when (`tv`.`tipo_tripulante` = 'CONDUCTOR_UNO_REEMPLAZO') then concat(`t`.`primer_nombre`, ' ',
                                                                                               `t`.`segundo_nombre`,
                                                                                               ' ',
                                                                                               `t`.`primer_apellido`,
                                                                                               ' ',
                                                                                               `t`.`segundo_apellido`) end)
                    separator
                    ',')                                                                                AS `CONDUCTOR1_REEMPLAZO`,
       group_concat((case when (`tv`.`tipo_tripulante` = 'CONDUCTOR_DOS_REEMPLAZO') then `tv`.`trabajador_id` end)
                    separator
                    ',')                                                                                AS `CONDUCTOR2_REEMPLAZO_ID`,
       group_concat((case
                         when (`tv`.`tipo_tripulante` = 'CONDUCTOR_DOS_REEMPLAZO') then concat(`t`.`primer_nombre`, ' ',
                                                                                               `t`.`segundo_nombre`,
                                                                                               ' ',
                                                                                               `t`.`primer_apellido`,
                                                                                               ' ',
                                                                                               `t`.`segundo_apellido`) end)
                    separator
                    ',')                                                                                AS `CONDUCTOR2_REEMPLAZO`,
       group_concat((case when (`tv`.`tipo_tripulante` = 'AUXILIAR_REEMPLAZO') then `tv`.`trabajador_id` end) separator
                    ',')                                                                                AS `AUXILIAR_REEMPLAZO_ID`,
       group_concat((case
                         when (`tv`.`tipo_tripulante` = 'AUXILIAR_REEMPLAZO') then concat(`t`.`primer_nombre`, ' ',
                                                                                          `t`.`segundo_nombre`, ' ',
                                                                                          `t`.`primer_apellido`, ' ',
                                                                                          `t`.`segundo_apellido`) end)
                    separator
                    ',')                                                                                AS `AUXILIAR_REEMPLAZO`
from (((((`erppluss`.`viajes` `v` left join `erppluss`.`trabajador_viajes` `tv`
          on ((`v`.`id` = `tv`.`viaje_id`))) left join `erppluss`.`trabajadores` `t`
         on ((`tv`.`trabajador_id` = `t`.`id`))) join `erppluss`.`buses` `b`
        on ((`v`.`buses_id` = `b`.`id`))) join `erppluss`.`destinos` `d`
       on ((`v`.`destino_id` = `d`.`id`))) join `erppluss`.`destinos` `o` on ((`v`.`origen_id` = `o`.`id`)))
group by `v`.`id`
order by `v`.`fecha_viaje` desc, `v`.`hora_salida`;


