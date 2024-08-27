
/*alter table ahorro_trabajadores
    add constraint FK_ahorro_trabajadores_ahorros_voluntarios
        foreign key (ahorro_voluntario_id) references ahorros_voluntarios (id)
            on update cascade on delete cascade;

alter table ahorro_trabajadores
    add constraint FK_ahorro_trabajadores_trabajadores
        foreign key (trabajador_id) references trabajadores (id)
            on update cascade on delete cascade;
alter table archivo_solicitud
    add constraint FK_archivo_solicitud_solicitud_trabajador
        foreign key (solicitud_id) references solicitud_trabajador (id)
            on update cascade on delete cascade;
*/

alter table autorizadores
    add constraint autorizadores_trabajadores_id_fk
        foreign key (trabajador_id) references trabajadores (id);

alter table banco_trabajadores
    add constraint banco_trabajadores_ibfk_1
        foreign key (trabajador_id) references trabajadores (id)
            on update cascade on delete cascade;

alter table banco_trabajadores
    add constraint banco_trabajadores_ibfk_2
        foreign key (banco_id) references banco (id)
            on update cascade on delete cascade;

alter table bono_trabajador
    add constraint bono_trabajador_ibfk_1
        foreign key (trabajador_id) references trabajadores (id)
            on update cascade on delete cascade;

alter table bono_trabajador
    add constraint bono_trabajador_ibfk_2
        foreign key (bonos_id) references bono_haberes (id)
            on update cascade on delete cascade;

alter table bus_certificados
    add constraint FK_bus_certificados_buses
        foreign key (bus_id) references buses (id)
            on update cascade on delete cascade;


alter table bus_trabajadores
    add constraint FK_bus_trabajadores_buses
        foreign key (bus_id) references buses (id)
            on update cascade on delete cascade;

alter table bus_trabajadores
    add constraint FK_bus_trabajadores_trabajadores
        foreign key (trabajador_id) references trabajadores (id)
            on update cascade on delete cascade;

alter table buses
    add constraint buses_ibfk_1
        foreign key (empleador_id) references empleadores (id)
            on update cascade on delete cascade;

alter table calendario_configuracion
    add constraint FK_calendario_configuracion_regiones
        foreign key (region_id) references regiones (id);

alter table carga_familiares
    add constraint carga_familiares_ibfk_1
        foreign key (parentesco_id) references parentescos (id)
            on update cascade on delete cascade;

alter table carga_familiares
    add constraint carga_familiares_ibfk_2
        foreign key (trabajador_id) references trabajadores (id)
            on update cascade on delete cascade;


alter table cargos
    add constraint cargos_ibfk_1
        foreign key (area_id) references areas (id)
            on update cascade;

alter table categoria_user
    add constraint FK_categoria_users_categorias
        foreign key (categoria_id) references categorias (id)
            on update cascade on delete cascade;

alter table categoria_user
    add constraint FK_categoria_users_users
        foreign key (user_id) references users (id)
            on update cascade on delete cascade;

alter table certificado_recorridos
    add constraint FK_certificado_recorridos_bus_certificados
        foreign key (bus_certificado_id) references bus_certificados (id)
            on update cascade on delete cascade;

alter table certificado_recorridos
    add constraint FK_certificado_recorridos_destinos
        foreign key (origen_id) references destinos (id)
            on update cascade on delete cascade;

alter table certificado_recorridos
    add constraint FK_certificado_recorridos_destinos_2
        foreign key (destino_id) references destinos (id)
            on update cascade on delete cascade;

alter table checklist_item_fields
    add constraint checklist_item_fields_ibfk_1
        foreign key (item_id) references checklist_items (id);

alter table checklist_item_fields
    add constraint checklist_item_fields_ibfk_2
        foreign key (field_type_id) references field_types (id);

alter table checklist_item_users
    add constraint checklist_item_users_item_id_foreign
        foreign key (item_id) references checklist_items (id);

