create table ahorro_trabajadores
(
    id                   int auto_increment
        primary key,
    tipo_ahorro          varchar(50)     null,
    ahorro_voluntario_id int             null,
    tipo_moneda          varchar(50)     null,
    monto                float           null,
    forma_pago           varchar(50)     null,
    trabajador_id        bigint unsigned null
);

create table ahorros_voluntarios
(
    id     int auto_increment
        primary key,
    nombre varchar(200) null
);



create table archivo_solicitud
(
    id             bigint unsigned auto_increment
        primary key,
    solicitud_id   int          null,
    nombre_archivo varchar(200) null,
    created_at     timestamp    null,
    updated_at     timestamp    null
);


create table areas
(
    id               bigint auto_increment primary key,

    descripcion_area varchar(200)     null,
    trabajador_id    bigint default 0 null comment 'jefe de area'
);


create table autorizadores
(
    id            int unsigned auto_increment
        primary key,
    trabajador_id bigint unsigned             null,
    modulo        varchar(200)                not null,
    estado        enum ('0', '1') default '0' null
);




create table banco
(
    id           int auto_increment
        primary key,
    nombre_banco varchar(100) not null
);

create table banco_trabajadores
(
    id                   int auto_increment
        primary key,
    banco_id             int             null,
    trabajador_id        bigint unsigned null,
    nro_cuenta           varchar(50)     null,
    tipo_cuenta          varchar(255)    null,
    fecha_ingreso_cuenta date            null,
    predeterminado       enum ('Y', 'N') null
);



create table bono_haberes
(
    id                   int auto_increment
        primary key,
    descripcion          varchar(200)                                                                                                                                   not null,
    monto                int                                                                                                             default 0                      null,
    tipo                 enum ('PROPORCIONAL', 'SIMPLE')                                                                                 default 'SIMPLE'               null,
    clasificacion        enum ('LIQUIDO', 'BRUTO', 'AJUSTE')                                                                             default 'BRUTO'                null,
    categoria            enum ('BONOS', 'ANTICIPOS', 'DESCUENTOS', 'HORAS EXTRAS', 'HABERES NO IMPONIBLES', 'COMISIONES', 'PERMANENTES') default 'BONOS'                null,
    moneda               enum ('PESO', 'UF')                                                                                             default 'PESO'                 null,
    fecha_termino        date                                                                                                                                           null,
    factor               decimal(20, 20)                                                                                                 default 0.00000000000000000000 null,
    aplica_gratificacion enum ('SI', 'NO')                                                                                               default 'NO'                   null,
    aplica_hora_extra    enum ('SI', 'NO')                                                                                               default 'NO'                   null,
    aplica_anticipable   enum ('SI', 'NO')                                                                                               default 'NO'                   null,
    aplica_proporcional  enum ('SI', 'NO')                                                                                                                              null,
    aplica_imponible     enum ('SI', 'NO')                                                                                                                              null,
    estado               enum ('activo', 'inactivo')                                                                                     default 'activo'               null
);

create table bono_trabajador
(
    id            int auto_increment
        primary key,
    trabajador_id bigint unsigned             null,
    bonos_id      int                         null,
    mes           int default 1               not null,
    anyo          int                         null,
    monto         int default 0               null,
    estado        enum ('activo', 'inactivo') null
);



create table bus_certificados
(
    id                         int unsigned auto_increment
        primary key,
    bus_id                     bigint unsigned                                                                                                                                  null,
    fecha_emision              date                                                                                                                                             null,
    fecha_vencimiento          date                                                                                                                                             null,
    tipo_certificado           enum ('REVISION TECNICA', 'CERTIFICADO DE GASES', 'SEGUROS SOAP', 'PERMISO CIRCULACION', 'CERTIFICADO SERVICIO ESPECIAL', 'CARTÓN DE RECORRIDO') null,
    compania                   varchar(255)                                                                                                                                     null,
    municipalidad              varchar(255)                                                                                                                                     null,
    nro_certificado            varchar(255)                                                                                                                                     null,
    fecha_inicio_vehiculo      date                                                                                                                                             null,
    fecha_vencimiento_vehiculo date                                                                                                                                             null,
    fecha_inicio_servicio      date                                                                                                                                             null,
    fecha_vencimiento_servicio date                                                                                                                                             null,
    certificado_pdf            varchar(255)                                                                                                                                     null,
    estado                     enum ('VALIDO', 'VENCIDO')                                                                                                                       null
);

create table bus_trabajadores
(
    id            int unsigned auto_increment
        primary key,
    trabajador_id bigint unsigned                                                                                       null,
    bus_id        bigint unsigned                                                                                       null,
    tipo_chofer   enum ('jefe de maquina', 'jefe maquina temporal', 'jefe de maquina prueba') default 'jefe de maquina' null,
    fecha_inicio  date                                                                                                  null,
    fecha_termino date                                                                                                  null,
    estado        tinyint                                                                     default 0                 null
)
    charset = latin1;

create table buses
(
    id                        bigint unsigned auto_increment
        primary key,
    numero_bus                varchar(200)                                                                                                                                                 not null,
    marca_chasis              varchar(200)                                                                                                                                                 null,
    modelo_chasis             varchar(200)                                                                                                                                                 null,
    numero_chasis             int                                default 0 null,
    marca_carroceria          varchar(200)                                                                                                                                                 null,
    modelo_carroceria         varchar(200)                                                                                                                                                 null,
    numero_carroceria         int                                default 0                                                                                                                 null,
    patente                   varchar(10)                                                                                                                                                  null,
    tipo_bus                  varchar(255)                       default 'Mixto'                                                                                                           null,
    tipo_servicio             enum ('comercial', 'minero')                                                                                                                                 null,
    numero_piso               enum ('dos pisos', 'piso y medio') default 'piso y medio'                                                                                                    null,
    empleador_id              bigint unsigned                                                                                                                                              null,
    anyo_bus                  int                                                                                                                                                          null,
    numero_asientos           int                                                                                                                                                          null,
    numero_asiento_premium    int                                                                                                                                                          null,
    numero_asiento_mixto      int                                                                                                                                                          null,
    numero_asiento_cama       int                                                                                                                                                          null,
    numero_asiento_semicama   int                                                                                                                                                          null,
    numero_pantallas          int                                                                                                                                                          null,
    numero_pantallas_premium  int                                                                                                                                                          null,
    numero_pantallas_mixtos   int                                                                                                                                                          null,
    numero_pantallas_cama     int                                                                                                                                                          null,
    numero_pantallas_semicama int                                                                                                                                                          null,
    fecha_ultima_carga        date                                                                                                                                                         null,
    tipo_pantalla             enum ('Zeus', 'HD', 'Streaming', 'HD + Streaming', 'Zeus + Streaming')                                                                                       null,
    estado                    enum ('Avería en la vía', 'Bus operativo', 'Nombre_causas', 'Mantención preventiva', 'Sustitución de otro bus', 'Viaje Especial', 'en ruta', 'Dado de baja') null,
    propietario               varchar(255)                                                                                                                                                 null
)
    charset = latin1;



