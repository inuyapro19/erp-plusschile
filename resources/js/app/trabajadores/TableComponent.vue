<template>
    <div>
        <CardComponent :title="'Trabajadores'">
            <template #header>
                <div class="row">
                    <div class="col-md-12">
                        <div class="btn-group mb-3">
                            <a href="/trabajadores/create" class="btn btn-primary btn-sm"><i
                                class="fa fa-plus-circle"></i> Agregar</a>
                            <a href="/export-trabajadores" download="lista_trabajadores-plusschile.xlsx" target="_blank"
                               class="btn btn-secondary btn-sm"><i class="fa fa-cloud-download-alt"></i> Descargar</a>
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
                <table class="table align-middle table-row-dashed fs-6 gy-5 mt-3" id="kt_customers_table">
                    <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th>
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1"/>
                            </div>
                        </th>
                        <th v-show="mostrar_codigo">
                            CÓDIGO
                            <a @click="cargarTablaTrabajadores('asc','CODIGO_TRABAJADOR')"><i
                                class="fa fa-caret-up"></i></a>
                            <a @click="cargarTablaTrabajadores('desc','CODIGO_TRABAJADOR')"><i
                                class="fa fa-caret-down"></i></a>
                        </th>
                        <th>
                            RUT
                            <a @click="cargarTablaTrabajadores('asc','RUT')"><i class="fa fa-caret-up"></i></a>
                            <a @click="cargarTablaTrabajadores('desc','RUT')"><i class="fa fa-caret-down"></i></a>
                        </th>
                        <th>
                            NOMBRE
                            <a @click="cargarTablaTrabajadores('asc','NOMBRE_COMPLETO')"><i class="fa fa-caret-up"></i></a>
                            <a @click="cargarTablaTrabajadores('desc','NOMBRE_COMPLETO')"><i
                                class="fa fa-caret-down"></i></a>
                        </th>
                        <th v-show="mostrar_cargo">
                            CARGO
                            <a @click="cargarTablaTrabajadores('asc','CARGO')"><i class="fa fa-caret-up"></i></a>
                            <a @click="cargarTablaTrabajadores('desc','CARGO')"><i class="fa fa-caret-down"></i></a>
                        </th>
                        <th v-show="mostrar_empleador">
                            EMPLEADOR
                            <a @click="cargarTablaTrabajadores('asc','EMPLEADOR')"><i class="fa fa-caret-up"></i></a>
                            <a @click="cargarTablaTrabajadores('desc','EMPLEADOR')"><i class="fa fa-caret-down"></i></a>
                        </th>
                        <th v-show="mostrar_ubicacion">
                            UBICACIÓN
                            <a @click="cargarTablaTrabajadores('asc','UBICACION')"><i class="fa fa-caret-up"></i></a>
                            <a @click="cargarTablaTrabajadores('desc','UBICACION')"><i class="fa fa-caret-down"></i></a>
                        </th>
                        <th v-show="mostrar_estado">
                            ESTADO
                            <a @click="cargarTablaTrabajadores('asc','ESTADO_TRABAJADOR')"><i
                                class="fa fa-caret-up"></i></a>
                            <a @click="cargarTablaTrabajadores('desc','ESTADO_TRABAJADOR')"><i
                                class="fa fa-caret-down"></i></a>
                        </th>
                        <th v-show="mostrar_condicion">
                            CONDICIÓN
                            <a @click="cargarTablaTrabajadores('asc','CONDICION_TRABAJADOR')"><i
                                class="fa fa-caret-up"></i></a>
                            <a @click="cargarTablaTrabajadores('desc','CONDICION_TRABAJADOR')"><i
                                class="fa fa-caret-down"></i></a>
                        </th>
                        <th>
                            ACCIONES
                            <div class="btn-group">
                                <button type="button" class="btn btn-success-outline btn-sm dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-arrow-alt-circle-down"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#"><input type="checkbox" v-model="mostrar_codigo"
                                                                             @click="!mostrar_codigo">Código</a>
                                    <a class="dropdown-item" href="#"><input type="checkbox" v-model="mostrar_cargo"
                                                                             @click="!mostrar_cargo"> Cargo</a>
                                    <a class="dropdown-item" href="#"><input type="checkbox" v-model="mostrar_empleador"
                                                                             @click="!mostrar_empleador"> Empleador</a>
                                    <a class="dropdown-item" href="#"><input type="checkbox" v-model="mostrar_ubicacion"
                                                                             @click="!mostrar_ubicacion"> Ubicacion</a>
                                    <a class="dropdown-item" href="#"><input type="checkbox" v-model="mostrar_estado"
                                                                             @click="!mostrar_estado"> Estado</a>
                                    <a class="dropdown-item" href="#"><input type="checkbox" v-model="mostrar_condicion"
                                                                             @click="!mostrar_condicion"> Condicion</a>
                                </div>
                            </div>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                    <transition name="slide-fade">
                        <tr v-show="filtrar">
                            <td></td>

                            <td colspan="3">

                                <select
                                    name="trabajador_id"
                                    class="form-select mb-2"
                                    id="trabajador_id"
                                    data-control="select2"
                                    data-placeholder="Seleccione trabajador"
                                    data-allow-clear="true"
                                    v-model="trabajador_id"
                                    @change.prevent="cargarTablaTrabajadores('desc','TRABAJADOR_ID')"
                                    ref="trabajadores">
                                    <option
                                        v-for="({id,rut,primer_nombre,segundo_nombre,primer_apellido, segundo_apellido}, index) in trabajadores_filtros"
                                        :value="id">
                                        {{
                                            rut + ' - ' + primer_nombre + ' ' + segundo_nombre + ' ' + primer_apellido + ' ' + segundo_apellido
                                        }}
                                    </option>
                                </select>
                            </td>

                            <td v-show="mostrar_cargo">
                                <select
                                    name="cargos"
                                    id="cargos"
                                    v-model="cargos_id"
                                    @change="cargarTablaTrabajadores('desc','TRABAJADOR_ID')"
                                    class="form-control form-control-sm"
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
                                        @change="cargarTablaTrabajadores('desc','TRABAJADOR_ID')" v-model="empleador_id"
                                        class="form-control form-control-sm">
                                    <option value="" selected>----Empresas----</option>
                                    <option v-for="({id,nombre_empleador}, index) in empleadores" :value="id">
                                        {{ nombre_empleador }}
                                    </option>
                                </select>
                            </td>
                            <td v-show="mostrar_ubicacion">
                                <select name="ubicaciones" id="ubicaciones" v-model="ubicacion_id"
                                        @change="cargarTablaTrabajadores('desc','TRABAJADOR_ID')"
                                        class="form-control form-control-sm">
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
                    <!-- <paginate name="trabajadores" :list="trabajadores" :per="perpage" tag="tbody">-->
                    <tr v-for="trabajador in trabajadores.data">
                        <td>
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1"/>
                            </div>
                        </td>
                        <td v-show="mostrar_codigo" class="remarcar">{{ trabajador.CODIGO_TRABAJADOR }}</td>
                        <td class="remarcar">{{ trabajador.RUT }}</td>
                        <td class="remarcar">{{ trabajador.NOMBRE_COMPLETO }}</td>
                        <td v-show="mostrar_cargo">
                            {{ trabajador.CARGO }}
                        </td>
                        <td v-show="mostrar_empleador">
                            {{ trabajador.EMPLEADOR }}
                        </td>
                        <td v-show="mostrar_ubicacion">{{ trabajador.UBICACION }}</td>
                        <td v-show="mostrar_estado"><span
                            class="badge badge-success">{{ trabajador.ESTADO_TRABAJADOR }}</span></td>
                        <td v-show="mostrar_condicion">
                            <!--- 'dias libre','vacaciones','falla','disponible','en ruta',' licencia médica','permiso especial'-->
                            <span v-if="trabajador.CONDICION_TRABAJADOR=='disponible'"
                                  class="badge badge-success">{{
                                    trabajador.CONDICION_TRABAJADOR.toString().toUpperCase()
                                }}</span>
                            <span v-if="trabajador.CONDICION_TRABAJADOR=='vacaciones'"
                                  class="badge badge-warning">{{
                                    trabajador.CONDICION_TRABAJADOR.toString().toUpperCase()
                                }}</span>
                            <span v-if="trabajador.CONDICION_TRABAJADOR=='en ruta'"
                                  class="badge badge-info">{{
                                    trabajador.CONDICION_TRABAJADOR.toString().toUpperCase()
                                }}</span>
                            <span v-if="trabajador.CONDICION_TRABAJADOR=='licencia médica'" class="badge badge-primary">{{
                                    trabajador.CONDICION_TRABAJADOR.toString().toUpperCase()
                                }}</span>
                            <span v-if="trabajador.CONDICION_TRABAJADOR=='dias libre'" class="badge link-badge-warning">{{
                                    trabajador.CONDICION_TRABAJADOR.toString().toUpperCase()
                                }}</span>
                        </td>
                        <td>

                            <div class='btn-group'>
                                <a :href="'/trabajadores/'+trabajador.TRABAJADOR_ID+'/edita_admin'"
                                   class='btn btn-info btn-sm' data-toggle="tooltip" data-placement="top"
                                   title="Editar"><i class="fa fa-edit"></i></a>
                                <a :href="'trabajadores/reset/'+trabajador.RUT" class='btn btn-warning btn-sm'
                                   data-toggle="tooltip" data-placement="top" title="reset password"><i
                                    class="fa fa-key"></i></a>
                                <a :href="'/generar-certificado-antiguidad/'+trabajador.TRABAJADOR_ID"
                                   class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                            </div>

                        </td>
                    </tr>
                    </tbody>
                    <!-- </paginate>-->
                </table>

                <div class="row">
                    <div class="col-md-1">
                        <select v-model="per_page" class="form-control form-control-sm"
                                @change.prevent="cantidadRegistros">
                            <option v-for="numero in numero_registros" :value="numero">{{ numero }}</option>
                        </select>
                    </div>

                    <div class="col-md-11">
                        <!--paginate -->
                        <paginate :pagination="trabajadores" :onPageChange="cargarTablaTrabajadores"></paginate>
                    </div>

                </div>
            </template>
        </CardComponent>
    </div>
