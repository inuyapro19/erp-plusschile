create table if not exists ahorros_voluntarios
(
    id     int auto_increment
        constraint `PRIMARY`
        primary key,
    nombre varchar(200) null
)
    charset = latin1;

create table if not exists areas
(
    id               bigint auto_increment
        constraint `PRIMARY`
        primary key,
    descripcion_area varchar(200)     null,
    trabajador_id    bigint default 0 null comment 'jefe de area'
)
    charset = latin1;

create table if not exists banco
(
    id           int auto_increment
        constraint `PRIMARY`
        primary key,
    nombre_banco varchar(100) not null
)
    charset = latin1;

create table if not exists bono_haberes
(
    id                   int auto_increment
        constraint `PRIMARY`
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
)
    charset = latin1;

create table if not exists cargos
(
    id           bigint auto_increment
        constraint `PRIMARY`
        primary key,
    nombre_cargo varchar(200) null,
    area_id      bigint       null,
    created_at   timestamp    null,
    updated_at   timestamp    null,
    constraint cargos_ibfk_1
        foreign key (area_id) references areas (id)
            on update cascade
)
    charset = latin1;

create table if not exists categorias
(
    id               bigint unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    nombre_categoria varchar(100) null,
    created_at       timestamp    null,
    updated_at       timestamp    null
)
    charset = latin1;

create table if not exists certificadosfolios
(
    id             int unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    folio          int unsigned                                                                                           null,
    fecha_creacion date                                                                                                   null,
    hora           time                                                                                                   null,
    tipo_folio     enum ('VIAJE', 'CERTIFICADO DE SALIDA', 'CERTIFICADO SANITIZACION') default 'CERTIFICADO SANITIZACION' null
)
    charset = latin1;

create table if not exists checklist_categories
(
    id          bigint unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    name        varchar(255) not null,
    description text         null,
    created_at  timestamp    null,
    updated_at  timestamp    null
);

create table if not exists checklist_types
(
    id          bigint unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    name        varchar(255)    not null,
    description text            null,
    category_id bigint unsigned not null,
    order_type  int default 0   null,
    constraint checklist_types_ibfk_1
        foreign key (category_id) references checklist_categories (id)
);

create table if not exists checklist_items
(
    id          bigint unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    type_id     bigint unsigned      not null,
    name        varchar(255)         not null,
    description text                 null,
    parent_id   bigint unsigned      null,
    isChild     tinyint(1) default 0 not null,
    order_item  int        default 0 not null,
    area_id     bigint unsigned      null,
    constraint checklist_items_ibfk_1
        foreign key (type_id) references checklist_types (id),
    constraint checklist_items_ibfk_2
        foreign key (parent_id) references checklist_items (id)
);

create index parent_id
    on checklist_items (parent_id);

create index type_id
    on checklist_items (type_id);

create table if not exists checklist_structure
(
    id          bigint unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    category_id bigint unsigned not null,
    type_id     bigint unsigned not null,
    constraint checklist_structure_ibfk_1
        foreign key (category_id) references checklist_categories (id),
    constraint checklist_structure_ibfk_2
        foreign key (type_id) references checklist_types (id)
);

create index category_id
    on checklist_structure (category_id);

create index type_id
    on checklist_structure (type_id);

create index category_id
    on checklist_types (category_id);

create table if not exists clientes
(
    id             int unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    nombre_cliente varchar(50) not null
)
    charset = latin1;