create table calendario_configuracion
(
    id              int auto_increment
        primary key,
    dia             int                                                                                                                                null,
    mes             enum ('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre') null,
    anyo            int                                                                                                                                null,
    fecha_inicio    date                                                                                                                               null,
    fecha_fin       date                                                                                                                               null,
    tipo_de_fecha   enum ('feriado', 'fin de semana')                                                                                                  null,
    tipo_de_feriado enum ('nacional', 'regional')                                                                                                      null,
    region_id       bigint unsigned                                                                                                                    null
)
    charset = latin1;

create table carga_familiares
(
    id                      int auto_increment
        primary key,
    rut                     varchar(15)     not null,
    nombres                 varchar(200)    null,
    apellidos               varchar(200)    null,
    fecha_nacimiento        date            null,
    fecha_vencimiento_carga date            null,
    parentesco_id           int             null,
    trabajador_id           bigint unsigned null
)
    charset = latin1;



create table cargos
(
    id           bigint auto_increment
        primary key,
    nombre_cargo varchar(200) null,
    area_id      bigint       null,
    created_at   timestamp    null,
    updated_at   timestamp    null
)
    charset = latin1;


create table categoria_user
(
    categoria_id bigint unsigned null,
    user_id      bigint unsigned null
)
    charset = latin1;

create table categorias
(
    id               bigint unsigned auto_increment
        primary key,
    nombre_categoria varchar(100) null,
    created_at       timestamp    null,
    updated_at       timestamp    null
)
    charset = latin1;



create table certificado_recorridos
(
    id                     int unsigned auto_increment
        primary key,
    bus_certificado_id     int unsigned null,
    origen_id              int unsigned null,
    destino_id             int unsigned null,
    recorrido_tramo_ida    text         null,
    recorrido_tramo_vuelta text         null
)
    charset = latin1;



create table certificadosfolios
(
    id             int unsigned auto_increment
        primary key,
    folio          int unsigned                                                                                           null,
    fecha_creacion date                                                                                                   null,
    hora           time                                                                                                   null,
    tipo_folio     enum ('VIAJE', 'CERTIFICADO DE SALIDA', 'CERTIFICADO SANITIZACION') default 'CERTIFICADO SANITIZACION' null
)
    charset = latin1;

create table checklist_categories
(
    id          bigint unsigned auto_increment
        primary key,
    name        varchar(255) not null,
    description text         null,
    created_at  timestamp    null,
    updated_at  timestamp    null
);

create table checklist_item_fields
(
    id            bigint unsigned auto_increment
        primary key,
    item_id       bigint unsigned not null,
    field_type_id bigint unsigned not null,
    label         varchar(255)    not null,
    options       text            null
);



create table checklist_item_users
(
    id      bigint unsigned auto_increment
        primary key,
    item_id bigint unsigned not null,
    user_id bigint unsigned not null
);

create table checklist_items
(
    id             bigint unsigned auto_increment
        primary key,
    type_id        bigint unsigned                                                              not null,
    name           varchar(255)                                                                 not null,
    description    text                                                                         null,
    parent_id      bigint unsigned                                                              null,
    isChild        tinyint(1)                                                default 0          not null,
    order_item     int                                                       default 0          not null,
    area_id        bigint unsigned                                                              null,
    is_attachement enum ('si', 'no')                                         default 'no'       null,
    critical       enum ('approved', 'approved with observation', 'refused') default 'approved' null,
    prioridad      enum ('baja', 'media', 'alta')                            default 'baja'     null,
    is_active      enum ('si', 'no')                                         default 'si'       null
);

create table checklist_responses
(
    id           bigint unsigned auto_increment
        primary key,
    checklist_id bigint unsigned not null,
    item_id      bigint unsigned not null,
    response     text            null,
    created_at   timestamp       null,
    updated_at   timestamp       null
);



create table checklist_structure
(
    id          bigint unsigned auto_increment
        primary key,
    category_id bigint unsigned not null,
    type_id     bigint unsigned not null
);



create table checklist_types
(
    id          bigint unsigned auto_increment
        primary key,
    name        varchar(255)    not null,
    description text            null,
    category_id bigint unsigned not null,
    order_type  int default 0   null
);



create table checklists
(
    id            bigint unsigned auto_increment
        primary key,
    category_id   bigint unsigned                                                                     not null,
    user_id       bigint unsigned                                                                     not null,
    bus_id        bigint unsigned                                                                     not null,
    folio         varchar(255)                                                                        null,
    tipo_servicio enum ('SERVICIO EN LINEA', 'SERVICIO EN MINERIA')       default 'SERVICIO EN LINEA' null,
    destino_id    int unsigned                                                                        null,
    fecha         date                                                    default '2023-01-01'        null,
    hora_salida   time                                                                                null,
    observaciones text                                                                                null,
    status        enum ('incomplete', 'complete', 'approved', 'rejected') default 'incomplete'        not null,
    created_at    timestamp                                                                           null,
    updated_at    timestamp                                                                           null
);


create table clientes
(
    id             int unsigned auto_increment
        primary key,
    nombre_cliente varchar(50) not null
)
    charset = latin1;

