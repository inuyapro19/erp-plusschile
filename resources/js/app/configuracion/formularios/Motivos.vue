<template>
    <div class="col-lg-11 mx-auto">
        <button type="button" class="btn btn-success btn-sm" @click="openModalCreate"><i class="fa fa-plus"></i> Agregar</button>
        <div class="row mt-3">
            <div class="col-md-12">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                    <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th>ID</th>
                            <th>Código</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(motivo, index) in motivos">
                        <td>{{motivo.id}}</td>
                        <td>{{motivo.codigo}}</td>
                        <td>{{motivo.descripcion}}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger" @click="openModalEliminar(motivo.id)"  title="Eliminar"><i class="fa fa-trash"></i></button>
                            <button type="button" class="btn btn-sm btn-info"  @click="openModalEditar(motivo.id)"   title="Editar"><i class="fa fa-edit"></i></button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="MotivoModelAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Motivo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div :class="'alert '+alerta" v-if="respuesta">{{mensajes}}</div>
                                <label for="codigo">Código </label>
                                <input type="text" v-model="codigo" id="codigo" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label for="descripcion">Descripcion</label>
                                <textarea name="descripcion" class="form-control" v-model="descripcion"id="descripcion" cols="30" rows="10"></textarea>

                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                        <button type="button" v-show="crear" class="btn btn-primary btn-sm" @click.prevent="agregarEmpleador">Guardar</button>
                        <button type="button" v-show="editar" class="btn btn-primary btn-sm" @click.prevent="editarEmpleador(id)">Editar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="MotivoModalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eliminarModalLabel">Eliminar Motivo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div :class="'alert '+alerta" v-if="respuesta">{{mensajes}}</div>
                                <p>¿Desea Eliminar Motivo?</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary btn-sm" @click.prevent="eliminarEmpleador(id)">Eliminar</button>

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
            motivos:[],
            editar:false,
            crear:false,
            id:0,
            alerta:'',
            mensajes:'',
            inputClass:'form-control mb-4',
            errorsClass:'',
            respuesta:false,
            codigo:'',
            descripcion:''
        }
    },
    mounted() {
     this.getMotivos()
    },
    methods:{
       async getMotivos(){
           await axios.get('/motivos').then((res)=>{
                this.motivos = res.data
            });
        },
        openModalCreate:function(){
            this.editar = false
            this.crear = true
            this.codigo_empleador = ''
            this.nombre_empresa = ''
            $('#MotivoModelAdd').modal('show')
        },
        openModalEditar:function(id){
            this.crear = false
            this.editar = true
            this.id = id
            let motivo = this.motivos.find((item) => item.id === this.id);
            this.codigo = motivo.codigo
            this.descripcion = motivo.descripcion

            $('#MotivoModelAdd').modal('show')
        },
        openModalEliminar:function(id){
            this.id = id
            //console.log(this.id)
            $('#MotivoModalDelete').modal('show')
        },
       async agregarEmpleador(){
           await axios.post('/motivos',{codigo:this.codigo,descripcion:this.descripcion}).then((res)=>{
                this.respuesta = true
                this.alerta= 'alert-success'
                this.mensajes = 'Motivo Creada exitosamente'
                this.getMotivos()
                this.codigo_empleador = '';
                this.nombre_empresa = '';
                $('#EmpleadorModelAdd').modal('hide')

            }).catch((error)=>{
                this.respuesta = true
                this.alerta= 'alert-danger'
                this.mensajes = 'Error al enviar el formulario'
                this.errorsClass = 'form-control is-invalid';
            })
        },
       async eliminarEmpleador(id){
            // alert(id)
           await axios.delete('/motivos/'+id).then((res)=>{
                this.respuesta = true
                this.alerta= 'alert-danger'
                this.mensajes = 'Ubicación eliminada exitosamente'
                this.getMotivos()
            }).catch((error)=>{
                this.respuesta = true
                this.alerta= 'alert-danger'
                this.mensajes = 'Error al eliminar'
                // this.errorsClass = 'form-control is-invalid';
            })
        },
        async editarEmpleador(id){
           await axios.put('/motivos/'+id,{codigo:this.codigo,descripcion:this.descripcion}).then((res)=>{
                this.respuesta = true
                this.alerta= 'alert-success'
                this.mensajes = 'Motivo editada exitosamente'
                this.getMotivos()
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