create table if not exists contrato_temporal
(
    id                int          not null
        constraint `PRIMARY`
        primary key,
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

create table if not exists destinos
(
    id     int unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    ciudad varchar(255) not null
)
    charset = latin1;

create table if not exists checklists
(
    id            bigint unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    category_id   bigint unsigned                                                                     not null,
    user_id       bigint unsigned                                                                     not null,
    bus_id        bigint unsigned                                                                     not null,
    folio         varchar(255)                                                                        null,
    TIPO_SERVICIO enum ('SERVICIO EN LINEA', 'SERVICION EN MINERIA')      default 'SERVICIO EN LINEA' null,
    destino_id    int unsigned                                                                        null,
    fecha         date                                                    default '2023-01-01'        null,
    observaciones text                                                                                null,
    status        enum ('incomplete', 'complete', 'approved', 'rejected') default 'incomplete'        not null,
    created_at    timestamp                                                                           null,
    updated_at    timestamp                                                                           null,
    constraint folio
        unique (folio),
    constraint checklists_ibfk_1
        foreign key (category_id) references checklist_categories (id),
    constraint checklists_ibfk_2
        foreign key (destino_id) references destinos (id)
            on update cascade on delete cascade,
    constraint checklists_ibfk_3
        foreign key (destino_id) references destinos (id)
            on update cascade on delete cascade
);

create table if not exists checklist_responses
(
    id           bigint unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    checklist_id bigint unsigned not null,
    item_id      bigint unsigned not null,
    response     text            null,
    created_at   timestamp       null,
    updated_at   timestamp       null,
    constraint checklist_responses_ibfk_1
        foreign key (checklist_id) references checklists (id),
    constraint checklist_responses_ibfk_2
        foreign key (item_id) references checklist_items (id)
);

create index checklist_id
    on checklist_responses (checklist_id);

create index item_id
    on checklist_responses (item_id);

create index category_id
    on checklists (category_id);

create index destino_id
    on checklists (destino_id);

create table if not exists documento_contratos
(
    id         bigint auto_increment
        constraint `PRIMARY`
        primary key,
    texto      longtext  not null,
    created_at timestamp null,
    updated_at timestamp null
)
    charset = latin1;

create table if not exists documentos
(
    id               bigint auto_increment
        constraint `PRIMARY`
        primary key,
    texto            longtext                                                                                                                          not null,
    tipo_documento   enum ('certificado antiguidad', 'certificado vacaciones', 'certidicado de afiliacion', 'sin determinar') default 'sin determinar' null,
    created_at       timestamp                                                                                                                         null,
    updated_at       timestamp                                                                                                                         null,
    nombre_documento varchar(200)                                                                                                                      null
)
    charset = latin1;

create table if not exists empleadores
(
    id                  bigint unsigned auto_increment
        constraint `PRIMARY`
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
    updated_at          timestamp    null,
    constraint empleadores_codigo_empresa_uindex
        unique (codigo_empresa)
)
    collate = utf8mb4_unicode_ci;

create table if not exists buses
(
    id                        bigint unsigned auto_increment
        constraint `PRIMARY`
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
    propietario               varchar(255)                                                                                                                                                 null,
    constraint buses_ibfk_1
        foreign key (empleador_id) references empleadores (id)
            on update cascade on delete cascade
)
    charset = latin1;

create table if not exists bus_certificados
(
    id                         int unsigned auto_increment
        constraint `PRIMARY`
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
    estado                     enum ('VALIDO', 'VENCIDO')                                                                                                                       null,
    constraint FK_bus_certificados_buses
        foreign key (bus_id) references buses (id)
            on update cascade on delete cascade
)
    charset = latin1;

create index empleador_id
    on buses (empleador_id);

create table if not exists certificado_recorridos
(
    id                     int unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    bus_certificado_id     int unsigned null,
    origen_id              int unsigned null,
    destino_id             int unsigned null,
    recorrido_tramo_ida    text         null,
    recorrido_tramo_vuelta text         null,
    constraint FK_certificado_recorridos_bus_certificados
        foreign key (bus_certificado_id) references bus_certificados (id)
            on update cascade on delete cascade,
    constraint FK_certificado_recorridos_destinos
        foreign key (origen_id) references destinos (id)
            on update cascade on delete cascade,
    constraint FK_certificado_recorridos_destinos_2
        foreign key (destino_id) references destinos (id)
            on update cascade on delete cascade
)
    charset = latin1;

create table if not exists failed_jobs
(
    id         bigint unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    uuid       varchar(255)                        not null,
    connection text                                not null,
    queue      text                                not null,
    payload    longtext                            not null,
    exception  longtext                            not null,
    failed_at  timestamp default CURRENT_TIMESTAMP not null,
    constraint failed_jobs_uuid_unique
        unique (uuid)
)
    collate = utf8mb4_unicode_ci;

create table if not exists field_types
(
    id   bigint unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    name varchar(255) not null
);

create table if not exists checklist_item_fields
(
    id            bigint unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    item_id       bigint unsigned not null,
    field_type_id bigint unsigned not null,
    label         varchar(255)    not null,
    options       text            null,
    constraint checklist_item_fields_ibfk_1
        foreign key (item_id) references checklist_items (id),
    constraint checklist_item_fields_ibfk_2
        foreign key (field_type_id) references field_types (id)
);

create index field_type_id
    on checklist_item_fields (field_type_id);

create index item_id
    on checklist_item_fields (item_id);

create table if not exists firmas
(
    id           bigint auto_increment
        constraint `PRIMARY`
        primary key,
    nombre_firma varchar(200) null,
    imagen_firma varchar(200) null,
    created_at   timestamp    null,
    updated_at   timestamp    null
)
    charset = latin1;

create table if not exists folios_viajes
(
    id        int unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    nro_folio int      default 0                     null,
    fecha     datetime default '2022-11-01 00:00:00' null
)
    charset = latin1;

create table if not exists gasto_tipos
(
    id        int unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    tipo_name varchar(200) default 'PEAJE' null
)
    charset = latin1;

create table if not exists historial_contratos
(
    id                         bigint unsigned auto_increment
        constraint `PRIMARY`
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

create index FK_contrato_areas
    on historial_contratos (area_id);

create index FK_contrato_empleadores
    on historial_contratos (empleador_id);

create index cargo_id
    on historial_contratos (cargo_id);

create index contrato_prevision_id_foreign
    on historial_contratos (prevision_id);

create index contrato_salud_id_foreign
    on historial_contratos (salud_id);

create index contrato_trabajador_id_foreign
    on historial_contratos (trabajador_id);

create index ubicacion_id
    on historial_contratos (ubicacion_id);

create table if not exists historial_trabajadores
(
    id                          bigint unsigned auto_increment
        constraint `PRIMARY`
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
    deleted_at                  timestamp                                                                                                                                                                                                                            null,
    constraint rut
        unique (rut),
    constraint trabajadores_codigo_trabajador_uindex
        unique (codigo_trabajador)
)
    collate = utf8mb4_unicode_ci;

create index FK_trabajadores_comunas
    on historial_trabajadores (comuna_id);

create index FK_trabajadores_regiones
    on historial_trabajadores (region_id);

create index FK_trabajadores_users
    on historial_trabajadores (user_id);

create index nacionalidad_id
    on historial_trabajadores (nacionalidad_id);

create index pueblo_originario_id
    on historial_trabajadores (pueblo_originario_id);

create table if not exists menus
(
    id        int auto_increment
        constraint `PRIMARY`
        primary key,
    title     varchar(255)  not null,
    parent_id int           null,
    route     varchar(255)  null,
    icon      varchar(255)  null,
    position  int default 0 null,
    constraint menus_ibfk_1
        foreign key (parent_id) references menus (id)
);

create index parent_id
    on menus (parent_id);

create table if not exists meses_remuneraciones
(
    id         int auto_increment
        constraint `PRIMARY`
        primary key,
    nombre_mes varchar(200)                null,
    isOpen     enum ('Y', 'N') default 'Y' null
)
    charset = latin1;

create table if not exists migrations
(
    id        int unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    migration varchar(255) not null,
    batch     int          not null
)
    collate = utf8mb4_unicode_ci;

create table if not exists montos_destinos
(
    id                   int unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    destino_id           int unsigned             null,
    monto_predeterminado int unsigned default '0' null,
    constraint montos_destinos_ibfk_1
        foreign key (destino_id) references destinos (id)
)
    charset = latin1;

create index destino_id
    on montos_destinos (destino_id);

create table if not exists movimiento_trabajadores
(
    id          int auto_increment
        constraint `PRIMARY`
        primary key,
    codigo      varchar(200) null,
    descripcion text         null
)
    charset = latin1;

create table if not exists historial_desvinculaciones
(
    id                     int unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    fecha_desvinculacion   date            null,
    causal_de_hecho        varchar(200)    null,
    motivo_interno_empresa varchar(200)    null,
    motivo_id              int             null,
    trabajador_id          bigint unsigned null,
    created_at             timestamp       null,
    updated_at             timestamp       null,
    constraint FK_historial_desvinculaciones_movimiento_trabajadores
        foreign key (motivo_id) references movimiento_trabajadores (id)
            on update cascade on delete cascade
)
    charset = latin1;

create index FK_historial_desvinculaciones_trabajadores
    on historial_desvinculaciones (trabajador_id);

create table if not exists nacionalidades
(
    id                       int unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    descripcion_nacionalidad varchar(100) null
)
    charset = latin1;

create table if not exists notifications
(
    id              char(36)        not null
        constraint `PRIMARY`
        primary key,
    type            varchar(255)    not null,
    notifiable_type varchar(255)    not null,
    notifiable_id   bigint unsigned not null,
    data            text            not null,
    read_at         timestamp       null,
    created_at      timestamp       null,
    updated_at      timestamp       null
)
    collate = utf8mb4_unicode_ci;

create index notifications_notifiable_type_notifiable_id_index
    on notifications (notifiable_type, notifiable_id);

create table if not exists oauth_access_tokens
(
    id         varchar(100)    not null
        constraint `PRIMARY`
        primary key,
    user_id    bigint unsigned null,
    client_id  char(36)        not null,
    name       varchar(255)    null,
    scopes     text            null,
    revoked    tinyint(1)      not null,
    created_at timestamp       null,
    updated_at timestamp       null,
    expires_at datetime        null
)
    collate = utf8mb4_unicode_ci;

create index oauth_access_tokens_user_id_index
    on oauth_access_tokens (user_id);

create table if not exists oauth_auth_codes
(
    id         varchar(100)    not null
        constraint `PRIMARY`
        primary key,
    user_id    bigint unsigned not null,
    client_id  char(36)        not null,
    scopes     text            null,
    revoked    tinyint(1)      not null,
    expires_at datetime        null
)
    collate = utf8mb4_unicode_ci;

create index oauth_auth_codes_user_id_index
    on oauth_auth_codes (user_id);

create table if not exists oauth_clients
(
    id                     char(36)        not null
        constraint `PRIMARY`
        primary key,
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
)
    collate = utf8mb4_unicode_ci;

create index oauth_clients_user_id_index
    on oauth_clients (user_id);

create table if not exists oauth_personal_access_clients
(
    id         bigint unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    client_id  char(36)  not null,
    created_at timestamp null,
    updated_at timestamp null
)
    collate = utf8mb4_unicode_ci;

create table if not exists oauth_refresh_tokens
(
    id              varchar(100) not null
        constraint `PRIMARY`
        primary key,
    access_token_id varchar(100) not null,
    revoked         tinyint(1)   not null,
    expires_at      datetime     null
)
    collate = utf8mb4_unicode_ci;

create index oauth_refresh_tokens_access_token_id_index
    on oauth_refresh_tokens (access_token_id);

create table if not exists oficinas
(
    id         int unsigned auto_increment
        constraint `PRIMARY`
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
)
    collate = utf8mb4_unicode_ci;

create table if not exists parametro_liquidaciones
(
    id          int auto_increment
        constraint `PRIMARY`
        primary key,
    descripcion varchar(200)                                                                                                     null,
    valor       float(10, 2)                                                                                                     null,
    tipo        enum ('GRATIFICACION DEFINIDA', 'PREVIRED', 'TRAMOS FAMILIAR', 'SEGURO CENSANTIA TRABAJADOR', 'TRAMOS IMPUESTO') null
)
    charset = latin1;

create table if not exists parentescos
(
    id          int auto_increment
        constraint `PRIMARY`
        primary key,
    codigo      int          not null,
    descripcion varchar(200) not null
)
    charset = latin1;

create table if not exists password_resets
(
    email      varchar(255) not null,
    token      varchar(255) not null,
    created_at timestamp    null
)
    collate = utf8mb4_unicode_ci;

create index password_resets_email_index
    on password_resets (email);

create table if not exists permissions
(
    id         bigint unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    name       varchar(255) not null,
    guard_name varchar(255) not null,
    created_at timestamp    null,
    updated_at timestamp    null,
    constraint permissions_name_guard_name_unique
        unique (name, guard_name)
)
    collate = utf8mb4_unicode_ci;

create table if not exists model_has_permissions
(
    permission_id bigint unsigned not null,
    model_type    varchar(255)    not null,
    model_id      bigint unsigned not null,
    constraint `PRIMARY`
        primary key (permission_id, model_id, model_type),
    constraint model_has_permissions_permission_id_foreign
        foreign key (permission_id) references permissions (id)
            on delete cascade
)
    collate = utf8mb4_unicode_ci;

create index model_has_permissions_model_id_model_type_index
    on model_has_permissions (model_id, model_type);

create table if not exists personal_access_tokens
(
    id             bigint unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    tokenable_type varchar(255)    not null,
    tokenable_id   bigint unsigned not null,
    name           varchar(255)    not null,
    token          varchar(64)     not null,
    abilities      text            null,
    last_used_at   timestamp       null,
    expires_at     timestamp       null,
    created_at     timestamp       null,
    updated_at     timestamp       null,
    constraint personal_access_tokens_token_unique
        unique (token)
)
    collate = utf8mb4_unicode_ci;

create index personal_access_tokens_tokenable_type_tokenable_id_index
    on personal_access_tokens (tokenable_type, tokenable_id);

create table if not exists prestamos_trabajador
(
    id            int auto_increment
        constraint `PRIMARY`
        primary key,
    monto         int                      not null,
    cuotas        int                      not null,
    tipo          enum ('EMPRESA', 'CAJA') null,
    trabajador_id bigint                   null,
    descripcion   varchar(200)             null,
    periodo_pago  varchar(200)             null comment 'mes de la cuota',
    cuota_inicial int                      null
)
    charset = latin1;

create table if not exists prevision_inp
(
    id     int auto_increment
        constraint `PRIMARY`
        primary key,
    codigo int          null,
    nombre varchar(100) null
)
    charset = latin1;

create table if not exists previsiones
(
    id                   bigint unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    codigo               varchar(10)  null,
    nombre_prevision     varchar(255) not null,
    porcentaje_prevision float        null
)
    collate = utf8mb4_unicode_ci;

create table if not exists previsiones_tempora
(
    id            int auto_increment
        constraint `PRIMARY`
        primary key,
    trabajador_id int          null,
    afp           varchar(255) null,
    afp_id        int          null,
    salud         varchar(255) null,
    salud_id      int          null,
    porcentaje    int          null
)
    charset = latin1;

create table if not exists pueblo_originarios
(
    id                bigint unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    pueblo_originario varchar(100) null
)
    charset = latin1;

create table if not exists regiones
(
    id            bigint unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    nombre_region varchar(255) not null
)
    collate = utf8mb4_unicode_ci;

create table if not exists calendario_configuracion
(
    id              int auto_increment
        constraint `PRIMARY`
        primary key,
    dia             int                                                                                                                                null,
    mes             enum ('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre') null,
    anyo            int                                                                                                                                null,
    fecha_inicio    date                                                                                                                               null,
    fecha_fin       date                                                                                                                               null,
    tipo_de_fecha   enum ('feriado', 'fin de semana')                                                                                                  null,
    tipo_de_feriado enum ('nacional', 'regional')                                                                                                      null,
    region_id       bigint unsigned                                                                                                                    null,
    constraint FK_calendario_configuracion_regiones
        foreign key (region_id) references regiones (id)
)
    charset = latin1;

create table if not exists comunas
(
    id            bigint unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    nombre_comuna varchar(255)    not null,
    region_id     bigint unsigned not null,
    constraint comunas_region_id_foreign
        foreign key (region_id) references regiones (id)
)
    collate = utf8mb4_unicode_ci;

create table if not exists roles
(
    id         bigint unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    name       varchar(255) not null,
    guard_name varchar(255) not null,
    created_at timestamp    null,
    updated_at timestamp    null,
    constraint roles_name_guard_name_unique
        unique (name, guard_name)
)
    collate = utf8mb4_unicode_ci;

create table if not exists menu_role
(
    menu_id int             not null,
    role_id bigint unsigned not null,
    constraint `PRIMARY`
        primary key (menu_id, role_id),
    constraint menu_role_ibfk_1
        foreign key (menu_id) references menus (id),
    constraint menu_role_ibfk_2
        foreign key (role_id) references roles (id)
);

create index role_id
    on menu_role (role_id);

create table if not exists model_has_roles
(
    role_id    bigint unsigned not null,
    model_type varchar(255)    not null,
    model_id   bigint unsigned not null,
    constraint `PRIMARY`
        primary key (role_id, model_id, model_type),
    constraint model_has_roles_role_id_foreign
        foreign key (role_id) references roles (id)
            on delete cascade
)
    collate = utf8mb4_unicode_ci;

create index model_has_roles_model_id_model_type_index
    on model_has_roles (model_id, model_type);

create table if not exists role_has_permissions
(
    permission_id bigint unsigned not null,
    role_id       bigint unsigned not null,
    constraint `PRIMARY`
        primary key (permission_id, role_id),
    constraint role_has_permissions_permission_id_foreign
        foreign key (permission_id) references permissions (id)
            on delete cascade,
    constraint role_has_permissions_role_id_foreign
        foreign key (role_id) references roles (id)
            on delete cascade
)
    collate = utf8mb4_unicode_ci;

create table if not exists salud
(
    id           bigint unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    nombre_salud varchar(255) not null
)
    collate = utf8mb4_unicode_ci;

create table if not exists tipo_licencia_medicas
(
    id              bigint unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    nombre_licencia varchar(200) null
)
    charset = latin1;

create table if not exists tipo_licencias
(
    id          int auto_increment
        constraint `PRIMARY`
        primary key,
    descripcion varchar(100) null
)
    charset = latin1;

create table if not exists trabajador_temporal
(
    id               int auto_increment
        constraint `PRIMARY`
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
)
    charset = latin1;

create table if not exists tramos
(
    id    int unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    tramo varchar(200) not null
)
    charset = latin1;

create table if not exists tramo_viajes
(
    id         int auto_increment
        constraint `PRIMARY`
        primary key,
    origen_id  int unsigned null,
    destino_id int unsigned null,
    horas      int          null,
    tramo_id   int unsigned null,
    constraint tramo_viajes_ibfk_1
        foreign key (origen_id) references destinos (id),
    constraint tramo_viajes_ibfk_2
        foreign key (destino_id) references destinos (id),
    constraint tramo_viajes_ibfk_3
        foreign key (tramo_id) references tramos (id)
)
    charset = latin1;

create index destino_id
    on tramo_viajes (destino_id);

create index origen_id
    on tramo_viajes (origen_id);

create index tramo_id
    on tramo_viajes (tramo_id);

create table if not exists ubicaciones
(
    id               bigint auto_increment
        constraint `PRIMARY`
        primary key,
    nombre_ubicacion varchar(200) not null
)
    charset = latin1;

create table if not exists users
(
    id                  bigint unsigned auto_increment
        constraint `PRIMARY`
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
    oficina_id          int unsigned         default '0' null,
    constraint rut
        unique (rut)
)
    collate = utf8mb4_unicode_ci;

create table if not exists categoria_user
(
    categoria_id bigint unsigned null,
    user_id      bigint unsigned null,
    constraint FK_categoria_users_categorias
        foreign key (categoria_id) references categorias (id)
            on update cascade on delete cascade,
    constraint FK_categoria_users_users
        foreign key (user_id) references users (id)
            on update cascade on delete cascade
)
    charset = latin1;

create table if not exists checklist_item_users
(
    id      bigint unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    item_id bigint unsigned not null,
    user_id bigint unsigned not null,
    constraint checklist_item_users_item_id_foreign
        foreign key (item_id) references checklist_items (id),
    constraint checklist_item_users_user_id_foreign
        foreign key (user_id) references users (id)
);

create table if not exists folios_impresion_caja
(
    id         int auto_increment
        constraint `PRIMARY`
        primary key,
    nro_folio  varchar(10)                         not null,
    fecha      date                                not null,
    user_id    bigint unsigned                     null,
    created_at timestamp default CURRENT_TIMESTAMP not null,
    updated_at timestamp default CURRENT_TIMESTAMP not null on update CURRENT_TIMESTAMP,
    constraint folios_impresion_caja_ibfk_1
        foreign key (user_id) references users (id)
)
    charset = latin1;

create index user_id
    on folios_impresion_caja (user_id);

create table if not exists log_sistemas
(
    id                int unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    user_id           bigint unsigned null,
    fecha             datetime        null,
    accion            varchar(200)    null,
    tabla             varchar(200)    null,
    registro_id       bigint unsigned null,
    registro_anterior text            null,
    registro_nuevo    text            null,
    constraint log_sistemas_ibfk_1
        foreign key (user_id) references users (id)
)
    charset = latin1;

create index user_id
    on log_sistemas (user_id);

create table if not exists oficina_users
(
    id         int unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    oficina_id int unsigned    null,
    user_id    bigint unsigned null,
    constraint oficina_users_ibfk_1
        foreign key (oficina_id) references oficinas (id),
    constraint oficina_users_ibfk_2
        foreign key (user_id) references users (id)
)
    charset = latin1;

create index oficina_id
    on oficina_users (oficina_id);

create index user_id
    on oficina_users (user_id);

create table if not exists ticket
(
    id                 bigint unsigned auto_increment
        constraint `PRIMARY`
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
    updated_at         timestamp                       null,
    constraint ticket_ibfk_1
        foreign key (checklist_id) references checklists (id),
    constraint ticket_ibfk_2
        foreign key (reported_by) references users (id),
    constraint ticket_ibfk_3
        foreign key (assigned_to) references users (id)
);

create index assigned_to
    on ticket (assigned_to);

create index checklist_id
    on ticket (checklist_id);

create index reported_by
    on ticket (reported_by);

create table if not exists ticket_attachments
(
    id          bigint unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    ticket_id   bigint unsigned not null,
    uploaded_by bigint unsigned not null,
    file_name   varchar(255)    not null,
    file_path   varchar(255)    not null,
    file_type   varchar(255)    not null,
    file_size   bigint          not null,
    created_at  timestamp       null,
    updated_at  timestamp       null,
    constraint ticket_attachments_ibfk_1
        foreign key (ticket_id) references ticket (id),
    constraint ticket_attachments_ibfk_2
        foreign key (uploaded_by) references users (id)
);

create index ticket_id
    on ticket_attachments (ticket_id);

create index uploaded_by
    on ticket_attachments (uploaded_by);

create table if not exists ticket_histories
(
    id          bigint unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    ticket_id   bigint unsigned not null,
    action_by   bigint unsigned not null,
    action      varchar(255)    not null,
    description text            null,
    created_at  timestamp       null,
    updated_at  timestamp       null,
    constraint ticket_histories_ibfk_1
        foreign key (ticket_id) references ticket (id),
    constraint ticket_histories_ibfk_2
        foreign key (action_by) references users (id)
);

create index action_by
    on ticket_histories (action_by);

create index ticket_id
    on ticket_histories (ticket_id);

create table if not exists trabajadores
(
    id                          bigint unsigned auto_increment
        constraint `PRIMARY`
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
    deleted_at                  timestamp                                                                                                                                                                                                                            null,
    constraint rut
        unique (rut),
    constraint trabajadores_codigo_trabajador_uindex
        unique (codigo_trabajador),
    constraint FK_trabajadores_comunas
        foreign key (comuna_id) references comunas (id)
            on update cascade on delete cascade,
    constraint FK_trabajadores_regiones
        foreign key (region_id) references regiones (id)
            on update cascade on delete cascade,
    constraint FK_trabajadores_users
        foreign key (user_id) references users (id)
            on update cascade on delete cascade,
    constraint trabajadores_ibfk_1
        foreign key (nacionalidad_id) references nacionalidades (id)
            on update cascade on delete cascade,
    constraint trabajadores_ibfk_2
        foreign key (pueblo_originario_id) references pueblo_originarios (id)
)
    collate = utf8mb4_unicode_ci;

create table if not exists ahorro_trabajadores
(
    id                   int auto_increment
        constraint `PRIMARY`
        primary key,
    tipo_ahorro          varchar(50)     null,
    ahorro_voluntario_id int             null,
    tipo_moneda          varchar(50)     null,
    monto                float           null,
    forma_pago           varchar(50)     null,
    trabajador_id        bigint unsigned null,
    constraint FK_ahorro_trabajadores_ahorros_voluntarios
        foreign key (ahorro_voluntario_id) references ahorros_voluntarios (id)
            on update cascade on delete cascade,
    constraint FK_ahorro_trabajadores_trabajadores
        foreign key (trabajador_id) references trabajadores (id)
            on update cascade on delete cascade
)
    charset = latin1;

create table if not exists autorizadores
(
    id            int unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    trabajador_id bigint unsigned             null,
    modulo        varchar(200)                not null,
    estado        enum ('0', '1') default '0' null,
    constraint autorizadores_ibfk_1
        foreign key (trabajador_id) references trabajadores (id)
)
    charset = latin1;

create index trabajador_id
    on autorizadores (trabajador_id);

create table if not exists banco_trabajadores
(
    id                   int auto_increment
        constraint `PRIMARY`
        primary key,
    banco_id             int             null,
    trabajador_id        bigint unsigned null,
    nro_cuenta           varchar(50)     null,
    tipo_cuenta          varchar(255)    null,
    fecha_ingreso_cuenta date            null,
    predeterminado       enum ('Y', 'N') null,
    constraint banco_trabajadores_ibfk_1
        foreign key (trabajador_id) references trabajadores (id)
            on update cascade on delete cascade,
    constraint banco_trabajadores_ibfk_2
        foreign key (banco_id) references banco (id)
            on update cascade on delete cascade
)
    charset = latin1;

create index banco_id
    on banco_trabajadores (banco_id);

create index trabajador_id
    on banco_trabajadores (trabajador_id);

create table if not exists bono_trabajador
(
    id            int auto_increment
        constraint `PRIMARY`
        primary key,
    trabajador_id bigint unsigned             null,
    bonos_id      int                         null,
    mes           int default 1               not null,
    anyo          int                         null,
    monto         int default 0               null,
    estado        enum ('activo', 'inactivo') null,
    constraint bono_trabajador_ibfk_1
        foreign key (trabajador_id) references trabajadores (id)
            on update cascade on delete cascade,
    constraint bono_trabajador_ibfk_2
        foreign key (bonos_id) references bono_haberes (id)
            on update cascade on delete cascade
)
    charset = latin1;

create index bonos_id
    on bono_trabajador (bonos_id);

create index trabajador_id
    on bono_trabajador (trabajador_id);

create table if not exists bus_trabajadores
(
    id            int unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    trabajador_id bigint unsigned                                                                                       null,
    bus_id        bigint unsigned                                                                                       null,
    tipo_chofer   enum ('jefe de maquina', 'jefe maquina temporal', 'jefe de maquina prueba') default 'jefe de maquina' null,
    fecha_inicio  date                                                                                                  null,
    fecha_termino date                                                                                                  null,
    estado        tinyint                                                                     default 0                 null,
    constraint FK_bus_trabajadores_buses
        foreign key (bus_id) references buses (id)
            on update cascade on delete cascade,
    constraint FK_bus_trabajadores_trabajadores
        foreign key (trabajador_id) references trabajadores (id)
            on update cascade on delete cascade
)
    charset = latin1;

create table if not exists carga_familiares
(
    id                      int auto_increment
        constraint `PRIMARY`
        primary key,
    rut                     varchar(15)     not null,
    nombres                 varchar(200)    null,
    apellidos               varchar(200)    null,
    fecha_nacimiento        date            null,
    fecha_vencimiento_carga date            null,
    parentesco_id           int             null,
    trabajador_id           bigint unsigned null,
    constraint rut
        unique (rut),
    constraint carga_familiares_ibfk_1
        foreign key (parentesco_id) references parentescos (id)
            on update cascade on delete cascade,
    constraint carga_familiares_ibfk_2
        foreign key (trabajador_id) references trabajadores (id)
            on update cascade on delete cascade
)
    charset = latin1;

create index parentesco_id
    on carga_familiares (parentesco_id);

create index trabajador_id
    on carga_familiares (trabajador_id);

create table if not exists contactos
(
    id              bigint auto_increment
        constraint `PRIMARY`
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
    updated_at      timestamp                                                          null,
    constraint contactos_ibfk_1
        foreign key (region_id) references regiones (id)
            on update cascade on delete cascade,
    constraint contactos_ibfk_2
        foreign key (comuna_id) references comunas (id)
            on update cascade on delete cascade,
    constraint contactos_ibfk_3
        foreign key (trabajador_id) references trabajadores (id)
            on update cascade on delete cascade
)
    charset = latin1;

create index comuna_id
    on contactos (comuna_id);

create index region_id
    on contactos (region_id);

create index trabajador_id
    on contactos (trabajador_id);

create table if not exists contrato
(
    id                         bigint unsigned auto_increment
        constraint `PRIMARY`
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
    lugar_id                   int unsigned    null,
    constraint FK_contrato_areas
        foreign key (area_id) references areas (id),
    constraint FK_contrato_empleadores
        foreign key (empleador_id) references empleadores (id)
            on update cascade on delete cascade,
    constraint contrato_ibfk_1
        foreign key (ubicacion_id) references ubicaciones (id)
            on update cascade on delete cascade,
    constraint contrato_ibfk_2
        foreign key (cargo_id) references cargos (id)
            on update cascade on delete cascade,
    constraint contrato_prevision_id_foreign
        foreign key (prevision_id) references previsiones (id),
    constraint contrato_salud_id_foreign
        foreign key (salud_id) references salud (id),
    constraint contrato_trabajador_id_foreign
        foreign key (trabajador_id) references trabajadores (id)
)
    collate = utf8mb4_unicode_ci;

create index cargo_id
    on contrato (cargo_id);

create index ubicacion_id
    on contrato (ubicacion_id);

create table if not exists gastos_egreso_cajas
(
    id             bigint unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    fecha          datetime        null,
    nro_documento  varchar(200)    not null,
    monto          int default 0   null,
    observacion    varchar(200)    null,
    empleador_id   bigint unsigned null,
    trabajador_id  bigint unsigned null,
    autorizados_id int unsigned    null,
    user_id        bigint unsigned null,
    constraint gastos_egreso_cajas_ibfk_1
        foreign key (empleador_id) references empleadores (id),
    constraint gastos_egreso_cajas_ibfk_2
        foreign key (trabajador_id) references trabajadores (id),
    constraint gastos_egreso_cajas_ibfk_3
        foreign key (user_id) references trabajadores (id),
    constraint gastos_egreso_cajas_ibfk_4
        foreign key (autorizados_id) references autorizadores (id)
)
    charset = latin1;

create index autorizados_id
    on gastos_egreso_cajas (autorizados_id);

create index empleador_id
    on gastos_egreso_cajas (empleador_id);

create index trabajador_id
    on gastos_egreso_cajas (trabajador_id);

create index user_id
    on gastos_egreso_cajas (user_id);

create table if not exists gestion_trabajadores
(
    id            int unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    tipo          enum ('dias libre', 'falla', 'permiso especial') default 'dias libre' null,
    trabajador_id bigint unsigned                                                       null,
    fecha_inicial date                                                                  null,
    fecha_termino date                                                                  null,
    fecha_retorno date                                                                  null,
    numero_dias   int                                                                   null,
    estado        enum ('EN CURSO', 'FINALIZADO')                  default 'EN CURSO'   null,
    constraint FK_gestion_trabajadores_trabajadores
        foreign key (trabajador_id) references trabajadores (id)
            on update cascade on delete cascade
)
    charset = latin1;

create table if not exists licencia_conducir
(
    id                   int auto_increment
        constraint `PRIMARY`
        primary key,
    tipo_licencia_id     int             null,
    nro_serie            varchar(200)    null,
    categorias           json            null,
    fecha_de_vencimiento date            null,
    restriccion          tinytext        null,
    trabajador_id        bigint unsigned null,
    fecha_de_ingreso     date            null,
    tipo_licencia        json            null,
    constraint FK_licencia_conducir_trabajadores
        foreign key (trabajador_id) references trabajadores (id)
            on update cascade on delete cascade,
    constraint licencia_conducir_ibfk_1
        foreign key (tipo_licencia_id) references tipo_licencias (id)
            on update cascade on delete cascade
)
    charset = latin1;

create index tipo_licencia_id
    on licencia_conducir (tipo_licencia_id);

create table if not exists liquidacion_trabajador
(
    id               bigint unsigned auto_increment
        constraint `PRIMARY`
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
    updated_at       timestamp                             null,
    constraint liquidacion_trabajador_ibfk_1
        foreign key (trabajador_id) references trabajadores (id)
            on update cascade on delete cascade
)
    charset = latin1;

create index trabajador_id
    on liquidacion_trabajador (trabajador_id);

create table if not exists prevision_trabajadores
(
    id               int auto_increment
        constraint `PRIMARY`
        primary key,
    tipo_entidad     enum ('afp', 'inp') default 'afp' null,
    prevision_id     bigint unsigned                   null,
    prevision_inp_id int                               null,
    trabajador_id    bigint unsigned                   null,
    constraint FK_prevision_trabajadores_prevision_inp
        foreign key (prevision_inp_id) references prevision_inp (id)
            on update cascade on delete cascade,
    constraint FK_prevision_trabajadores_previsiones
        foreign key (prevision_id) references previsiones (id)
            on update cascade on delete cascade,
    constraint FK_prevision_trabajadores_trabajadores
        foreign key (trabajador_id) references trabajadores (id)
            on update cascade on delete cascade
)
    charset = latin1;

create table if not exists salud_discapacidades
(
    id                  int auto_increment
        constraint `PRIMARY`
        primary key,
    posee_carnet        enum ('Y', 'N') null,
    discpacidad         varchar(200)    null,
    causa_principal     varchar(200)    null,
    causa_secundaria    varchar(200)    null,
    capacidad_reducidad enum ('Y', 'N') null,
    trabajador_id       bigint unsigned null,
    constraint FK_salud_discapacidades_trabajadores
        foreign key (trabajador_id) references trabajadores (id)
            on update cascade on delete cascade
)
    charset = latin1;

create table if not exists salud_enfermedades
(
    id                     int auto_increment
        constraint `PRIMARY`
        primary key,
    enfermedad_prexistente enum ('Y', 'N') default 'N' not null,
    tipo_sangre            varchar(100)                null,
    enfermedades           text                        null,
    medicamentos           text                        null,
    trabajador_id          bigint unsigned             not null,
    constraint FK_salud_enfermedades_trabajadores
        foreign key (trabajador_id) references trabajadores (id)
            on update cascade on delete cascade
)
    charset = latin1;

create table if not exists salud_trabajadores
(
    id                     int auto_increment
        constraint `PRIMARY`
        primary key,
    salud_id               int                            null,
    cotiza_siete_porciento enum ('SI', 'NO') default 'NO' null,
    tipo_plan_salud        varchar(50)                    null,
    monto_peso             int                            null,
    monto_uf               float                          null,
    trabajador_id          bigint unsigned                null,
    constraint FK_salud_trabajadores_trabajadores
        foreign key (trabajador_id) references trabajadores (id)
            on update cascade on delete cascade
)
    charset = latin1;

create table if not exists solicitud_trabajador
(
    id             int auto_increment
        constraint `PRIMARY`
        primary key,
    asunto         varchar(100)                                                                                                                                          null,
    trabajador_id  bigint unsigned                                                                                                                                       null,
    user_id        bigint unsigned                                                                                                                                       null,
    comentario     text                                                                                                                                                  null,
    tipo_solicitud enum ('copia de contrato', 'certificado antiguidad', 'carga familiar', 'modificación de datos', 'cambio cuenta bancaria') default 'copia de contrato' not null,
    datos          text                                                                                                                                                  null,
    estado         enum ('pendiente', 'en proceso', 'finalizado')                                                                            default 'pendiente'         not null,
    created_at     timestamp                                                                                                                                             null,
    updated_at     timestamp                                                                                                                                             null,
    constraint FK_solicitud_trabajador_trabajadores
        foreign key (trabajador_id) references trabajadores (id)
            on update cascade on delete cascade,
    constraint FK_solicitud_trabajador_users
        foreign key (user_id) references users (id)
            on update cascade on delete cascade
)
    charset = latin1;

create table if not exists archivo_solicitud
(
    id             bigint unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    solicitud_id   int          null,
    nombre_archivo varchar(200) null,
    created_at     timestamp    null,
    updated_at     timestamp    null,
    constraint FK_archivo_solicitud_solicitud_trabajador
        foreign key (solicitud_id) references solicitud_trabajador (id)
            on update cascade on delete cascade
)
    charset = latin1;

create table if not exists respuesta_solicitudes
(
    id           bigint auto_increment
        constraint `PRIMARY`
        primary key,
    user_id      bigint unsigned not null,
    solicitud_id int             null,
    mensaje      text            not null,
    archivos     varchar(255)    null,
    created_at   timestamp       null,
    updated_at   timestamp       null,
    constraint FK_respuesta_solicitudes_solicitud_trabajador
        foreign key (solicitud_id) references solicitud_trabajador (id)
            on update cascade on delete cascade,
    constraint respuesta_solicitudes_ibfk_1
        foreign key (user_id) references users (id)
            on update cascade on delete cascade
)
    charset = latin1;

create index user_id
    on respuesta_solicitudes (user_id);

create table if not exists sugerencias
(
    id                  int auto_increment
        constraint `PRIMARY`
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
    updated_at          timestamp                                                                         null,
    constraint FK_sugerencias_areas
        foreign key (areas_id) references areas (id)
            on update cascade on delete cascade,
    constraint FK_sugerencias_trabajadores
        foreign key (trabajador_id) references trabajadores (id)
            on update cascade on delete cascade
)
    charset = latin1;

create table if not exists trabajador_vacaciones
(
    id                               bigint unsigned auto_increment
        constraint `PRIMARY`
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
    rut                              varchar(50)                  null,
    constraint trabajador_vacaciones_ibfk_1
        foreign key (trabajador_id) references trabajadores (id)
            on update cascade on delete cascade
)
    charset = latin1;

create index trabajador_id
    on trabajador_vacaciones (trabajador_id);

create table if not exists trabajador_vitacoras
(
    id            int unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    trabajador_id bigint unsigned null,
    fecha         datetime        null,
    observacion   text            null,
    user_id       bigint unsigned null,
    constraint trabajador_vitacoras_ibfk_1
        foreign key (trabajador_id) references trabajadores (id),
    constraint trabajador_vitacoras_ibfk_2
        foreign key (user_id) references users (id)
)
    charset = latin1;

create index trabajador_id
    on trabajador_vitacoras (trabajador_id);

create index user_id
    on trabajador_vitacoras (user_id);

create index nacionalidad_id
    on trabajadores (nacionalidad_id);

create index pueblo_originario_id
    on trabajadores (pueblo_originario_id);

create table if not exists tramite_licencia_medicas
(
    id                       bigint unsigned auto_increment
        constraint `PRIMARY`
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
    updated_at               timestamp                                          null,
    constraint FK_tramite_licencia_medicas_tipo_licencia_medicas
        foreign key (tipo_licencia_medicas_id) references tipo_licencia_medicas (id)
            on update cascade on delete cascade,
    constraint FK_tramite_licencia_medicas_trabajadores
        foreign key (trabajador_id) references trabajadores (id)
            on update cascade on delete cascade,
    constraint FK_tramite_licencia_medicas_users
        foreign key (user_id) references users (id)
            on update cascade on delete cascade
)
    charset = latin1;

create index oficina_id
    on users (oficina_id);

create table if not exists viajes
(
    id               int unsigned auto_increment
        constraint `PRIMARY`
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
    estado           enum ('EN RUTA', 'EN ORIGEN', 'EN DESTINO', 'SUSPENDIDO', 'FINALIZADO') default 'EN ORIGEN'         null,
    constraint FK_viajes_buses
        foreign key (buses_id) references buses (id)
            on update set null on delete set null,
    constraint FK_viajes_clientes
        foreign key (cliente_id) references clientes (id)
            on update set null on delete set null,
    constraint FK_viajes_destinos
        foreign key (origen_id) references destinos (id)
            on update set null on delete set null,
    constraint FK_viajes_destinos_2
        foreign key (destino_id) references destinos (id)
            on update set null on delete set null,
    constraint FK_viajes_empleadores
        foreign key (empleador_id) references empleadores (id)
            on update set null on delete set null
)
    charset = latin1;

create table if not exists documento_entragados
(
    id               int unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    nro_doc          varchar(100)                                                                       null,
    fecha_de_entrega datetime                                            default CURRENT_TIMESTAMP      null,
    tipo             enum ('checklist mantención', 'hoja de recorridos') default 'checklist mantención' null,
    viaje_id         int unsigned                                                                       null,
    tripulacion_id   bigint unsigned                                                                    null,
    user_id          bigint unsigned                                                                    null,
    estado           enum ('pendiente', 'entregado')                     default 'pendiente'            null,
    constraint documento_entragados_ibfk_1
        foreign key (tripulacion_id) references trabajadores (id),
    constraint documento_entragados_ibfk_2
        foreign key (viaje_id) references viajes (id),
    constraint documento_entragados_ibfk_3
        foreign key (user_id) references users (id)
)
    charset = latin1;

create index tripulacion_id
    on documento_entragados (tripulacion_id);

create index user_id
    on documento_entragados (user_id);

create index viaje_id
    on documento_entragados (viaje_id);

create table if not exists monto_asignacion_peajes
(
    id               int auto_increment
        constraint `PRIMARY`
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
    fecha_modicacion datetime                                                     null,
    constraint FK_monto_asignacion_peajes_users
        foreign key (user_id) references users (id)
            on update cascade on delete cascade,
    constraint FK_monto_asignacion_peajes_viajes
        foreign key (viaje_id) references viajes (id)
            on update cascade on delete cascade
)
    charset = latin1;

create table if not exists monto_entregados
(
    id                         int unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    monto_asignacion_peajes_id int                                                                            null,
    monto_entregado            int                                          default 0                         null,
    nota                       text                                                                           null,
    fecha_entrega              timestamp                                                                      null,
    user_id                    bigint unsigned                                                                null,
    estado                     enum ('PENDIENTE DE APROBACION', 'APROBADO') default 'PENDIENTE DE APROBACION' null,
    constraint monto_entregados_ibfk_1
        foreign key (monto_asignacion_peajes_id) references monto_asignacion_peajes (id),
    constraint monto_entregados_ibfk_2
        foreign key (user_id) references users (id)
)
    charset = latin1;

create index monto_asignacion_peajes_id
    on monto_entregados (monto_asignacion_peajes_id);

create index user_id
    on monto_entregados (user_id);

create table if not exists monto_viajes
(
    id             int auto_increment
        constraint `PRIMARY`
        primary key,
    viaje_id       int unsigned                                                                     null,
    monto_total    int                                                      default 0               null,
    responsable_id bigint unsigned                                          default '0'             null,
    user_id        bigint unsigned                                                                  null,
    estado         enum ('CONCILIADO', 'NO CONCILIADO', 'SALDO A DEVOLVER') default 'NO CONCILIADO' null,
    constraint monto_viajes_ibfk_1
        foreign key (viaje_id) references viajes (id),
    constraint monto_viajes_ibfk_2
        foreign key (user_id) references users (id),
    constraint monto_viajes_ibfk_3
        foreign key (responsable_id) references trabajadores (id)
)
    charset = latin1;

create table if not exists gasto_pasaje_viaje
(
    id             int unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    monto_viaje_id int                                     default 0        null,
    nro_documento  varchar(100)                                             not null,
    monto_gasto    int                                     default 0        null,
    tipo           enum ('GASTOS', 'BOLETOS EN EL CAMINO') default 'GASTOS' null,
    fecha          date                                                     null,
    user_id        bigint unsigned                                          null,
    tipo_id        int unsigned                                             null,
    tripulacion_id bigint unsigned                                          null,
    constraint gasto_pasaje_viaje_ibfk_1
        foreign key (monto_viaje_id) references monto_viajes (id),
    constraint gasto_pasaje_viaje_ibfk_2
        foreign key (user_id) references users (id),
    constraint gasto_pasaje_viaje_ibfk_3
        foreign key (tipo_id) references gasto_tipos (id),
    constraint gasto_pasaje_viaje_ibfk_4
        foreign key (tripulacion_id) references trabajadores (id)
)
    charset = latin1;

create index monto_viaje_id
    on gasto_pasaje_viaje (monto_viaje_id);

create index tipo_id
    on gasto_pasaje_viaje (tipo_id);

create index tripulacion_id
    on gasto_pasaje_viaje (tripulacion_id);

create index user_id
    on gasto_pasaje_viaje (user_id);

create index responsable_id
    on monto_viajes (responsable_id);

create index user_id
    on monto_viajes (user_id);

create index viaje_id
    on monto_viajes (viaje_id);

create table if not exists ruta_pasaje_ventas
(
    id               int unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    numero_documento varchar(100) null,
    monto            int          null,
    fecha            date         null,
    viaje_id         int unsigned null,
    constraint ruta_pasaje_ventas_ibfk_1
        foreign key (viaje_id) references viajes (id)
)
    charset = latin1;

create index viaje_id
    on ruta_pasaje_ventas (viaje_id);

create table if not exists trabajador_viajes
(
    id                      int unsigned auto_increment
        constraint `PRIMARY`
        primary key,
    trabajador_id           bigint unsigned                                                                                                                 null,
    trabajador_reemplazo_id bigint unsigned             default '0'                                                                                         not null,
    viaje_id                int unsigned                                                                                                                    null,
    motivo                  text                                                                                                                            null,
    tipo_tripulante         enum ('CONDUCTOR_UNO', 'CONDUCTOR_DOS', 'AUXILIAR', 'CONDUCTOR_UNO_REEMPLAZO', 'CONDUCTOR_DOS_REEMPLAZO', 'AUXILIAR_REEMPLAZO') null,
    orden                   int unsigned                                                                                                                    null,
    estado                  enum ('ACTIVO', 'INACTIVO') default 'ACTIVO'                                                                                    null,
    constraint FK_trabajador_viajes_trabajadores
        foreign key (trabajador_id) references trabajadores (id)
            on update cascade on delete cascade,
    constraint FK_trabajador_viajes_viajes
        foreign key (viaje_id) references viajes (id)
            on update cascade on delete cascade
)
    charset = latin1;

create table if not exists viajesalidas
(
    id          int auto_increment
        constraint `PRIMARY`
        primary key,
    folio       varchar(45)                                                                                                                                                   null,
    fecha       date                                                                                                                                                          null,
    hora        time                                                                                                                                                          null,
    viaje_id    int unsigned                                                                                                                                                  null,
    tipo_salida enum ('SALIDA A SERVICIO', 'PRUEBA DE RUTA', 'TRASLADO A OTRO DEPENDENCIA', 'TRASLADO A TALLER EXTERNO', 'SALIDA DE EMERGENBCIA') default 'SALIDA A SERVICIO' null,
    constraint viajeSalidas_ibfk_1
        foreign key (viaje_id) references viajes (id)
)
    charset = latin1;

create index viaje_id
    on viajesalidas (viaje_id);

create table if not exists votaciones
(
    user_id        bigint unsigned null,
    trabajador_id  bigint unsigned null,
    categoria      varchar(100)    null,
    fecha_votacion timestamp       null,
    constraint FK_votaciones_users
        foreign key (user_id) references users (id)
            on update cascade on delete cascade,
    constraint FK_votaciones_users_2
        foreign key (trabajador_id) references users (id)
            on update cascade on delete cascade
)
    charset = latin1;