create table comunas
(
    id            bigint unsigned auto_increment
        primary key,
    nombre_comuna varchar(255)    not null,
    region_id     bigint unsigned not null
)
    collate = utf8mb4_unicode_ci;

create table contactos
(
    id              bigint auto_increment
        primary key,
    nombre          varchar(100)                                                       null,
    apellido        varchar(100)                                                       null,
    correo          varchar(100)                                                       null,
    telefono        varchar(50)                                                        null,
    direccion       varchar(100)                                                       null,
    region_id       bigint unsigned                                                    null,
    comuna_id       bigint unsigned                                                    null,
    parentesco      enum ('hijo(a)', 'padre', 'conyuge', 'madre', 'abuelo(a)', 'otro') null,
    otro_parentesco varchar(100)                                                       null,
    trabajador_id   bigint unsigned                                                    null,
    created_at      timestamp                                                          null,
    updated_at      timestamp                                                          null
)
    charset = latin1;



create table contrato
(
    id                         bigint unsigned auto_increment
        primary key,
    ubicacion_id               bigint          null,
    fecha_ingreso              date            null,
    fecha_antiguidad           date            null,
    fecha_vencimiento_contrato date            null,
    trabajador_id              bigint unsigned null,
    prevision_id               bigint unsigned null,
    salud_id                   bigint unsigned null,
    centro_costo               varchar(255)    null,
    tipo_contrato              varchar(255)    null,
    tipo_jornada               varchar(255)    null,
    empleador_id               bigint unsigned null,
    area_id                    bigint          null,
    cargo_id                   bigint          null,
    sueldo_base                int             null,
    fecha_desvinculacion       timestamp       null,
    updated_at                 timestamp       null,
    created_at                 timestamp       null,
    fecha_segundo_vencimiento  date            null,
    jornada_excepcional        varchar(50)     null,
    lugar_id                   int unsigned    null
)
    collate = utf8mb4_unicode_ci;




create table contrato_temporal
(
    id                int          not null,
    trabajaor_id      int          null,
    ubicacion         varchar(255) null,
    ubicacion_id      int          null,
    cargos            varchar(255) null,
    cargo_id          int          null,
    area              varchar(255) null,
    area_id           int          null,
    empleador         varchar(255) null,
    empleador_id      int          null,
    fecha_ingreso     date         null,
    fecha_ant         date         null,
    fecha_vencimiento date         null
)
    charset = latin1;



create table destinos
(
    id     int unsigned auto_increment
        primary key,
    ciudad varchar(255) not null
)
    charset = latin1;



create table documento_contratos
(
    id         bigint auto_increment
        primary key,
    texto      longtext  not null,
    created_at timestamp null,
    updated_at timestamp null
)
    charset = latin1;

create table documento_entragados
(
    id               int unsigned auto_increment
        primary key,
    nro_doc          varchar(100)                                                                       null,
    fecha_de_entrega datetime                                            default CURRENT_TIMESTAMP      null,
    tipo             enum ('checklist mantención', 'hoja de recorridos') default 'checklist mantención' null,
    viaje_id         int unsigned                                                                       null,
    tripulacion_id   bigint unsigned                                                                    null,
    user_id          bigint unsigned                                                                    null,
    estado           enum ('pendiente', 'entregado')                     default 'pendiente'            null
)
    charset = latin1;



create table documentos
(
    id               bigint auto_increment
        primary key,
    texto            longtext                                                                                                                          not null,
    tipo_documento   enum ('certificado antiguidad', 'certificado vacaciones', 'certidicado de afiliacion', 'sin determinar') default 'sin determinar' null,
    created_at       timestamp                                                                                                                         null,
    updated_at       timestamp                                                                                                                         null,
    nombre_documento varchar(200)                                                                                                                      null
)
    charset = latin1;

create table empleadores
(
    id                  bigint unsigned auto_increment
        primary key,
    codigo_empresa      varchar(50)  null,
    rut                 varchar(15)  null,
    nombre_empleador    varchar(255) null,
    direccion           varchar(255) null,
    comuna              varchar(255) null,
    region              varchar(255) null,
    representante_legal varchar(255) null,
    rut_representante   varchar(255) null,
    created_at          timestamp    null,
    updated_at          timestamp    null
);



create table failed_jobs
(
    id         bigint unsigned auto_increment
        primary key,
    uuid       varchar(255)                        not null,
    connection text                                not null,
    queue      text                                not null,
    payload    longtext                            not null,
    exception  longtext                            not null,
    failed_at  timestamp default CURRENT_TIMESTAMP not null
);

create table field_types
(
    id   bigint unsigned auto_increment
        primary key,
    name varchar(255) not null
);



create table firmas
(
    id           bigint auto_increment
        primary key,
    nombre_firma varchar(200) null,
    imagen_firma varchar(200) null,
    created_at   timestamp    null,
    updated_at   timestamp    null
)
    charset = latin1;
create table folios_impresion_caja
(
    id         int auto_increment
        primary key,
    nro_folio  varchar(10)                         not null,
    fecha      date                                not null,
    user_id    bigint unsigned                     null,
    created_at timestamp default CURRENT_TIMESTAMP not null,
    updated_at timestamp default CURRENT_TIMESTAMP not null on update CURRENT_TIMESTAMP
)

    charset = latin1;

create index user_id
    on folios_impresion_caja (user_id);

create table folios_viajes
(
    id        int unsigned auto_increment
        primary key,
    nro_folio int      default 0                     null,
    fecha     datetime default '2022-11-01 00:00:00' null
)
    charset = latin1;

create table gasto_pasaje_viaje
(
    id             int unsigned auto_increment
        primary key,
    monto_viaje_id int                                     default 0        null,
    nro_documento  varchar(100)                                             not null,
    monto_gasto    int                                     default 0        null,
    tipo           enum ('GASTOS', 'BOLETOS EN EL CAMINO') default 'GASTOS' null,
    fecha          date                                                     null,
    user_id        bigint unsigned                                          null,
    tipo_id        int unsigned                                             null,
    tripulacion_id bigint unsigned                                          null
)
    charset = latin1;