alter table checklist_item_users
    add constraint checklist_item_users_user_id_foreign
        foreign key (user_id) references users (id);

alter table checklist_items
    add constraint checklist_items_ibfk_1
        foreign key (type_id) references checklist_types (id);

alter table checklist_items
    add constraint checklist_items_ibfk_2
        foreign key (parent_id) references checklist_items (id);

alter table checklist_responses
    add constraint checklist_responses_ibfk_1
        foreign key (checklist_id) references checklists (id);

alter table checklist_responses
    add constraint checklist_responses_ibfk_2
        foreign key (item_id) references checklist_items (id);

alter table checklist_structure
    add constraint checklist_structure_ibfk_1
        foreign key (category_id) references checklist_categories (id);

alter table checklist_structure
    add constraint checklist_structure_ibfk_2
        foreign key (type_id) references checklist_types (id);

alter table checklist_types
    add constraint checklist_types_ibfk_1
        foreign key (category_id) references checklist_categories (id);

alter table checklists
    add constraint checklists_ibfk_1
        foreign key (category_id) references checklist_categories (id);

alter table checklists
    add constraint checklists_ibfk_2
        foreign key (destino_id) references destinos (id)
            on update cascade on delete cascade;

alter table checklists
    add constraint checklists_ibfk_3
        foreign key (destino_id) references destinos (id)
            on update cascade on delete cascade;

alter table comunas
    add constraint comunas_region_id_foreign
        foreign key (region_id) references regiones (id);

alter table contactos
    add constraint contactos_ibfk_1
        foreign key (region_id) references regiones (id)
            on update cascade on delete cascade;

alter table contactos
    add constraint contactos_ibfk_2
        foreign key (comuna_id) references comunas (id)
            on update cascade on delete cascade;

alter table contactos
    add constraint contactos_ibfk_3
        foreign key (trabajador_id) references trabajadores (id)
            on update cascade on delete cascade;

alter table contrato
    add constraint FK_contrato_areas
        foreign key (area_id) references areas (id);

alter table contrato
    add constraint FK_contrato_empleadores
        foreign key (empleador_id) references empleadores (id)
            on update cascade on delete cascade;

alter table contrato
    add constraint contrato_ibfk_1
        foreign key (ubicacion_id) references ubicaciones (id)
            on update cascade on delete cascade;

alter table contrato
    add constraint contrato_ibfk_2
        foreign key (cargo_id) references cargos (id)
            on update cascade on delete cascade;

alter table contrato
    add constraint contrato_prevision_id_foreign
        foreign key (prevision_id) references previsiones (id);

alter table contrato
    add constraint contrato_salud_id_foreign
        foreign key (salud_id) references salud (id);

alter table contrato
    add constraint contrato_trabajador_id_foreign
        foreign key (trabajador_id) references trabajadores (id);

alter table documento_entragados
    add constraint documento_entragados_ibfk_1
        foreign key (tripulacion_id) references trabajadores (id);

alter table documento_entragados
    add constraint documento_entragados_ibfk_2
        foreign key (viaje_id) references viajes (id);

alter table documento_entragados
    add constraint documento_entragados_ibfk_3
        foreign key (user_id) references users (id);

alter table empleadores
    add constraint empleadores_codigo_empresa_uindex
        unique (codigo_empresa);

alter table failed_jobs
    add constraint failed_jobs_uuid_unique
        unique (uuid);

alter table folios_impresion_caja
    add constraint folios_impresion_caja_ibfk_1
        foreign key (user_id) references users (id);

alter table gasto_pasaje_viaje
    add constraint gasto_pasaje_viaje_ibfk_1
        foreign key (monto_viaje_id) references monto_viajes (id);

alter table gasto_pasaje_viaje
    add constraint gasto_pasaje_viaje_ibfk_2
        foreign key (user_id) references users (id);

alter table gasto_pasaje_viaje
    add constraint gasto_pasaje_viaje_ibfk_3
        foreign key (tipo_id) references gasto_tipos (id);

