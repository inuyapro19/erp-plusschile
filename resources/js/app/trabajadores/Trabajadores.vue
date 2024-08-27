<template>
    <div>
        <CardComponent :title="'Trabajadores'">
            <template #header>
                <div class="row">
                    <div class="col-md-12">
                        <div class="btn-group mb-3">
                            <a href="/trabajador-nuevo" class="btn btn-primary btn-sm"><i
                                class="fa fa-plus-circle"></i> Agregar</a>
                            <button @click="handleExport"
                               class="btn btn-secondary btn-sm"><i class="fa fa-cloud-download-alt"></i> Descargar</button>
                            <button type="button" class="btn btn-success btn-sm" @click="mostrarFiltrar"><i
                                class="fa fa-filter"></i> Filtrar
                            </button>
                        </div>
                    </div>
                </div>
            </template>
            <loading v-model:active="isLoading"
                     :can-cancel="true"
                     :is-full-page="fullPage"
                     :active="active"
            />
            <template #body>
                <DataTable
                    :columns="columns"
                    :items="trabajadores.data"
                    :isCheck="false"
                    :colores="colores"
                >
                    <template #filtros>
                        <transition name="slide-fade">
                            <tr v-show="filtrar">
                                <td></td>

                                <td colspan="2">

<!--                                    <select-2
                                        v-model="trabajador_id"
                                        dataType="number"
                                        @select-changed="cargarTablaTrabajadores()"
                                    >
                                        <option
                                            v-for="({id,rut,primer_nombre,segundo_nombre,primer_apellido, segundo_apellido}, index) in trabajadores_filtros"
                                            :value="id">
                                            {{
                                                rut + ' - ' + primer_nombre + ' ' + segundo_nombre + ' ' + primer_apellido + ' ' + segundo_apellido
                                            }}
                                        </option>
                                    </select-2>-->

                                    <v-select
                                        :options="formattedTrabajador"
                                        label="label"
                                        class="form-control form-control-solid"
                                        :reduce="trabajador => trabajador.id" v-model="trabajador_id"
                                        @input="cargarTablaTrabajadores()"
                                        style="padding:0px !important"
                                    ></v-select>

                                </td>

                                <td v-show="mostrar_cargo">
                                    <select
                                        name="cargos"
                                        id="cargos"
                                        v-model="cargos_id"
                                        @change="cargarTablaTrabajadores('desc','TRABAJADOR_ID')"
                                        class="form-select form-select"
                                    >
                                        <option value="" selected>----Cargos----</option>
                                        <option
                                            v-for="({id, nombre_cargo}, index) in cargos"
                                            :value="id">{{ nombre_cargo }}
                                        </option>
                                    </select>
                                </td>
                                <td v-show="mostrar_empleador">
                                    <select name="empresas" id="empresas"
                                            @change="cargarTablaTrabajadores('desc','TRABAJADOR_ID')"
                                            v-model="empleador_id" class="form-select form-select">
                                        <option value="" selected>----Empresas----</option>
                                        <option v-for="({id,nombre_empleador}, index) in empleadores" :value="id">
                                            {{ nombre_empleador }}
                                        </option>
                                    </select>
                                </td>
                                <td v-show="mostrar_ubicacion">
                                    <select name="ubicaciones" id="ubicaciones" v-model="ubicacion_id"
                                            @change="cargarTablaTrabajadores('desc','TRABAJADOR_ID')"
                                            class="form-select form-select">
                                        <option value="" selected>----Ubicaciones----</option>
                                        <option v-for="({id,nombre_ubicacion}, index) in ubicaciones" :value="id">
                                            {{ nombre_ubicacion }}
                                        </option>
                                    </select>
                                </td>
                                <td v-show="mostrar_estado"></td>
                                <td v-show="mostrar_condicion">
                                    <select class="form-control" v-model="estado_select"
                                            @change="cargarTablaTrabajadores('desc','TRABAJADOR_ID')">
                                        <option value="" selected>----Condicion----</option>
                                        <option v-for="estado in estados" :value="estado">{{ estado.toUpperCase() }}
                                        </option>
                                    </select>
                                </td>
                                <td></td>
                            </tr>

                        </transition>
                    </template>
                    <template #actions="{item}">
                        <div class='btn-group'>
                            <a :href="'/trabajador-editar/'+item.TRABAJADOR_ID"
                               class='btn btn-info btn-sm' data-toggle="tooltip" data-placement="top" title="Editar"><i
                                class="fa fa-edit"></i></a>
                            <button class="btn btn-danger btn-sm" @click="OpenDevinculadarTrabajadorModal(item.TRABAJADOR_ID)">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                            <a :href="'trabajadores/reset/'+item.RUT" class='btn btn-warning btn-sm'
                               data-toggle="tooltip" data-placement="top" title="reset password"><i
                                class="fa fa-key"></i></a>
                            <button @click="handleDownloaderPdf(item.TRABAJADOR_ID)"
                               class="btn btn-primary btn-sm"><i class="fa fa-file"></i></button>
                        </div>
                    </template>

                </DataTable>

                <!-- Rest of your template remains the same -->
                <div class="row">
                    <div class="col-md-1">
                        <select v-model="per_page" class="form-select form-select-solid-sm"
                                @change.prevent="cantidadRegistros">
                            <option v-for="numero in numero_registros" :value="numero">{{ numero }}</option>
                        </select>
                    </div>

                    <div class="col-md-11">
                        <paginate :pagination="trabajadores" :onPageChange="cargarTablaTrabajadores"></paginate>
                    </div>

                </div>

            </template>
        </CardComponent>
        <bootstrap-modal
            :id="'devicularTrabajador'"
            :title="'Desvincular Trabajador'"
            :customClass="'modal-dialog-centered mw-650px'"
            :hideCloseButton="false"
            :onCloseButton="cerrarDevinculadarTrabajadorModal"
        >
            <template #body>
                <form @submit.prevent="onSubmit">
                    <div class="col-md-6 mb-2">
                        <label class="fs-6 fw-semibold mb-2">Fecha de desvinculación</label>
                        <input
                            class="form-control form-control-solid"
                            type="date"
                           v-model='fecha_desvinculacion'
                        />
                        <input type="hidden" v-model='trabajador_id_desvincular'/>
                    </div>
                    <div class="col-md-8 mb-2">
                        <label class="fs-6 fw-semibold mb-2">Causal de Hecho</label>
                        <textarea
                            class="form-control form-control-solid"
                           v-model='causal_hecho'
                        ></textarea>

                    </div>
                    <div class="col-md-8 mb-2">
                        <label class="fs-6 fw-semibold mb-2">Motivo Interno Empresa</label>
                        <textarea
                            class="form-control form-control-solid"

                           v-model='motivo_interno_empresa'
                        ></textarea>
                    </div>

                    <div class="col-md-8 mb-2">
                        <label class="fs-6 fw-semibold mb-2">Motivo</label>
                        <select
                            class="form-select form-select-solid"
                           v-model='motivo_id'
                        >
                        <option value="">---Seleccione---</option>
                        <option v-for="movimiento in movimientos" :value="movimiento.id">{{movimiento.codigo}}-{{movimiento.descripcion}}</option>


                        </select>
                    </div>

                    <div class="col-md-8 mb-2 mt-5">
                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash-alt"></i> Desvincular</button>
                    </div>
                </form>

            </template>

        </bootstrap-modal>
    </div>
