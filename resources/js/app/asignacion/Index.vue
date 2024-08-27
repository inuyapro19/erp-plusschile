<template>
    <div>
        <button type="button" class="btn btn-success btn-sm mb-3" @click.prevent="openModalCreate"><i class="fa fa-plus"></i> Agregar </button>
        <button type="button" class="btn btn-secondary btn-sm mb-3" @click.prevent="openModalImportar"><i class="fa fa-upload"></i> Importar </button>
        <button type="button" class="btn btn-primary btn-sm mb-3" @click.prevent="openModalExportar"><i class="fa fa-download"></i> Exportar </button>
        <button type="button" class="btn btn-warning btn-sm mb-3" @click.prevent="openModalEstado"><i class="fa fa-edit"></i> Cambios Estado </button>
        <button type="button" class="btn btn-danger btn-sm mb-3" @click.prevent="openModalEliminar"><i class="fa fa-trash"></i> Eliminar </button>
        <div class="row mb-3">
            <div class="col-md-4 form-group">
                <!--- <input type="text" v-model="rut" id="rut" class="form-control" placeholder="Ingrese rut sin puntos y con guión">-->

                <select name="trabajador_id" class="form-control selectpicker" v-model="trabajador_id_filtro"  @change.prevent="getBonosTrabajador"  ref="trabajadores" data-size="10" data-live-search="true" id="trabajador_id">

                    <option value="">--------</option>
                    <option v-for="(trabajador, index) in trabajadores"  :value="trabajador.id">{{trabajador.rut+' - '+trabajador.primer_nombre +' '+ trabajador.primer_apellido+ ' ' +trabajador.segundo_apellido}}</option>
                </select>
            </div>
            <div class="col-md-3 form-group">
                <!--- <input type="text" v-model="rut" id="rut" class="form-control" placeholder="Ingrese rut sin puntos y con guión">-->

                <select name="trabajador_id" class="form-control" v-model="estado_filtro" @change.prevent="getBonosTrabajador"  id="trabajador_id">

                    <option value="">--------</option>
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                </select>
            </div>
        </div>
        <loading v-model:active="isLoading"
                 :can-cancel="true"
                 :is-full-page="fullPage"
                 :active="active"
        />
        <table class="table table-striped table-bordered">
            <thead>
            <th><input type="checkbox" v-model="seleccionarTodos" @change="selectALL"></th>
            <th>RUT</th>
            <th>NOMBRE</th>
            <th>DESCRIPCIÓN</th>
            <th>CATEGORIAS</th>
            <th>MES/AÑO</th>
            <th>MONTO</th>
            <th>ESTADO</th>
            <th>ACCIONES</th>

            </thead>
            <tbody>
                <tr v-for="(bono_trabajador, index) in bonos_trabajador.data">
                    <td><input type="checkbox"  v-model="seleccion_masiva_id" :value="bono_trabajador.BONO_TRABAJADOR_ID"></td>
                    <td>{{bono_trabajador.RUT}}</td>
                    <td>{{bono_trabajador.NOMBRE_COMPLETO}}</td>
                    <td>{{bono_trabajador.DESCRIPCION}}</td>
                    <td>{{bono_trabajador.CATEGORIA}}</td>
                    <th>{{bono_trabajador.MES+'/'+bono_trabajador.ANYO}}</th>
                    <td>${{bono_trabajador.MONTO_MOD > 0 ? bono_trabajador.MONTO_MOD : bono_trabajador.MONTO_PRE }}</td>
                    <td v-if="bono_trabajador.ESTADO_ASIGNACION === 'activo'"><span class="badge badge-success">{{bono_trabajador.ESTADO_ASIGNACION}}</span></td>
                    <td v-else><span class="badge badge-danger">{{bono_trabajador.ESTADO_ASIGNACION}}</span></td>
                    <td>
                        <button class="btn btn-sm btn-primary" @click="openModalEditar(bono_trabajador.BONO_TRABAJADOR_ID)"><i class="fa fa-edit"></i></button>
                       <!-- <button class="btn btn-sm btn-danger" @click="eliminar_bono(bono_trabajador.BONO_TRABAJADOR_ID)"><i class="fa fa-trash"></i></button>-->
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
                        <li v-for="paginate in bonos_trabajador.links" :class="paginate.active ? page_class: 'page-item'"><a class="page-link" href="#" rel="nofollow" @click="getPaginate(paginate.label)">{{paginate.label}}</a></li>
                    </ul>
                </nav>
            </div>
        </div>


        <!-- AGREGAR BONOS -->
        <div class="modal  fade" id="bonoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Bono</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <!--- <input type="text" v-model="rut" id="rut" class="form-control" placeholder="Ingrese rut sin puntos y con guión">-->
                                <label for="">Trabajador</label>
                                <select name="trabajador_id" class="form-control selectpicker" v-model="trabajador_id"   ref="trabajadores2" data-size="10" data-live-search="true" id="trabajador_id">

                                    <option value="">--------</option>
                                    <option v-for="(trabajador, index) in trabajadores"  :value="trabajador.id">{{trabajador.rut+' - '+trabajador.primer_nombre +' '+ trabajador.primer_apellido+ ' ' +trabajador.segundo_apellido}}</option>
                                </select>
                            </div>

                            <div class="col-md-12 form-group">
                                <!--- <input type="text" v-model="rut" id="rut" class="form-control" placeholder="Ingrese rut sin puntos y con guión">-->
                                <label for="">Bono</label>
                                <select name="trabajador_id" class="form-control" v-model="bono_id"   id="trabajador_id">

                                    <option value="">--------</option>
                                    <option v-for="(bono, index) in bonos" :value="bono.id">{{bono.descripcion}}</option>

                                </select>
                            </div>

                            <div class="col-md-12 form-group">
                                <!--- <input type="text" v-model="rut" id="rut" class="form-control" placeholder="Ingrese rut sin puntos y con guión">-->
                                <label for="">Mes</label>
                                <select name="trabajador_id" class="form-control" v-model="mes"   id="trabajador_id">

                                    <option value="">--------</option>
                                    <option v-for="(mes, index) in meses" :value="index+1">{{mes}}</option>

                                </select>
                            </div>

                            <div class="col-md-12">
                                <label for="">Año</label>
                               <input type="text" v-model="anyo" id="rut" class="form-control">
                            </div>

                            <div class="col-md-12">
                                <label for="">Monto</label>
                                <input type="text" v-model="monto" id="monto" class="form-control">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                        <button type="button"  class="btn btn-primary btn-sm" @click.prevent="enviarFormulario()"><i class="fa fa-trash"></i> Eliminar</button>

                    </div>
                </div>
            </div>
        </div>

        <!-- IMPORTAR BONOS -->
        <div class="modal  fade" id="importarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Importar Bono</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="form-group col-md-12">
                                <input  name="excel" ref="file"  id="file-upload" class="form-control-file" type="file" aria-label="Adjunte su Reporte Anual" @change="onFileChange()" required   accept=".xlsx, .xls, .csv" />
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                        <button type="button"  class="btn btn-primary btn-sm" @click.prevent="cargaDatos()">Guardar</button>

                    </div>
                </div>
            </div>
        </div>

        <!-- EXPORTAR BONOS -->
        <div class="modal  fade" id="exportarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Exportar Lista</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <select name="cargos" id="cargos" v-model="cargos_id" @change="cargo_activar_export" class="form-control form-control-sm" >
                                    <option value="" selected>----Cargos----</option>

                                    <option v-for="(cargo, index) in cargos" :value="cargo.id">{{cargo.nombre_cargo}}</option>

                                </select>
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                        <a :href="url_export"  v-if="descarga" class="btn btn-primary btn-sm" ><i class="fa fa-download"></i> Exportar</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Cambio Monto -->
        <div class="modal  fade" id="editarMontoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Monto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="form-group col-md-12">
                                <label for="">Monto</label>
                                <input type="text" class="form-control" v-model="monto">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                        <button type="button"  class="btn btn-primary btn-sm" @click.prevent="guardarMonto()">Guardar</button>

                    </div>
                </div>
            </div>
        </div>

        <!-- Cambio estados -->
        <div class="modal  fade" id="cambioEstadoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cambio Estado</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="form-group col-md-12">
                                <label for="">Estado</label>
                                <select v-model="estado" class="form-control">
                                    <option value="">------------</option>
                                    <option value="activo">Activo</option>
                                    <option value="inactivo">Inactivo</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                        <button type="button"  v-if="this.seleccion_masiva_id.length > 0" class="btn btn-primary btn-sm" @click.prevent="cambioEstado()">Guardar</button>

                    </div>
                </div>
            </div>
        </div>

        <!-- eliminacion masiva -->
        <div class="modal  fade" id="eliminarMasivaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Eliminacion</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="form-group col-md-12">
                               Desea Eliminar estos Registros
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                        <button type="button" v-if="seleccion_masiva_id.length > 0" class="btn btn-danger btn-sm" @click.prevent="eliminarMasiva()">Eliminar</button>

                    </div>
                </div>
            </div>
        </div>

    </div>