alter table gasto_pasaje_viaje
    add constraint gasto_pasaje_viaje_ibfk_4
        foreign key (tripulacion_id) references trabajadores (id);

alter table gastos_egreso_cajas
    add constraint gastos_egreso_cajas_ibfk_1
        foreign key (empleador_id) references empleadores (id);

alter table gastos_egreso_cajas
    add constraint gastos_egreso_cajas_ibfk_2
        foreign key (trabajador_id) references trabajadores (id);

alter table gastos_egreso_cajas
    add constraint gastos_egreso_cajas_ibfk_3
        foreign key (user_id) references trabajadores (id);

alter table gastos_egreso_cajas
    add constraint gastos_egreso_cajas_ibfk_4
        foreign key (autorizados_id) references autorizadores (id);

alter table gestion_trabajadores
    add constraint FK_gestion_trabajadores_trabajadores
        foreign key (trabajador_id) references trabajadores (id)
            on update cascade on delete cascade;

alter table historial_desvinculaciones
    add constraint FK_historial_desvinculaciones_movimiento_trabajadores
        foreign key (motivo_id) references movimiento_trabajadores (id)
            on update cascade on delete cascade;

alter table historial_trabajadores
    add constraint trabajadores_codigo_trabajador_uindex
        unique (codigo_trabajador);

alter table licencia_conducir
    add constraint FK_licencia_conducir_trabajadores
        foreign key (trabajador_id) references trabajadores (id)
            on update cascade on delete cascade;

alter table licencia_conducir
    add constraint licencia_conducir_ibfk_1
        foreign key (tipo_licencia_id) references tipo_licencias (id)
            on update cascade on delete cascade;

alter table liquidacion_trabajador
    add constraint liquidacion_trabajador_ibfk_1
        foreign key (trabajador_id) references trabajadores (id)
            on update cascade on delete cascade;


alter table log_sistemas
    add constraint log_sistemas_ibfk_1
        foreign key (user_id) references users (id);

alter table menu_role
    add constraint menu_role_ibfk_1
        foreign key (menu_id) references menus (id);

alter table menu_role
    add constraint menu_role_ibfk_2
        foreign key (role_id) references roles (id);

alter table menus
    add constraint menus_ibfk_1
        foreign key (parent_id) references menus (id);

create index model_has_permissions_model_id_model_type_index
    on model_has_permissions (model_id, model_type);

alter table model_has_permissions
    add primary key (permission_id, model_id, model_type);

alter table model_has_permissions
    add constraint model_has_permissions_permission_id_foreign
        foreign key (permission_id) references permissions (id)
            on delete cascade;

create index model_has_roles_model_id_model_type_index
    on model_has_roles (model_id, model_type);

alter table model_has_roles
    add primary key (role_id, model_id, model_type);

alter table model_has_roles
    add constraint model_has_roles_role_id_foreign
        foreign key (role_id) references roles (id)
            on delete cascade;

alter table monto_asignacion_peajes
    add constraint FK_monto_asignacion_peajes_users
        foreign key (user_id) references users (id)
            on update cascade on delete cascade;

alter table monto_entregados
    add constraint monto_entregados_ibfk_1
        foreign key (monto_asignacion_peajes_id) references monto_asignacion_peajes (id);

alter table monto_entregados
    add constraint monto_entregados_ibfk_2
        foreign key (user_id) references users (id);

alter table monto_viajes
    add constraint monto_viajes_ibfk_1
        foreign key (viaje_id) references viajes (id);

alter table monto_viajes
    add constraint monto_viajes_ibfk_2
        foreign key (user_id) references users (id);

alter table monto_viajes
    add constraint monto_viajes_ibfk_3
        foreign key (responsable_id) references trabajadores (id);

alter table montos_destinos
    add constraint montos_destinos_ibfk_1
        foreign key (destino_id) references destinos (id);


