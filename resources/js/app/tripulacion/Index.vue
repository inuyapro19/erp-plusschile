<template>
    <div>

        <CardComponent>
            <template #header>
                <div class="row">
                    <div class="col-md-12">
                        <div class="btn-group mb-2">
                            <button type="button" class="btn btn-sm btn-success" @click="filtrar = !filtrar"><i class="fa fa-filter"></i> Filtrar</button>
                            <button type="button" class="btn btn-sm btn-warning" @click="abrirModalReporte"><i class="fa fa-print"></i> Reporte </button>
                        </div>
                    </div>
                </div>

            </template>
            <template #body>
                <loading v-model:active="isLoading"
                         :can-cancel="true"
                         :is-full-page="fullPage"
                         :active="active"
                />
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>RUT</th>
                        <th>NOMBRE</th>
                        <th>TELÉFONO</th>
                        <th>DIRECCIÓN</th>
                        <th>FECHA INGRESO</th>
                        <th v-show="mostrar_cargo">CARGO</th>
                        <th v-show="mostrar_empleador">EMPLEADOR</th>
                        <th v-show="mostrar_estado">CONDICION</th>
                        <th v-show="esVacaciones">Fecha Regreso Vacaciones</th>
                        <th v-show="esLicencia">Fecha Regreso licencia Med.</th>
                        <th v-show="mostrar_condicion">UBICACIÓN ACTUAL</th>
                        <th>
                            ACCIONES
                            <div class="m-0">
                                <!--begin::Menu toggle-->
                                <a href="#" class="btn btn-sm btn-flex bg-body btn-color-gray-700 btn-active-color-primary fw-bold" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
                                    <span class="svg-icon svg-icon-6 svg-icon-muted me-1">
												<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="currentColor" />
												</svg>
											</span>
                                    <!--end::Svg Icon--></a>
                                <!--end::Menu toggle-->
                                <!--begin::Menu 1-->
                                <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_637dc76daeb86">
                                    <!--begin::Header-->
                                    <div class="px-7 py-5">
                                        <div class="fs-5 text-dark fw-bold">Opciones</div>
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Menu separator-->
                                    <div class="separator border-gray-200"></div>
                                    <!--end::Menu separator-->
                                    <!--begin::Form-->
                                    <div class="px-7 py-5">

                                        <!--end::Input group-->
                                        <!--begin::Input group-->
                                        <div class="mb-10">
                                            <!--begin::Label-->
                                            <label class="form-label fw-semibold">Cargo:</label>
                                            <!--end::Label-->
                                            <!--begin::Switch-->
                                            <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox"  v-model="mostrar_cargo" @click="!mostrar_cargo"  />
                                                <label class="form-check-label">Activar</label>
                                            </div>

                                            <!--end::Switch-->
                                        </div>
                                        <div class="mb-10">
                                            <!--begin::Label-->
                                            <label class="form-label fw-semibold">Empleador:</label>
                                            <!--end::Label-->
                                            <!--begin::Switch-->
                                            <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" v-model="mostrar_empleador" @click="!mostrar_empleador"  />
                                                <label class="form-check-label">Activar</label>
                                            </div>
                                        </div>
                                        <div class="mb-10">
                                            <!--begin::Label-->
                                            <label class="form-label fw-semibold">Ubicacion:</label>
                                            <!--end::Label-->
                                            <!--begin::Switch-->
                                            <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" v-model="mostrar_ubicacion" @click="!mostrar_ubicacion"  />
                                                <label class="form-check-label">Activar</label>
                                            </div>
                                        </div>

                                        <div class="mb-10">
                                            <!--begin::Label-->
                                            <label class="form-label fw-semibold">Estado:</label>
                                            <!--end::Label-->
                                            <!--begin::Switch-->
                                            <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" v-model="mostrar_estado" @click="!mostrar_estado"  />
                                                <label class="form-check-label">Activar</label>
                                            </div>
                                        </div>

                                        <div class="mb-10">
                                            <!--begin::Label-->
                                            <label class="form-label fw-semibold">Ubicacion actual:</label>
                                            <!--end::Label-->
                                            <!--begin::Switch-->
                                            <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" v-model="mostrar_condicion" @click="!mostrar_condicion"  />
                                                <label class="form-check-label">Activar</label>
                                            </div>
                                        </div>

                                    </div>
                                    <!--end::Form-->
                                </div>
                                <!--end::Menu 1-->
                            </div>

                        </th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-show="filtrar">
                            <td colspan="3">
                                <!--<input type="text" class="form-control form-control-sm" v-model="rut" @keypress.enter="cargarTablaTrabajadores" name="rut" placeholder="Buscar por rut">-->
    <!--                            <select name="trabajador_id"  class="form-select mb-2" data-control="select2" data-placeholder="Seleccione trabajador" data-allow-clear="true"  id="trabajador_id">
                                    <option value="">&#45;&#45;&#45;&#45;&#45;&#45;&#45;&#45;</option>
                                    <option v-for="({TRABAJADOR_ID,RUT,NOMBRE_COMPLETO}, index) in trabajadores_filtros"  :value="TRABAJADOR_ID">{{RUT+' - '+NOMBRE_COMPLETO}}</option>
                                </select>-->
                                <select-2
                                    v-model="trabajador_id"
                                    dataType="number"
                                    @select-changed="cargarTablaTrabajadores()"
                                >
                                    <option v-for="({TRABAJADOR_ID,RUT,NOMBRE_COMPLETO}, index) in trabajadores_filtros"  :value="TRABAJADOR_ID">{{RUT+' - '+NOMBRE_COMPLETO}}</option>

                                </select-2>
                            </td>
                            <td></td>
                            <td></td>
                            <td v-show="mostrar_cargo">
                                <select name="cargo_id" class="form-control form-control-sm" v-model="cargo_id"  @change="cargarTablaTrabajadores()" >
                                    <option value="">--------</option>
                                    <option v-for="({id,nombre_cargo}, index) in cargos"  :value="id">{{nombre_cargo}}</option>
                                </select>
                            </td>
                            <td v-show="mostrar_empleador">

                                <select-2
                                    name="empleador_id"
                                    v-model="empleador_id"
                                    dataType="number"
                                    @select-changed="cargarTablaTrabajadores()">
                                    <option v-for="propietario in empleadores" :value="propietario.id">{{propietario.nombre_empleador}}</option>
                                </select-2>

                            </td>
                            <td v-show="mostrar_estado">
                                <select name="empresas" id="empresas" @change="cargarTablaTrabajadores()" v-model="condicion" class="form-control form-control-sm">
                                    <option value="" selected>----Condicion----</option>

                                    <option v-for="(condicion, index) in condiciones" :value="condicion">{{condicion.toUpperCase()}}</option>

                                </select>
                            </td>
                            <td v-show="esVacaciones"></td>
                            <td v-show="esLicencia"></td>
                            <td v-show="mostrar_condicion">

                            </td>
                            <td>
                                <button class="btn btn-success" type="button" @click.prevent="filtrarTrabajador">Reset</button>
                            </td>

                        </tr>
                        <tr v-for="{RUT,NOMBRE_COMPLETO,CARGO, TELEFONO_CELULAR,DIRECCION,FECHA_INGRESO,EMPLEADOR,TRABAJADOR_ID,EMPLEADOR_ID, UBICACION_ACTUAL, CONDICION,FECHA_FINAL_LICENCIA,FECHA_FINAL_VACACIONES} in trabajadores.data">

                            <td>{{RUT}}</td>
                            <td>{{NOMBRE_COMPLETO }}</td>
                            <td>{{TELEFONO_CELULAR}}</td>
                            <td>{{DIRECCION}}</td>
                            <td>{{FECHA_INGRESO | FormatoFecha}}</td>
                            <td v-show="mostrar_cargo">
                                {{CARGO }}
                            </td>
                            <td v-show="mostrar_empleador">
                                {{EMPLEADOR }}
                            </td>
                            <td v-show="mostrar_estado">
                                <!--- 'dias libre','vacaciones','falla','disponible','en ruta',' licencia médica','permiso especial'-->
                                <span v-if="CONDICION=='disponible'" class="badge badge-success">{{CONDICION.toString().toUpperCase()}}</span>
                                <span v-if="CONDICION=='vacaciones'" class="badge badge-warning">{{CONDICION.toString().toUpperCase()}}</span>
                                <span v-if="CONDICION=='en ruta'" class="badge badge-info">{{CONDICION.toString().toUpperCase()}}</span>
                                <span v-if="CONDICION=='licencia médica'" class="badge badge-primary">{{CONDICION.toString().toUpperCase()}}</span>
                                <span v-if="CONDICION=='dias libre'" class="badge link-badge-warning">{{CONDICION.toString().toUpperCase()}}</span>
                            </td>
                            <td v-show="esVacaciones">{{FECHA_FINAL_VACACIONES | FormatoFecha}}</td>
                            <td v-show="esLicencia">{{FECHA_FINAL_LICENCIA | FormatoFecha}}</td>
                            <td v-show="mostrar_condicion">
                                {{UBICACION_ACTUAL}}
                            </td>
                            <td>

                                <div class='btn-group'>
                                    <button class="btn btn-info btn-sm" type="button" @click.prevent="abrir_modal_ubicacion(TRABAJADOR_ID)"><i class="fa fa-edit"></i></button>
                                    <!-- solo admin puede cambiar estado-->
                                    <button class="btn btn-warning btn-sm" v-if="isRoleAdmin" type="button" @click.prevent="cambioEstado(TRABAJADOR_ID)"><i class="fa fa-pencil"></i></button>
                                </div>

                            </td>
                        </tr>
                    </tbody>
                </table>
            </template>
            <template  #footer>
                <div class="row">
                    <div class="col-md-1">
                        <select v-model="per_page" class="form-control form-control-sm" @change.prevent="cantidadRegistros">
                            <option v-for="numero in numero_registros" :value="numero">{{numero}}</option>
                        </select>
                    </div>
                    <div class="col-md-11">
                        <!--<nav aria-label="Page navigation example mt-3">
                            <ul class="pagination">
                                <li v-for="paginate in trabajadores.links" :class="paginate.active ? page_class: 'page-item'"><a class="page-link" href="#" rel="nofollow" @click="getPaginate(paginate.label)">{{paginate.label}}</a></li>
                            </ul>
                        </nav>-->
                        <paginate :pagination="trabajadores" :onPageChange="cargarTablaTrabajadores"></paginate>                    </div>
                </div>
            </template>
        </CardComponent>

        <!-- Modal -->
        <div class="modal  fade" id="ubicacionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar ubicacion actual</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-12">
                                <label for="ubicacion_actual">Ubicación actual</label>
                                <textarea name="ubicacion_actual"  id="ubicacion_actual" class="form-control" v-model="ubicacion_actual" style="width: 100%;height: 250px"></textarea>
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" @click="cerrarModal" data-dismiss="modal">Cerrar</button>
                        <button type="button"  class="btn btn-primary btn-sm" @click.prevent="agregarUbicacionActual" >Guardar</button>

                    </div>
                </div>
            </div>
        </div>

        <!-- Modal  Filtro-->
        <div class="modal  fade" id="reporteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Reporte de proximas reicorporaciones</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                     <!-- Formulario de filtro por Fechas de termino-->
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-label" for="fecha_inicio">Fecha inicio</label>
                                <date-picker type="date" name="fecha_inicio" id="fecha_inicio" valueType="format" v-model="fecha_inicio_filtro"/>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-label" for="fecha_final">Fecha final</label>
                                <date-picker type="date" name="fecha_final" id="fecha_final" valueType="format"  v-model="fecha_fin_filtro"/>
                            </div>
                        </div>
                        <!-- Formulario de filtro por Fechas de termino-->

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" @click="cerrarModal" data-dismiss="modal">Cerrar</button>
                        <button type="button"  class="btn btn-primary btn-sm" @click.prevent="filtrarReicorporaciones" >Buscar</button>

                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Cambios de estado -->
        <div class="modal fade" id="estadosModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cambio de estado</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 form-group">

                                <label for="estado">Estado</label>
                                <select type="text" v-model="estado_cambiar" id="estado" class="form-control">
                                    <option value="">----------------------</option>
                                    <option v-for="estado in condiciones" :value="estado">{{estado}}</option>

                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary btn-sm" @click.prevent="update_cambio_estado()">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import moment from 'moment';