create table gasto_tipos
(
    id        int unsigned auto_increment
        primary key,
    tipo_name varchar(200) default 'PEAJE' null
)
    charset = latin1;



create table gastos_egreso_cajas
(
    id             bigint unsigned auto_increment
        primary key,
    fecha          datetime        null,
    nro_documento  varchar(200)    not null,
    monto          int default 0   null,
    observacion    varchar(200)    null,
    empleador_id   bigint unsigned null,
    trabajador_id  bigint unsigned null,
    autorizados_id int unsigned    null,
    user_id        bigint unsigned null
)
    charset = latin1;



create table gestion_trabajadores
(
    id            int unsigned auto_increment
        primary key,
    tipo          enum ('dias libre', 'falla', 'permiso especial') default 'dias libre' null,
    trabajador_id bigint unsigned                                                       null,
    fecha_inicial date                                                                  null,
    fecha_termino date                                                                  null,
    fecha_retorno date                                                                  null,
    numero_dias   int                                                                   null,
    estado        enum ('EN CURSO', 'FINALIZADO')                  default 'EN CURSO'   null
)
    charset = latin1;

create table historial_contratos
(
    id                         bigint unsigned auto_increment
        primary key,
    ubicacion_id               bigint                                                                                                                               null,
    fecha_ingreso              date                                                                                                                                 null,
    fecha_antiguidad           date                                                                                                                                 null,
    fecha_vencimiento_contrato date                                                                                                                                 null,
    trabajador_id              bigint unsigned                                                                                                                      null,
    rut                        varchar(50)                                                                                                                          null,
    prevision_id               bigint unsigned                                                                                                                      null,
    salud_id                   bigint unsigned                                                                                                                      null,
    centro_costo               enum ('Producción', 'Administracón', 'Ventas')                                                                                       null,
    tipo_contrato              enum ('Contrato a Plazo Fijo', 'Contrato Indefinido', 'Contrato por obra o faena', 'Contrato por honorario', 'Contrato practicante') null,
    tipo_jornada               enum ('Jornada completa', 'Part Time', 'Excepcional', 'Turno Rotativo', 'Bisemanal')                                                 null,
    empleador_id               bigint unsigned                                                                                                                      null,
    area_id                    bigint                                                                                                                               null,
    cargo_id                   bigint                                                                                                                               null,
    fecha_desvinculacion       timestamp                                                                                                                            null,
    updated_at                 timestamp                                                                                                                            null,
    created_at                 timestamp                                                                                                                            null,
    fecha_segundo_vencimiento  date                                                                                                                                 null
)
    collate = utf8mb4_unicode_ci;



create table historial_desvinculaciones
(
    id                     int unsigned auto_increment
        primary key,
    fecha_desvinculacion   date            null,
    causal_de_hecho        varchar(200)    null,
    motivo_interno_empresa varchar(200)    null,
    motivo_id              int             null,
    trabajador_id          bigint unsigned null,
    created_at             timestamp       null,
    updated_at             timestamp       null
)
    charset = latin1;



create table historial_trabajadores
(
    id                          bigint unsigned auto_increment
        primary key,
    codigo_trabajador           varchar(10)                                                                                                                                                                                                                          null,
    rut                         varchar(255)                                                                                                                                                                                                                         null,
    primer_nombre               varchar(255)                                                                                                                                                                                                                         null,
    segundo_nombre              varchar(255)                                                                                                                                                                                                                         null,
    primer_apellido             varchar(255)                                                                                                                                                                                                                         null,
    segundo_apellido            varchar(255)                                                                                                                                                                                                                         null,
    telefono_local              varchar(255)                                                                                                                                                                                                                         null,
    telefono_celular            varchar(255)                                                                                                                                                                                                                         null,
    correo                      varchar(255)                                                                                                                                                                                                                         null,
    fecha_nac                   date                                                                                                                                                                                                                                 null,
    estado_civil                enum ('Soltero', 'Casado', 'Divorsiado', 'Viudo', ' Unión Civil') default 'Soltero'                                                                                                                                                  null,
    sexo                        enum ('masculino', 'femenino', 'Indeterminado')                   default 'masculino'                                                                                                                                                null,
    grado_escolaridad           enum ('SIN ESCOLARIDAD', 'BÁSICA', 'MEDIA CIENTÍFICO HUMANISTA', 'MEDIA TÉCNICA PROFESIONAL', 'TÉCNICO SUPERIOR INCOMPLETA', 'TÉCNICO SUPERIOR COMPLETA', 'PROFESIONAL INCOMPLETA', 'PROFESIONAL COMPLETA', 'MAGISTER', 'DOCTORADO') null,
    direccion                   varchar(255)                                                                                                                                                                                                                         null,
    comuna_id                   bigint unsigned                                                   default '0'                                                                                                                                                        null,
    region_id                   bigint unsigned                                                   default '0'                                                                                                                                                        null,
    nacionalidad_id             int unsigned                                                                                                                                                                                                                         null,
    pertenece_pueblo_originario enum ('si', 'no')                                                 default 'no'                                                                                                                                                       null,
    pueblo_originario_id        bigint unsigned                                                                                                                                                                                                                      null,
    tiene_familia               enum ('si', 'no')                                                 default 'no'                                                                                                                                                       null,
    tiene_discapacidad          enum ('si', 'no')                                                 default 'no'                                                                                                                                                       null,
    user_id                     bigint unsigned                                                   default '0'                                                                                                                                                        null,
    estado                      enum ('postulado', 'contratado', 'desvinculado', 'reincorporado') default 'postulado'                                                                                                                                                null,
    created_at                  timestamp                                                                                                                                                                                                                            null,
    updated_at                  timestamp                                                                                                                                                                                                                            null,
    deleted_at                  timestamp                                                                                                                                                                                                                            null
);



create table licencia_conducir
(
    id                   int auto_increment
        primary key,
    tipo_licencia_id     int             null,
    nro_serie            varchar(200)    null,
    categorias           json            null,
    fecha_de_vencimiento date            null,
    restriccion          tinytext        null,
    trabajador_id        bigint unsigned null,
    fecha_de_ingreso     date            null,
    tipo_licencia        json            null
)
    charset = latin1;



