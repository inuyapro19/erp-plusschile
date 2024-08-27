<template>
    <div>
        <CardComponent :title="'Certificados'">
            <template #header>
                <div class="row">
                    <div class="col-md-12">
                        <div class="btn-group mb-3">
                            <a href="/certificado-buses-create" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i>
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
                    :items="certificados.data"
                    :colores="colores"
                    :ischeck="false"
                    :loading="loading"
                >
                    <template #filtros>
                        <tr v-show="filtro">
                            <td colspan="2">
                                <select-2
                                    v-model="filtroporBus"
                                    dataType="number"
                                    @select-changed="getCertificados()"
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
                                    name="tipo_certificado"
                                    v-model="tipo_certificado"
                                    dataType="number"
                                    @select-changed="getCertificados()">
                                    <option v-for="certificado in certificados" :value="certificado.id">
                                        {{ certificado.tipo_certificado }}
                                    </option>
                                </select-2>
                            </td>
                            <td>
                                <select class="form-control" v-model="estado" @change="getCertificados()">
                                    <option value="">-------------------</option>
                                    <option value="VALIDO">VALIDO</option>
                                    <option value="VENCIDO">VENCIDO</option>
                                </select>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-success btn-sm" @click.prevent="resetCertificado()"><i
                                        class="fa fa-search"></i> Reset
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                    <template #actions="{ item }">
                        <div class="btn-group">
                            <a :href="'/certificados/create/'+item.id" class="btn btn-primary btn-sm"><i
                                class="fa fa-edit"></i></a>
                            <button type="button" class="btn btn-sm btn-warning" @click="cambio_estado(item.id)"><i
                                class="fa fa-pencil"></i></button>
                        </div>
                    </template>
                </data-table>
                <!--paginate -->
                <paginate :pagination="certificados" :onPageChange="getCertificados"></paginate>
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
                            <option v-for="certificado in certificados" :value="certificado.estado">{{ certificado.estado }}</option>
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
const colores = []
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
            certificados: [],
            patente: '',
            numero_bus: '',
            filtros: '',
            tipo_certificado: 0,
            estado: '',
            page: 0,
            page_class: 'page-item active',
            filtro: false,
            buses_all: [],
            filtroporBus: 0,
            id: 0,
            columns: [
                {key: 'numero_bus', label: 'Nº Bus', sortable: true},
                {key: 'patente', label: 'Patente', sortable: true},
                {key: 'tipo_certificado', label: 'Tipo Certificado', sortable: true},
                {key: 'fecha_emision', label: 'Fecha Emisión', sortable: true},
                {key: 'fecha_vencimiento', label: 'Fecha Vencimiento', sortable: true},
                {key: 'adjunto', label: 'Adjunto', sortable: true},
                {key: 'estado', label: 'Estado', badge: true, sortable: true},
            ],
            loading: false,
            colores:colores
        }
    },
    mounted() {
        this.getBusesAll()
        this.getCertificados()
    },
    methods: {
        async getBusesAll() {
            try {
                let url = '/getBusesLista?operador=lista'
                const {data, status} = await axios.get(url)
                if (status === 200) {
                    this.buses_all = data
                }
            } catch (e) {
                console.log(e)
            }
        },
        async getCertificados(page = 1) {
            this.loading = false;
            const minLoadingTime = 1000; // 2 segundos
            const startTime = new Date().getTime();

            let url = '/getCertificados?operador=get';
            let filters = {};

            if (this.tipo_certificado > 0) {
                filters['filtro[tipo_certificado]'] = this.tipo_certificado;
            }

            if (this.estado != '') {
                filters['filtro[estado]'] = this.estado;
            }

            if (this.filtroporBus > 0) {
                filters['filtro[id]'] = this.filtroporBus;
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

                setTimeout(() => {
                    this.certificados = res.data;
                    this.loading = false;
                }, remainingTime);
            }).catch(error => {
                console.error(error);
                this.loading = false;
            })
        },
        cerrarModal() {
            this.id = 0;
            this.estado = 'VALIDO';
            $('#estadosModal').modal('hide')
        },
        cambio_estado: function (id) {
            let certificado = this.certificados.find((item) => item.id === id);
            this.estado = certificado.estado
            this.id = id
            $('#estadosModal').modal('show')
        },
        async update_cambio_estado() {
            try {
                let formData = new FormData();
                formData.append('estado', this.estado)

                const {data, status} = await axios.post('/cambiar_estado-certificados/' + this.id, formData)

                if (status === 200) {
                    this.$swal({
                        title: 'CAMBIO DE ESTADO A' + this.estado,
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    })

                    this.estado = ''

                    this.getCertificados()

                    $('#estadosModal').modal('hide')
                }
            } catch (error) {
                console.log(error)
                this.$swal('error al cambiar el estado');
            }
        },
        resetCertificado() {
            this.filtroporBus = 0
            this.tipo_certificado = 0
            this.estado = ''

            this.getCertificados()
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
