<template>
    <div>
        <div class="btn-group">
            <button type="button" class="btn btn-success btn-sm mb-3" @click="agregarJefeMaquina"><i class="fa fa-plus"></i> Agregar</button>
        </div>

        <loading v-model:active="isLoading"
                 :can-cancel="true"
                 :is-full-page="fullPage"
                 :active="active"
        />

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
               <tr>
                   <th>Bus</th>
                   <th>RUT</th>
                   <th>NOMBRE</th>
                   <th>CARGO</th>
                   <th>TIPO CONDUCTOR</th>
                   <th>EMPLEADOR</th>
                   <th>CONDICIÓN</th>
                   <th>ACCIONES</th>
               </tr>
            </thead>
            <tbody>

                <tr v-for="(trabajador, index) in buses_trabajador" >
                    <td>

                     Nº:{{trabajador.numero_bus}} <br>Pantente: {{trabajador.patente}}
                    </td>
                    <td>{{trabajador.rut}}</td>
                    <td>{{trabajador.primer_nombre +' '+trabajador.segundo_nombre  +' '+trabajador.primer_apellido +' '+trabajador.segundo_apellido  }}</td>
                    <td>
                        {{trabajador.nombre_cargo }}
                    </td>
                    <td>
                        {{trabajador.tipo_chofer}}
                    </td>
                    <td>
                        {{trabajador.nombre_empleador }}
                    </td>
                    <td>{{trabajador.condicion}}</td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-success btn-sm" @click="editarJefeMaquina(trabajador.buses_trabajador_id)"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-danger btn-sm" @click="eliminarJefeMaquina(trabajador.buses_trabajador_id)"><i class="fa fa-trash"></i></button>
                        </div>

                    </td>
                </tr>

            </tbody>

        </table>
    </div>



        <!-- Modal -->
        <div class="modal  fade" id="trabajadorModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Asignar Conductor</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <div :class="'alert '+alerta" v-if="respuesta">{{mensajes}}</div>
                                <label for="trabajador_id">Nombre Conductor</label>
                                <select name="trabajador_id" class="form-control selectpicker" v-model="trabajador_id"  ref="choferes"  data-live-search="true" id="trabajador_id">

                                    <option value="">--------</option>
                                    <option v-for="({TRABAJADOR_ID,RUT,NOMBRE_COMPLETO}, index) in trabajadores"  :value="TRABAJADOR_ID">{{ RUT+' - '+NOMBRE_COMPLETO}}</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">

                                <label for="tipo_chofer">Tipo Conductor</label>
                                <select name="tipo_chofer" class="form-control" v-model="tipo_chofer" id="tipo_chofer" >
                                    <option value="">----Seleccione tipo de conductor-----</option>
                                    <option v-for="(tipo, index) in tipos" :value="tipo">{{tipo}}</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">

                                <label for="bus_id">Bus</label>
                                <select name="bus_id" class="form-control selectpicker" v-model="bus_id" data-live-search="true" id="bus_id" ref="buses" >
                                    <option value="">----Seleccione bus-----</option>
                                    <option v-for="(bus, index) in buses" :value="bus.id">{{bus.numero_bus +' - '+ bus.patente}}</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="bus_id">Fecha Inicio</label>
                                <input type="date" id="fecha_inicio" v-model="fecha_inicio" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="bus_id">Fecha Termino</label>
                                <input type="date" id="fecha_termino" v-model="fecha_termino" class="form-control">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                        <button type="button"  class="btn btn-primary btn-sm" @click.prevent="agregarChofer()">Guardar</button>

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
            trabajadores:[],
            buses:[],
            buses_trabajador:[],
            nombre_chofer:'',
            trabajador_id:0,
            tipos:[
                'jefe de maquina',
                'jefe maquina temporal',
                'jefe de maquina prueba'
            ],
            tipo_chofer:'',
            bus_id:'',
            fecha_termino:'',
            fecha_inicio:'',
            editar:false,
            crear:false,
            id:0,
            alerta:'',
            mensajes:'',
            inputClass:'form-control mb-4',
            errorsClass:'',
            respuesta:false,
            paginate:['trabajadores'],
            perpage:20,
            isLoading: false,
            fullPage: true,
            active:true
        }
    },
    mounted() {
       this.cargarTablaTrabajadores()
        this.getBuses()
        this.cargarBusesChofresTabla()
    },
  updated() {
        this.refrescar()
    },
    methods: {
        refrescar:function(){
            //this.$refs.categorias.selectpicker('refresh')
            $(this.$refs.choferes).selectpicker('refresh')
            $(this.$refs.buses).selectpicker('refresh')
        },
        openModalCreate:function(){

            $('#trabajadorModal').modal('show')
        },
       async agregarChofer() {
          try{
              let formData = new FormData();
              let valor = this.validaciones();
              if (valor){
                  return;
              }
              formData.append('trabajador_id',this.trabajador_id)
              formData.append('bus_id',this.bus_id)
              formData.append('tipo_chofer',this.tipo_chofer)
              formData.append('fecha_inicio',this.fecha_inicio)
              formData.append('fecha_termino',this.fecha_termino)

              if(this.editar)
              {
                  formData.append('id_bus_trabajador',this.id)
              }

             const { status } =  await  axios.post('/agregar-jefe-maquina',formData)
              if (status === 200) {
                 this.$swal.fire({
                        title: 'Guardado!',
                        text: 'Se ha guardado correctamente',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    }).then((res) =>{
                     this.trabajador_id = 0
                     this.bus_id = 0
                     this.tipo_chofer = ''
                     this.fecha_termino = ''
                     this.fecha_inicio = ''
                     this.cargarBusesChofresTabla()
                     $('#trabajadorModal').modal('hide')
                 })

              }
          }catch (e) {
              this.$swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Algo salio mal!',
                })

          }
        },
        validaciones (){
            // trabajador id requerido
            if(this.trabajador_id === 0){
                this.$swal('Debe seleccionar un tripulante')

                return true;
            }
            // bus id requerido
            if(this.bus_id === 0){
                this.$swal('Debe seleccionar un bus')
                return true;
            }

            if (this.tipo_chofer === ''){
                this.$swal('Debe seleccionar tipo de conductor')
                return true;
            }

            if (this.fecha_inicio === ''){
                this.$swal('Debe seleccionar fecha de inicio')
                return true;
            }

            if(this.fecha_termino === ''){
                this.$swal('Debe seleccionar fecha de termino')
                return true;
            }

        },
        async getBuses (){

            await axios.get('/getBuses?operador=get').then((res)=>{
                this.buses = res.data.data
            }).catch((error)=>{
                console.log('error')
            })
        },
        //Solo choferes disponibles

        async cargarTablaTrabajadores (){
            this.isLoading = true;
            // simulate AJAX
            setTimeout(() => {
                this.isLoading = false
                this.active = false
            }, 2000)

            let url = '/getTripulacion?&filtros_cargos[contrato]=3&opcion=2'

            if(this.nombre_chofer !== ''){
                url = url+'&'+'filtro[primer_nombre]='+this.nombre_chofer
                this.nombre_chofer = ''
            }

            await axios.get(url).then((res)=>{
                this.trabajadores = res.data
            }).catch((error)=>{
                console.log(error)
            })

        },

        async cargarBusesChofresTabla(){
            await axios.get('/buses-tripulacion-jefe-maquina').then((res)=>{
                this.buses_trabajador = res.data
            }).catch(error=>{
                console.log(error)
            })
        },
        agregarJefeMaquina(){
            this.editar = false
            this.crear = true
            this.openModalCreate()
        },
        editarJefeMaquina (id){

            let trabajadores_buses = this.buses_trabajador.find((item) => item.buses_trabajador_id === id )
            console.log(trabajadores_buses)
            this.editar = true
            this.crear = false
            this.trabajador_id = trabajadores_buses.trabajador_id
            this.bus_id = trabajadores_buses.bus_id
            this.tipo_chofer = trabajadores_buses.tipo_chofer
            this.fecha_inicio = trabajadores_buses.fecha_inicio
            this.fecha_termino = trabajadores_buses.fecha_termino
            this.id = id

            this.openModalCreate()
        },
        async eliminarJefeMaquina(id){
          this.$swal.fire({
                title: '¿Estas seguro?',
                text: "No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar!'
            }).then(async (result) => {
                if (result.value) {
                    await axios.delete('/tripulacion/'+id).then((res)=>{
                        this.$swal.fire(
                            'Eliminado!',
                            'El registro ha sido eliminado.',
                            'success'
                        )
                        this.cargarBusesChofresTabla()
                    }).catch((error)=>{
                            console.log(error)
                        }
                    )
                  /*  axios.delete('/eliminar-jefe-maquina/'+id).then((res)=>{
                        this.cargarBusesChofresTabla()
                        this.$swal.fire(
                            'Eliminado!',
                            'El registro ha sido eliminado.',
                            'success'
                        )
                    }).catch((error)=>{
                        console.log(error)
                    })*/
                }

          })
        }
    },
}
</script>

<style scoped>
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
