<template>
    <div>
        <div class="col-lg-11 mx-auto">
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" @click="openModalCreate()"><i class="fa fa-plus"></i> Agregar</button>
            <div class="row mt-3">
                <div class="col-md-12">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                        <thead>
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th>ID</th>
                                <th>Nacionalidad</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                            <tr v-for="(nacionalidades, index) in nacionalidad">
                                <td>{{nacionalidades.id}}</td>
                                <td>{{nacionalidades.descripcion_nacionalidad}}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-danger" @click="openModalEliminar(nacionalidades.id)" title="Eliminar"><i class="fa fa-trash"></i></button>
                                    <button type="button" class="btn btn-sm btn-info"   @click="openModalEditar(nacionalidades.id)"  title="Editar"><i class="fa fa-edit"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="nacionalidadModalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Nacionalidad</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div :class="'alert '+alerta" v-if="respuesta">{{mensajes}}</div>
                                <label for="descripcion_nacionalidad">Nacionalidad</label>
                                <input type="text" v-model="descripcion" id="descripcion_nacionalidad" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                        <button type="button" v-show="crear" class="btn btn-primary btn-sm" @click.prevent="agregarNacionalidad">Guardar</button>
                        <button type="button" v-show="editar" class="btn btn-primary btn-sm" @click.prevent="editarNacionalidad(id)">Editar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="nacionalidadModalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eliminarModalLabel">Eliminar Nacionalidad</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div :class="'alert '+alerta" v-if="respuesta">{{mensajes}}</div>
                                <p>¿Desea Eliminar Nacionalidad?</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary btn-sm" @click.prevent="eliminarNacionalidad(id)">Eliminar</button>

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
            nacionalidad: [],
            descripcion:'',
            alerta:'',
            mensajes:'',
            inputClass:'form-control mb-4',
            errorsClass:'',
            respuesta:false,
            editar:false,
            crear:false,
            id:0
        }
    },
    mounted() {
        this.cargarNacionalidad()
  },
    methods:{
       async cargarNacionalidad(){
           await axios.get('/nacionalidades').then(res=>{
                this.nacionalidad = res.data
            })
        },
        openModalCreate:function(){
            this.editar = false
            this.crear = true

            $('#nacionalidadModalAdd').modal('show')
        },
        openModalEditar:function(id){
            this.crear = false
            this.editar = true
            this.id = id
            let nacionalidades = this.nacionalidad.find((item) => item.id === this.id);
            this.descripcion = nacionalidades.descripcion_nacionalidad
            $('#nacionalidadModalAdd').modal('show')
        },
        openModalEliminar:function(id){
            this.id = id
            console.log(this.id)
            $('#nacionalidadModalDelete').modal('show')
        },
        async agregarNacionalidad(){
           await axios.post('/nacionalidades',{descripcion_nacionalidad:this.descripcion}).then((res)=>{
                this.respuesta = true
                this.alerta= 'alert-success'
                this.mensajes = 'Trabajador Creado exitosamente'
                this.cargarNacionalidad()
                this.descripcion = '';
                $('#nacionalidadModalAdd').modal('hide')

            }).catch((error)=>{
                this.respuesta = true
                this.alerta= 'alert-danger'
                this.mensajes = 'Error al enviar el formulario'
                this.errorsClass = 'form-control is-invalid';
                if (error.response.status === 422) {
                    this.mostarError = true
                    this.errors = error.response.data.errors || {};
                }
            })
        },
       async eliminarNacionalidad(id){
           // alert(id)
          await  axios.delete('/nacionalidades/'+id).then((res)=>{
                this.respuesta = true
                this.alerta= 'alert-danger'
                this.mensajes = 'Nacionalidad eliminada exitosamente'
                this.cargarNacionalidad()
            }).catch((error)=>{
                this.respuesta = true
                this.alerta= 'alert-danger'
                this.mensajes = 'Error al eliminar'
               // this.errorsClass = 'form-control is-invalid';
            })
        },
      async editarNacionalidad(id){
          await  axios.put('/nacionalidades/'+id,{descripcion_nacionalidad:this.descripcion}).then((res)=>{
                this.respuesta = true
                this.alerta= 'alert-success'
                this.mensajes = 'Nacionalidad editada exitosamente'
                this.cargarNacionalidad()
            }).catch((error)=>{
                this.respuesta = true
                this.alerta= 'alert-danger'
                this.mensajes = 'Error al editar Nacionalidad'
                // this.errorsClass = 'form-control is-invalid';
            })
        }
  }
}
</script>

<style scoped>

</style>