</template>

<script>
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import CardComponent from "../../components/CardComponent.vue";
import Paginate from "../../components/paginate.vue";

export default {
    components: {
        CardComponent,
        Loading,
        Paginate
    },
    props: {
        filtros: {
            required: false,
            type: String
        }
    },
    data() {
        return {
            ubicaciones: [],
            cargos: [],
            areas: [],
            empleadores: [],
            rut: '',
            cargos_id: 0,
            empleador_id: 0,
            ubicacion_id: 0,
            fecha_ingreso_inicial: '',
            fecha_ingreso_final: '',
            trabajadores: [],
            filtrar: false,
            paginate: ['trabajadores'],
            perpage: 20,
            isLoading: false,
            fullPage: true,
            active: true,
            numero_registros: [10, 20, 50, 80, 100, 500, 1000],
            per_page: 10,
            page_class: 'page-item',
            seleccion_masiva_id: [],
            seleccionarTodos: false,
            trabajador_id: 0,
            trabajadores_filtros: [],
            url_filtro: '',
            filtro_xls: false,
            codigo_filtro: '',
            rut_filtro: '',
            nombre_completo_filtro: '',
            cargo_filtro: '',
            estado_filtro: '',
            condiciones: ['dias libre', 'vacaciones', 'falla', 'disponible', 'activo', 'en ruta', 'licencia médica', 'permiso especial'],
            condicione_select: '',
            mostrar_cargo: true,
            mostrar_empleador: true,
            mostrar_ubicacion: true,
            mostrar_estado: true,
            mostrar_condicion: false,
            mostrar_codigo: true,
            orderRegistro: 'asc',
            orderPor: 'TRABAJADOR_ID',
            estado_select: '',
            estados: ['disponible', 'dias libre', 'vacaciones', 'falla', 'en ruta', 'licencia médica', 'permiso especial'],
        }
    },
    mounted() {
        this.cargarTablaTrabajadores();
        this.cargarCargos()
        this.cargarUbicaciones()
        this.cargarEmpleador()
        this.getTrabajadoresFiltro()
    },
    updated() {
        // this.refrescar()
        $("#trabajador_id").on('select2:select', this.onSelectTraabajador);
    },
    methods: {
        refrescar: function () {
            $(this.$refs.trabajadores).selectpicker('refresh')
        },
        onSelectTraabajador: function (e) {
            this.trabajador_id = parseInt(e.params.data.id);
            //transformalo en int
            //  this.trabajador_id = parseInt(this.trabajador_id)
            this.cargarTablaTrabajadores()
        },
        async cargarTablaTrabajadores(orderRegistro = 'desc', orderPor = 'TRABAJADOR_ID', page = 1) {
            try {
                this.isLoading = true;

                const params = new URLSearchParams();
                params.append('opciones', 'listPage');
                params.append('perpage', this.per_page);
                params.append('order', orderRegistro);
                params.append('orderPor', orderPor);

                if (page > 0) {
                    params.append('page', page);
                }

                if (this.trabajador_id > 0) {
                    params.append('filtro[TRABAJADOR_ID]', this.trabajador_id);
                }

                if (this.cargos_id > 0) {
                    params.append('filtro[CARGO_ID]', this.cargos_id);
                }

                if (this.empleador_id > 0) {
                    params.append('filtro[EMPLEADOR_ID]', this.empleador_id);
                }

                if (this.ubicacion_id > 0) {
                    params.append('filtro[UBICACION_ID]', this.ubicacion_id);
                }

                if (this.estado_select !== '') {
                    params.append('filtro[CONDICION_TRABAJADOR]', this.estado_select);
                }

                let url = '/lista-trabajadores?' + params.toString();

                const {data, status} = await axios.get(url);

                if (status === 200) {
                    this.trabajadores = data;
                }

                this.isLoading = false;
            } catch (e) {
                console.log(e)
                this.isLoading = false;
            }
        },
        async getTrabajadoresFiltro() {
            try {

                let url = '/lista-trabajadores?opciones=all'

                const {data, status} = await axios.get(url)
                if (status === 200) {
                    this.trabajadores_filtros = data
                }

            } catch (error) {
                console.log(error)
            }
        },
        mostrarFiltrar: function () {
            this.filtrar = !this.filtrar
        },
        async cargarCargos() {
            try {

                const {data, status} = await axios.get('/cargos')

                if (status === 200) {
                    this.cargos = data
                }

            } catch (e) {
                console.log(e)
            }

        },
        async cargarEmpleador() {
            try {
                const {data, status} = await axios.get('/empleador')
                if (status === 200) {
                    this.empleadores = data
                }
            } catch (e) {
                console.log(e)
            }
        },
        async cargarUbicaciones() {
            try {
                const {data, status} = await axios.get('/ubicaciones')
                if (status === 200) {
                    this.ubicaciones = data
                }
            } catch (e) {
                console.log(e)
            }
        },

        getPaginate: function (page_number) {
            this.page = page_number
            this.page_class = 'page-item active'
            this.cargarTablaTrabajadores()
        },
        cantidadRegistros: function () {
            this.page = 1
            this.cargarTablaTrabajadores()
        }
    }

}

</script>

<style scoped>
/* Las animaciones de entrada y salida pueden usar */
/* funciones de espera y duración diferentes.      */
.slide-fade-enter-active {
    transition: all .3s ease;
}

.slide-fade-leave-active {
    transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}

.slide-fade-enter, .slide-fade-leave-to
    /* .slide-fade-leave-active below version 2.1.8 */
{
    transform: translateX(10px);
    opacity: 0;
}

.text-success {
    color: #8dbf42 !important;
    font-weight: bold !important;
}

.text-warning {
    font-weight: bolder !important;
}

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

.remarcar {
    font-weight: bolder !important;
    color: #222222 !important;
}

.bootstrap-select.btn-group .dropdown-toggle .filter-option {
    color: #222222 !important;
    font-size: 10px !important;
}

</style>
