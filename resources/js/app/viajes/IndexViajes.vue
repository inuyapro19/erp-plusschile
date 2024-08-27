<template>
    <div>
        <CardComponent :title="'Viajes'">
            <template #header>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="btn-group">
                            <a href="/viajes/create" class="btn btn-sm btn-primary"><i class="fa fa-plus-circle"></i> Agregar</a>
                            <button class="btn btn-warning btn-sm" @click="actualizarEstados()"> Actualizar </button>
                            <button class="btn btn-success btn-sm" @click="filtrar = !filtrar"> <i class="fa fa-filter"></i> Filtrar</button>
                        </div>
                    </div>
                </div>
            </template>
            <template #body>
                <table class="table table-flush align-middle table-row-bordered table-row-solid gy-4 gs-9" id="kt_customers_table">
                    <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th>NRO VIAJE</th>
                        <th>BUS</th>
                        <th>TRIPULACIÓN</th>
                        <th>TIPO DE VIAJE</th>
                        <th>ORIGEN</th>
                        <th>DESTINO</th>
                        <th>FECHA Y HORA</th>
                        <th>ESTADO</th>
                        <th v-if="finalizados === false">ACCIONES</th>
                    </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                    <tr v-show="filtrar">
                        <td>
                            <input type="text" class="form-control" v-model="nro_viaje_filtro" @keypress.enter="getViajes" placeholder="NRO DE VIAJE">

                        </td>
                        <td>
                            <select
                                name="numero_bus"
                                id="numero_bus"
                                class="form-select mb-2"
                                data-control="select2"
                                data-placeholder="Seleccione bus"
                                data-allow-clear="true"
                                @change="getViajes()"
                                ref="buses"
                                v-model="filtroporBus">
                                <option value="">--------- BUSES -------------</option>
                                <option  v-for="(bus, index) in buses" :value="bus.id">{{bus.numero_bus + ' - '+ bus.patente }}</option>
                            </select>
                        </td>
                        <td>

                        </td>
                        <td>
                            <select class="form-control" v-model="tipo_viaje_filtro" @change="getViajes" id="tipo_servicio">
                                <option value="">-----Tipo de viaje-----</option>
                                <option value="servicio en linea">Servicion de linea</option>
                                <option value="servicio en mineria">Servicio de mineria</option>
                            </select>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <select class="form-control" v-model="estado_filtro" @change="getViajes" id="tipo_servicio">
                                <option value="">-----Estado viaje-----</option>
                                <option v-for="(estado, index) in estados"  :value="estado">{{estado}}</option>
                            </select>
                        </td>
                        <td>

                        </td>
                    </tr>
                    <tr v-for="({id,bus,nro_viaje,trabajadores,tipo_viaje,origen,destino,fecha_viaje,hora_salida,estado}, index) in viajes">
                        <td>
                            <a
                                rel="nofollow"
                                @click="mostrar_viaje(id)"
                                style="cursor: pointer;color: #333;font-weight: 700"
                                title="ver viaje">
                                {{nro_viaje}}
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </a>
                        </td>
                        <td>
                            {{ bus.numero_bus +' - '+ bus.patente }}
                        </td>

                        <td>
                            <div class="d-flex flex-column">
                                <li  v-for="({id,rut,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido}, index) in trabajadores" class="d-flex align-items-center py-2">
                                    <span class="bullet bg-dark mr-3" style="margin: 10px"></span> {{' '+rut +' '+primer_nombre +' '+segundo_nombre+' '+primer_apellido+' '+segundo_apellido }}
                                </li>
                            </div>
                        </td>
                        <td v-html="getColorType(tipo_viaje)">

                        </td>
                        <td>
                            {{origen.ciudad}}
                        </td>
                        <td>
                            {{destino.ciudad}}
                        </td>
                        <td>
                            {{fecha_viaje | FormatoFecha }} - {{hora_salida}}
                        </td>

                        <td v-html="getColorType(estado)">

                        </td>
                        <td >
                            <!--                            <div class="btn-group" v-if="estado !== 'FINALIZADO' && estado !== 'SUSPENDIDO'">
                                                            <button type="button" class="btn btn-sm btn-primary" @click="cambio_estado(id)"><i class="fa fa-edit"></i></button>
                                                            <button type="button" class="btn btn-sm btn-secondary" @click="agregar_folio(id)"><i class="fa fa-dollar-sign"></i></button>
                                                            <button type="button" class="btn btn-sm btn-danger" v-show="isRoleAdmin" @click="eliminar_viaje(id)"><i class="fa fa-trash"></i></button>
                                                        </div>-->
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-primary" :class="{ 'disabled': estado === 'FINALIZADO' || estado === 'SUSPENDIDO' }" @click="cambio_estado(id)" :title="estado === 'FINALIZADO' || estado === 'SUSPENDIDO' ? 'No se pueden editar viajes finalizados o suspendidos' : ''">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-secondary" :class="{ 'disabled': estado === 'FINALIZADO' || estado === 'SUSPENDIDO' }" @click="agregar_folio(id)" :title="estado === 'FINALIZADO' || estado === 'SUSPENDIDO' ? 'No se pueden agregar folios a viajes finalizados o suspendidos' : ''">
                                    <i class="fa fa-dollar-sign"></i>
                                </button>
                                <button @click="abrirModalImprimir(id)" class="btn btn-sm btn-info" >
                                    <i class="fa fa-print"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" v-show="isRoleAdmin" :class="{ 'disabled': estado === 'FINALIZADO' || estado === 'SUSPENDIDO' }" @click="eliminar_viaje(id)" :title="estado === 'FINALIZADO' || estado === 'SUSPENDIDO' ? 'No se pueden eliminar viajes finalizados o suspendidos' : ''">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </td>
                        <!--  <td v-if="role === 'admin'">

                        </td>-->
                    </tr>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-md-1">
                        <select v-model="per_page" class="form-control form-control-sm" @change.prevent="cantidadRegistros">
                            <option v-for="numero in numero_registros" :value="numero">{{numero}}</option>
                        </select>

                    </div>

                    <div class="col-md-11">
                        <!--                <nav aria-label="Page navigation example mt-3">
                                            <ul class="pagination">
                                                <li v-for="paginate in links" :class="paginate.active ? page_class: 'page-item'"><a class="page-link" href="#" rel="nofollow" @click="getPaginate(paginate.label)">{{paginate.label}}</a></li>
                                            </ul>
                                        </nav>-->
                        <!--paginate -->
                        <paginate :pagination="links" :onPageChange="getViajes"></paginate>
                    </div>
                </div>
            </template>
        </CardComponent>



        <!-- Modal Detalle de viaje -->
        <div class="modal fade" id="viajesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered min-w-1000px">
                <div class="modal-content">
                    <div class="modal-header">



                        <h2 class="fw-bold">Detalle de viaje</h2>
                        <div id="trabajadorModal_close" @click="cerrar_modal_viajes()" class="btn btn-icon btn-sm btn-active-icon-primary" >
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                            <span class="svg-icon svg-icon-1">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
								    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
								</svg>
                            </span>
                            <!--end::Svg Icon-->
                        </div>

                    </div>
                    <div class="modal-body">
                        <button
                            @click="editar_viaje()"
                            class="btn btn-sm btn-danger" > <i class="fa fa-edit"></i> Editar</button>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="empresa_id">Empresa</label>
                                     <input type="text" class="form-control" v-model="nombre_empresa" :disabled="true">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tipo_servicio">Tipo de viaje</label>
                                    <select class="form-control" v-model="tipo_viaje" :disabled="true" id="tipo_servicio">
                                        <option value="">-----Tipo de viaje-----</option>
                                        <option value="servicio en linea">Servicion de linea</option>
                                        <option value="servicio de mineria">Servicio de mineria</option>
                                    </select>
                                </div>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Nro de viaje</label>
                                    <input type="text"  v-model="nro_viaje" :disabled="editar" name="nro_viaje" id="nro_viaje" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="numero_bus">Asignar Bus (nro bus + pantente)</label>
                                    <select name="numero_bus" class="form-control selectpicker" :disabled="editar" ref="buses" data-live-search="true" data-size="10" v-model="bus_select" id="numero_bus">
                                        <option value="">----------------------</option>
                                        <option  v-for="({id,numero_bus,patente}, index) in buses" :value="id">{{numero_bus + ' - '+ patente }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Fecha viaje</label>
                                    <input type="date" v-model="fecha_viaje"  :disabled="editar" name="fecha_viaje" id="fecha_viaje" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Hora viaje</label>
                                    <input type="time" v-model="hora_viaje" :disabled="editar" name="hora_viaje" id="hora_viaje" class="form-control">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="origen_id">Origen</label>
                                    <input type="text" v-model="origen" class="form-control" :disabled="true">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="destino_id">Destino</label>
                                    <input type="text" v-model="destino" class="form-control" :disabled="true">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="">Nota de viaje</label>
                                <textarea :disabled="editar" v-model="nota_de_viaje" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <button class="btn btn-sm btn-primary" :disabled="editar" @click="actualizar_viaje">Guadar</button>
                            </div>
                        </div>

                        <div class="row" v-show="editar_folio">
                            <div class="col-md-4 form-group">
                                <label for="">Folio</label>
                                <input type="text" v-model="nro_folio_editar" class="form-control" :disabled="true">
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="">Monto</label>
                                <input type="text" v-model="monto_asignado" class="form-control" >
                            </div>

                            <div class="col-md-4 form-group">
                                <label for="">Fecha</label>
                                <input type="text" v-model="fecha_monto" class="form-control" :disabled="true">
                            </div>
                            <div class="col-md-8">
                                <label for="">Observación</label>
                                <input type="text" v-model="glosa" class="form-control">
                            </div>
                            <div class="col-md-12 mt-3 mb-3">
                                <button class="btn btn-success btn-sm" @click="add_folios()">Guadar</button>
                                <button @click="editar_folio = false" class="btn btn-danger btn-sm">cerrar</button>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-12">
                               <table class="table table-flush align-middle table-row-bordered table-row-solid gy-4 gs-9" >
                                   <thead>
                                   <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                           <th>Nro Folio</th>
                                           <th>Monto</th>
                                           <th>Motivo</th>
                                           <th>Fecha</th>
                                           <th>Ingresado por</th>
                                           <th></th>
                                       </tr>

                                   </thead>
                                   <tbody>
                                        <tr v-for="({id, nro_folio,monto_asignado,glosas,fecha,user }) in montos_asignados">
                                            <td>{{nro_folio}}</td>
                                            <td >${{monto_asignado | formatPrice}}</td>

                                            <td>{{glosas}}</td>
                                            <td>{{fecha | FormatoFecha}}</td>
                                            <td>{{ user.name + ' ' + user.apellidos}}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a :href="'/generar-folio/'+nro_folio" target="_blank" class="btn btn-secondary btn-sm"><i class="fa fa-print"></i></a>
                                                    <button class="btn btn-primary btn-sm" @click="editar_monto_asignado(id)"><i class="fa fa-edit"></i></button>
                                                </div>

                                            </td>
                                        </tr>
                                   </tbody>
                               </table>
                            </div>

                        </div>
                        <h4>Tripulación</h4>
                        <div class="row my-5" v-show="activar_ediccion">
                            <div class="col-md-4">
                                <label for="">RUT</label>
                                <input type="text" v-model="rut_tripulante" class="form-control" :disabled="true">
                            </div>
                            <div class="col-md-4">
                                <label for="">Nombre</label>
                                <input type="text" v-model="nombre_tripulante" class="form-control" :disabled="true">
                            </div>

                            <div class="col-md-4">
                                <label for="">Apellido</label>
                                <input type="text" v-model="apellido_tripulante" class="form-control" :disabled="true">
                            </div>
                            <div class="col-md-8">
                                <label for="">Tripulantes</label>
                                <select
                                    name="auxiliar_select"
                                    class="form-select mb-2"
                                    data-control="select2"
                                    data-placeholder="Seleccione trabajador"
                                    data-allow-clear="true"
                                    data-dropdown-parent="#viajesModal"
                                    id="auxiliar_select"
                                   >
                                    <option value="">--------</option>
                                    <option v-for="({id,rut,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido}, index) in tripulaciones"  :value="id">{{rut+' '+primer_nombre +' '+segundo_nombre+' '+ primer_apellido+ ' ' +segundo_apellido}}</option>
                                </select>
                            </div>

                            <div class="col-md-6 mt-2"><button class="btn btn-success btn-sm" @click.prevent="eliminar_tripulante" >Cambiar</button></div>
                        </div>
                        <div class="row ">
                            <div class="col-md-8" v-show="addTripulante">
                                <label for="">Tripulantes</label>
                                <select
                                        name="auxiliar_select"
                                        class="form-select mb-2 form-select-solid fw-bold"
                                        data-control="select2"
                                        data-placeholder="Seleccione trabajador"
                                        data-allow-clear="true"
                                        data-dropdown-parent="#viajesModal"
                                        id="auxiliar_select1">
                                    <option value="">--------</option>
                                    <option v-for="({id,rut,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido}, index) in tripulaciones"  :value="id">{{rut+' '+primer_nombre +' '+segundo_nombre+' '+ primer_apellido+ ' ' +segundo_apellido}}</option>
                                </select>

                            </div>
                            <div class="col-md-8 mt-3 mb-3" v-show="addTripulante">
                                <button class="btn btn-sm btn-primary" @click.prevent="enviar_formulario_tripulante">Guardar</button>
                                <button class="btn btn-sm btn-danger" @click="addTripulante = false">Cerrar</button>
                            </div>
                            <div class="col-md-6 mt-2 mb-2" v-if="addTripulante === false"><button class="btn btn-success btn-sm" @click.prevent="agregar_tripulante" ><i class="fa fa-plus-circle"></i> Agregar</button></div>

                            <div class="col-md-12">
                                <table class="table table-flush align-middle table-row-bordered table-row-solid gy-4 gs-9" >
                                    <thead>
                                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                            <th>RUT</th>
                                            <th>Nombre</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody ref="sortable">
                                        <tr
                                            v-for="({id,rut,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido}, index) in tripulacion"
                                            :data-id="id"
                                            :key="id"
                                        >
                                            <td>{{rut}}</td>
                                            <td>{{primer_nombre+' '+segundo_nombre+' '+primer_apellido + ' ' + segundo_apellido}}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-info btn-sm" @click.prevent="cambiar_tripulante(id)"><i class="fa fa-edit"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" @click="cerrar_modal_viajes()">Cerrar</button>

                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Folio-->
        <div class="modal fade" id="foliosModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered ">

                <div class="modal-content">
                    <div class="modal-header">

                        <h2 class="fw-bold">Agregar Folio</h2>
                        <div id="trabajadorModal_close" @click="cerrarFolioModal()" class="btn btn-icon btn-sm btn-active-icon-primary" >
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                            <span class="svg-icon svg-icon-1">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
								    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
								</svg>
                            </span>
                            <!--end::Svg Icon-->
                        </div>

                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">


                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nro_folio">Nro folio</label>
                                        <input type="text" v-model="nro_folio" name="nro_folio" id="nro_folio" :disabled="true" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="monto_asignado">Monto asignado</label>
                                        <input type="number" v-model="monto_asignado" name="monto_asignado" id="monto_asignado" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="glosa">Motivo</label>
                                        <textarea  v-model="glosa" name="glosa" id="glosa" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" @click="cerrarFolioModal()" >Cerrar</button>
                        <button type="button"  class="btn btn-primary btn-sm" @click.prevent="add_folios()">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Cambios de estado -->
        <div class="modal fade" id="estadosModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="fw-bold">Cambio de estado</h2>
                        <div id="trabajadorModal_close" @click="cerrar_modal_estados()" class="btn btn-icon btn-sm btn-active-icon-primary" >
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                            <span class="svg-icon svg-icon-1">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
								    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
								</svg>
                            </span>
                            <!--end::Svg Icon-->
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 form-group">

                                <label for="estado">Estado</label>
                                <select type="text" v-model="estado" id="estado" class="form-control" @change="isEstadoSuspendidos()">
                                    <option value="">----------------------</option>
                                    <option value="EN RUTA">EN RUTA</option>
                                    <option value="SUSPENDIDO">SUSPENDIDO</option>
                                    <option value="FINALIZADO">FINALIZADO</option>
                                </select>
                            </div>

                            <div class="col-md-12 form-group" v-show="isSuspendido">

                                <label for="estado">Motivo de la suspención</label>
                               <textarea v-model="motivo_suspencion" class="form-control"></textarea>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer flex-center">
                        <button type="button" class="btn btn-secondary btn-sm" @click="cerrar_modal_estados()">Cerrar</button>
                        <button type="button" class="btn btn-primary btn-sm" @click.prevent="update_cambio_estado()">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="imprimirModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="fw-bold">Imprimir Documentos</h2>
                        <div id="trabajadorModal_close" @click="cerrarModalImprimir()" class="btn btn-icon btn-sm btn-active-icon-primary" >
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                            <span class="svg-icon svg-icon-1">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
								    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
								</svg>
                            </span>
                            <!--end::Svg Icon-->
                        </div>
                    </div>
                    <div class="modal-body justify-content-around">

                        <div class="form-check form-switch form-check-custom form-check-solid mt-5">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="buses"
                                   v-model="isCertificadoSanitizacion"


                            />
                            <label class="form-check-label fw-semibold text-gray-400 ms-3" for="status">Certificado de Sanitización</label>
                        </div>

                        <div class="form-check form-switch form-check-custom form-check-solid mt-5">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="buses"
                                   v-model="IsCertificadoAutorizacion"


                            />
                            <label class="form-check-label fw-semibold text-gray-400 ms-3" for="status">Autorización Salida de Taller</label>
                        </div>
                        <div v-show="isCertificadoSanitizacion" class="mt-5">
                            <button class="btn btn-danger mt-3 mb-3"  @click="imprimirCertidicado(1)">Certificado de sanitización</button>

                        </div>
                        <div v-show="IsCertificadoAutorizacion" class="mt-5">
                            <select class="form-control mb-5" v-model="tipo_salida_select">
                                <option value="">----------------------</option>
                                <option v-for="autorizacion in tipos_salidas" :value="autorizacion">{{autorizacion}}</option>
                            </select>

                            <button class="btn btn-warning" @click="imprimirCertidicado(2)">Autorización de salidas de taller</button>

                        </div>
                    </div>
                    <div class="modal-footer flex-center">
                        <button type="button" class="btn btn-secondary btn-sm" @click="cerrarModalImprimir()">Cerrar</button>

                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import moment from "moment";
import Sortable from 'sortablejs';
import paginate from "../../components/paginate.vue";
import CardComponent from "../../components/CardComponent.vue";
//propiedad estado color
const COLOR_CLASSES = {
    'EN ORIGEN': 'badge-primary',
    'EN RUTA': 'badge-success',
    'SUSPENDIDO': 'badge-warning',
    'FINALIZADO': 'badge-danger',
    'servicio en linea': 'badge-info',
    'servicio en mineria': 'badge-secondary',
}
export default {
    components: {
        paginate,
        CardComponent
    },
    props:{
        finalizados:{
            type:Boolean,
            required: false,
        },
      /*  role:{
            type:String,
            required: false,
            default: 'admin'
        },*/
    },
    data() {
        return {
            filtrar: false,
            viajes:[],
            viaje_mostrar:[],
            filtros:'',
            filtroporBus:'',
            estado:'',
            id:0,
            nro_folio:0,
            monto_asignado:0,
            glosa:'',
            montos_asignados:[],
            tripulacion:[],
            nombre_empresa:'',
            nro_viaje:'',
            fecha_viaje:'',
            hora_viaje:'',
            origen:'',
            destino:'',
            bus_select:0,
            tipo_viaje:'',
            nota_de_viaje:'',
            nro_viaje_filtro:'',
            tipo_viaje_filtro:'',
            estados:['EN RUTA','EN ORIGEN','EN DESTINO','SUSPENDIDO','FINALIZADO'],
            estado_filtro:'',
            buses:[],
            tripulaciones:[],
            id_tripulante:0,
            rut_tripulante:'',
            nombre_tripulante: '',
            apellido_tripulante:'',
            activar_ediccion:false,
            tripulante_select:0,
            id_viaje:0,
            buses_disponibles:[],
            editar:true,
            addTripulante:false,
            editar_folio:false,
            monto_folio:0,
            nro_folio_editar:0,
            fecha_monto:'',
            id_folio_editar:0,
            observacion:'',
            bus_id_old:0,
            usuario:[],
            isRoleAdmin:false,
            isSuspendido:false,
            motivo_suspencion:'',
            isLoading: false,
            fullPage: true,
            active:true,
            numero_registros:[10,20,50,80,100,500,1000],
            per_page:10,
            page_class : 'page-item',
            links:[],
            isCertificadoSanitizacion:false,
            IsCertificadoAutorizacion:false,
            tipos_salidas:[
                'SALIDA A SERVICIO',
                'PRUEBA DE RUTA',
                'TRANSLADO A OTRA DEPENDENCIA',
                'TRASLADO A TALLER EXTERNO',
                'SALIDA DE EMERGENCIA'],
            tipo_salida_select:'',
            sortable: null,
        }
    },
    created() {
        this.getlastFolio()
        this.userLogin()
    },
    mounted() {
        this.estado_finalizado()
        this.getViajes()
        this.getBuses()
        this.cargarTablaTrabajadores()
    },
    updated() {
       // this.refrescar()
        $('#numero_bus').on('select2:select', this.onSelectTrabajador)
        $('#auxiliar_select').on('select2:select', this.onSelectTriulacionUpdate)
        $('#auxiliar_select1').on('select2:select', this.onSelectTrabajadorAdd)
    },
    methods: {
        refrescar:function(){
            $(this.$refs.buses).selectpicker('refresh')
            $(this.$refs.auxiliares).selectpicker('refresh')
            $(this.$refs.buses).selectpicker('refresh')
        },
        onSelectTrabajador(e) {
            const id = e.params.data.id
            //console.log(id)
            this.filtroporBus = parseInt(id)
            console.log(this.filtroporBus)
            this.getViajes()
           // const trabajador = this.trabajadores.find(t => t.id === parseInt(id))
           // this.trabajadorSeleccionado = trabajador
        },
        onSelectTriulacionUpdate(e) {
            const id = e.params.data.id
            //console.log(id)
            this.tripulante_select = parseInt(id)
        },
        onSelectTrabajadorAdd(e) {
            const id = e.params.data.id
            //console.log(id)
            this.tripulante_select = parseInt(id)
        },
        estado_finalizado:function (){
           if (this.finalizados){
               this.estado_filtro = 'FINALIZADO'
           }
        },
        initSortable() {
            this.sortable = new Sortable(this.$refs.sortable, {
                animation: 150,
                onUpdate: () => {
                    this.items = this.$refs.sortable.querySelectorAll('tr').map((tr, index) => {
                        return {
                            id: tr.getAttribute('data-id'),
                            name: tr.querySelector('td:nth-child(2)').textContent,
                            order: index + 1,
                        };
                    });
                },
            });
        },
       async getViajes(page = 1){
           try {
               let url = '/getViajes?opcion=paginate';

               if (page > 0){
                   url = url + '&page='+page
               }

               if (this.nro_viaje_filtro !== ''){
                   url = url + '&filtro[nro_viaje]='+this.nro_viaje_filtro
               }
               //filtro por bus
              //console.log($('[name=numero_bus]').val());
               if (this.filtroporBus !== ''){
                   url = url + '&filtroporBus='+this.filtroporBus
               }

               if (this.tipo_viaje_filtro !== ''){
                   url = url + '&filtro[tipo_viaje]='+this.tipo_viaje_filtro
               }

               if (this.estado_filtro !== ''){
                   url = url + '&filtro[estado]='+this.estado_filtro
               }

              const { data, status} = await axios.get(url)

               if (status === 200){
                   this.viajes = data.data
                   this.links = data
               }

           }catch (e) {
               console.log(e)
           }
       },
        async cargarTablaTrabajadores (){
            try {
                let url = '/lista-trabajadores?filtros_cargos[contrato]=2&opcion=1'

                const { data, status} = await axios.get(url)

                if (status === 200){
                    this.tripulaciones = data
                }
            }catch (e) {
                console.log(e)
            }
        },
        cambio_estado:function (id){
            let viaje = this.viajes.find((item) => item.id === id);
            this.id = id
            $('#estadosModal').modal('show')
        },
        agregar_folio(id){
            let viaje = this.viajes.find((item) => item.id === id);
            this.id =  id
            $('#foliosModal').modal('show')
        },
        mostrar_viaje(viaje_id){

              const {
                  id,
                  nro_viaje,
                  trabajadores,
                  monto_asignaciones,
                  fecha_viaje,
                  hora_salida,
                  empleador,
                  tipo_viaje,
                  origen,
                  destino,
                  bus,
                  nota_viaje
              } = this.viajes.find((item) => item.id === viaje_id);
              this.id_viaje = id
              this.nro_viaje = nro_viaje
              this.tripulacion = trabajadores
              this.montos_asignados = monto_asignaciones
              this.fecha_viaje = fecha_viaje
              this.hora_viaje = hora_salida
              this.nombre_empresa = empleador.nombre_empleador
              this.tipo_viaje = tipo_viaje
              this.origen = origen.ciudad
              this.destino = destino.ciudad
              this.bus_select = bus.id
              this.bus_id_old = bus.id
              this.nota_de_viaje = nota_viaje

              $('#viajesModal').modal('show')
        },
        cargarTripulacion(){
           try{
                let url = '/lista-trabajadores?filtros_cargos[contrato]=2&opcion=1'

                const { data, status} = axios.get(url)

                if (status === 200){
                     this.tripulaciones = data
                }
           }catch (e) {
               console.log(e)
           }
        },
        es_servicio_mineria(){
            if(this.tipo_viaje === 'servicio de mineria'){
                this.tiene_cliente = true
            }else{
                this.tiene_cliente = false
            }
        },
        async update_cambio_estado()
        {
            try {
                let formData = new FormData();
                //formData.append('id', this.id)
                formData.append('estado', this.estado)
                //SOLO SI EL ESTADO ES SUSPENDIDO
                if (this.estado === 'SUSPENDIDO'){
                    //VALIDAR QUE EL MOTIVO NO ESTE VACIO
                    if (this.motivo_suspencion === ''){
                        this.$swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Debe ingresar un motivo de suspencion!',
                        })
                        return
                    }

                    formData.append('motivo_suspencion', this.motivo_suspencion)
                }


               const {data, status} = await axios.post('/cambio-estado-viaje/'+this.id,formData)

                if (status === 200) {
                    this.$swal({
                        title: 'CAMBIO DE ESTADO A'+this.estado,
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    })
                    this.estado = ''
                    if (this.estado === 'SUSPENDIDO'){
                       this.motivo_suspencion = ''
                    }
                    this.getViajes()
                    $('#estadosModal').modal('hide')
                }
            }catch (error) {
                console.log(error)
                this.$swal('error al cambiar el estado');
            }
        },
        async getlastFolio(){
            try {
              const {data , status} =  await axios.get('/obtener-ultimo-folio')
                if (status === 200){
                    this.nro_folio = data
                }
            }catch (error){
                console.log(error)
            }
        },
        async add_folios()
        {
            try{
                let url = '/agregar-folio'

                if (this.editar_folio){
                    url = '/agregar-folio/'+this.id_folio_editar
                }

                let formData = new FormData()

                formData.append('nro_folio',this.nro_folio)
                formData.append('monto_asignado',this.monto_asignado)
                formData.append('fecha_monto',this.fecha_monto)
                formData.append('glosa',this.glosa)
                formData.append('viaje_id',this.id)

                const {status} =   await axios.post(url,formData)

                if (status === 200){
                    //mensaje
                    this.$swal('Folio agregado')
                    this.monto_asignado = 0
                    this.glosa = ''
                    this.getViajes()
                    if (this.editar_folio){
                        this.id_folio_editar = 0
                        this.editar_folio = false
                        $('#viajesModal').modal('hide')
                    }
                   else{
                        $('#foliosModal').modal('hide')
                    }
                }

            }catch (error) {
                console.log(error)
            }

        },
        async getBuses(){
            try {
                let  url = '/getBusesLista?operador=lista'

                /* if (this.empleador_id !== 0){
                     url = url + '&filtro[empleador_id]='+this.empleador_id
                 }*/

                const { data, status } = await axios.get(url)
                if (status === 200){
                    this.buses = data
                    console.log(this.buses)
                }

            }catch (e) {
                console.log(e)
            }
        },
        cambiar_tripulante(id){

            //si el viaje esta finalizado no se puede editar
            let viaje = this.viajes.find(item => item.id === this.id_viaje)
            //si el viaje esta finalizado no se puede editar
            if (viaje.estado === 'FINALIZADO' || viaje.estado === 'SUSPENDIDO'){
                this.$swal.fire({
                    title: 'No se puede editar un viaje finalizado',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                })
                return;
            }
           let tripulacion = this.tripulacion.find((item) => item.id === id)

            this.id_tripulante=id
            this.rut_tripulante = tripulacion.rut
            this.nombre_tripulante = tripulacion.primer_nombre
            this.apellido_tripulante = tripulacion.primer_apellido
            this.activar_ediccion = true

        },
       async eliminar_tripulante(id){
            try{
                    let formData = new FormData()

                    //el que va ser eliminado del viaje
                    formData.append('id_tripulante',this.id_tripulante)
                    //el id del viaje
                    formData.append('viaje_id',this.id_viaje)
                    //el nuevo tripulante reemplazante
                    formData.append('trabajador_id',this.tripulante_select)

                  const {data, status} = await axios.post('/reemplazar-tripulante/'+id,formData)

                    if (status === 200){
                        this.$swal.fire({
                            title: 'Tripulante reemplazado',
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        })

                        this.getViajes()
                    }

            }catch (e){
                console.log(e)
            }

        },
        cerrar_modal_viajes() {
            $('#viajesModal').modal('hide')
            //resetear los valores
            this.id_viaje = ''
            this.nro_viaje = ''
            this.tripulacion = []
            this.montos_asignados = []
            this.fecha_viaje = ''
            this.hora_viaje = ''
            this.nombre_empresa = ''
            this.tipo_viaje = ''
            this.origen = ''
            this.destino = ''
            this.bus_select = 0
            this.nota_de_viaje = ''
            this.editar = true
            this.tiene_cliente = false
        },
        agregar_tripulante(){
            //si el viaje esta finalizado no se puede editar
            let viaje = this.viajes.find(item => item.id === this.id_viaje)
            //si el viaje esta finalizado no se puede editar
            if (viaje.estado === 'FINALIZADO' || viaje.estado === 'SUSPENDIDO'){
                this.$swal.fire({
                    title: 'No se puede editar un viaje finalizado',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                })
                return;
            }
           this.addTripulante = true
        },
       async enviar_formulario_tripulante(){
           try{
               if (this.tripulante_select === 0){
                   this.$swal.fire({
                       title: 'Debe seleccionar un tripulante',
                       icon: 'error',
                       confirmButtonText: 'Ok'
                   })
                   return;
                }
               //tripulacion length no debe superar los 3 tripulantes
                if (this.tripulacion.length >= 3){
                     this.$swal.fire({
                          title: 'No se puede agregar mas tripulantes',
                          icon: 'error',
                          confirmButtonText: 'Ok'
                     })
                     return;
                }

                let formData = new FormData()
                formData.append('viaje_id',this.id_viaje)
                formData.append('trabajador_id',this.tripulante_select)

               const { status } = await axios.post('/agregar-tripulante/'+this.id_viaje,formData)

               if (status === 200){
                   this.$swal.fire({
                       title: 'Tripulante agregado exitosamente',
                       icon: 'success',
                       confirmButtonText: 'Ok'
                   })
                   this.tripulante_select = 0
                   this.getViajes()
                   //cerrar modal
                     $('#tripulantesModal').modal('hide')
               }

           }catch (e) {
              // error de envio de formulario swal
               this.$swal.fire({
                   title: 'Error al agregar tripulante',
                   icon: 'error',
                   confirmButtonText: 'Ok'
               })

           }
        },
       async actualizar_viaje(){
          try{
                let formData = new FormData()
                formData.append('bus_id',this.bus_select)
                formData.append('bus_id_old',this.bus_id_old)
                formData.append('fecha_viaje',this.fecha_viaje)
                formData.append('hora_viaje',this.hora_viaje)
                formData.append('nota_viaje',this.nota_de_viaje)
                formData.append('nro_viaje',this.nro_viaje)

               const { status }  = await axios.post('/actualizar-viaje/'+this.id_viaje,formData)

                  if (status === 200){
                      //mensaje
                      this.$swal.fire({
                          title: 'Viaje actualizado',
                          icon: 'success',
                          confirmButtonText: 'Ok'
                      })
                      this.getViajes()
                      this.editar = true
                      $('#viajesModal').modal('hide')
                  }
          }catch (e){
              console.log(error)
              this.$swal.fire({
                  title: 'Error al actualizar viaje',
                  icon: 'error',
                  confirmButtonText: 'Ok'
              })
          }
        },
        // solo debe hacerlo el administrador
       async eliminar_viaje(id){
           try {
            //mensaje confirmar eliminacion
            const { value: accept } = await this.$swal.fire({
                title: '¿Estas seguro de eliminar este viaje?',
                text: "No podras revertir esta accion",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar!'
            }).then(res =>{
                if (res.value){
                    axios.delete('/eliminar-viaje/'+id).then(res=>{
                        this.$swal.fire({
                            title: 'Viaje eliminado',
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        })
                        this.getViajes()
                    }).catch(error => {
                        console.log(error)
                        this.$swal.fire({
                            title: 'Error al eliminar viaje',
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        })
                    })
                }
            })

           } catch (e) {
             console.log(e)
           }
        },
        editar_monto_asignado(id){
            //si el viaje esta finalizado no se puede editar
            let viaje = this.viajes.find(item => item.id === this.id_viaje)
            //si el viaje esta finalizado no se puede editar
            if (viaje.estado === 'FINALIZADO' || viaje.estado === 'SUSPENDIDO'){
                this.$swal.fire({
                    title: 'No se puede editar un viaje finalizado',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                })
                return;
            }
          //find monto asignado
            let monto = this.montos_asignados.find(item => item.id === id)
            this.monto_asignado = monto.monto_asignado
            this.nro_folio_editar = monto.nro_folio
            this.fecha_monto= monto.fecha
            this.glosa = monto.glosas
            this.id_folio_editar = id
            this.editar_folio = true
        },
       async actualizar_monto_folio(){
            try {
                let formData = new FormData()
                formData.append('monto_asignado',this.monto_folio)
                formData.append('fecha_monto',this.fecha_monto)
                formData.append('observacion',this.observacion)

                const { status } =await axios.post('/actualizar-monto-folio/'+this.id_folio_editar,formData)

                if (status === 200){
                    this.$swal.fire({
                        title: 'Monto actualizado',
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    })
                    this.getViajes()
                    this.editar_folio = false
                }
            }catch (e) {
                this.$swal.fire({
                    title: 'Error al actualizar monto',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                })
            }
        },
        getColorType(tipo) {
            if (!COLOR_CLASSES.hasOwnProperty(tipo)) {
                throw new Error(`Tipo ${tipo} no es válido`);
            }

            const colorClass = COLOR_CLASSES[tipo];
            return `<span class="badge ${colorClass}">${tipo}</span>`;
        },
        editar_viaje(){
             //encuentra el viaje
            let viaje = this.viajes.find(item => item.id === this.id_viaje)
            //si el viaje esta finalizado no se puede editar
            if (viaje.estado === 'FINALIZADO' || viaje.estado === 'SUSPENDIDO'){
                this.$swal.fire({
                    title: 'No se puede editar un viaje finalizado o suspendido',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                })
                this.editar = true
                return;
            }
            this.editar = false
        },
       async userLogin(){
          try{

              let url = '/getUsuarioLogeado'
              const {data , status } = await axios.get(url)

              if (status === 200){
                  this.usuario = data
                  this.isAdmin()
              }

          }catch (e) {
              console.log(e)
          }
        },
        isAdmin(){
          let admin = this.usuario.roles.find(item => item.name === 'admin')
            if (admin){
                this.isRoleAdmin = true
                return true
            }
        },
        isEstadoSuspendidos(){
            if (this.estado === 'SUSPENDIDO'){
                this.isSuspendido = true
            }
        },
        getPaginate:function (page_number){
            this.page =  page_number
            this.page_class = 'page-item active'
            this.getViajes()
        },
        cantidadRegistros:function (){
            this.page = 1
            this.getViajes()
        },
        cerrar_modal_estados(){
            this.estado = ''
            $('#estadosModal').modal('hide')
        },
        cerrarFolioModal(){
            $('#foliosModal').modal('hide')
        },
        abrirModalImprimir(id){
            this.id_viaje = id
            $('#imprimirModal').modal('show')
        },
        cerrarModalImprimir(){
            this.id_viaje = 0
            $('#imprimirModal').modal('hide')
        },
        imprimirCertidicado(numero){
            if (numero === 1){
                window.open('/getCertificadoSanitizacion/'+this.id_viaje,'_blank')
            }else{
                if(this.tipo_salida_select === ''){
                    this.$swal.fire({
                        title: 'Debe seleccionar un tipo de certificado',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                    return;
                }


                window.open('/getComprobanteSalida/'+this.id_viaje+'?TIPO_AUTORIZACION='+this.tipo_salida_select,'_blank')
            }
        },
        actualizarEstados(){
            //desea actualizar los estados de los viajes
            this.$swal.fire({
                title: '¿Desea actualizar los estados de los viajes?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Si',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.value) {
                    axios.get('/comprobar-estados-viajes').then(response => {
                        this.$swal.fire({
                            title: 'Estados actualizados',
                            icon: 'success',
                            confirmButtonText: 'Ok'

                        })
                        this.getViajes()
                    }).catch(error => {
                        console.log(error)
                        this.$swal.fire({
                            title: 'Error al actualizar estados',
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        })
                    })
                }
            })
        }
    },

   /* filters:{
        FormatoFecha(fecha){
            return moment(fecha).format('DD-MM-YYYY')
        },
        formatPrice(value) {
            let val = (value/1).toFixed(0).replace('.', ',')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        }
    }*/
}
/*$('#numero_bus').on("change",function(){
    app.filtroporBus = $(this).val();
    console.log('Name : '+$(this).val());
});*/
</script>

<style scoped>
    thead tr th{
        background-color: #D3B560;
        color: white;
    }
</style>