alter table oficina_users
    add constraint oficina_users_ibfk_1
        foreign key (oficina_id) references oficinas (id);

alter table oficina_users
    add constraint oficina_users_ibfk_2
        foreign key (user_id) references users (id);


alter table permissions
    add constraint permissions_name_guard_name_unique
        unique (name, guard_name);

create index personal_access_tokens_tokenable_type_tokenable_id_index
    on personal_access_tokens (tokenable_type, tokenable_id);

alter table personal_access_tokens
    add constraint personal_access_tokens_token_unique
        unique (token);

alter table prevision_trabajadores
    add constraint FK_prevision_trabajadores_prevision_inp
        foreign key (prevision_inp_id) references prevision_inp (id)
            on update cascade on delete cascade;

alter table prevision_trabajadores
    add constraint FK_prevision_trabajadores_previsiones
        foreign key (prevision_id) references previsiones (id)
            on update cascade on delete cascade;

alter table prevision_trabajadores
    add constraint FK_prevision_trabajadores_trabajadores
        foreign key (trabajador_id) references trabajadores (id)
            on update cascade on delete cascade;


alter table respuesta_solicitudes
    add constraint FK_respuesta_solicitudes_solicitud_trabajador
        foreign key (solicitud_id) references solicitud_trabajador (id)
            on update cascade on delete cascade;

alter table respuesta_solicitudes
    add constraint respuesta_solicitudes_ibfk_1
        foreign key (user_id) references users (id)
            on update cascade on delete cascade;

alter table role_has_permissions
    add constraint role_has_permissions_permission_id_foreign
        foreign key (permission_id) references permissions (id)
            on delete cascade;

alter table role_has_permissions
    add constraint role_has_permissions_role_id_foreign
        foreign key (role_id) references roles (id)
            on delete cascade;

alter table roles
    add constraint roles_name_guard_name_unique
        unique (name, guard_name);

alter table ruta_pasaje_ventas
    add constraint ruta_pasaje_ventas_ibfk_1
        foreign key (viaje_id) references viajes (id);

alter table salud_discapacidades
    add constraint FK_salud_discapacidades_trabajadores
        foreign key (trabajador_id) references trabajadores (id)
            on update cascade on delete cascade;

alter table salud_enfermedades
    add constraint FK_salud_enfermedades_trabajadores
        foreign key (trabajador_id) references trabajadores (id)
            on update cascade on delete cascade;

alter table salud_trabajadores
    add constraint FK_salud_trabajadores_trabajadores
        foreign key (trabajador_id) references trabajadores (id)
            on update cascade on delete cascade;

alter table solicitud_trabajador
    add constraint FK_solicitud_trabajador_trabajadores
        foreign key (trabajador_id) references trabajadores (id)
            on update cascade on delete cascade;

alter table solicitud_trabajador
    add constraint FK_solicitud_trabajador_users
        foreign key (user_id) references users (id)
            on update cascade on delete cascade;

alter table sugerencias
    add constraint FK_sugerencias_areas
        foreign key (areas_id) references areas (id)
            on update cascade on delete cascade;

alter table sugerencias
    add constraint FK_sugerencias_trabajadores
        foreign key (trabajador_id) references trabajadores (id)
            on update cascade on delete cascade;

alter table ticket
    add constraint ticket_ibfk_1
        foreign key (checklist_id) references checklists (id);

alter table ticket
    add constraint ticket_ibfk_2
        foreign key (reported_by) references users (id);

alter table ticket
    add constraint ticket_ibfk_3
        foreign key (assigned_to) references users (id);


alter table ticket_attachments
    add constraint ticket_attachments_ibfk_1
        foreign key (ticket_id) references ticket (id);

alter table ticket_attachments
    add constraint ticket_attachments_ibfk_2
        foreign key (uploaded_by) references users (id);

alter table ticket_histories
    add constraint ticket_histories_ibfk_1
        foreign key (ticket_id) references ticket (id);