create table liquidacion_trabajador
(
    id               bigint unsigned auto_increment
        primary key,
    trabajador_id    bigint unsigned                       null,
    total_haberes    float(10, 4)                          null,
    total_descuentos float(10, 4)                          null,
    total_a_pagar    float(10, 4)                          null,
    resumen_detalle  json                                  null,
    mes              int                                   null,
    year             int                                   null,
    estado           enum ('OPEN', 'CLOSE') default 'OPEN' null,
    created_at       timestamp                             null,
    updated_at       timestamp                             null
)
    charset = latin1;



create table log_sistemas
(
    id                int unsigned auto_increment
        primary key,
    user_id           bigint unsigned null,
    fecha             datetime        null,
    accion            varchar(200)    null,
    tabla             varchar(200)    null,
    registro_id       bigint unsigned null,
    registro_anterior text            null,
    registro_nuevo    text            null
)
    charset = latin1;



create table menu_role
(
    menu_id int             not null,
    role_id bigint unsigned not null
);



create table menus
(
    id        int auto_increment
        primary key,
    title     varchar(255)  not null,
    parent_id int           null,
    route     varchar(255)  null,
    icon      varchar(255)  null,
    position  int default 0 null
);



create table meses_remuneraciones
(
    id         int auto_increment
        primary key,
    nombre_mes varchar(200)                null,
    isOpen     enum ('Y', 'N') default 'Y' null
)
    charset = latin1;

create table migrations
(
    id        int unsigned auto_increment
        primary key,
    migration varchar(255) not null,
    batch     int          not null
)
    collate = utf8mb4_unicode_ci;

create table model_has_permissions
(
    permission_id bigint unsigned not null,
    model_type    varchar(255)    not null,
    model_id      bigint unsigned not null
);



create table model_has_roles
(
    role_id    bigint unsigned not null,
    model_type varchar(255)    not null,
    model_id   bigint unsigned not null
);



create table monto_asignacion_peajes
(
    id               int auto_increment
        primary key,
    nro_folio        int                                  default 0               not null comment 'numero de folio autoincrementado en cada viaje',
    glosas           varchar(150)                         default ''              not null,
    monto_asignado   int unsigned                                                 null,
    viaje_id         int unsigned                                                 null,
    user_id          bigint unsigned                                              not null,
    fecha            date                                                         null,
    tipo_id          int unsigned                                                 null,
    estado           enum ('consiliado', 'no consiliado') default 'no consiliado' null,
    observacion      varchar(200)                                                 null,
    fecha_modicacion datetime                                                     null
)
    charset = latin1;

create table monto_entregados
(
    id                         int unsigned auto_increment
        primary key,
    monto_asignacion_peajes_id int                                                                            null,
    monto_entregado            int                                          default 0                         null,
    nota                       text                                                                           null,
    fecha_entrega              timestamp                                                                      null,
    user_id                    bigint unsigned                                                                null,
    estado                     enum ('PENDIENTE DE APROBACION', 'APROBADO') default 'PENDIENTE DE APROBACION' null
);

create table monto_viajes
(
    id             int auto_increment
        primary key,
    viaje_id       int unsigned                                                                     null,
    monto_total    int                                                      default 0               null,
    responsable_id bigint unsigned                                          default '0'             null,
    user_id        bigint unsigned                                                                  null,
    estado         enum ('CONCILIADO', 'NO CONCILIADO', 'SALDO A DEVOLVER') default 'NO CONCILIADO' null
);

create table montos_destinos
(
    id                   int unsigned auto_increment
        primary key,
    destino_id           int unsigned             null,
    monto_predeterminado int unsigned default '0' null
);



create table movimiento_trabajadores
(
    id          int auto_increment
        primary key,
    codigo      varchar(200) null,
    descripcion text         null
);

create table nacionalidades
(
    id                       int unsigned auto_increment
        primary key,
    descripcion_nacionalidad varchar(100) null
);

create table notifications
(
    id              char(36)        not null,
    type            varchar(255)    not null,
    notifiable_type varchar(255)    not null,
    notifiable_id   bigint unsigned not null,
    data            text            not null,
    read_at         timestamp       null,
    created_at      timestamp       null,
    updated_at      timestamp       null
);



create table oauth_access_tokens
(
    id         varchar(100)    not null,
    user_id    bigint unsigned null,
    client_id  char(36)        not null,
    name       varchar(255)    null,
    scopes     text            null,
    revoked    tinyint(1)      not null,
    created_at timestamp       null,
    updated_at timestamp       null,
    expires_at datetime        null
);



create table oauth_auth_codes
(
    id         varchar(100)    not null,
    user_id    bigint unsigned not null,
    client_id  char(36)        not null,
    scopes     text            null,
    revoked    tinyint(1)      not null,
    expires_at datetime        null
);



create table oauth_clients
(
    id                     char(36)        not null,
    user_id                bigint unsigned null,
    name                   varchar(255)    not null,
    secret                 varchar(100)    null,
    provider               varchar(255)    null,
    redirect               text            not null,
    personal_access_client tinyint(1)      not null,
    password_client        tinyint(1)      not null,
    revoked                tinyint(1)      not null,
    created_at             timestamp       null,
    updated_at             timestamp       null
);

create table oauth_personal_access_clients
(
    id         bigint unsigned auto_increment
        primary key,
    client_id  char(36)  not null,
    created_at timestamp null,
    updated_at timestamp null
);

create table oauth_refresh_tokens
(
    id              varchar(100) not null,
    access_token_id varchar(100) not null,
    revoked         tinyint(1)   not null,
    expires_at      datetime     null
);

create table oficina_users
(
    id         int unsigned auto_increment
        primary key,
    oficina_id int unsigned    null,
    user_id    bigint unsigned null
);


create table oficinas
(
    id         int unsigned auto_increment
        primary key,
    ciudad     varchar(255)                                      null,
    tipo       enum ('oficina', 'punto-pluss') default 'oficina' null,
    direccion  varchar(255)                                      null,
    telefono   varchar(255)                                      null,
    imagen     varchar(255)                                      null,
    horario_at varchar(255)                                      null,
    mapa       mediumtext                                        null,
    position   int unsigned                    default '0'       null,
    created_at timestamp                                         null,
    updated_at timestamp                                         null,
    deleted_at timestamp                                         null
);

