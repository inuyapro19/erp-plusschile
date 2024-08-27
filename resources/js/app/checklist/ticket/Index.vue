<template xmlns="http://www.w3.org/1999/html">
    <div>
        <CardComponent :title="'Ticket Calidad'">

            <template #header>
                <div class="row">
                    <div class="col-md-12">
                        <div class="btn-group mb-3">
                            <!-- Removed the "New" button as per your request -->
                            <button class="btn btn-success btn-sm"
                                    @click="filtrar = !filtrar"
                            >
                                <i class="fa fa-filter"></i> Filtrar
                            </button>
                            <button @click="handleExport"
                                    class="btn btn-secondary btn-sm"><i class="fa fa-cloud-download-alt"></i> Descargar
                            </button>
                        </div>
                    </div>
                </div>
            </template>

            <template #body v-show="loading">

                <data-table
                    :items="tickets.data"
                    :loading="loading"
                    :columns="columns"
                    :colores="colores"
                >
                    <template #filtros>
                        <transition name="slide-fade">
                            <tr v-show="filtrar">
                                <td>
                                    <v-select
                                        :options="formattedTickets"
                                        label="label"
                                        class="form-control form-control-solid"
                                        :reduce="ticket => ticket.id" v-model="ticket_id"
                                        @input="getTickets()"
                                        style="padding:0px !important"
                                    ></v-select>
                                </td>
                                <td>
                                    <v-select
                                        :options="formattedBuses"
                                        label="label"
                                        class="form-control form-control-solid"
                                        :reduce="bus => bus.id" v-model="bus_id"
                                        @input="getTickets()"
                                        style="padding:0px !important"
                                    ></v-select>
                                </td>
                                <td></td>
                                <td>
                                    <v-select
                                        :options="formattedUserReportado"
                                        label="label"
                                        class="form-control form-control-solid"
                                        :reduce="user => user.id" v-model="user_id_reportado"
                                        @input="getTickets()"
                                        style="padding:0px !important"
                                    ></v-select>
                                </td>
                                <td>
                                    <v-select
                                        :options="formattedUsersAsignados"
                                        label="label"
                                        class="form-control form-control-solid"
                                        :reduce="user => user.id" v-model="user_id_asignado"
                                        @input="getTickets()"
                                        style="padding:0px !important"
                                    ></v-select>
                                </td>
                                <td>
                                    <v-select :options="formattedAreas"
                                              label="label"
                                              class="form-control form-control-solid"
                                              :reduce="area => area.id"
                                              v-model="area_id"
                                              @input="getTickets()"
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
                                    <select v-model="filtro_prioridad"
                                            class="form-select form-select-solid"
                                            @change="getTickets()"
                                    >
                                        <option value="alta">Alta</option>
                                        <option value="media">Media</option>
                                        <option value="baja">Baja</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="filtro_estados"
                                            class="form-select form-select-solid"
                                            @change="getTickets()"
                                    >
                                        <option value="Abierto">Abierto</option>
                                        <option value="Cerrado">Cerrado</option>
                                    </select>
                                </td>
                                <td>
                                    <select v-model="filtro_estado_validado"
                                            class="form-select form-select-solid"
                                            @change="getTickets()"
                                    >
                                        <option value="validado">Validado</option>
                                        <option value="no validado">No validado</option>
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
                        <button
                            class="btn btn-sm btn-primary"
                            @click="viewTicket(item.TICKET_ID)"
                            v-if="tienePermisoEditarTicket"
                        >

                            <i class="fa fa-edit"></i>
                        </button>
                        <button
                            class="btn btn-sm btn-success"
                            @click="validarTicket(item.TICKET_ID)"
                            :disabled="item.ESTADO_VALIDACION === 'validado'"
                            v-if="item.ESTADO === 'Cerrado' && tienePermisoValidarTicket">
                            <i class="fa fa-check"></i>
                        </button>

                    </template>
                </data-table>
                <div class="row">


                    <div class="col-md-11">
                        <paginate :pagination="tickets" :onPageChange="getTickets"></paginate>
                    </div>

                </div>

            </template>

        </CardComponent>
        <bootstrap-modal
            :id="'verTicket'"
            :title="'Informacion del ticket'"
            :customClass="'modal-dialog-centered mw-850px'"
            :hideCloseButton="false"
            :onCloseButton="cerrarModal"
        >

            <template #body>
                <div class="mb-13 text-center">

                </div>
                <div class="d-flex flex-column mb-8 fv-row fv-plugins-icon-container">
                    <!--begin::Label-->
                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                        Titulo
                    </label>
                    <!--end::Label-->
                    <input type="text"
                           class="form-control form-control-solid"
                           :disabled="true"
                           placeholder="Enter your ticket subject" v-model="titulo">

                </div>

                <div class="row g-9 mb-8">
                    <div class="col-md-6 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            Bus
                        </label>
                        <input type="text"
                               :disabled="true"
                               class="form-control form-control-solid"
                               placeholder="Enter your ticket subject" v-model="bus">
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            Reportado por
                        </label>
                        <input type="text"
                               class="form-control form-control-solid"
                               :disabled="true"
                               v-model="reportado_por"
                        />
                    </div>
                </div>

                <div class="row g-9 mb-8">
                    <div class="col-md-6 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            Asignado a
                        </label>
                        <input type="text"
                               class="form-control form-control-solid"
                               :disabled="true"
                               v-model="asignado_a"
                        />
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            Prioridad
                        </label>
                        <input type="text"
                               class="form-control form-control-solid"
                               :disabled="true"
                               v-model="prioridad"
                        />
                    </div>

                    <div class="col-md-6 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            Respuesta
                        </label>
                        <input type="text"
                               class="form-control form-control-solid"
                               :disabled="true"
                               v-model="respuesta"
                        />
                    </div>
                    <div class="col-md-6 fv-row" v-if="respuesta_add">
                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            Respuesta adicional
                        </label>
                        <input type="text"
                               class="form-control form-control-solid"
                               :disabled="true"
                               v-model="respuesta_add"
                        />
                    </div>

                    <div class="col-md-12 fv-row" v-if="observaciones">
                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            Observaciones
                        </label>
                        <textarea
                            class="form-control form-control-solid"
                            :disabled="true"
                            v-model="observaciones"
                        > </textarea>

                    </div>

                    <div class="col-md-12 fv-row" v-if="observacion_validacion">
                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            Observaciones de validación
                        </label>
                        <textarea
                            class="form-control form-control-solid"
                            :disabled="true"
                            v-model="observacion_validacion"
                        > </textarea>

                    </div>

                    <div class="col-md-6 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            Estado
                        </label>
                        <select v-model="estado"
                                :disabled="isDisabled"
                                class="form-select form-select-solid">
                            <option v-for="estado in estados" :value="estado.value" :selected="estado.value === estado">
                                {{ estado.name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-8 fv-row" v-if="estado === 'Cerrado'">
                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            Resumen de la resolución
                        </label>
                        <textarea
                            class="form-control form-control-solid"
                            v-model="resolution_summary"
                        > </textarea>
                    </div>
                </div>


            </template>
            <template #footer>
                <div class="text-center">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" @click="cerrarModal">Cerrar
                    </button>
                    <button type="button" class="btn btn-primary" @click="cambiarEstadoEstado(ticketInfo.TICKET_ID)">
                        Cambiar estado
                    </button>
                </div>
            </template>
        </bootstrap-modal>

    </div>
</template>

<script>
import moment from 'moment';
import CardComponent from "@/components/CardComponent.vue";
import DataTable from "@/components/DataTable.vue";
import BootstrapModal from "@/components/modalComponent.vue";
import paginate from "@/components/paginate.vue";
import DateRangePicker from 'vue2-daterange-picker'
import 'vue2-daterange-picker/dist/vue2-daterange-picker.css';


const colores = [
    {status: 'Abierto', label: 'Abierto', color: 'danger'},
    {status: 'Cerrado', label: 'Cerrado', color: 'success'},
    {status: 'alta', label: 'Alta', color: 'light-danger'},
    {status: 'media', label: 'Media', color: 'light-warning'},
    {status: 'baja', label: 'Baja', color: 'light-primary'},
    {status: 'validado', label: 'Validado', color: 'light-success'},
    {status: 'no validado', label: 'No validado', color: 'light-danger'},
]
export default {
    props: {
        permisos: {
            type: Array,
            required: false
        }
    },
    components: {
        CardComponent,
        DataTable,
        BootstrapModal,
        paginate,
        DateRangePicker
    },
    computed: {
        tienePermisoValidarTicket() {
            return this.permisos.includes('Validar Ticket');
        },
        tienePermisoEditarTicket() {
            return this.permisos.includes('Editar Ticket');
        },
        formattedBuses() {
            return this.buses.map(bus => ({
                id: bus.id,
                label: bus.numero_bus + ' - ' + bus.patente
            }));
        },
        formattedTickets() {
            return this.ticket_filtros.map(ticket => ({
                id: ticket.TICKET_ID,
                label: ticket.NRO_TICKET
            }));
        },
        formattedAreas() {
            const ids = [3, 8, 9, 12, 6];
            return this.areas
                .filter(area => ids.includes(area.id))
                .map(area => ({
                    id: area.id,
                    label: area.descripcion_area
                }));
        },
        formattedUsersAsignados() {
            return this.users_asignados.map(user => ({
                id: user.id,
                label: user.rut + ' - ' + user.name + ' ' + user.apellidos
            }));
        },
        formattedUserReportado() {
            return this.user_reportado.map(user => ({
                id: user.id,
                label: user.rut + ' - ' + user.name + ' ' + user.apellidos
            }));
        }
    },
    data() {
        return {
            columns: [
                {key: 'NRO_TICKET', label: 'NRO TICKET', sortable: true},
                {key: 'BUS', label: 'Bus'},
                {key: 'TITULO', label: 'Titulo', sortable: true},
                {key: 'REPORTADO_POR', label: 'Reportado por', sortable: true},
                {key: 'AREA_DESCRIPCION', label: 'AREA ENCARGADA', sortable: true},
                {key: 'FECHA_CREACION', label: 'Fecha reportado', sortable: true},
                {key: 'PRIORIDAD', label: 'Prioridad', sortable: true, badge: true},
                {key: 'ESTADO', label: 'Estado', sortable: true, badge: true},
                {key: 'ESTADO_VALIDACION', label: 'Validación', sortable: true, badge: true},
            ],
            tickets: [],
            loading: false,
            colores: colores,
            ticketInfo: [],
            titulo: '',
            bus: '',
            reportado_por: '',
            asignado_a: '',
            prioridad: '',
            filtro_prioridad: '',
            estado: '',
            ticketId: 0,
            areas: [],
            area_id: '',
            prioridades: [
                {value: 'alta', name: 'Alta'},
                {value: 'media', name: 'Media'},
                {value: 'baja', name: 'Baja'},
            ],
            estados: [
                {value: 'Abierto', name: 'Abierto'},
                {value: 'Cerrado', name: 'Cerrado'},
            ],
            filtrar: false,
            buses: [],
            bus_id: null,
            filtro_estados: '',
            filtro_estado_validado: '',
            locale: {
                direction: 'ltr', // Puedes omitir esta línea si tu aplicación está en LTR por defecto
                format: 'YYYY-MM-DD',
                separator: ' - ',
                applyLabel: 'Aplicar',
                cancelLabel: 'Cancelar',
                weekLabel: 'S',
                customRangeLabel: 'Rango Personalizado',
                daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                firstDay: 1 // El primer día de la semana, Lunes
            },
            dateRange: {
                startDate: null,
                endDate: null
            },
            respuesta: '',
            respuesta_add: '',
            observaciones: '',
            image: '',
            observacion_validacion: '',
            isDisabled: false,
            ticket_filtros: [],
            ticket_id: 0,
            users_asignados: [],
            user_id_asignado: 0,
            user_reportado: [],
            user_id_reportado: 0,
            resolution_summary: ''
        };
    },
    mounted() {
        this.getTickets();
        this.getAllTicket();
        this.getBusesAll();
        this.getAreas();
        this.getUserAsignado();
        this.getUserReportado();
    },
    methods: {
        resetFilters() {
            this.bus_id = null;
            this.filtro_prioridad = '';
            this.filtro_estados = '';
            this.filtro_estado_validado = '';
            this.area_id = '';
            this.dateRange.startDate = null;
            this.dateRange.endDate = null;
            this.ticket_id = 0;
            this.getTickets();
        },
        getTickets(page = 1) {
            this.loading = true;
            const params = new URLSearchParams();
            //params.append('opciones', 'listPage');
            //params.append('perpage', 10);
            /*  params.append('order', 'desc');
              params.append('orderPor', 'TICKET_ID');*/

            if (this.ticket_id) {
                params.append('filtro[TICKET_ID]', this.ticket_id);
            }

            if (this.bus_id) {
                params.append('filtro[BUS_ID]', this.bus_id);
            }

            if (this.user_id_reportado) {
                params.append('filtro[REPORTADO_POR_ID]', this.user_id_reportado);
            }

            if (this.user_id_asignado) {
                params.append('filtro[ASIGNADO_A_ID]', this.user_id_asignado);
            }

            if (this.filtro_prioridad) {
                params.append('filtro[PRIORIDAD]', this.filtro_prioridad);
            }

            if (this.filtro_estados) {
                params.append('filtro[ESTADO]', this.filtro_estados);
            }

            if (this.filtro_estado_validado) {
                params.append('filtro[ESTADO_VALIDACION]', this.filtro_estado_validado);
            }

            if (this.area_id) {
                params.append('filtro[AREA_ID]', this.area_id);
            }

            if (this.dateRange.startDate && this.dateRange.endDate) {
                params.append('filtros[FECHA_INICIO]', this.dateRange.startDate);
                params.append('filtros[FECHA_FIN]', this.dateRange.endDate);
            }


            if (page > 0) {
                params.append('page', page);
            }

            // Agrega aquí más parámetros de filtro según sea necesario

            let url = '/ticket-calidad?option=paginate&' + params.toString();

            axios.get(url)
                .then((response) => {
                    if (response.status === 200) {
                        this.tickets = response.data;
                    }
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        async getAllTicket() {
            const {data, status} = await axios.get('/ticket-calidad?option=all')
            if (status === 200) {
                this.ticket_filtros = data
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
        async getAreas() {
            try {
                const {data, status} = await axios.get('/areas') // replace '/areas' with your actual API endpoint
                if (status === 200) {
                    this.areas = data
                }
            } catch (e) {
                console.log(e)
            }
        },
        async getUserAsignado() {
            const {data, status} = await axios.post('/getUsersByAreas', {
                area_ids: [3, 6, 8, 9, 12]
            })

            if (status === 200) {
                this.users_asignados = data
            }
        },
        async getUserReportado() {
            const {data, status} = await axios.post('/getUsersByAreas', {
                area_ids: [3]
            })

            if (status === 200) {
                this.user_reportado = data
            }
        },
        async handleExport() {
            try {
                const params = new URLSearchParams();

                if (this.bus_id) {
                    params.append('filtro[BUS_ID]', this.bus_id);
                }

                if (this.filtro_prioridad) {
                    params.append('filtro[PRIORIDAD]', this.filtro_prioridad);
                }

                if (this.filtro_estados) {
                    params.append('filtro[ESTADO]', this.filtro_estados);
                }

                if (this.filtro_estado_validado) {
                    params.append('filtro[ESTADO_VALIDACION]', this.filtro_estado_validado);
                }
                const urlBase = '/export-ticket?' + params.toString();

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
        async cambiarEstadoEstado() {
            await axios.post('/ticket-calidad/' + this.ticketId, {
                estado: this.estado,
                resolution_summary: this.resolution_summary
            })
                .then((response) => {
                    this.getTickets();
                    this.estado = ''
                    this.resolution_summary = ''
                    $('#verTicket').modal('hide')
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        viewTicket(ticketId) {
            //buscar y settear la informacion del ticket
            this.ticketInfo = this.tickets.data.find(ticket => ticket.TICKET_ID === ticketId)
            this.titulo = this.ticketInfo.TITULO
            this.bus = this.ticketInfo.BUS
            this.reportado_por = this.ticketInfo.REPORTADO_POR
            this.asignado_a = this.ticketInfo.ASIGNADO_A
            this.prioridad = this.ticketInfo.PRIORIDAD
            this.estado = this.ticketInfo.ESTADO
            //dashabiliar estado si el ticket esta cerrado

            this.ticketId = this.ticketInfo.TICKET_ID
            this.respuesta = this.ticketInfo.RESPUESTAS ? this.ticketInfo.RESPUESTAS : ''
            this.respuesta_add = this.ticketInfo.RESPUESTA_ADDITIONAL ? this.ticketInfo.RESPUESTA_ADDITIONAL : ''
            this.observaciones = this.ticketInfo.OBSERVACIONES ? this.ticketInfo.OBSERVACIONES : ''
            this.image = this.ticketInfo.IMAGENES ? this.ticketInfo.IMAGENES : ''

            this.observacion_validacion = this.ticketInfo.OBSERVACION_VALIDACION ? this.ticketInfo.OBSERVACION_VALIDACION : ''
            this.resolution_summary = this.ticketInfo.RESUMEN_RESOLUCION ? this.ticketInfo.RESUMEN_RESOLUCION : ''

            //abrir modal
            $('#verTicket').modal('show')

        },
        cerrarModal() {
            $('#verTicket').modal('hide')
        },
        //accion validar ticket solo si el estado del ticket esta cerrado aparece el boton
        validarTicket(ticketId) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger',
                    denyButton: 'btn btn-warning'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: '¿Estás seguro?',
                text: "¿Desea validar el ticket?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, validar',
                cancelButtonText: 'Cancelar',
                denyButtonText: 'No, rechazar',
                showDenyButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    this.loading = true;
                    axios.post('/validateTicket/' + ticketId, {action: 'validate'})
                        .then((response) => {
                            swalWithBootstrapButtons.fire('¡Validado!', 'El ticket ha sido validado exitosamente.', 'success');
                            this.getTickets();
                        })
                        .catch((error) => {
                            // Manejar error
                        })
                        .finally(() => {
                            this.loading = false;
                        });
                } else if (result.isDenied) {
                    // Solicitar motivo de rechazo
                    Swal.fire({
                        title: 'Motivo del rechazo',
                        input: 'text',
                        inputPlaceholder: 'Ingrese el motivo del rechazo',
                        showCancelButton: true,
                        inputValidator: (value) => {
                            if (!value) {
                                return '¡Necesitas escribir un motivo!';
                            }
                        }
                    }).then((inputResult) => {
                        if (inputResult.value) {
                            // Aquí enviar el motivo del rechazo
                            axios.post('/validateTicket/' + ticketId, {action: 'reject', reason: inputResult.value})
                                .then((response) => {
                                    swalWithBootstrapButtons.fire('Rechazado', `El ticket ha sido rechazado. Motivo: ${inputResult.value}`, 'info');
                                    this.getTickets();
                                })
                                .catch((error) => {
                                    // Manejar error
                                    Swal.fire('Error', 'Ocurrió un error al rechazar el ticket', 'error');
                                });
                        }
                    });
                }
            });
        }


    }
}
</script>
<style scoped>
.slide-fade-enter-active, .slide-fade-leave-active {
    transition: all .3s ease;
}

.slide-fade-enter, .slide-fade-leave-to
    /* .slide-fade-leave-active below version 2.1.8 */
{
    transform: translateX(10px);
    opacity: 0;
}

.daterangepicker.show-calendar >>> .ranges {
    display: none !important;
}

</style>