</template>

<script>
import {ref, reactive, computed, onMounted, onUpdated} from 'vue';
import CardComponent from "@/components/CardComponent.vue";
import DataTable from "@/components/DataTable.vue";
import Select2 from "@/components/Form/Select2.vue";
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import paginate from '@/components/paginate.vue';
import {cargarCargos, cargarEmpleador, cargarUbicaciones} from "@/helpers/Global";
import BootstrapModal from "@/components/modalComponent.vue";

export default {
    components: {
        BootstrapModal,
        Select2,
        CardComponent,
        DataTable,
        Loading,
        paginate
    },
    props: {
        filtros: {
            required: false,
            type: String
        }
    },
    computed: {
        formattedTrabajador() {
            return this.trabajadores_filtros.map(trabajador => ({
                id: trabajador.id,
                label: trabajador.rut + ' - ' + trabajador.primer_nombre + ' ' + trabajador.segundo_nombre + ' ' + trabajador.primer_apellido + ' ' + trabajador.segundo_apellido
            }));
        }
    },
    setup(props) {
        const isLoading = ref(false);
        const fullPage = ref(true);
        const active = ref(true);
        const per_page = ref(10);
        const trabajadores = ref([]);
        const trabajadores_filtros = ref([]);
        const url_filtro = ref('');
        const filtro_xls = ref(false);
        const mostrar_cargo = ref(true);
        const mostrar_empleador = ref(true);
        const mostrar_ubicacion = ref(true);
        const mostrar_estado = ref(true);
        const mostrar_condicion = ref(false);
        const mostrar_codigo = ref(true);
        const orderRegistro = ref('asc');
        const orderPor = ref('TRABAJADOR_ID');
        const estado_select = ref('');
        const estados = ref(['disponible', 'dias libre', 'vacaciones', 'falla', 'en ruta', 'licencia médica', 'permiso especial']);
        const numero_registros = ref([10, 25, 50, 100, 200, 500, 1000]);
        const cargos = ref([]);
        const cargos_id = ref(0);
        const empleador_id = ref(0);
        const ubicacion_id = ref(0);
        const trabajador_id = ref(0);
        const trabajador_id_desvincular = ref(0);
        const empleadores = ref([]);
        const ubicaciones = ref([]);
        const filtrar = ref(false);
        const order = ref('asc');
        const orderBy = ref('TRABAJADOR_ID');
        // Define your columns for DataTable
        const columns = ref([
            {key: 'CODIGO_TRABAJADOR', label: 'Código'},
            {key: 'RUT', label: 'RUT'},
            {key: 'NOMBRE_COMPLETO', label: 'Nombre'},
            {key: 'CARGO', label: 'Cargo'},
            {key: 'EMPLEADOR', label: 'Empleador'},
            {key: 'UBICACION', label: 'Ubicación'},
            {key: 'ESTADO_TRABAJADOR', label: 'Estado', badge: true},
            {key: 'CONDICION_TRABAJADOR', label: 'Condición', badge: true},
        ]);

        const colores = ref([
            {status: 'disponible', label: '', color: 'success'},
            {status: 'dias libre', label: '', color: 'info'},
            {status: 'vacaciones', label: '', color: 'warning'},
            {status: 'falla', label: '', color: 'danger'},
            {status: 'en ruta', label: '', color: 'primary'},
            {status: 'licencia médica', label: '', color: 'secondary'},
            {status: 'permiso especial', label: '', color: 'dark'},
            {status: 'contratado', label: 'Contratado', color: 'light-success'},
        ]);

        const fecha_desvinculacion = ref('');
        const causal_hecho = ref('');
        const motivo_interno_empresa = ref('');
        const motivo_id = ref('');
        const movimientos = ref([]);



        const cargarTablaTrabajadores = async ( page = 1) => {
            try {
                isLoading.value = true;

                const params = new URLSearchParams();
                params.append('opciones', 'listPage');
                params.append('perpage', per_page.value);
                params.append('order', order.value);
                params.append('orderPor', orderBy.value);

                if (page > 0) {
                    params.append('page', page);
                }

                if (trabajador_id.value > 0) {
                    params.append('filtro[TRABAJADOR_ID]', trabajador_id.value);
                }

                if (cargos_id.value > 0) {
                    params.append('filtro[CARGO_ID]', cargos_id.value);
                }

                if (empleador_id.value > 0) {
                    params.append('filtro[EMPLEADOR_ID]', empleador_id.value);
                }

                if (ubicacion_id.value > 0) {
                    params.append('filtro[UBICACION_ID]', ubicacion_id.value);
                }

                if (estado_select.value !== '') {
                    params.append('filtro[CONDICION_TRABAJADOR]', estado_select.value);
                }

                let url = '/lista-trabajadores?' + params.toString();

                const {data, status} = await axios.get(url);

                if (status === 200) {
                    trabajadores.value = data;
                }

                isLoading.value = false;
            } catch (e) {
                console.log(e)
                isLoading.value = false;
            }
        };

        const getTrabajadoresFiltro = async () => {
            try {

                let url = '/lista-trabajadores?opciones=all'

                const {data, status} = await axios.get(url)
                if (status === 200) {
                    trabajadores_filtros.value = data
                }

            } catch (error) {
                console.log(error)
            }
        };

        const mostrarFiltrar = () => {
            filtrar.value = !filtrar.value
        };

        const getPaginate = (page_number) => {
            page.value = page_number
            //page_class.value = 'page-item active'
            cargarTablaTrabajadores()
        };

        const cantidadRegistros = () => {
            page.value = 1
            cargarTablaTrabajadores()
        };

        const handleExport = async () => {
            try {
                const response = await axios({
                    url: '/export-trabajadores',
                    method: 'GET',
                    responseType: 'blob', // Important
                });
                //console.log(response.data)
                let date = Date.now()
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;

                link.setAttribute('download', date+'.xlsx'); //or any other extension
                document.body.appendChild(link);
                link.click();
            } catch (error) {
                console.error("Error downloading the file.");
            }
        };

        //descargar pdf
        const handleDownloaderPdf = async (id) => {
            try {
                const response = await axios({
                    url: '/generar-certificado-antiguidad/'+id,
                    method: 'GET',
                    responseType: 'blob', // Important
                });
                //console.log(response.data)
                let date = Date.now()
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;

                link.setAttribute('download', date+'.pdf'); //or any other extension
                document.body.appendChild(link);
                link.click();
            } catch (error) {
                console.error("Error downloading the file.");
            }
        };

        //motivos
        const getMotivos = async () => {
            try {
                const {data, status} = await axios.get('/motivos');
                if (status === 200) {
                    movimientos.value = data;
                }
            } catch (e) {
                console.log(e)
            }
        };

        const OpenDevinculadarTrabajadorModal = (id) => {
            trabajador_id_desvincular.value = id;
            $("#devicularTrabajador").modal("show");
        };
        const  cerrarDevinculadarTrabajadorModal = () => {
            $("#devicularTrabajador").modal("hide");
        };
        onMounted(async () => {
            await cargarTablaTrabajadores();
            await getMotivos();
            cargos.value = await cargarCargos();
            ubicaciones.value = await cargarUbicaciones();
            empleadores.value = await cargarEmpleador();
            await getTrabajadoresFiltro();
        });

        const onSubmit = async () => {
            //validar campos
            if (fecha_desvinculacion.value === '') {
                Swal.fire({
                    title: '¡Error!',
                    text: 'La fecha de desvinculación es requerida.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }
            if (causal_hecho.value === '') {
                Swal.fire({
                    title: '¡Error!',
                    text: 'La causal de hecho es requerida.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }
            if (motivo_interno_empresa.value === '') {
                Swal.fire({
                    title: '¡Error!',
                    text: 'El motivo interno de la empresa es requerido.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }

            if (motivo_id.value === '') {
                Swal.fire({
                    title: '¡Error!',
                    text: 'El motivo es requerido.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }

            try {
                // Paso 1: Swal de confirmación
                const result = await Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¿Quieres desvincular a este trabajador?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, desvincular',
                    cancelButtonText: 'Cancelar'
                });

                if (result.isConfirmed) {
                    // Paso 2: Swal de carga
                    Swal.fire({
                        title: 'Desvinculando...',
                        html: 'Por favor, espera...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                    });

                    isLoading.value = true;
                    const data = {
                        fecha_desvinculacion: fecha_desvinculacion.value,
                        causal_hecho: causal_hecho.value,
                        motivo_interno_empresa: motivo_interno_empresa.value,
                        motivo_id: motivo_id.value,
                        // trabajador_id se obtiene de trabajador_id_desvincular
                    };
                    const id = trabajador_id_desvincular.value;
                    const {status} = await axios.post('/unlinkTrabajador/' + id, data);

                    if (status === 200) {
                        await cargarTablaTrabajadores();
                        cerrarDevinculadarTrabajadorModal();

                        // Paso 3: Swal de éxito
                        Swal.fire({
                            title: '¡Desvinculado!',
                            text: 'El trabajador ha sido desvinculado exitosamente.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    }
                    isLoading.value = false;
                }
            } catch (e) {
                console.log(e);
                isLoading.value = false;
                // Opcional: Swal de error
                Swal.fire({
                    title: '¡Error!',
                    text: 'Ocurrió un error durante el proceso de desvinculación.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        };



        return {
            isLoading,
            fullPage,
            active,
            per_page,
            trabajadores,
            trabajadores_filtros,
            url_filtro,
            filtro_xls,
            mostrar_cargo,
            mostrar_empleador,
            mostrar_ubicacion,
            mostrar_estado,
            mostrar_condicion,
            mostrar_codigo,
            orderRegistro,
            orderPor,
            estado_select,
            estados,
            columns,
            numero_registros,
            cargos,
            cargos_id,
            empleador_id,
            ubicacion_id,
            trabajador_id,
            empleadores,
            ubicaciones,
            filtrar,
            colores,
            order,
            orderBy,
            cargarTablaTrabajadores,
            getTrabajadoresFiltro,
            mostrarFiltrar,
            cargarCargos,
            cargarEmpleador,
            cargarUbicaciones,
            getPaginate,
            cantidadRegistros,
            handleExport,
            cerrarDevinculadarTrabajadorModal,
            OpenDevinculadarTrabajadorModal,
            onSubmit,
            handleDownloaderPdf,
            fecha_desvinculacion,
            causal_hecho,
            motivo_interno_empresa,
            motivo_id,
            movimientos,
            trabajador_id_desvincular
        };
    },
};
</script>

<style scoped>
/* Your styles remain the same */
</style>