import da from "vue2-datepicker/locale/es/da";
import CardComponent from "../../components/CardComponent.vue";
import Paginate from "../../components/paginate.vue";
import modalComponent from "../../components/modalComponent.vue";
import DataTable from "../../components/DataTable.vue";
import Select2 from "../../components/Form/Select2.vue";
export default {
    components:{
        Loading,
        CardComponent,
        Paginate,
        modalComponent,
        DataTable,
        Select2
    },
    props:{
        filtros:{
            required:false,
            type:String
        }
    },
    data() {
        return {
            ubicaciones: [],
            cargos:[],
            areas:[],
            empleadores:[],
            rut:'',
            nombre:'',
            apellido:'',
            cargos_id:[],
            cargo_id:'',
            empleador_id:'',
            ubicacion_id:'',
            fecha_ingreso_inicial:'',
            fecha_ingreso_final:'',
            trabajadores:[],
            filtrar:false,
            paginate:['trabajadores'],
            per_page:10,
            isLoading: false,
            fullPage: true,
            active:true,
            //acciones
            id_seleccionado:0,
            ubicacion_actual:'',
            condicion:'',
            condiciones:['dias libre','vacaciones','falla','disponible','en ruta','licencia médica','permiso especial'],
            trabajador_id:0,
            trabajadores_filtros:[],
            numero_registros:[10,20,50,80,100,500,1000],
            page_class:'',
            esVacaciones:false,
            esLicencia:false,
            mostrar_cargo:true,
            mostrar_empleador:true,
            mostrar_ubicacion:true,
            mostrar_estado:true,
            mostrar_condicion:false,
            fecha_inicio_filtro:'2022-01-01',
            fecha_fin_filtro:'2022-01-01',
            tipo_reporte:[],
            tipos:['VACACIONES','LICENCIA MEDICA','DIAS LIBRE'],
            cargos_list:['CONDUCTORES DE BUSES','AUXILIARES DE BUSES'],
            cargos_reporte:[],
            estado_cambiar:'',
            isRoleAdmin:false,
            usuario:[],
        }
    },
    created() {
        this.userLogin();

    },
    mounted() {
        this.cargarTablaTrabajadores();
        this.getTrabajadoresFiltro();
        this.cargarEmpleador();
        this.cargarCargos();
        //$("#trabajador_id").on('select2:select',this.onSelectTrabajador);

    },
    updated() {
        $("#trabajador_id").on('select2:select',this.onSelectTrabajador);
    },
    methods:{
        onSelectTrabajador:function(e) {
            const id = e.params.data.id
            this.trabajador_id = parseInt(id)
            this.cargarTablaTrabajadores()
        },
        async cargarTablaTrabajadores (page = 1) {
             try{
                     this.isLoading = true;
                     // simulate AJAX
                     setTimeout(() => {
                         this.isLoading = false
                         this.active = false
                     }, 2500)

                     let url = '/lista-tripulacion?opciones=listPage&perpage='+this.per_page

                     if (page > 0){
                         url = url + '&page='+page
                     }

                     if (this.trabajador_id > 0){
                         url = url + '&filtro[TRABAJADOR_ID]='+this.trabajador_id
                     }

                     if(this.empleador_id > 0){
                         url = url + '&filtro[EMPLEADOR_ID]='+this.empleador_id
                     }

                     if(this.cargo_id > 0){
                         url = url + '&filtro[CARGO_ID]='+this.cargo_id
                     }

                     if (this.condicion !== ''){
                         url = url+'&'+'filtro[CONDICION]='+this.condicion
                         if (this.condicion==='vacaciones'){
                             this.esVacaciones = true
                         }else{
                             this.esVacaciones = false
                         }

                         if (this.condicion==='licencia médica'){
                             this.esLicencia = true
                         }else{
                             this.esLicencia = false
                         }
                     }
                     const {data, status} = await axios.get(url)

                     if (status === 200) {
                         this.trabajadores = data
                         this.$refs.tripulacion.goToPage(1)
                     }

             }catch (e) {
                console.log(e)
                     /*this.$swal({
                         title: 'Error!',
                         text: 'Error al cargar los trabajadores',
                         icon: 'error',
                         confirmButtonText: 'Aceptar'
                     }*/
             }
        },
        async getTrabajadoresFiltro (){
            try{
                const {data, status} = await axios.get('/lista-tripulacion?opciones=all')
                if (status === 200) {
                    this.trabajadores_filtros = data
                }
            }catch (e) {
                console.log(e)
            }

        },
        mostrarFiltrar:function (){
            this.filtrar = !this.filtrar
        },
        async cargarCargos(){
            try{

                const {data, status} = await axios.get('/cargos')

                if (status === 200){
                    this.cargos = data
                    this.cargos = this.cargos.filter(({id}) => id === 2 ||  id === 3)
                    console.log(this.cargos)
                }

            }catch (e){
                console.log(e)
            }

        },
        async cargarEmpleador(){
            try {
                const {data, status} = await axios.get('/empleador')
                if (status === 200){
                    this.empleadores = data
                }
            }
            catch (e) {
                console.log(e)
            }
        },
       async cargarUbicaciones(){
           try{
              const {data, status} = axios.get('/ubicaciones')

               if (status === 200) {
                   this.ubicaciones = data
               }
           }catch (e){
                this.$swal({
                     title: 'Error!',
                     text: 'Error al cargar los ubicaciones',
                     icon: 'error',
                     confirmButtonText: 'Aceptar'
                })
           }
        },
        filtrarTrabajador:function (){
            /*let filtros = {
                rut:this.rut,
                cargo_id:this.cargo_id,
                empleador_id:this.empleador_id,
                ubicacion_id:this.ubicacion_id,
                fecha_ingreso_inicial:this.fecha_ingreso_inicial,
                fecha_ingreso_final:this.fecha_ingreso_final
            }
            axios.post('/trabajador-filtro',filtros).then((res)=>{
               this.trabajadores = res.data
            }).catch((error)=>{
                console.log(error)
            })*/
            this.cargarTablaTrabajadores()
            location.reload()

        },

        abrir_modal_ubicacion:function (id){
            this.id_seleccionado = id
            $('#ubicacionModal').modal('show')
        },

        async agregarUbicacionActual(){
            try{
                let formData = new FormData();

                formData.append('ubicacion_actual',this.ubicacion_actual)

               const {status} = await axios.post('/actualiza-ubicacion-trabajador/'+this.id_seleccionado,formData)

                if (status === 200) {
                    this.ubicacion_actual = ''
                    this.cargarTablaTrabajadores()
                    this.$swal({
                        title: 'Exito!',
                        text: 'La ubicación actual ha sido actualizada exitosamente',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    })
                    this.cerrarModal()
                }

            }catch (e) {
                this.$swal({
                    title: 'Error!',
                    text: 'Error al agregar la ubicacion actual',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                })
            }


        },
        cerrarModal:function (){
            this.id_seleccionado = 0
            $('#ubicacionModal').modal('hide')
        },
        getPaginate:function (page_number){
            this.page =  page_number
            this.page_class = 'page-item active'
            this.cargarTablaTrabajadores()
        },
        cantidadRegistros:function (){
            this.page = 1
            this.cargarTablaTrabajadores()
        },
        abrirModalReporte(){
            this.iniciar_fecha()
            $('#reporteModal').modal('show')
        },
        cerrarModalReporte(){
            $('#reporteModal').modal('hide')
        },
        iniciar_fecha(){
            this.fecha_inicio_filtro = moment().format('YYYY-MM-DD')
            this.fecha_fin_filtro = moment().format('YYYY-MM-DD')
        },
        async filtrarReicorporaciones(){
          try{
                    //this.cargando = true
                    let url = '/export-tripulacion-retorno?opciones=all'

                    this.validaciones()

                    if (this.fecha_inicio_filtro !== ''){
                        url = url+'&'+'fecha_inicio='+this.fecha_inicio_filtro
                    }else{
                        this.$swal.fire({
                            title: 'Error!',
                            text: 'Debe ingresar una fecha de inicio',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        })
                        return;
                    }

                    if (this.fecha_fin_filtro !== ''){
                        url = url+'&'+'fecha_fin='+this.fecha_fin_filtro
                    }else {
                        this.$swal.fire({
                            title: 'Error!',
                            text: 'Debe ingresar una fecha de fin',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        })
                        return;
                    }





                    const {data, status} = await axios.get(url)

                    if (status === 200) {
                       //mensaje de exito
                        this.$swal.fire({
                            title: 'Exito!',
                            text: 'Se han encontrado registros',
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        }).then(res =>{
                            //this.reincorporaciones = data
                            this.printDatos()
                            this.cerrarModalReporte()
                        })
                    }

                }catch (e) {
                    console.log(e)
                }
            },
            printDatos(){
               //redireccionar a la vista de impresion
                window.open('/export-tripulacion-retorno-print?opciones=all&fecha_fin='+this.fecha_fin_filtro+'&fecha_inicio='+this.fecha_inicio_filtro, '_blank');
            },
        cambioEstado:function (id){
            this.id_seleccionado = id
            $('#estadosModal').modal('show')
        },
       async update_cambio_estado(){
           try {
               let formData = new FormData();
               formData.append('estado',this.estado_cambiar)
            const { status } = await axios.post('/update-cambio-estado-tripulacion/'+this.id_seleccionado,formData)

               if (status === 200) {
                   this.cargarTablaTrabajadores()
                   this.estado_cambiar = ''
                   this.$swal({
                       title: 'Exito!',
                       text: 'El estado ha sido actualizado exitosamente',
                       icon: 'success',
                       confirmButtonText: 'Aceptar'
                   })
                   this.cerrarModalEstado()
               }
           }catch (e) {
              //error
                this.$swal({
                     title: 'Error!',
                     text: 'Error al actualizar el estado',
                     icon: 'error',
                     confirmButtonText: 'Aceptar'
                })
           }
        },
        cerrarModalEstado:function (){
            this.id_seleccionado = 0
            $('#estadosModal').modal('hide')
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
        validaciones(){
            //fecha de inicio no puede ser mayor a la fecha final
            if (this.fecha_inicio_filtro > this.fecha_fin_filtro){
                this.$swal({
                    title: 'Error!',
                    text: 'La fecha de inicio no puede ser mayor a la fecha final',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                })
                return
            }
            //fecha de final no puede ser menor a la fecha de inicio
            if (this.fecha_fin_filtro < this.fecha_inicio_filtro){
                this.$swal({
                    title: 'Error!',
                    text: 'La fecha final no puede ser menor a la fecha de inicio',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                })
                return
            }

            //debe selecionar fechas

            if (this.fecha_inicio_filtro === '' && this.fecha_fin_filtro === ''){
                this.$swal({
                    title: 'Error!',
                    text: 'Debe seleccionar un rango de fechas',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                })
                return
            }
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
    /* .slide-fade-leave-active below version 2.1.8 */ {
    transform: translateX(10px);
    opacity: 0;
}

.text-success {
    color: #8dbf42 !important;
    font-weight: bold!important;
}
.text-warning{
    font-weight: bolder!important;
}
th{
    font-weight: bolder!important;
    color: #fff!important;
}
th a:hover{
    cursor: pointer;
    color: #222222!important;
}

thead tr th{
    background-color: #D3B560;
    color: white;
}

</style>