create table parametro_liquidaciones
(
    id          int auto_increment
        primary key,
    descripcion varchar(200)                                                                                                     null,
    valor       float(10, 2)                                                                                                     null,
    tipo        enum ('GRATIFICACION DEFINIDA', 'PREVIRED', 'TRAMOS FAMILIAR', 'SEGURO CENSANTIA TRABAJADOR', 'TRAMOS IMPUESTO') null
);

create table parentescos
(
    id          int auto_increment
        primary key,
    codigo      int          not null,
    descripcion varchar(200) not null
);



create table password_resets
(
    email      varchar(255) not null,
    token      varchar(255) not null,
    created_at timestamp    null
);



create table permissions
(
    id         bigint unsigned auto_increment
        primary key,
    name       varchar(255) not null,
    guard_name varchar(255) not null,
    created_at timestamp    null,
    updated_at timestamp    null
);



create table personal_access_tokens
(
    id             bigint unsigned auto_increment
        primary key,
    tokenable_type varchar(255)    not null,
    tokenable_id   bigint unsigned not null,
    name           varchar(255)    not null,
    token          varchar(64)     not null,
    abilities      text            null,
    last_used_at   timestamp       null,
    expires_at     timestamp       null,
    created_at     timestamp       null,
    updated_at     timestamp       null
);



create table prestamos_trabajador
(
    id            int auto_increment
        primary key,
    monto         int                      not null,
    cuotas        int                      not null,
    tipo          enum ('EMPRESA', 'CAJA') null,
    trabajador_id bigint                   null,
    descripcion   varchar(200)             null,
    periodo_pago  varchar(200)             null comment 'mes de la cuota',
    cuota_inicial int                      null
);

create table prevision_inp
(
    id     int auto_increment
        primary key,
    codigo int          null,
    nombre varchar(100) null
);

create table prevision_trabajadores
(
    id               int auto_increment
        primary key,
    tipo_entidad     enum ('afp', 'inp') default 'afp' null,
    prevision_id     bigint unsigned                   null,
    prevision_inp_id int                               null,
    trabajador_id    bigint unsigned                   null
);


create table previsiones
(
    id                   bigint unsigned auto_increment
        primary key,
    codigo               varchar(10)  null,
    nombre_prevision     varchar(255) not null,
    porcentaje_prevision float        null
);



create table previsiones_tempora
(
    id            int auto_increment
        primary key,
    trabajador_id int          null,
    afp           varchar(255) null,
    afp_id        int          null,
    salud         varchar(255) null,
    salud_id      int          null,
    porcentaje    int          null
);

create table pueblo_originarios
(
    id                bigint unsigned auto_increment
        primary key,
    pueblo_originario varchar(100) null
);

create table regiones
(
    id            bigint unsigned auto_increment
        primary key,
    nombre_region varchar(255) not null
);



create table respuesta_solicitudes
(
    id           bigint auto_increment
        primary key,
    user_id      bigint unsigned not null,
    solicitud_id int             null,
    mensaje      text            not null,
    archivos     varchar(255)    null,
    created_at   timestamp       null,
    updated_at   timestamp       null
);



create table role_has_permissions
(
    permission_id bigint unsigned not null,
    role_id       bigint unsigned not null
);



create table roles
(
    id         bigint unsigned auto_increment
        primary key,
    name       varchar(255) not null,
    guard_name varchar(255) not null,
    created_at timestamp    null,
    updated_at timestamp    null
);



create table ruta_pasaje_ventas
(
    id               int unsigned auto_increment
        primary key,
    numero_documento varchar(100) null,
    monto            int          null,
    fecha            date         null,
    viaje_id         int unsigned null
);



create table salud
(
    id           bigint unsigned auto_increment
        primary key,
    nombre_salud varchar(255) not null
);



create table salud_discapacidades
(
    id                  int auto_increment
        primary key,
    posee_carnet        enum ('Y', 'N') null,
    discpacidad         varchar(200)    null,
    causa_principal     varchar(200)    null,
    causa_secundaria    varchar(200)    null,
    capacidad_reducidad enum ('Y', 'N') null,
    trabajador_id       bigint unsigned null
);

create table salud_enfermedades
(
    id                     int auto_increment
        primary key,
    enfermedad_prexistente enum ('Y', 'N') default 'N' not null,
    tipo_sangre            varchar(100)                null,
    enfermedades           text                        null,
    medicamentos           text                        null,
    trabajador_id          bigint unsigned             not null
);

create table salud_trabajadores
(
    id                     int auto_increment
        primary key,
    salud_id               int                            null,
    cotiza_siete_porciento enum ('SI', 'NO') default 'NO' null,
    tipo_plan_salud        varchar(50)                    null,
    monto_peso             int                            null,
    monto_uf               float                          null,
    trabajador_id          bigint unsigned                null
);

create table solicitud_trabajador
(
    id             int auto_increment
        primary key,
    asunto         varchar(100)                                                                                                                                          null,
    trabajador_id  bigint unsigned                                                                                                                                       null,
    user_id        bigint unsigned                                                                                                                                       null,
    comentario     text                                                                                                                                                  null,
    tipo_solicitud enum ('copia de contrato', 'certificado antiguidad', 'carga familiar', 'modificación de datos', 'cambio cuenta bancaria') default 'copia de contrato' not null,
    datos          text                                                                                                                                                  null,
    estado         enum ('pendiente', 'en proceso', 'finalizado')                                                                            default 'pendiente'         not null,
    created_at     timestamp                                                                                                                                             null,
    updated_at     timestamp                                                                                                                                             null
);