</template>

<script>
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
export default {

    components:{
        Loading
    },
    data() {
        return {
            trabajador_id_filtro: [],
            trabajador_id:0,
            trabajadores:[],
            bonos:[],
            bono_id:0,
            mes:0,
            anyo:0,
            monto:0,
            bonos_trabajador:[],
            estado:'activo',
            estado_filtro:'',
            meses:[
                'ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE'
            ],
            page:0,
            page_class:'page-item active',
            size:'',
            filename:'',
            archivo:'',
            url_export:'/export-lista-asignacion-bonos?opciones=cargos',
            descarga:false,
            cargos:[],
            cargos_id:0,
            seleccion_masiva_id:[],
            seleccionarTodos:false,
            bono_trabajador_id:0,
            numero_registros:[10,20,50,80,100,500,1000],
            per_page:10,
            //loading
            isLoading: false,
            fullPage: true,
            active:true
        }
    },
    updated() {
        this.refrescar()
    },
    mounted() {
        this.getTrabajadores()
        this.getBonos()
        this.getBonosTrabajador()
    },
    methods:{
        refrescar:function(){
            //this.$refs.categorias.selectpicker('refresh')
            $(this.$refs.trabajadores).selectpicker('refresh')
            $(this.$refs.trabajadores2).selectpicker('refresh')
            // $(this.$refs.buses).selectpicker('refresh')
        },
        async getTrabajadores (){
            await axios.get('/lista-trabajadores').then((res)=>{
                this.trabajadores = res.data
            }).catch((error)=>{
                console.log(error)
            })
        },
        cargarCargos:function (){

            axios.get('/cargos').then(res=>{
                this.cargos = res.data
            })
        },
        async getBonos(){

            await axios.get('/bonos-disponibles-all').then((res)=>{
                this.bonos = res.data
            }).catch((error) =>{
                console.log('bonos error')
            })
        },

        async getBonosTrabajador(){

            this.isLoading = true;
            // simulate AJAX
            setTimeout(() => {
                this.isLoading = false
                this.active = false
            }, 1000)

            let url = '/bonos-trabajador-disponibles?opcion=1&perpage='+this.per_page;

            if (this.page > 0){
                url = url + '&page='+this.page
            }

            if (this.trabajador_id_filtro > 0){
                 url = url + '&trabajador_id='+this.trabajador_id_filtro
            }

            if (this.estado_filtro !== ''){
                url = url + '&estado='+this.estado_filtro
            }



            await axios.get(url).then((res)=>{
                this.bonos_trabajador = res.data
            }).catch((error)=>{
                console.log('error error')
            })
        },
        async enviarFormulario(){
            let url = '/bonos-trabajador-agregar'



            await axios.post('/bonos-trabajador-agregar',{
                trabajador_id:this.trabajador_id,
                bono_id: this.bono_id,
                mes:this.mes,
                anyo:this.anyo,
                monto:this.monto,
                estado:this.estado
            }).then((res)=>{
                this.$swal('Asignacion agregada exitosamente')
                //especificar el modal a cerrar
                $('#bonoModal').modal('hide')
                this.getBonosTrabajador()
                this.resetear_form()
            }).catch((erro)=>{
                console.log('error al agregar')
            })

        },
        resetear_form:function (){
            this.trabajador_id = 0
            this.bono_id = 0
            this.mes = ''
            this.anyo = ''
        },
        openModalCreate:function(){
            $('#bonoModal').modal('show')
        },
        openModalImportar:function (){
           $('#importarModal').modal('show')
        },
        openModalExportar:function (){
            this.cargarCargos()
            $('#exportarModal').modal('show')
        },
        openModalEditar:function (id){
            this.bono_trabajador_id = id
            $('#editarMontoModal').modal('show')
        },
        getPaginate:function (page_number){
            this.page =  page_number
            this.page_class = 'page-item active'
            this.getBonosTrabajador()
        },
        openModalEstado:function (){
            $('#cambioEstadoModal').modal('show')
        },
        openModalEliminar:function (){
          $('#eliminarMasivaModal').modal('show')
        },
        async cambioEstado(){
         // alert('Proximamente...')
            console.log(this.seleccion_masiva_id.length)
            let datos = this.seleccion_masiva_id

            await  axios.post('/cambio-estado-bono-asignados',{datos:datos,estado:this.estado}).then((res)=>{
                this.$swal('cambios realizados exitosamente')
                this.getBonosTrabajador()
                this.seleccion_masiva_id = []
                this.seleccionarTodos = false
                $('#cambioEstadoModal').modal('hide')
            }).catch((error)=>{
               console.log('error...')
                this.$swal('Error al enviar formulario')
                $('#cambioEstadoModal').modal('hide')
            })

        },
        async cargaDatos(){
            let formData =  new FormData()

            if(this.archivo !== ''){
                formData.append('file',this.archivo)
            }else{
                this.$swal('Debe cargar un archivo excel')
                return
            }

            await axios.post('/carga-archivos-asignaciones',
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then((res)=>{
                    this.$swal('Datos Importados exitosamente')
                    this.getBonosTrabajador()
                    $('#importarModal').modal('hide')
            }).catch((error)=>{
                this.$swal('error al cargar el archivo')
            })

        },
        onFileChange() {
            //console.log(e.target.files[0]);
            this.filename =   this.$refs.file.files[0].name;
            this.size =  this.file = this.$refs.file.files[0].size;
            this.archivo = this.$refs.file.files[0];
        },
        cargo_activar_export(){
           if (this.cargos_id > 0){
               this.url_export = this.url_export + '&cargo='+this.cargos_id
               console.log(this.url_export)
               this.descarga = true
           }else{
               this.url_export = '/export-lista-asignacion-bonos?opciones=cargos'
               this.descarga = false
           }
        },
       async eliminarMasiva(){

           let datos = this.seleccion_masiva_id

           await axios.post('/eliminar-masiva-bono-asignados', {datos:datos}).then((res)=>{
               this.$swal('Datos eliminados exitosamente')
               this.getBonosTrabajador()
               $('#eliminarMasivaModal').modal('hide')
               this.seleccion_masiva_id = []
               this.seleccionarTodos = false
           }).catch((error)=>{
               console.log('error')
           })
        },
        async eliminar_bono(id){
            await axios.delete('/bonos-trabajador-delete/'+id).then((res)=>{
                this.$swal('Registro eliminado exitosamente')
                this.getBonosTrabajador()
            }).catch((error)=>{
                this.$swal('error al eliminar')
            })
        },
        selectALL(){
            if(this.seleccionarTodos){
                this.bonos_trabajador.data.map((item)=>{
                    console.log(item.BONO_TRABAJADOR_ID)
                    this.seleccion_masiva_id.push(item.BONO_TRABAJADOR_ID)
                    console.table(this.seleccion_masiva_id)
                })
            }else{
                this.seleccion_masiva_id = []
                console.log(this.seleccion_masiva_id);
            }

        },
        async guardarMonto(){

            let id = this.bono_trabajador_id
          await axios.post('/cambio-monto-bono-asignado/'+id,{monto:this.monto}).then((res)=>{
                this.$swal('Cambio realizado exitosamente')
                $('#editarMontoModal').modal('hide')
               this.monto = 0
               this.getBonosTrabajador()
          }).catch((error)=>{
              this.$swal('error al cambiar el monto')
              $('#editarMontoModal').modal('hide')
          })

        },
        cantidadRegistros:function (){
            this.page = 1
            this.getBonosTrabajador()
        }
    }
}
</script>

<style scoped>

</style>
