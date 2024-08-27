<template>
    <div>
        <CardComponent :title="'Checklist Prevención'">

            <template #header>
                <div class="row">
                    <div class="col-md-12">
                        <div class="btn-group mb-3">
                            <a v-if="tienePermisoAgregarChecklist" href="/checklist-prevencion/nuevo"
                               class="btn btn-primary btn-sm"><i
                                class="fa fa-plus-circle"></i> Agregar</a>
                            <button class="btn btn-success btn-sm"
                                    @click="filtrar = !filtrar"
                            >
                                <i class="fa fa-filter"></i> Filtrar
                            </button>
                            <button @click="handleExport"
                                    class="btn btn-secondary btn-sm"><i class="fa fa-cloud-download-alt"></i> Descargar
                            </button>

                            <button @click="handleSendReport"
                                    class="btn btn-warning btn-sm"><i class="fa fa-envelope"></i> Reporte diario
                            </button>
                        </div>
                    </div>
                </div>
            </template>

            <template #body v-show="loading">
                <!--                <loading v-model:active="isLoading"
                                         :can-cancel="true"
                                         :is-full-page="fullPage"
                                         :active="active"
                                />-->
                <data-table
                    :items="checklist.data"
                    :loading="loading"
                    :columns="columns"
                    :colores="colores"
                >
                    <template #filtros>
                        <transition name="slide-fade">
                            <tr v-show="filtrar">
                                <td>
                                    <v-select
                                        :options="formattedChecklist"
                                        placeholder="Checklist"
                                        class="form-control form-control-solid"
                                        :reduce="checklist => checklist.id" v-model="checklist_filtro_id"
                                        @input="getChecklist()"
                                        style="padding:0px !important"
                                    ></v-select>
                                </td>
                                <td></td>
                                <td>
                                    <v-select
                                        :options="formattedBuses"
                                        placeholder="Buses"
                                        class="form-control form-control-solid"
                                        :reduce="bus => bus.id" v-model="bus_id"
                                        @input="getChecklist()"
                                        style="padding:0px !important"
                                    ></v-select>
                                </td>
                                <td>
                                    <v-select
                                        :options="formattedUserReportado"
                                        placeholder="Reportado por"
                                        class="form-control form-control-solid"
                                        :reduce="user => user.id" v-model="user_reportado_id"
                                        @input="getChecklist()"
                                        style="padding:0px !important"
                                    ></v-select>
                                </td>
                                <td>
                                    <input type="date" v-model="dateRange.startDate" @change="validateDates"
                                           class="form-control form-control-solid">
                                    <input type="date" v-model="dateRange.endDate" @change="validateDates; getTickets()"
                                           class="form-control form-control-solid">
                                </td>
                                <td>
                                    <select v-model="filtro_estado_firmado" @change="getChecklist()"
                                            class="form-select form-select-solic">
                                        <option value="">Firmado</option>
                                        <option value="Firmado">Firmado</option>
                                        <option value="No Firmado">No Firmado</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="filtro_estado" @change="getChecklist()"
                                            class="form-select form-select-solic">
                                        <option value="">Estado</option>
                                        <option value="aprobado">Aprobado</option>
                                        <option value="rechazado">Rechazado</option>
                                        <option value="aprobado con observaciones">Aprobado con observaciones</option>
                                    </select>
                                </td>

                                <td>
                                    <button class="btn btn-light" @click="resetFilters">
                                        <i class="fa fa-eraser"></i> Limpiar
                                    </button>
                                </td>
                            </tr>
                        </transition>
                    </template>
                    <template #actions="{ item }">
                        <div class="btn-group">
                            <button
                                class="btn btn-sm btn-light-info"
                                @click="getChecklistById(item.CHECKLIST_ID)">
                                <i class="fa fa-eye"></i>
                            </button>
                            <a class="btn btn-primary btn-sm"
                               :href="'/checklist-calidad/editar/'+item.CHECKLIST_ID"
                               v-if="tienePermisoEditarChecklist"
                            >
                                <i class="fa fa-edit"></i>
                            </a>
                            <button
                                class="btn btn-sm btn-success"
                                v-if="tienePermisoFirmarChecklist"
                                @click="abirFirmaModal(item.CHECKLIST_ID)">
                                <i class="fa fa-file"></i>
                            </button>
                        </div>
                    </template>
                </data-table>
                <div class="row">


                    <div class="col-md-11">
                        <paginate :pagination="checklist" :onPageChange="getChecklist"></paginate>
                    </div>

                </div>


            </template>

        </CardComponent>
        <bootstrap-modal
            :id="'verChecklist'"
            :title="'Informacion del checklist'"
            :customClass="'modal-dialog-centered mw-1000px'"
            :hideCloseButton="false"
            :onCloseButton="cerrarModal"
        >

            <template #body>
                <div>
                    <!-- Información Básica del Checklist -->
                    <div class="ficha-resumen">
                        <div class="ficha-resumen-header">
                            <div>
                                <div class="label">FOLIO:</div>
                                <div class="value"> {{ respuestaschecklist.folio }}</div>
                            </div>
                            <div>
                                <div class="label">FECHA:</div>
                                <div class="value">{{ formatearFecha(respuestaschecklist.fecha) }}</div>

                            </div>
                            <div>
                                <div class="label">ESTADO:</div>
                                <div class="value"><span :class="'badge badge-'+determinaClass">{{ respuestaschecklist.status }}</span></div>
                            </div>

                        </div>
                    </div>

                    <div v-if="respuestasAprobadasConObservaciones.length > 0">
                        <h1 class="mb-5">Aprobados con observaciones <i class="fa fa-warning"></i></h1>
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th>Item</th>
                                <th>Categoria</th>
                                <th>Respuesta</th>
                                <th>Valor</th>
                                <th>Observaciones</th>
                                <th>Respuesta adicional</th>
                                <th>Area</th>
                            </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                            <tr v-for="item in respuestasAprobadasConObservaciones" :key="item.id">
                                <td>{{ item.name }}</td>
                                <td>{{ item.type.name }}</td>
                                <td>{{ item.responses[0].respuesta }}</td>
                                <td>{{ item.responses[0].valor !== 'null' ? item.responses[0].valor : '-' }}</td>

                                <td>{{ item.responses[0].observaciones }}</td>
                                <td>{{ item.responses[0].respuesta_add }}</td>
                                <td>{{ item.area.descripcion_area }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div v-if="respuestasRechazadas.length > 0">
                        <h1 class="mb-5">Rechazados <i class=" fa fa-ban"></i></h1>

                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th>Item</th>
                                <th>Categoria</th>
                                <th>Respuesta</th>
                                <th>Valor</th>
                                <th>Observaciones</th>
                                <th>Respuesta adicional</th>
                                <th>Area</th>
                            </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                            <tr v-for="item in respuestasRechazadas" :key="item.id">
                                <td>{{ item.name }}</td>
                                <td>{{ item.type.name }}</td>
                                <td>{{ item.responses[0].respuesta }}</td>
                                <td>{{ item.responses[0].valor !== 'null' ? item.responses[0].valor : '-' }}</td>

                                <td>{{ item.responses[0].observaciones }}</td>
                                <td>{{ item.responses[0].respuesta_add }}</td>
                                <td>{{ item.area.descripcion_area }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>



                    <!-- Tabla de Items con Respuestas -->
                    <div class="table-responsive">
                        <h1 class="mb-5">Aprobadas <i class="fa fa-check"></i></h1>
                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th>Item</th>
                                <th>Categoria</th>
                                <th>Respuesta</th>
                                <th>Valor</th>
                                <th>Observaciones</th>
                                <th>Respuesta adicional</th>
                                <th>Area</th>
                                <!-- Agrega más encabezados si es necesario -->
                            </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                            <tr v-for="item in respuestasAprobadas" :key="item.id">
                                <td>{{ item.name }}</td>
                                <td>{{ item.type.name }}</td>
                                <td>{{ item.responses[0].respuesta }}</td>
                                <td>{{ item.responses[0].valor !== 'null' ? item.responses[0].valor : '-' }}</td>

                                <td>{{ item.responses[0].observaciones }}</td>
                                <td>{{ item.responses[0].respuesta_add }}</td>
                                <td>{{ item.area.descripcion_area }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </template>

            <template #footer>
                <div class="text-center">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" @click="cerrarModal">Cerrar
                    </button>
                </div>
            </template>
        </bootstrap-modal>

        <bootstrap-modal
            :id="'firmarChecklist'"
            :title="'Firmar checklist'"
            :customClass="'modal-dialog-centered mw-1000px'"
            :hideCloseButton="false"
            :onCloseButton="cerrarFirmaModal"
        >

            <template #body>
                <!--                <div class="col-md-8 mb-5">
                                    <label class="fs-6 fw-semibold mb-2" for="">Areas</label>
                                    <select v-model="area_id"
                                            @change="getTrabajadores"
                                            class="form-select form-select-solic">
                                        <option value="0">Selecciona un area</option>
                                        <option v-for="area in areas" :key="area.id" :value="area.id">{{ area.name }}</option>
                                    </select>
                                </div>-->

                <div class="ficha-resumen">
                    <div class="ficha-resumen-header">
                        <div>
                            <div class="label">FOLIO:</div>
                            <div class="value"> {{ folio_checklist }}</div>
                        </div>
                        <div>
                            <div class="label">FECHA:</div>
                            <div class="value">{{ fecha_checklist }}</div>

                        </div>
                        <div>
                            <div class="label">ESTADO:</div>
                            <div class="value">{{status_checklist }}</div>
                        </div>

                    </div>
                </div>


                <div class="table-responsive" v-if="respuestaschecklistNegativeApprovedwithObservation.length > 0">
                    <h1 class="mb-5">Aprobados con observaciones <i class="fa fa-warning"></i></h1>
                    <table class="table align-middle table-row-dashed fs-6 gy-5">
                        <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th>Item</th>
                            <th>Categoria</th>
                            <th>Respuesta</th>
                            <th>Valor</th>
                            <th>Observaciones</th>
                            <th>Area</th>
                            <!-- Agrega más encabezados si es necesario -->
                        </tr>
                        </thead>

                        <tbody class="fw-semibold text-gray-600">
                        <tr v-for="(item,index) in respuestaschecklistNegativeApprovedwithObservation" :key="index">
                            <td>{{ item.item_name }}</td>
                            <td>{{ item.type_name }}</td>
                            <td>{{ item.respuesta }}</td>
                            <td>{{ item.valor }}</td>
                            <td>{{ item.observaciones }}</td>
                            <td>{{ item.area_name }}</td>
                        </tr>

                        </tbody>
                    </table>
                </div>

                <!-- Tabla de Items con Respuestas -->
                <div class="table-responsive" v-if="respuestaschecklistNegativeRefused.length > 0">
                    <h1 class="mb-5">Rechazados <i class=" fa fa-ban"></i></h1>
                    <table class="table align-middle table-row-dashed fs-6 gy-5">
                        <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th>Item</th>
                            <th>Categoria</th>
                            <th>Respuesta</th>
                            <th>Valor</th>
                            <th>Observaciones</th>
                            <th>Area</th>
                            <!-- Agrega más encabezados si es necesario -->
                        </tr>
                        </thead>

                        <tbody class="fw-semibold text-gray-600">
                        <tr v-for="(item,index) in respuestaschecklistNegativeRefused" :key="index">
                            <td>{{ item.item_name }}</td>
                            <td>{{ item.type_name }}</td>
                            <td>{{ item.respuesta }}</td>
                            <td>{{ item.valor }}</td>
                            <td>{{ item.observaciones }}</td>
                            <td>{{ item.area_name }}</td>
                        </tr>

                        </tbody>
                    </table>
                </div>

                <div class="col-md-8 mb-5">
                    <label class="fs-6 fw-semibold mb-2" for="">Areas</label>
                    <select v-model="area_id" class="form-select form-select-solid">
                        <option v-for="area in areasWithNegativeResponse" :value="area.id">{{ area.name }}</option>
                    </select>
                </div>
                <div class="col-md-8 mb-5">
                    <label class="fs-6 fw-semibold mb-2" for="">Trabajador</label>
                    <v-select
                        :options="formattedTrabajadores"
                        placeholder="Trabajadores"
                        class="form-control form-control-solid"
                        :reduce="trabajador => trabajador.id" v-model="trabajador_id"
                        style="padding:0px !important"
                    ></v-select>
                </div>
                <div class="col-md-5">
                    <label for="tiene_discapacidad" class="fs-6 fw-semibold mb-2">¿Acepta Firmar?</label>
                    <div class="form-check form-switch form-check-custom form-check-solid">
                        <input class="form-check-input"
                               type="checkbox"
                               id="tiene_discapacidad"
                               v-model="isAgreeSigned"
                        />
                        <label class="form-check-label fw-semibold text-gray-400 ms-3" for="status"></label>
                    </div>
                </div>

                <div v-if="isAgreeSigned">
                    <div class="col-md-8 mb-5">
                        <label class="fs-6 fw-semibold mb-2">Contraseña</label>
                        <div class="input-group">
                            <input :type="showPassword ? 'text' : 'password'" v-model="password"
                                   class="form-control form-control-solic">
                            <button class="btn btn-outline-secondary" type="button"
                                    @click="showPassword = !showPassword">
                                <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                            </button>
                        </div>
                        <p class="text-danger" v-if="passwordError">{{ passwordError }}</p>
                    </div>
                    <div class="col-md-8 mb-5">
                        <label class="fs-6 fw-semibold mb-2">Repetir Contraseña</label>
                        <div class="input-group">
                            <input :type="showPassword ? 'text' : 'password'" v-model="password_repeat"
                                   class="form-control form-control-solic">
                            <button class="btn btn-outline-secondary" type="button"
                                    @click="showPassword = !showPassword">
                                <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                            </button>
                        </div>
                    </div>
                </div>


                <div class="col-md-8 mb-5" v-else>
                    <label class="fs-6 fw-semibold mb-2" for="">Observación</label>
                    <textarea class="form-control form-control-solic" v-model="observacion" rows="3"></textarea>
                </div>

                <h1>Usuario que Firmaron</h1>
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Area</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="user in users" :key="user.id">
                            <td>{{ user.nombre + ' ' + user.apellidos }}</td>
                            <td>{{ user.area_name }}</td>
                            <td>{{ user.fecha }}</td>
                            <td>{{ user.firmado === 1 ? 'firmado' : 'no firmado' }}</td>
                        </tr>
                        </tbody>
                    </table>

                </div>

            </template>

            <template #footer>
                <div class="text-center">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" @click="cerrarFirmaModal">
                        Cerrar
                    </button>
                    <button type="button" :disabled="users.length >= 3" class="btn btn-primary"
                            @click="firmarChecklist">Firmar
                    </button>
                </div>
            </template>

        </bootstrap-modal>

    </div>
</template>


<script>

import BootstrapModal from "@/components/modalComponent.vue";
import DataTable from "@/components/DataTable.vue";
import Select2 from "@/components/Form/Select2.vue";
import CardComponent from "@/components/CardComponent.vue";
import Loading from "vue-loading-overlay";
import paginate from "@/components/paginate.vue";

const colores = [
    {status: 'aprobado con observaciones', label: 'Aprobado con observaciones', color: 'warning'},
    {status: 'aprobado', label: 'Aprobado', color: 'success'},
    {status: 'rechazado', label: 'Rechazado', color: 'danger'},
    {status: 'Firmado', label: 'Firmado', color: 'light-info'},
    {status: 'No Firmado', label: 'No Firmado', color: 'light-danger'},
]
export default {
    props: {
        permisos: {
            type: Array,
            required: false
        }
    },
    components: {
        Loading,
        CardComponent,
        paginate,
        BootstrapModal,
        DataTable,
        Select2
    },
    computed: {
        formattedTrabajadores() {
            return this.trabajadores.map((trabajador) => {
                return {
                    id: trabajador.id,
                    label: trabajador.rut+' - '+trabajador.name + ' ' + trabajador.apellidos
                };
            });

        },
        tienePermisoFirmarChecklist() {
            return this.permisos.includes('Firmar Checklist Prevencion');
        },
        tienePermisoEditarChecklist() {
            return this.permisos.includes('Editar Checklist Prevencion');
        },
        tienePermisoAgregarChecklist() {
            return this.permisos.includes('Agregar Checklist Prevencion');
        },
        formattedBuses() {
            return this.buses.map(bus => ({
                id: bus.id,
                label: bus.numero_bus + ' - ' + bus.patente
            }));
        },
        formattedUserReportado() {
            return this.user_reportado.map(user => ({
                id: user.id,
                label:user.rut +' - ' + user.name + ' ' + user.apellidos
            }));
        },
        formattedChecklist() {
            return this.checklist_all.map(checklist => ({
                id: checklist.CHECKLIST_ID,
                label: checklist.FOLIO
            }));
        },
        respuestasRechazadas() {
            if (Array.isArray(this.respuestaschecklist.items)) {
                return this.respuestaschecklist.items.filter(item => {
                    // Revisar si el estatus es 'refused'
                    const isRefused = item.critical === 'refused';

                    // Revisar si alguna de las respuestas es 'NO'
                    const hasNoResponse = item.responses.some(response => {
                        return response.respuesta === 'NO' || response.valor === 'NO';
                    });

                    // Solo incluir el objeto si ambas condiciones son verdaderas
                    return isRefused && hasNoResponse;
                });
            }

            return []; // Retornar un arreglo vacío si items no está definido o no es un arreglo
        },
        respuestasAprobadasConObservaciones() {
            // Primero, asegurarnos de que this.respuestaschecklist.items es un arreglo
            if (Array.isArray(this.respuestaschecklist.items)) {
                return this.respuestaschecklist.items.filter(item => {
                    const isRefused = item.critical === 'approved with observation';
                    const hasNoResponse = item.responses.some(response => {
                        return response.respuesta === 'NO' || response.valor === 'NO';
                    });
                    return isRefused && hasNoResponse;
                });
            }
            return []; // Retornar un arreglo vacío si items no está definido o no es un arreglo
        },
        respuestasAprobadas() {
            // Primero, asegurarnos de que this.respuestaschecklist.items es un arreglo
            if (Array.isArray(this.respuestaschecklist.items)) {
                return this.respuestaschecklist.items.filter(item => {
                    // Revisar si el estatus es 'refused'
                    //const isRefused = item.critical === 'refused';

                    // Revisar si alguna de las respuestas es 'NO'
                    const hasResponse = item.responses.some(response => {
                        return response.respuesta === 'SI' || response.valor === 'SI';
                    });

                    // Solo incluir el objeto si ambas condiciones son verdaderas
                    return hasResponse;
                });
            }

            return []; // Retornar un arreglo vacío si items no está definido o no es un arreglo

        },
        determinaClass() {
            // Intenta encontrar el color correspondiente al status
            const colorObj = this.colores.find(color => color.status === this.respuestaschecklist.status);
            // Devuelve el color si el objeto existe, de lo contrario, devuelve un color predeterminado
            return colorObj ? colorObj.color : 'success'; // 'defaultColor' es un valor predeterminado
        },
        //filtar respuestaschecklistNegative por critical
        respuestaschecklistNegativeRefused() {
            return this.respuestaschecklistNegative.filter(item => {
                return item.critical === 'refused';
            });
        },
        //critical approved with observation
        respuestaschecklistNegativeApprovedwithObservation() {
            return this.respuestaschecklistNegative.filter(item => {
                return item.critical === 'approved with observation';
            });
        },
        //filtar las areas por las area_id que viene en respuestaschecklistNegative y solo deja las que esten en respuestaschecklistNegative
        areasWithNegativeResponse() {
            // Creamos un Set para almacenar los ids únicos de respuestaschecklistNegative
            const uniqueAreaIds = new Set(this.respuestaschecklistNegative.map(item => item.area_id));

            // Filtramos el array areas para obtener solo los elementos cuyo id esté en uniqueAreaIds
            return this.areas.filter(area => uniqueAreaIds.has(area.id));
        }
    },
    data() {
        return {
            columns: [
                {key: 'FOLIO', label: 'Folio', sortable: true},
                {key: 'CATEGORIA', label: 'Categoria', sortable: true},
                {key: 'BUS', label: 'Bus', sortable: true},
                {key: 'NOMBRE_USUARIO', label: 'Ingresado por', sortable: true},
                {key: 'FECHA_CREACION', label: 'Fecha', sortable: true},
                {key: 'SIGNED_STATUS', label: 'Firmado', sortable: false, badge: true},
                {key: 'STATUS', label: 'Estado', sortable: true, badge: true},
            ],
            colores: colores,
            checklist: [],
            selectArray: [],
            loading: false,
            fullPage: true,
            isLoading: false,
            active: true,
            respuestaschecklist: [],
            respuestaschecklistNegative: [],
            areas: [
                {id: 28, name: 'Prevencion'},
                {id: 8, name: 'Informatica'},
                {id: 9, name: 'Mantención'},
                {id: 12, name: 'Operaciones'},
                {id: 10, name: 'Montitoreo'},
            ],
            area_id: 0,
            trabajador_id: 0,
            password: '',
            trabajadores: [],
            checklist_id: 0,
            password_repeat: '',
            showPassword: false,
            isAgreeSigned: true,
            observacion: '',
            users: [],
            buses: [],
            bus_id: 0,
            destinos: [],
            destino_id: 0,
            filtro_estado: '',
            filtro_estado_firmado: '',
            filtrar: false,
            user_reportado: [],
            user_reportado_id: 0,
            checklist_all:[],
            checklist_filtro_id: 0,
            passwordError: '',
            dateRange: {
                startDate: null,
                endDate: null
            },
            folio_checklist: '',
            fecha_checklist: '',
            status_checklist: '',
        };
    },
    watch: {
        password(newVal) {
            this.validatePassword();
        },
        password_repeat(newVal) {
            this.validatePassword();
        },
        area_id: function (newVal) {
            this.getTrabajadores(newVal);
        }
    },
    mounted() {
        this.getChecklist();
       // this.getTrabajadores();
        this.getBusesAll();
        this.getUserReportado();
        this.getAllChecklist();
    },
    methods: {
        validatePassword() {
            // Resetear el mensaje de error cada vez que se valida
            this.passwordError = '';

            // Ejemplo de validación: asegurar que las contraseñas coincidan
            if (this.password !== this.password_repeat) {
                this.passwordError = 'Las contraseñas no coinciden.';
            }

            // Aquí puedes agregar más validaciones según necesites
        },
        getChecklist(page = 1) {

            const params = new URLSearchParams();

            if (this.checklist_filtro_id !== 0) {
                params.append('filtro[CHECKLIST_ID]', this.checklist_filtro_id);
            }

            if (this.bus_id !== 0) {
                params.append('filtro[BUS_ID]', this.bus_id);
            }

            if (this.user_reportado_id !== 0) {
                params.append('filtro[USER_ID]', this.user_reportado_id);
            }

            if (this.filtro_estado) {
                params.append('filtro[STATUS]', this.filtro_estado);
            }

            if (this.filtro_estado_firmado) {
                params.append('filtro[SIGNED_STATUS]', this.filtro_estado_firmado);
            }

            if (this.dateRange.startDate && this.dateRange.endDate) {
                params.append('filtros[FECHA_INICIO]', this.dateRange.startDate);
                params.append('filtros[FECHA_FIN]', this.dateRange.endDate);
            }

            if (page > 1) {
                params.append('page', page);
            }

            let url = '/getchecklistPrevencion?option=paginate&' + params.toString();

            axios
                .get(url)
                .then((res) => {
                    this.checklist = res.data;
                    this.loading = false;
                })
                .catch((err) => {
                    console.log(err);
                });

        },

       async getAllChecklist() {
           const {data,status} = await axios.get('/getchecklistPrevencion?option=all')
              if (status === 200) {
                this.checklist_all = data
              }
        },
        validateDates() {
            if (this.dateRange.startDate && this.dateRange.endDate) {
                if (this.dateRange.startDate > this.dateRange.endDate) {
                    Swal.fire(
                        'Error',
                        'La fecha de inicio no puede ser mayor a la fecha de fin',
                        'error'
                    );
                }
            }
        },
        async getBusesAll() {
            try {
                let url = '/getBusesLista?operador=lista'

                const {data, status} = await axios.get(url)
                if (status === 200) {
                    this.buses = data
                }

            } catch (e) {
                console.log(e)
            }
        },
        async handleExport() {
            try {
                const params = new URLSearchParams();

                if (this.bus_id) {
                    params.append('filtro[BUS_ID]', this.bus_id);
                }

                if (this.filtro_estado) {
                    params.append('filtro[STATUS]', this.filtro_estado);
                }

                if (this.filtro_estado_firmado) {
                    params.append('filtro[SIGNED_STATUS]', this.filtro_estado_firmado);
                }
                const urlBase = '/export-checklist-prevencion?' + params.toString();

                const response = await axios({
                    url: urlBase,
                    method: 'GET',
                    responseType: 'blob', // Important
                });
                //console.log(response.data)
                let date = Date.now()
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;

                link.setAttribute('download', date + '.xlsx'); //or any other extension
                document.body.appendChild(link);
                link.click();
            } catch (error) {
                console.error("Error downloading the file.");
            }
        },
        getChecklistById(id) {
            axios
                .get("/getChecklistPrevencionById/" + id)
                .then((res) => {
                    this.respuestaschecklist = res.data;
                    $("#verChecklist").modal("show");
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        async getCheckListCalidadIdNegativeResponses(id) {
            const {data, status} = await axios.get("/getCheckListCalidadIdNegativeResponse/" + id)
            if (status === 200) {
                this.respuestaschecklistNegative = data
            }
        },
        //getFirmantes
        async getFirmantes(checklist_id) {
            await axios.get('/getFirmantes/' + checklist_id)
                .then((res) => {
                    this.users = res.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        cerrarModal() {
            this.respuestaschecklist = [];
            $("#verChecklist").modal("hide");
        },
        getColorStatus(status) {
            //devuelve el color del status
            return this.colores.find((color) => color.status === status).color;
        },
        cerrarFirmaModal() {
            this.area_id = 0;
            this.trabajador_id = 0;
            this.password = '';
            this.password_repeat = '';
            this.checklist_id = 0;
            this.isAgreeSigned = true;
            this.observacion = '';
            this.users = [];

            this.folio_checklist = '';
            this.fecha_checklist = '';
            this.status_checklist = '';

            $("#firmarChecklist").modal("hide");
        },
        abirFirmaModal(checklist_id) {
            this.checklist_id = checklist_id;

            //filtar el checklist por id
            const checklist = this.checklist.data.find(checklist => checklist.CHECKLIST_ID === checklist_id);

            this.folio_checklist = checklist.FOLIO;
            this.fecha_checklist = checklist.FECHA_CREACION;
            this.status_checklist = checklist.STATUS;


            this.getTrabajadores();
            this.getCheckListCalidadIdNegativeResponses(checklist_id);
            this.getFirmantes(checklist_id);
            $("#firmarChecklist").modal("show");
        },
        async getTrabajadores(area_id = null) {

            let url = '/trabajadoresByArea/'+this.checklist_id;

            await axios.get(url)
                .then((res) => {
                    this.trabajadores = res.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },

        checkPasswords() {
            if (this.password !== this.password_repeat) {
                this.passwordError = 'Passwords do not match';
                return false;
            }
            this.passwordError = '';
            return true;
        },
        async firmarChecklist() {
            if (!this.checkPasswords()) {
                return;
            }

            this.isLoading = true; // Asegúrate de establecer isLoading a true al inicio
            let formData = new FormData();

            let isAgreeSigned = this.isAgreeSigned ? 1 : 0;
            formData.append('area_id', this.area_id);
            formData.append('trabajador_id', this.trabajador_id);

            formData.append('password', this.password);
            formData.append('isAgreeSigned', isAgreeSigned);
            formData.append('observacion', this.observacion);

            try {
                const response = await axios.post('/validateChecklist/' + this.checklist_id, formData);

                // Si la petición es exitosa
                this.isLoading = false;
                this.area_id = 0;
                this.trabajador_id = 0;
                this.password = '';
                this.isAgreeSigned = true;
                this.password_repeat = '';
                $("#firmarChecklist").modal("hide");
                this.getChecklist();

                // Mostrar mensaje de éxito
                Swal.fire({
                    title: 'Éxito!',
                    text: 'Checklist firmado correctamente.',
                    icon: 'success',
                    confirmButtonText: 'Ok'
                });
            } catch (err) {
                this.isLoading = false;

                // Verificar si el error es de tipo 404 o capturar otro tipo de error
                let mensajeError = 'Ocurrió un error inesperado.';
                if (err.response && err.response.status === 404) {
                    mensajeError = 'No se encontró el checklist.';
                } else if (err.response && err.response.data && err.response.data.mensaje) {
                    mensajeError = err.response.data.mensaje;
                }

                // Mostrar mensaje de error
                Swal.fire({
                    title: 'Error!',
                    text: mensajeError,
                    icon: 'error',
                    confirmButtonText: 'Cerrar'
                });
            }
        },
        async getUserReportado() {
            const {data,status} = await axios.post('/getUsersByAreas', {
                area_ids: [3]
            })

            if (status === 200) {
                this.user_reportado = data
            }
        },
        handleSendReport() {
            Swal.fire({
                title: 'Enviar reporte diario',
                text: '¿Estás seguro de enviar el reporte diario?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.sendReport();
                }
            });
        },
        sendReport() {
            axios.get('/send-ticket-prevencion-notification')
                .then(response => {
                    // Handle the response here
                    Swal.fire({
                        title: 'Success!',
                        text: 'The daily report has been sent successfully.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                })
                .catch(error => {
                    // Handle the error here
                    console.log(error);
                });
        },
        resetFilters() {
            this.bus_id = 0;
            this.filtro_estado = '';
            this.filtro_estado_firmado = '';
            this.dateRange.startDate = null;
            this.dateRange.endDate = null;
            this.user_reportado_id = 0;
            this.checklist_filtro_id = 0;

            this.getChecklist();
        },
        formatearFecha(fecha) {
            if (!fecha) return '';
            const partes = fecha.split('-');
            return `${partes[2]}-${partes[1]}-${partes[0]}`; // DD-MM-YYYY
        }
    },
};

</script>
<style scoped>
.ficha-resumen {
    display: flex;
    flex-direction: column;
    flex-wrap: wrap;
    justify-content: space-between;
    width: 100%;
    margin: 20px auto;

}
.ficha-resumen-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}
.ficha-resumen-header > div {
    flex: 1;
    text-align: left;
}
.ficha-resumen-header > div:not(:last-child) {
    margin-right: 10px;
}
.label {
    font-weight: bold;
    margin-bottom: 2px;
}
.value {
    font-size: 1em;
}

</style>
