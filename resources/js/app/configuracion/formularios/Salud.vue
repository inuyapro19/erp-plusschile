<template>
    <div class="col-lg-11 mx-auto">
        <button type="button" class="btn btn-success btn-sm" @click="openModalCreate"><i class="fa fa-plus"></i> Agregar</button>
        <div class="row mt-3">
            <div class="col-md-12">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                    <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th>ID</th>
                            <th>Salud</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        <tr v-for="(salud, index) in salud">
                            <td>{{salud.id}}</td>
                            <td>{{salud.nombre_salud}}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger" @click="openModalEliminar(salud.id)"  title="Eliminar"><i class="fa fa-trash"></i></button>
                                <button type="button" class="btn btn-sm btn-info"  @click="openModalEditar(salud.id)"   title="Editar"><i class="fa fa-edit"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="SaludModalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Institución de salud</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div :class="'alert '+alerta" v-if="respuesta">{{mensajes}}</div>
                                <label for="nombre_salud">Institución de Salud</label>
                                <input type="text" v-model="nombre_salud" id="nombre_salud" class="form-control">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                        <button type="button" v-show="crear" class="btn btn-primary btn-sm" @click.prevent="agregarSalud">Guardar</button>
                        <button type="button" v-show="editar" class="btn btn-primary btn-sm" @click.prevent="editarSalud(id)">Editar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="SaludModalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eliminarModalLabel">Eliminar Institución Salud</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div :class="'alert '+alerta" v-if="respuesta">{{mensajes}}</div>
                                <p>¿Desea Eliminar Salud?</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary btn-sm" @click.prevent="eliminarSalud(id)">Eliminar</button>

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
            salud: [],
            editar:false,
            crear:false,
            id:0,
            alerta:'',
            mensajes:'',
            inputClass:'form-control mb-4',
            errorsClass:'',
            respuesta:false,
            nombre_salud:''
        }
    },
    mounted() {
        this.cargarSalud()
    },
    methods:{
       async cargarSalud (){
          await axios.get('/salud').then(res=>{
               this.salud = res.data
           })
       },
        openModalCreate:function(){
            this.editar = false
            this.crear = true
            this.nombre_salud = ''
            $('#SaludModalAdd').modal('show')
        },
        openModalEditar:function(id){
            this.crear = false
            this.editar = true
            this.id = id
            let salud = this.salud.find((item) => item.id === this.id);
            this.nombre_salud = salud.nombre_salud

            $('#SaludModalAdd').modal('show')
        },
        openModalEliminar:function(id){
            this.id = id
            //console.log(this.id)
            $('#SaludModalDelete').modal('show')
        },
       async agregarSalud (){
          await  axios.post('/salud',{nombre_salud:this.nombre_salud}).then((res)=>{
                this.respuesta = true
                this.alerta= 'alert-success'
                this.mensajes = 'Salud Creada exitosamente'
                this.cargarSalud()
                this.descripcion = '';
                $('#SaludModalAdd').modal('hide')

            }).catch((error)=>{
                this.respuesta = true
                this.alerta= 'alert-danger'
                this.mensajes = 'Error al enviar el formulario'
                this.errorsClass = 'form-control is-invalid';

            })
        },
        async eliminarSalud(id){
            // alert(id)
           await axios.delete('/salud/'+id).then((res)=>{
                this.respuesta = true
                this.alerta= 'alert-danger'
                this.mensajes = 'Prevision eliminada exitosamente'
                this.cargarSalud()
            }).catch((error)=>{
                this.respuesta = true
                this.alerta= 'alert-danger'
                this.mensajes = 'Error al eliminar'
                // this.errorsClass = 'form-control is-invalid';
            })
        },
       async editarSalud (id){
          await  axios.put('/salud/'+id,{nombre_salud:this.nombre_salud}).then((res)=>{
                this.respuesta = true
                this.alerta= 'alert-success'
                this.mensajes = 'Salud editada exitosamente'
                this.cargarSalud()
            }).catch((error)=>{
                this.respuesta = true
                this.alerta= 'alert-danger'
                this.mensajes = 'Error al editar Salud'
                // this.errorsClass = 'form-control is-invalid';
            })
        }
   }
}
</script>

<style scoped>

</style>