alter table ticket_histories
    add constraint ticket_histories_ibfk_2
        foreign key (action_by) references users (id);

alter table trabajador_vacaciones
    add constraint trabajador_vacaciones_ibfk_1
        foreign key (trabajador_id) references trabajadores (id)
            on update cascade on delete cascade;

alter table trabajador_viajes
    add constraint FK_trabajador_viajes_trabajadores
        foreign key (trabajador_id) references trabajadores (id)
            on update cascade on delete cascade;

alter table trabajador_viajes
    add constraint FK_trabajador_viajes_viajes
        foreign key (viaje_id) references viajes (id)
            on update cascade on delete cascade;

alter table trabajador_vitacoras
    add constraint trabajador_vitacoras_ibfk_1
        foreign key (trabajador_id) references trabajadores (id);

alter table trabajador_vitacoras
    add constraint trabajador_vitacoras_ibfk_2
        foreign key (user_id) references users (id);

alter table trabajadores
    add constraint rut
        unique (rut);

alter table trabajadores
    add constraint trabajadores_codigo_trabajador_uindex
        unique (codigo_trabajador);

alter table trabajadores
    add constraint FK_trabajadores_comunas
        foreign key (comuna_id) references comunas (id)
            on update cascade on delete cascade;

alter table trabajadores
    add constraint FK_trabajadores_regiones
        foreign key (region_id) references regiones (id)
            on update cascade on delete cascade;

alter table trabajadores
    add constraint FK_trabajadores_users
        foreign key (user_id) references users (id)
            on update cascade on delete cascade;

alter table trabajadores
    add constraint trabajadores_ibfk_1
        foreign key (nacionalidad_id) references nacionalidades (id)
            on update cascade on delete cascade;

alter table trabajadores
    add constraint trabajadores_ibfk_2
        foreign key (pueblo_originario_id) references pueblo_originarios (id);

alter table tramite_licencia_medicas
    add constraint FK_tramite_licencia_medicas_tipo_licencia_medicas
        foreign key (tipo_licencia_medicas_id) references tipo_licencia_medicas (id)
            on update cascade on delete cascade;

alter table tramite_licencia_medicas
    add constraint FK_tramite_licencia_medicas_trabajadores
        foreign key (trabajador_id) references trabajadores (id)
            on update cascade on delete cascade;

alter table tramite_licencia_medicas
    add constraint FK_tramite_licencia_medicas_users
        foreign key (user_id) references users (id)
            on update cascade on delete cascade;

alter table tramo_viajes
    add constraint tramo_viajes_ibfk_1
        foreign key (origen_id) references destinos (id);

alter table tramo_viajes
    add constraint tramo_viajes_ibfk_2
        foreign key (destino_id) references destinos (id);

alter table tramo_viajes
    add constraint tramo_viajes_ibfk_3
        foreign key (tramo_id) references tramos (id);

alter table users
    add constraint rut
        unique (rut);

alter table viajes
    add constraint FK_viajes_buses
        foreign key (buses_id) references buses (id)
            on update set null on delete set null;

alter table viajes
    add constraint FK_viajes_clientes
        foreign key (cliente_id) references clientes (id)
            on update set null on delete set null;

alter table viajes
    add constraint FK_viajes_destinos
        foreign key (origen_id) references destinos (id)
            on update set null on delete set null;

alter table viajes
    add constraint FK_viajes_destinos_2
        foreign key (destino_id) references destinos (id)
            on update set null on delete set null;

alter table viajes
    add constraint FK_viajes_empleadores
        foreign key (empleador_id) references empleadores (id)
            on update set null on delete set null;



alter table votaciones
    add constraint FK_votaciones_users
        foreign key (user_id) references users (id)
            on update cascade on delete cascade;

alter table votaciones
    add constraint FK_votaciones_users_2
        foreign key (trabajador_id) references users (id)
            on update cascade on delete cascade;
