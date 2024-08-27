<template>
    <div>
        <div class="btn-group">
            <button type="button" class="btn btn-primary btn-sm mb-3" @click="openModalCreate"><i class="fa fa-plus"></i> Agregar </button>
            <button class="btn btn-success btn-sm mb-3" @click="mostrarFiltrar"><i class="fa fa-filter"></i> Filtrar</button>

        </div>



        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
            <thead>
            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                    <th></th>
                    <th>RUT</th>
                    <th>NOMBRE</th>
                    <th>CARGO</th>
                    <th>EMPLEADOR</th>
                    <th>TIPO</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Termino</th>
                    <th>Fecha Retorno</th>
                    <th>Cant. Días</th>
                    <th>CONDICION</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
            <tbody class="fw-semibold text-gray-600">
                <transition name="slide-fade">
                    <tr v-show="filtrar">
                        <td></td>
                        <td colspan="2">
                            <select name="trabajador_id"
                                    v-model="trabajador_id_filtro"
                                    class="form-select mb-2 form-select-solid fw-bold"
                                    data-control="select2"
                                    data-placeholder="Seleccione trabajador"
                                    data-allow-clear="true"
                                    id="trabajador_id_filtro"
                            >

                                <option value="">--------</option>
                                <option v-for="({TRABAJADOR_ID,RUT,NOMBRE_COMPLETO}, index) in trabajadores_list"  :value="TRABAJADOR_ID">{{RUT+' - '+NOMBRE_COMPLETO}}</option>
                            </select>
                        </td>

                        <td>
                            <select name="cargos" id="cargos" @change.prevent="cargarBusesChofresTabla()" v-model="cargo_id" class="form-control form-control-sm">
                                <option value="" selected>----Cargos----</option>

                                <option v-for="({id,nombre_cargo}, index) in cargos" :value="id">{{nombre_cargo}}</option>

                            </select>

                        </td>
                        <td>
                            <select name="empresas" id="empresas" @change.prevent="cargarBusesChofresTabla()" v-model="empleador_id" class="form-control form-control-sm">
                                <option value="" selected>----Empresas----</option>

                                <option v-for="({id,nombre_empleador}, index) in empleadores" :value="id">{{nombre_empleador}}</option>

                            </select>
                        </td>
                        <td>
                            <select name="tipo_chofer" class="form-control" v-model="tipo_filtro" @click="cargarBusesChofresTabla()"  id="tipo_chofer" >
                                <option value="">----Seleccione tipo-----</option>
                                <option v-for="(tipo, index) in tipos" :value="tipo">{{tipo}}</option>
                            </select>
                        </td>
                        <td colspan="2">
                            <input type="date" class="form-control"  v-model="filtro_fecha_init">
                            <input type="date" class="form-control" v-model="filtro_fecha_final">
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-warning" @click="resetFiltro()">Reset</button>
                                <button class="btn btn-primary btn-sm">Descargar</button>
                            </div>

                        </td>
                    </tr>
                </transition>
                <tr v-for="(trabajador, index) in buses_trabajador.data" >
                    <td>#</td>
                    <td>{{trabajador.RUT}}</td>
                    <td>{{trabajador.NOMBRE_COMPLETO  }}</td>
                    <td>
                        {{trabajador.CARGO }}
                    </td>
                    <td>
                        {{trabajador.EMPLEADOR }}
                    </td>
                    <td>
                        <span v-if="trabajador.TIPO === 'dias libre'" class="badge badge-warning">  {{trabajador.TIPO | uppercase}}</span>
                        <span v-if="trabajador.TIPO === 'falla'" class="badge badge-danger">  {{trabajador.TIPO | uppercase}}</span>
                        <span v-if="trabajador.TIPO === 'permiso especial'" class="badge badge-primary">  {{trabajador.TIPO | uppercase}}</span>
                    </td>
                    <td>
                          {{trabajador.FECHA_INICIAL | moment("DD-MM-YYYY")}}
                    </td>
                    <td>
                        {{trabajador.FECHA_TERMINO | moment("DD-MM-YYYY")}}
                    </td>
                    <td>
                        {{trabajador.FECHA_RETORNO | moment("DD-MM-YYYY")}}
                    </td>
                    <td>
                            {{trabajador.NUMERO_DIAS}}
                    </td>
                    <td>
                        <span v-if="trabajador.ESTADO === 'EN CURSO'" class="badge badge-primary"> {{trabajador.ESTADO}}</span>
                        <span v-if="trabajador.ESTADO === 'FINALIZADO'" class="badge badge-danger"> {{trabajador.ESTADO}}</span>
                    </td>
                    <td>
                        <a v-if="trabajador.TIPO === 'dias libre'"  :href="'/dias-libres-pdf/'+trabajador.GESTION_INDENTI" class="btn btn-success btn-sm"><i class="fa fa-download"></i></a>
                    </td>
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
                <nav aria-label="Page navigation example mt-3">
                    <ul class="pagination">
                        <li v-for="paginate in buses_trabajador.links" :class="paginate.active ? page_class: 'page-item'"><a class="page-link" href="#" rel="nofollow" @click="getPaginate(paginate.label)">{{paginate.label}}</a></li>
                    </ul>
                </nav>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal  fade" id="trabajadorModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered mw-750px">
                <div class="modal-content">
                    <div class="modal-header" id="kt_modal_add_customer_header">
                        <h2 class="fw-bold">Agregar Gestión de tripulante</h2>
                        <div id="trabajadorModal_close" @click="cerrarModal()" class="btn btn-icon btn-sm btn-active-icon-primary" >
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
                            <div class="col-md-6 form-group">
                                <div :class="'alert '+alerta" v-if="respuesta">{{mensajes}}</div>
                                <label for="trabajador_id">Nombre Tripulante</label>
                                <select name="trabajador_id"
                                        class="form-select mb-2 form-select-solid fw-bold"
                                        data-control="select2"
                                        data-placeholder="Seleccione trabajador"
                                        data-allow-clear="true"
                                        data-dropdown-parent="#trabajadorModal"
                                        id="trabajador_id">

                                    <option value="">--------</option>
                                    <option v-for="({TRABAJADOR_ID,RUT,NOMBRE_COMPLETO}, index) in trabajadores_list"  :value="TRABAJADOR_ID">{{RUT+' - '+NOMBRE_COMPLETO}}</option>

                                </select>
                            </div>
                            <div class="col-md-6 form-group">

                                <label for="tipo_chofer">Tipo</label>
                                <select name="tipo_chofer" class="form-control" v-model="tipo" :disabled="desactivar_campo" @change="isFalla()" id="tipo_chofer" >
                                    <option value="">----Seleccione tipo-----</option>
                                    <option v-for="(tipo, index) in tipos" :value="tipo">{{tipo}}</option>
                                </select>
                            </div>



                            <div class="col-md-6 form-group">
                                <label for="fecha_inicio">Fecha Inicio</label>
                                <input type="date" id="fecha_inicio" v-model="fecha_inicio" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="nro_dias"> NRO DIAS</label>
                                <input type="number" id="nro_dias" v-model="nro_dias" min="1" @change="sumar_fecha_final" :disabled="tipo === 'falla' ? true : false" class="form-control">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="fecha_termino">Fecha Termino</label>
                                <input type="date" id="fecha_termino" :disabled="true" v-model="fecha_termino" class="form-control">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer flex-center">
                        <button type="button" class="btn btn-default btn-sm" @click="cerrarModal()">Cerrar</button>
                        <button type="button"  class="btn btn-primary btn-sm" @click.prevent="agregar">Guardar</button>

                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
       <!-- <div class="modal fade" id="AreaModalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eliminarModalLabel">Eliminar Areas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div :class="'alert '+alerta" v-if="respuesta">{{mensajes}}</div>
                                <p>¿Desea Eliminar Area?</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary btn-sm" @click.prevent="eliminarAreas(id)">Eliminar</button>

                    </div>
                </div>
            </div>
        </div>-->
    </div>
