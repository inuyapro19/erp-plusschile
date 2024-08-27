<template>
    <div class="col-lg-11 mx-auto">
        <button type="button" class="btn btn-success btn-sm" @click="openModalCreate"><i class="fa fa-plus"></i> Agregar</button>
        <div class="row mt-3">
            <div class="col-md-12">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                    <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        <tr v-for="(destino, index) in clientes">
                            <td>{{destino.id}}</td>
                            <td>{{destino.nombre_cliente}}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger" @click="openModalEliminar(destino.id)"  title="Eliminar"><i class="fa fa-trash"></i></button>
                                <button type="button" class="btn btn-sm btn-info"  @click="openModalEditar(destino.id)"   title="Editar"><i class="fa fa-edit"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="clienteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Cliente</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div :class="'alert '+alerta" v-if="respuesta">{{mensajes}}</div>
                                <label for="ciudad">Nombre Cliente</label>
                                <input type="text" v-model="nombre_cliente" id="cliente" class="form-control">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                        <button type="button" v-show="crear" class="btn btn-primary btn-sm" @click.prevent="agregarCliente()">Guardar</button>
                        <button type="button" v-show="editar" class="btn btn-primary btn-sm" @click.prevent="editarClinete(id)">Editar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="clienteEleminarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eliminarModalLabel">Eliminar Cliente</h5>
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
                        <button type="button" class="btn btn-primary btn-sm" @click.prevent="eliminarCliente(id)">Eliminar</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            clientes: [],
            editar:false,
            crear:false,
            id:0,
            alerta:'',
            mensajes:'',
            inputClass:'form-control mb-4',
            errorsClass:'',
            respuesta:false,
            ciudad:'',
            nombre_cliente:''
        }
    },
    mounted() {
        this.cargarClientes()
    },
    methods:{
        async cargarClientes(){
            await axios.get('/clientes').then(res=>{
                this.clientes = res.data
            })
        },
        openModalCreate:function(){
            this.editar = false
            this.crear = true
            this.nombre_area = ''
            $('#clienteModal').modal('show')
        },
        openModalEditar:function(id){
            this.crear = false
            this.editar = true
            this.id = id
            let cliente = this.clientes.find((item) => item.id === this.id);
            this.nombre_cliente = cliente.nombre_cliente
            $('#clienteModal').modal('show')
        },
        openModalEliminar:function(id){
            this.id = id
            //console.log(this.id)
            $('#clienteEleminarModal').modal('show')
        },
        async agregarCliente(){
            await axios.post('/clientes',{nombre_cliente:this.nombre_cliente}).then((res)=>{
                this.respuesta = true
                this.alerta= 'alert-success'
                this.mensajes = 'cliente Creado exitosamente'
                this.cargarClientes()
                this.nombre_cliente = '';
                $('#clienteModal').modal('hide')

            }).catch((error)=>{
                this.respuesta = true
                this.alerta= 'alert-danger'
                this.mensajes = 'Error al enviar el formulario'
                this.errorsClass = 'form-control is-invalid';

            })
        },
        async eliminarCliente(id){
            // alert(id)
            await axios.delete('/clientes/'+id).then((res)=>{
                this.respuesta = true
                this.alerta= 'alert-danger'
                this.mensajes = 'cliente eliminado exitosamente'
                this.cargarClientes()
            }).catch((error)=>{
                this.respuesta = true
                this.alerta= 'alert-danger'
                this.mensajes = 'Error al eliminar'
                // this.errorsClass = 'form-control is-invalid';
            })
        },
        async editarClinete(id)
        {
            await axios.post('/clientes/'+id,{nombre_cliente:this.nombre_cliente}).then((res)=>{
                this.respuesta = true
                this.alerta= 'alert-success'
                this.mensajes = 'cliente editado exitosamente'
                this.cargarClientes()
            }).catch((error)=>{
                this.respuesta = true
                this.alerta= 'alert-danger'
                this.mensajes = 'Error al editar'
                // this.errorsClass = 'form-control is-invalid';
            })
        }
    }
}
</script>

<style scoped>

</style>