create table sugerencias
(
    id                  int auto_increment
        primary key,
    trabajador_id       bigint unsigned                                                                   null,
    areas_id            bigint                                                                            null,
    area_operacion      enum ('seguridad', 'salud', 'medio ambiental', 'operacional', 'recursos humanos') null,
    mensaje_descripcion text                                                                              null,
    mensaje_propuestas  text                                                                              null,
    mensaje_de_mejoras  text                                                                              null,
    tipo_reclamo        enum ('reclamo', 'sugerencia', 'felicitaciones') default 'sugerencia'             null,
    estado              enum ('pendiente', 'respuesta envida')           default 'pendiente'              null,
    anonimo             enum ('si', 'no')                                default 'si'                     null,
    respuesta           text                                                                              null,
    created_at          timestamp                                                                         null,
    updated_at          timestamp                                                                         null
);



create table ticket
(
    id                 bigint unsigned auto_increment
        primary key,
    checklist_id       bigint unsigned                 not null,
    title              varchar(255)                    not null,
    description        text                            not null,
    status             varchar(255) default 'reported' not null,
    priority           varchar(255)                    null,
    category           varchar(255)                    null,
    reported_by        bigint unsigned                 null,
    assigned_to        bigint unsigned                 null,
    resolved_at        date                            null,
    resolution_summary text                            null,
    created_at         timestamp                       null,
    updated_at         timestamp                       null
);



create table ticket_attachments
(
    id          bigint unsigned auto_increment
        primary key,
    ticket_id   bigint unsigned not null,
    uploaded_by bigint unsigned not null,
    file_name   varchar(255)    not null,
    file_path   varchar(255)    not null,
    file_type   varchar(255)    not null,
    file_size   bigint          not null,
    created_at  timestamp       null,
    updated_at  timestamp       null
);

create table ticket_histories
(
    id          bigint unsigned auto_increment
        primary key,
    ticket_id   bigint unsigned not null,
    action_by   bigint unsigned not null,
    action      varchar(255)    not null,
    description text            null,
    created_at  timestamp       null,
    updated_at  timestamp       null
);



create table tipo_licencia_medicas
(
    id              bigint unsigned auto_increment
        primary key,
    nombre_licencia varchar(200) null
);

create table tipo_licencias
(
    id          int auto_increment
        primary key,
    descripcion varchar(100) null
);



create table trabajador_temporal
(
    id               int auto_increment
        primary key,
    rut              varchar(50)  null,
    nombres          varchar(255) null,
    apellidos        varchar(255) null,
    primer_nombre    varchar(255) null,
    segundo_nombres  varchar(255) null,
    primer_apellido  varchar(255) null,
    segundo_apellido varchar(255) null,
    contrasenas      varchar(255) null,
    user_id          int          null,
    comuna_id        int          null,
    direccion        varchar(255) null,
    region_id        int          null,
    fecha_nac        date         null,
    estado_civil     varchar(255) null,
    sexo             varchar(255) null,
    nacionalidad_id  int          null
);

create table trabajador_vacaciones
(
    id                               bigint unsigned auto_increment
        primary key,
    trabajador_id                    bigint unsigned              null,
    dias_habiles_solicitados         int                          null,
    fecha_primer_dia                 date                         null,
    saldo_previo_vacaciones          float                        null,
    saldo_despues_vacacaciones       float                        null,
    dias_corridos_del_periodo_de_vac int                          null,
    fecha_ultimo_dia                 date                         null,
    fecha_corte_calculo1             date                         null,
    fecha_corte_calculo2             date                         null,
    estado                           enum ('activo', 'terminada') null,
    rut                              varchar(50)                  null
);



create table trabajador_viajes
(
    id                      int unsigned auto_increment
        primary key,
    trabajador_id           bigint unsigned                                                                                                                 null,
    trabajador_reemplazo_id bigint unsigned             default '0'                                                                                         not null,
    viaje_id                int unsigned                                                                                                                    null,
    motivo                  text                                                                                                                            null,
    tipo_tripulante         enum ('CONDUCTOR_UNO', 'CONDUCTOR_DOS', 'AUXILIAR', 'CONDUCTOR_UNO_REEMPLAZO', 'CONDUCTOR_DOS_REEMPLAZO', 'AUXILIAR_REEMPLAZO') null,
    orden                   int unsigned                                                                                                                    null,
    estado                  enum ('ACTIVO', 'INACTIVO') default 'ACTIVO'                                                                                    null
);

create table trabajador_vitacoras
(
    id            int unsigned auto_increment
        primary key,
    trabajador_id bigint unsigned null,
    fecha         datetime        null,
    observacion   text            null,
    user_id       bigint unsigned null
);



create table trabajadores
(
    id                          bigint unsigned auto_increment
        primary key,
    codigo_trabajador           varchar(10)                                                                                                                                                                                                                          null,
    rut                         varchar(255)                                                                                                                                                                                                                         null,
    primer_nombre               varchar(255)                                                                                                                                                                                                                         null,
    segundo_nombre              varchar(255)                                                                                                                                                                                                                         null,
    primer_apellido             varchar(255)                                                                                                                                                                                                                         null,
    segundo_apellido            varchar(255)                                                                                                                                                                                                                         null,
    telefono_local              varchar(255)                                                                                                                                                                                                                         null,
    telefono_celular            varchar(255)                                                                                                                                                                                                                         null,
    correo                      varchar(255)                                                                                                                                                                                                                         null,
    fecha_nac                   date                                                                                                                                                                                                                                 null,
    estado_civil                varchar(255)                                                                                                         default 'Soltero'                                                                                               null,
    sexo                        enum ('masculino', 'femenino', 'Indeterminado')                                                                      default 'masculino'                                                                                             null,
    grado_escolaridad           enum ('SIN ESCOLARIDAD', 'BÁSICA', 'MEDIA CIENTÍFICO HUMANISTA', 'MEDIA TÉCNICA PROFESIONAL', 'TÉCNICO SUPERIOR INCOMPLETA', 'TÉCNICO SUPERIOR COMPLETA', 'PROFESIONAL INCOMPLETA', 'PROFESIONAL COMPLETA', 'MAGISTER', 'DOCTORADO') null,
    direccion                   varchar(255)                                                                                                                                                                                                                         null,
    comuna_id                   bigint unsigned                                                                                                      default '0'                                                                                                     null,
    region_id                   bigint unsigned                                                                                                      default '0'                                                                                                     null,
    nacionalidad_id             int unsigned                                                                                                                                                                                                                         null,
    pertenece_pueblo_originario enum ('si', 'no')                                                                                                    default 'no'                                                                                                    null,
    pueblo_originario_id        bigint unsigned                                                                                                                                                                                                                      null,
    tiene_familia               enum ('si', 'no')                                                                                                    default 'no'                                                                                                    null,
    tiene_discapacidad          enum ('si', 'no')                                                                                                    default 'no'                                                                                                    null,
    user_id                     bigint unsigned                                                                                                      default '0'                                                                                                     null,
    estado                      enum ('postulado', 'contratado', 'desvinculado', 'reincorporado')                                                    default 'postulado'                                                                                             null,
    condicion                   enum ('dias libre', 'vacaciones', 'falla', 'disponible', 'activo', 'en ruta', 'licencia médica', 'permiso especial') default 'disponible'                                                                                            null,
    ubicacion_actual            varchar(255)                                                                                                                                                                                                                         null,
    created_at                  timestamp                                                                                                                                                                                                                            null,
    updated_at                  timestamp                                                                                                                                                                                                                            null,
    deleted_at                  timestamp                                                                                                                                                                                                                            null
);



