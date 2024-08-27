<template>
    <div class="col-lg-11 mx-auto">
        <button type="button" class="btn btn-success btn-sm" @click="openModalCreate"><i class="fa fa-plus"></i> Agregar Ruta</button>
        <button class="btn btn-warning btn-sm" @click="abrirModelTramo()">Agregar Tramo</button>
        <div class="row mt-3">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                    <th>ID</th>
                    <th>Ciudad Origen</th>
                    <th>Ciudad Destino</th>
                    <th>Horas</th>
                    <th>Acciones</th>
                    </thead>
                    <tbody>
                    <tr v-for="(destino, index) in destinos">
                        <td>{{destino.ID_TRAMO}}</td>
                        <td>{{destino.CIUDAD_ORIGEN}}</td>
                        <td>{{destino.CIUDAD_DESTINO}}</td>
                        <td>{{destino.HORAS_VIAJE}} HRS</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger" @click="openModalEliminar(destino.ID_TRAMO)"  title="Eliminar"><i class="fa fa-trash"></i></button>
                            <button type="button" class="btn btn-sm btn-info"  @click="openModalEditar(destino.ID_TRAMO)"   title="Editar"><i class="fa fa-edit"></i></button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="destinosModelAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Ruta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div :class="'alert '+alerta" v-if="respuesta">{{mensajes}}</div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="ciudad">Ciudad Origen</label>
                                <select v-model="origen_id" class="form-control" id="">
                                    <option v-for="ciudad in ciudad_origen" :value="ciudad.id">{{ciudad.ciudad}}</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="ciudad">Ciudad Destino</label>
                                <select v-model="destino_id" class="form-control" id="">
                                    <option v-for="ciudad in ciudad_destinos" :value="ciudad.id">{{ciudad.ciudad}}</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="ciudad">Tramos</label>
                                <select v-model="tramo_id" class="form-control" id="">
                                    <option v-for="tramo in tramos" :value="tramo.id">{{tramo.tramo}}</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="ciudad">Horas</label>
                                <input type="number" v-model="horas" class="form-control">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                        <button type="button" v-show="crear" class="btn btn-primary btn-sm" @click.prevent="agregarDestinos">Guardar</button>
                        <button type="button" v-show="editar" class="btn btn-primary btn-sm" @click.prevent="editarDestinos(id)">Editar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="DestinoModalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eliminarModalLabel">Eliminar Destinos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div :class="'alert '+alerta" v-if="respuesta">{{mensajes}}</div>
                                <p>¿Desea Eliminar Destinos?</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary btn-sm" @click.prevent="eliminarDestinos(id)">Eliminar</button>

                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="tramoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Tramo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div :class="'alert '+alerta" v-if="respuesta">{{mensajes}}</div>
                        <div class="row">

                            <div class="col-md-12">
                                <label for="ciudad">Tramo</label>
                                <input type="text" v-model="tramo_add" class="form-control">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                        <button type="button"  class="btn btn-primary btn-sm" @click.prevent="agregarTramo()">Guardar</button>

                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    components: {},
    data() {
        return {
            destinos: [],
            editar:false,
            crear:false,
            id:0,
            alerta:'',
            mensajes:'',
            inputClass:'form-control mb-4',
            errorsClass:'',
            respuesta:false,
            ciudad:'',
            destino_id:0,
            origen_id:0,
            ciudad_destinos:[],
            ciudad_origen:[],
            horas:0,
            tramos:[],
            tramo_id:0,
            tramo_add:''
        }
    },
    mounted() {
        this.cargarDestinos()
        this.getDestinos()
        this.getOrigenes()
        this.cargarTramos()
    },
    methods:{
        async cargarDestinos(){
            await axios.get('/getRutas?opcion=2').then(res=>{
                this.destinos = res.data
            })
        },
        async getDestinos(){
            await axios.get('/destinos').then(res=>{
                this.ciudad_destinos = res.data
            })
        },
        async getOrigenes(){
            await axios.get('/destinos').then(res=>{
                this.ciudad_origen = res.data
            })
        },
        async cargarTramos(){
            await axios.get('/getTramos').then((res)=>{
                this.tramos = res.data
            }).catch(error=>{
                console.log(error)
            })
        },
        openModalCreate:function(){
            this.editar = false
            this.crear = true
            this.origen_id = 0
            this.destino_id = 0
            this.horas = 0
            //this.tramos = ''
            this.tramo_id = 0
            $('#destinosModelAdd').modal('show')
        },
        openModalEditar:function(id){
            this.crear  = false
            this.editar = true
            this.id = id
            const { ORIGEN_ID , DESTINO_ID , HORAS_VIAJE , TRAMO_ID } = this.destinos.find((item) => item.ID_TRAMO === this.id);
            /*console.log(ORIGEN_ID , DESTINO_ID , HORAS_VIAJE , TRAMO_ID)*/
            this.origen_id  = ORIGEN_ID
            this.destino_id = DESTINO_ID
            this.horas      = HORAS_VIAJE
            this.tramo_id   = TRAMO_ID

            $('#destinosModelAdd').modal('show')
        },
        openModalEliminar:function(id){
            this.id = id
            //console.log(this.id)
            $('#DestinoModalDelete').modal('show')
        },
        async agregarDestinos(){
            await axios.post('/rutas',{
                origen_id: this.origen_id,
                destino_id: this.destino_id,
                horas:this.horas,
                tramo_espacial:this.tramo_id
            }).then((res)=>{
                this.respuesta = true
                this.alerta= 'alert-success'
                this.mensajes = 'Destino Creado exitosamente'
                this.cargarDestinos()

                this.origen_id = 0
                this.destino_id = 0
                this.horas = 0
                this.tramos = ''

                $('#DestinoModelAdd').modal('hide')

            }).catch((error)=>{
                this.respuesta = true
                this.alerta= 'alert-danger'
                this.mensajes = 'Error al enviar el formulario'
                this.errorsClass = 'form-control is-invalid';

            })
        },
        async eliminarDestinos(id){
            // alert(id)
            await axios.delete('/rutas/'+id).then((res)=>{
                this.respuesta = true
                this.alerta= 'alert-danger'
                this.mensajes = 'Destino eliminado exitosamente'
                this.cargarDestinos()
            }).catch((error)=>{
                this.respuesta = true
                this.alerta= 'alert-danger'
                this.mensajes = 'Error al eliminar'
                // this.errorsClass = 'form-control is-invalid';
            })
        },
        async editarDestinos(id)
        {
            await axios.post('/rutas/'+id,{
                origen_id: this.origen_id,
                destino_id: this.destino_id,
                horas:this.horas,
                tramo_espacial:this.tramos
            }).then((res)=>{
                this.respuesta = true
                this.alerta= 'alert-success'
                this.mensajes = 'Destino editado exitosamente'

                this.origen_id = 0
                this.destino_id = 0
                this.horas = 0
                this.tramos = ''

                this.cargarDestinos()
            }).catch((error)=>{
                this.respuesta = true
                this.alerta= 'alert-danger'
                this.mensajes = 'Error al editar'
                // this.errorsClass = 'form-control is-invalid';
            })
        },
        abrirModelTramo(){
            this.tramo_add = ''
            $('#tramoModal').modal('show')
        },
       async agregarTramo(){
            await axios.post('/tramos',{tramo:this.tramo_add}).then((res)=>{
                this.$swal('Tramo agregado')
                $('#tramoModal').modal('hide')
                this.cargarTramos()
            }).catch((error) =>{
                console.log(error)
            })
        }
    }
}
</script>

<style scoped>

</style>
