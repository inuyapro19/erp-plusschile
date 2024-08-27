<template>
    <div class="col-lg-11 mx-auto">
        <button type="button" class="btn btn-success btn-sm" @click="openModalCreate"><i class="fa fa-plus"></i> Agregar</button>
        <div class="row mt-3">
            <div class="col-md-12">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                    <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th>ID</th>
                            <th>AFP</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        <tr v-for="(inp, index) in prevision">
                            <td>{{inp.id}}</td>
                            <td>{{inp.nombre}}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger" @click="openModalEliminar(inp.id)" title="Eliminar"><i class="fa fa-trash"></i></button>
                                <button type="button" class="btn btn-sm btn-info"  @click="openModalEditar(inp.id)"   title="Editar"><i class="fa fa-edit"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="PrevisionInpModalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Previsión</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div :class="'alert '+alerta" v-if="respuesta">{{mensajes}}</div>
                                <label for="codigo">Código</label>
                                <input type="text" v-model="codigo" id="codigo" class="form-control">
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="nombre_prevision">Previsión</label>
                                    <input type="text" class="form-control" id="nombre_prevision" v-model="nombre_prevision">
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                        <button type="button" v-show="crear" class="btn btn-primary btn-sm" @click.prevent="agregarPrevision">Guardar</button>
                        <button type="button" v-show="editar" class="btn btn-primary btn-sm" @click.prevent="editarPrevision(id)">Editar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="PrevisionInpModalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eliminarModalLabel">Eliminar Previsión</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div :class="'alert '+alerta" v-if="respuesta">{{mensajes}}</div>
                                <p>¿Desea Eliminar Previsión?</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary btn-sm" @click.prevent="eliminarPrevision(id)">Eliminar</button>

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
            prevision: [],
            editar:false,
            crear:false,
            id:0,
            alerta:'',
            mensajes:'',
            inputClass:'form-control mb-4',
            errorsClass:'',
            respuesta:false,
            codigo:'',
            nombre_prevision:'',

        }
    },
    mounted() {
        this.cargarPrevicion()
    },
    methods:{
      async cargarPrevicion(){
           await axios.get('/prevision_inp').then(res=>{
                this.prevision = res.data
            })
        },
        openModalCreate:function(){
            this.editar = false
            this.crear = true
            this.codigo =''
            this.nombre_prevision = ''
            $('#PrevisionInpModalAdd').modal('show')
        },
        openModalEditar:function(id){
            this.crear = false
            this.editar = true
            this.id = id
            let prevision = this.prevision.find((item) => item.id === this.id);
            this.codigo = prevision.codigo
            this.nombre_prevision = prevision.nombre

            $('#PrevisionInpModalAdd').modal('show')
        },
        openModalEliminar:function(id){
            this.id = id
            //console.log(this.id)
            $('#PrevisionInpModalDelete').modal('show')
        },
       async agregarPrevision(){
          await  axios.post('/previsiones_inp',{codigo:this.codigo, nombre:this.nombre_prevision}).then((res)=>{
                this.respuesta = true
                this.alerta= 'alert-success'
                this.mensajes = 'Previsión Creada exitosamente'
                this.cargarPrevicion()
                this.descripcion = '';
                $('#PrevisionModalAdd').modal('hide')

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
       async eliminarPrevision(id){
            // alert(id)
           await axios.delete('/previsiones_inp/'+id).then((res)=>{
                this.respuesta = true
                this.alerta= 'alert-danger'
                this.mensajes = 'Prevision eliminada exitosamente'
                this.cargarPrevicion()
            }).catch((error)=>{
                this.respuesta = true
                this.alerta= 'alert-danger'
                this.mensajes = 'Error al eliminar'
                // this.errorsClass = 'form-control is-invalid';
            })
        },
        editarPrevision:function (id){
            axios.put('/previsiones_inp/'+id,{codigo:this.codigo, nombre:this.nombre_prevision}).then((res)=>{
                this.respuesta = true
                this.alerta= 'alert-success'
                this.mensajes = 'Previsión editada exitosamente'
                this.cargarPrevicion()
            }).catch((error)=>{
                this.respuesta = true
                this.alerta= 'alert-danger'
                this.mensajes = 'Error al editar Cargo'
                // this.errorsClass = 'form-control is-invalid';
            })
        }
    }
}
</script>

<style scoped>

</style>
