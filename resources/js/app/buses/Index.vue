<template>
    <div>
        <CardComponent :title="'Buses'">
            <template #header>
                <div class="row">
                    <div class="col-md-12">
                        <div class="btn-group mb-3">
                            <a href="/buses/create" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i>
                                Agregar</a>
                            <button class="btn btn-success btn-sm" @click="filtro = !filtro"><i
                                class="fa fa-filter"></i> Filtro
                            </button>
                        </div>
                    </div>
                </div>
            </template>
            <template #body v-show="loading">

                <data-table
                    :columns="columns"
                    :items="buses.data"
                    :colores="colores"
                    :ischeck="false"
                    :loading="loading"
                    @sort-order="handleSortOrder"
                >
                    <template #filtros>
                        <tr v-show="filtro">
                            <td colspan="2">
                                <select-2
                                    v-model="filtroporBus"
                                    dataType="number"
                                    @select-changed="getBuses()"
                                >
                                    <option
                                        v-for="(bus, index) in buses_all"
                                        :key="bus.id"
                                        :value="bus.id">
                                        {{ bus.numero_bus + ' - ' + bus.patente }}
                                    </option>
                                </select-2>
                            </td>

                            <td>
                                <select-2
                                    name="empleador_id"
                                    v-model="empleador_id"
                                    dataType="number"
                                    @select-changed="getBuses()">
                                    <option v-for="propietario in empleadores" :value="propietario.id">
                                        {{ propietario.nombre_empleador }}
                                    </option>
                                </select-2>
                            </td>
                            <td>
                                <select v-model="tipo_servicio" @change.prevent="getBuses()" id="tipo_servicio"
                                        class="form-select form-select-solid">
                                    <option value="">-------------</option>
                                    <option value="comercial">Comercial</option>
                                    <option value="minero">Minero</option>
                                </select>
                            </td>
                            <td>
                                <select name="tipo_bus" v-model="tipo_bus" @change.prevent="getBuses()"
                                        id="empleador_id" class="form-select  form-select-solid">
                                    <option value="">-----</option>
                                    <option v-for="(tipo_bus, index) in tipos_buses" :value="tipo_bus">{{ tipo_bus }}
                                    </option>
                                </select>
                            </td>
                            <td>


                            </td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-success btn-sm" @click.prevent="resetFiltroBus()"><i
                                        class="fa fa-search"></i> Reset
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                    <template #actions="{ item }">
                        <div class="btn-group">
                            <a :href="'/buses/create/'+item.id" class="btn btn-primary btn-sm"><i
                                class="fa fa-edit"></i></a>
                            <button type="button" class="btn btn-sm btn-warning" @click="cambio_estado(item.id)"><i
                                class="fa fa-pencil"></i></button>
                        </div>
                    </template>
                </data-table>
                <!--paginate -->
                <paginate :pagination="buses" :onPageChange="getBuses"></paginate>
            </template>


            <!-- Modal Cambios de estado -->


        </CardComponent>
        <bootstrap-modal
            :id="'estadosModal'"
            :title="'Cambio de estado'"
            :customClass="'modal-dialog-centered mw-650px'"
            :hideCloseButton="false"
            :onCloseButton="cerrarModal"
        >
            <template #body>
                <!-- Contenido del cuerpo del modal -->
                <div class="row">
                    <div class="col-md-12 form-group">

                        <label class="fs-6 fw-semibold" for="estado">Estado</label>
                        <select
                            type="text"
                            v-model="estado"
                            id="estado"
                            class="form-select form-select-solid">
                            <option value="">-------</option>
                            <option v-for="buses in estados_buses" :value="buses">{{ buses }}</option>
                        </select>
                    </div>

                </div>
            </template>
            <template #footer>
                <!-- Contenido del pie de página del modal -->
                <button
                    type="button"
                    class="btn btn-primary btn-sm"
                    @click.prevent="update_cambio_estado()"
                >
                    Guardar
                </button>

            </template>
        </bootstrap-modal>
    </div>


</template>

<script>

import paginate from "@/components/paginate.vue";
import BootstrapModal from '@/components/modalComponent.vue';
import DataTable from "@/components/DataTable.vue";
import Select2 from "@/components/Form/Select2.vue";
import CardComponent from "@/components/CardComponent.vue";