create table tramite_licencia_medicas
(
    id                       bigint unsigned auto_increment
        primary key,
    rut                      varchar(50)                                        null,
    fecha_emision            date                                               null,
    fecha_recepcion          date                                               null,
    fecha_procesado          date                                               null,
    fecha_inicio             date                                               null,
    dias                     int                             default 0          null,
    fecha_fin                date                                               null,
    medio                    varchar(200)                                       null,
    motivo                   varchar(255)                                       null,
    tipo_licencia_medicas_id bigint unsigned                                    null,
    trabajador_id            bigint unsigned                                    null,
    user_id                  bigint unsigned                                    null,
    estado                   enum ('Iniciado', 'finalizado') default 'Iniciado' not null,
    created_at               timestamp                                          null,
    updated_at               timestamp                                          null
);



create table tramo_viajes
(
    id         int auto_increment
        primary key,
    origen_id  int unsigned null,
    destino_id int unsigned null,
    horas      int          null,
    tramo_id   int unsigned null
);

create table tramos
(
    id    int unsigned auto_increment
        primary key,
    tramo varchar(200) not null
);



create table ubicaciones
(
    id               bigint auto_increment
        primary key,
    nombre_ubicacion varchar(200) not null
);


create table users
(
    id                  bigint unsigned auto_increment
        primary key,
    name                varchar(255)                     null,
    apellidos           varchar(255)                     null,
    rut                 varchar(255)                     null,
    email               varchar(255)                     null,
    email_verified_at   timestamp                        null,
    digitos_rut         varchar(50)                      null,
    password            varchar(255)                     null,
    cargo               varchar(255)                     null,
    tpluss              enum ('Y', 'N', 'V') default 'N' null,
    thcm                enum ('Y', 'N', 'V') default 'N' null,
    tgcm                enum ('Y', 'N', 'V') default 'N' null,
    tdcm                enum ('Y', 'N', 'V') default 'N' null,
    bgcm                enum ('Y', 'N', 'V') default 'N' null,
    gcm                 enum ('Y', 'N', 'V') default 'N' null,
    turis               enum ('Y', 'N', 'V') default 'N' null,
    administracion      enum ('Y', 'N', 'V') default 'N' null,
    mantencion          enum ('Y', 'N', 'V') default 'N' null,
    servicios_generales enum ('Y', 'N', 'V') default 'N' null,
    agentes_ventas      enum ('Y', 'N', 'V') default 'N' null,
    plussmineria        enum ('Y', 'N', 'V') default 'N' null,
    primer_login        enum ('Y', 'N')      default 'Y' null,
    cambio_contrasena   enum ('Y', 'N')      default 'N' null,
    notificable         enum ('Y', 'N')      default 'N' null,
    remember_token      varchar(50)                      null,
    created_at          timestamp                        null,
    updated_at          timestamp                        null,
    deleted_at          timestamp                        null,
    oficina_id          int unsigned         default '0' null
);

create table viajes
(
    id               int unsigned auto_increment
        primary key,
    nro_viaje        varchar(50)                                                             default '0'                 not null,
    buses_id         bigint unsigned                                                                                     null,
    origen_id        int unsigned                                                                                        null,
    destino_id       int unsigned                                                                                        null,
    viaje_especial   enum ('Y', 'N')                                                         default 'N'                 null,
    destino_especial varchar(100)                                                                                        null,
    origen_especial  varchar(100)                                                                                        null,
    fecha_viaje      date                                                                                                not null,
    hora_salida      time                                                                                                not null,
    hora_llegada     time                                                                                                not null,
    fecha_llegada    date                                                                                                null,
    nota_viaje       text                                                                                                null,
    notificacion     enum ('Y', 'N')                                                         default 'N'                 null,
    cliente_id       int unsigned                                                                                        null,
    empleador_id     bigint unsigned                                                                                     null,
    tipo_viaje       enum ('servicio en linea', 'servicio en mineria')                       default 'servicio en linea' null,
    estado           enum ('EN RUTA', 'EN ORIGEN', 'EN DESTINO', 'SUSPENDIDO', 'FINALIZADO') default 'EN ORIGEN'         null
);

create table viajesalidas
(
    id          int auto_increment
        primary key,
    folio       varchar(45)                                                                                                                                                   null,
    fecha       date                                                                                                                                                          null,
    hora        time                                                                                                                                                          null,
    viaje_id    int unsigned                                                                                                                                                  null,
    tipo_salida enum ('SALIDA A SERVICIO', 'PRUEBA DE RUTA', 'TRASLADO A OTRO DEPENDENCIA', 'TRASLADO A TALLER EXTERNO', 'SALIDA DE EMERGENBCIA') default 'SALIDA A SERVICIO' null
);


create table votaciones
(
    user_id        bigint unsigned null,
    trabajador_id  bigint unsigned null,
    categoria      varchar(100)    null,
    fecha_votacion timestamp       null
);