</template>

<script>
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import moment from "moment";

export default {
    components:{
        Loading
    },
    props:{
        todos:{
            type:Boolean,
            default:false
        }
    },
    data() {
        return {
            trabajadores:[],
            buses:[],
            cargos:[],
            buses_trabajador:[],
            nombre_chofer:'',
            trabajador_id:0,
            tipos:[
                'permiso especial',
                'dias libre',
                'falla'
            ],
            tipo_filtro:'',
            nro_dias:'',
            tipo:'',
            cargo_id:0,
            bus_id:'',
            fecha_termino:'',
            fecha_inicio:'',
            fecha_retorno:'',
            editar:false,
            crear:false,
            id:0,
            alerta:'',
            mensajes:'',
            inputClass:'form-control mb-4',
            errorsClass:'',
            respuesta:false,
            paginate:['trabajadores'],
            isLoading: false,
            fullPage: true,
            active:true,
            numero_registros:[10,20,50,80,100,500,1000],
            per_page:10,
            page_class : 'page-item',
            page_link_class : 'page-link',
            desactivar_campo:false,
            empleador_id:0,
            empleadores:[],
            trabajadores_list:[],
            trabajador_id_filtro:0,
            filtrar:false,
            filtro_fecha_init:'',
            filtro_fecha_final:''
        }
    },
    mounted() {
        //this.cargarTablaTrabajadores()
        //this.getBuses()
        this.cargarBusesChofresTabla()
        this.getTrabajadores()
        this.cargarEmpleador()
        this.cargarCargos()
    },
    updated() {
        //this.refrescar()
        $('#trabajador_id_filtro').on('select2:select',this.selectTrabajadorFiltro)
        $('#trabajador_id').on('select2:select',this.selectTrabajador)
    },
    methods: {
        refrescar:function(){
            //this.$refs.categorias.selectpicker('refresh')
           // $(this.$refs.trabajadores).selectpicker('refresh')
            //$(this.$refs.choferes).selectpicker('refresh')
            //$(this.$refs.buses).selectpicker('refresh')
        },
        selectTrabajadorFiltro:function(e){
            const id = e.params.data.id
            this.trabajador_id_filtro = parseInt(id)
            this.cargarBusesChofresTabla()
        },
        selectTrabajador:function(e){
            const id = e.params.data.id
            this.trabajador_id = parseInt(id)
            //this.cargarTablaTrabajadores()
        },
        openModalCreate:function(){
            this.editar = false
            this.crear = true
            $('#trabajadorModal').modal('show')
        },
        async agregar() {
          try{
              let formData = new FormData();
              //realiza validaciones de campos
              let validar = this.validaciones()
              if (validar){
                  return;
              }

              formData.append('trabajador_id',this.trabajador_id)
              formData.append('nro_dias',this.nro_dias)
              formData.append('tipo',this.tipo)
              formData.append('fecha_inicio',this.fecha_inicio)
              formData.append('fecha_termino',this.fecha_termino)
              formData.append('fecha_retorno',this.fecha_retorno)

            const { status } = await axios.post('/gestion',formData)

              if (status === 200) {

                  this.$swal.fire({
                      title: 'Exito!',
                      text: 'Se ha agregado correctamente',
                      icon: 'success',
                      confirmButtonText: 'Aceptar'
                  }).then(() => {
                      this.cargarBusesChofresTabla()
                      this.trabajador_id = 0
                      this.nro_dias = 0
                      this.tipo = ''
                      this.fecha_inicio = ''
                      this.fecha_termino = ''
                      //resetear select2
                        $('#trabajador_id').val(null).trigger('change');
                      $('#trabajadorModal').modal('hide')
                  });

              }


          }catch (e) {
             this.$swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Algo salio mal!',
                });
          }
        },
        async getTrabajadores (){
            try{
                const {data, status} = await axios.get('/lista-tripulacion?opciones=all')

                if (status === 200){
                    this.trabajadores_list = data
                }

            }catch (e) {
                console.log(e)
            }
        },
       async cargarEmpleador(){
           try{
                const {data , status} = await axios.get('/empleador')

               if (status === 200){
                   this.empleadores = data
               }

           }catch (e){
                console.log(e)
           }
        },
        async cargarCargos(){
            try{
                const {data , status} = await axios.get('/cargos')

                if (status === 200){
                    this.cargos = data
                    this.cargos = this.cargos.filter((cargo)=>cargo.id === 2 || cargo.id === 3)
                }

            }catch (e){
                console.log(e)
            }
        },
        validaciones(){
            if (this.trabajador_id === 0){
                this.$swal({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Debe seleccionar un trabajador!',
                });
                return true;
            }
            if (this.tipo === ''){
                this.$swal({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Debe seleccionar un tipo de registro!',
                });
                return true;
            }
            if (this.fecha_inicio === ''){
                this.$swal({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Debe seleccionar una fecha de inicio!',
                });
                return true;
            }

            if (this.nro_dias === ''){
                this.$swal({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Debe ingresar un numero de dias!',
                });
                return true;
            }
        },
        //Solo choferes disponibles
        async cargarTablaTrabajadores(){
            try{
                //this.isLoading = true
                let url = '/getTripulacion?opciones=get'

             /*  if (this.todos){
                    url = url+'?opciones=listPage'
                }else{
                    url = url+'?opciones=listPage'
                }*/

/*
                if(this.trabajador_id_filtro > 0){
                    url = url+'&'+'filtro[TRABAJADOR_IDENTI]='+this.trabajador_id_filtro
                }

                if(this.cargo_id > 0){
                    url = url+'&'+'filtro[CARGO_ID]='+this.cargo_id
                }

                if(this.EMPLEADOR_ID > 0){
                    url = url+'&'+'filtro[EMPLEADOR_ID]='+this.empleador_id
                }

                if(this.tipo_filtro !== ''){
                    url = url+'&'+'filtro[TIPO]='+this.tipo_filtro
                }*/

               const {data, status} = await axios.get(url)

                if (status === 200) {
                    this.trabajadores = data
                    this.trabajadores = this.trabajadores.filter((trabajador)=>trabajador.cargo_id === 2 || trabajador.cargo_id === 3)
                }

            }catch (e) {
                console.log(e)
            }

        },
        resetFiltro(){
            this.trabajador_id_filtro = 0
            $('#trabajador_id_filtro').val(null).trigger('change');
            this.cargo_id = 0
            this.empleador_id = 0
            this.tipo_filtro = 0
            this.cargarBusesChofresTabla()
        },
        async cargarBusesChofresTabla(){
            /* carga el listado de historial de falla / licencias / permisos*/
            try {
                let url = '/getGestionTripulacion?opciones=get&perpage='+this.per_page
                if (this.todos){
                    url = url+'&tipo=trabajadores'
                    this.tipo = 'falla'
                    this.desactivar_campo = true
                }else{
                    url = url+'&tipo=tripulacion'
                }

                if (this.page > 0){
                    url = url + '&page='+this.page
                }

                if (this.trabajador_id_filtro>0){
                    url = url + '&filtro[TRABAJADOR_IDENTI]='+this.trabajador_id_filtro
                }

                if (this.empleador_id>0){
                    url = url + '&filtro[EMPLEADOR_ID]='+this.empleador_id
                }

                if (this.cargo_id>0){
                    url = url + '&filtro[CARGO_ID]='+this.cargo_id
                }

                if (this.tipo_filtro !== '' && this.tipo_filtro !== 0){
                    url = url + '&filtro[TIPO]='+this.tipo_filtro
                }

                //console.log(url)

               const {data , status} = await axios.get(url)

                if (status === 200){
                    this.buses_trabajador = data
                }

            }catch (e) {
                console.log(e)
            }
        },
        sumar_fecha_final(){

            let fecha_inicio
            let dias
            let dias_retorno
            let fecha_final

            /*VALIDAR FECHA DE INICIO*/
            if (this.fecha_inicio !== ''){
                fecha_inicio = new Date(this.fecha_inicio)
            }else{
                this.$swal({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Debe seleccionar una fecha de inicio!',
                });
            }

            /*VALIDAR FECHA DE INICIO*/
            if (this.nro_dias !== 0){
                dias = parseInt(this.nro_dias)
                dias_retorno = dias + 1
            }else{
                this.$swal({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Debe ingresar un numero de dias!',
                });
            }
            console.log(dias_retorno)
            this.fecha_termino = moment(fecha_inicio).add(dias,'days').format('YYYY-MM-DD') //cambiar en otros lugares
            //fecha_final = new Date(this.fecha_termino)
            this.fecha_retorno =  moment(fecha_inicio).add(dias_retorno,'days').format('YYYY-MM-DD')
            console.log(this.fecha_retorno)
        },
        getPaginate (page_number){
            this.page =  page_number
            this.page_class = 'page-item active'
            this.cargarBusesChofresTabla()
        },
        cantidadRegistros(){
            this.page = 1
            this.cargarBusesChofresTabla()
        },
        mostrarFiltrar:function (){
            this.filtrar = !this.filtrar
        },
        isFalla(){
            if (this.tipo === 'falla'){
                this.nro_dias = 1
                this.fecha_inicio = moment().format('YYYY-MM-DD')
                this.fecha_termino = moment().format('YYYY-MM-DD')

            }else{
                return false
            }
        },
        cerrarModal(){
           // this.resetFiltro()
           // this.resetForm()
            $('#trabajadorModal').modal('hide')
        },
    },
    filters: {
        uppercase: function(v) {
            return v.toUpperCase();
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