const colores = [
    {status: 'Avería en la vía', label: 'Avería en la vía', color: 'info'},
    {status: 'Bus operativo', label: 'Bus operativo', color: 'success'},
    {status: 'Nombre_causas', label: 'Nombre_causas', color: 'warning'},
    {status: 'Mantención preventiva', label: 'Mantención preventiva', color: 'info'},
    {status: 'Sustitución de otro bus', label: 'Sustitución de otro bus', color: 'primary'},
    {status: 'Viaje Especial', label: 'Viaje Especial', color: 'secondary'},
    {status: 'en ruta', label: 'en ruta', color: 'info'},
    {status: 'Dado de baja', label: 'Dado de baja', color: 'danger'},
    {status: 'comercial', label: 'Comercial', color: 'light-danger'},
    {status: 'minero', label: 'Minero', color: 'light-success'}
];
export default {
    components: {
        CardComponent,
        paginate,
        BootstrapModal,
        DataTable,
        Select2
    },
    data() {
        return {
            buses: [],
            patente: '',
            numero_bus: '',
            filtros: '',
            empleador_id: 0,
            tipo_servicio: '',
            tipo_bus: '',
            nro_bus: '',
            tipos_buses: [
                'Premium', 'Mixto', 'Cama', 'Semi Cama'
            ],
            empleadores: [],
            page: 0,
            page_class: 'page-item active',
            filtro: false,
            buses_all: [],
            filtroporBus: 0,
            id: 0,
            estado: 'Bus operativo',
            estados_buses: [
                'Avería en la vía',
                'Bus operativo',
                'Nombre_causas',
                'Mantención preventiva',
                'Sustitución de otro bus',
                'Viaje Especial',
                'en ruta',
                'Dado de baja'
            ],
            columns: [
                {key: 'numero_bus', label: 'Nº Bus', sortable: true},
                {key: 'patente', label: 'Patente', sortable: true},
                {key: 'empleador.nombre_empleador', label: 'Propietario', sortable: true},
                {key: 'anyo_bus', label: 'Año', sortable: true},
                {key: 'tipo_servicio', label: 'Tipo de servicio', badge: true, sortable: true},
                {key: 'estado', label: 'Estado', badge: true, sortable: true},
            ],
            colores: colores,
            loading: false,
            orderDirection: 'asc',
            orderBy: 'id',

        }
    },
    mounted() {
        this.cargarEmpleador()
        this.getBusesAll()
        this.getBuses()
    },
    //obeservar cambios en las variables buses
    watch: {
        buses() {
            this.loading = true;
        }
    },
    methods: {
        async cargarEmpleador() {
            await axios.get('/empleador').then(res => {
                this.empleadores = res.data
            })
        },
        async getBusesAll() {
            try {
                let url = '/getBusesLista?operador=lista'

                /* if (this.empleador_id !== 0){
                     url = url + '&filtro[empleador_id]='+this.empleador_id
                 }*/

                const {data, status} = await axios.get(url)
                if (status === 200) {
                    this.buses_all = data
                    console.log(this.buses)
                }

            } catch (e) {
                console.log(e)
            }
        },
        async getBuses(page = 1) {
            this.loading = false;

            // Establece el tiempo mínimo que mostrará el mensaje "Cargando..."
            const minLoadingTime = 1000; // 2 segundos
            const startTime = new Date().getTime();

            let url = '/getBuses?operador=get';
            let filters = {};

            if (this.empleador_id > 0) {
                filters['filtro[empleador_id]'] = this.empleador_id;
            }

            if (this.tipo_bus != '') {
                filters['filtro[tipo_bus]'] = this.tipo_bus;
            }

            if (this.tipo_servicio != '') {
                filters['filtro[tipo_servicio]'] = this.tipo_servicio;
            }

            if (this.filtroporBus > 0) {
                filters['filtro[id]'] = this.filtroporBus;
            }

            if (this.numero_bus != '') {
                filters['filtro_like[numero_bus]'] = this.numero_bus;
            }

            if (this.patente != '') {
                filters['filtro_like[patente]'] = this.patente;
            }

            for (let key in filters) {
                url += `&${key}=${filters[key]}`;
            }

            if (page > 0) {
                url = url + '&page=' + page
            }

            await axios.get(url).then((res) => {
                const elapsedTime = new Date().getTime() - startTime;
                const remainingTime = Math.max(0, minLoadingTime - elapsedTime);

                // Establece un temporizador para actualizar los datos y ocultar el mensaje "Cargando..."
                setTimeout(() => {
                    this.buses = res.data;
                    this.loading = false;
                }, remainingTime);
            }).catch(error => {
                console.error(error);
                this.loading = false;
            })
        },
        async elminar_bus(id) {
            //sweet alert de tipo confirm
            await axios.delete('/buses/' + id).then((res) => {
                this.getBuses()
                alert('Bus Eliminado Exitosamente')
            }).catch((error) => {
                alert('error al eliminar');
            })
        },
        handleSortOrder(sortDetails) {
            console.log(sortDetails); // { orderBy: 'nombreColumna', order: 'asc' o 'desc' }
            // Aquí podrías hacer una llamada a la API usando estos detalles para obtener los datos ordenados
        },
        cerrarModal() {
            this.id = 0;
            this.estado = 'Bus operativo';
            $('#estadosModal').modal('hide')
        },
        cambio_estado: function (id) {
            // alert(id)
            let buses = this.buses_all.find((item) => item.id === id);
            this.estado = buses.estado
            this.id = id
            console.log(this.id)
            $('#estadosModal').modal('show')
        },
        async update_cambio_estado() {
            try {
                let formData = new FormData();
                // formData.append('id', this.id)
                formData.append('estado', this.estado)
                //SOLO SI EL ESTADO ES SUSPENDIDO


                const {data, status} = await axios.post('/cambiar_estado-buses/' + this.id, formData)

                if (status === 200) {
                    this.$swal({
                        title: 'CAMBIO DE ESTADO A' + this.estado,
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    })

                    this.estado = ''

                    this.getBuses()

                    $('#estadosModal').modal('hide')
                }
            } catch (error) {
                console.log(error)
                this.$swal('error al cambiar el estado');
            }
        },
        resetFiltroBus() {
            this.filtroporBus = 0
            this.empleador_id = 0
            this.tipo_bus = ''
            this.tipo_servicio = ''

            this.getBuses()
        },

    }
}
</script>

<style scoped>
th {
    font-weight: bolder !important;
    color: #fff !important;
}

th a:hover {
    cursor: pointer;
    color: #222222 !important;
}

thead tr th {
    background-color: #D3B560;
    color: white;
}
</style>
