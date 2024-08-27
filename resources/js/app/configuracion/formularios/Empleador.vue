<template>
    <div class="col-lg-11 mx-auto">
        <button type="button" class="btn btn-success btn-sm" @click="openModalCreate"><i class="fa fa-plus"></i> Agregar</button>
        <div class="row mt-3">
            <div class="col-md-12">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                    <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">                            <th>ID</th>
                            <th>Código</th>
                            <th>Empleador</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        <tr v-for="(empleador, index) in empleadores">
                            <td>{{empleador.id}}</td>
                            <td>{{empleador.codigo_empresa}}</td>
                            <td>{{empleador.nombre_empleador}}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger" @click="openModalEliminar(empleador.id)"  title="Eliminar"><i class="fa fa-trash"></i></button>
                                <button type="button" class="btn btn-sm btn-info"  @click="openModalEditar(empleador.id)"   title="Editar"><i class="fa fa-edit"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


        <BootstrapModal
            :id="'EmpleadorModelAdd'"
            :title="'Agregar Empleador'"
            :customClass="'modal-md'"
            :hideCloseButton="false"
            :onCloseButton="cerrarModal"
        >
            <template #body>
                <div class="row">
                    <div class="col-md-12">
                        <div :class="'alert '+alerta" v-if="respuesta">{{mensajes}}</div>
                        <label for="codigo_empleador">Código Empleador</label>
                        <input type="text" v-model="codigo_empleador" id="codigo_empleador" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <label for="rut_empleador">RUT Empleador</label>
                        <input type="text" v-model="rut_empresa" id="rut_empleador" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <label for="nombre_empresa">Nombre Empleador</label>
                        <input type="text" v-model="nombre_empresa" id="nombre_empresa" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <label for="direccion">Dirección </label>
                        <input type="text" v-model="direccion" id="direccion" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <label for="comuna">Comuna </label>
                        <input type="text" v-model="comuna" id="comuna" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <label for="rut_representate">Rut representante legal </label>
                        <input type="text" v-model="rut_representante" id="rut_representate" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <label for="representante_legal">Representante legal </label>
                        <input type="text" v-model="representante_legal" id="representante_legal" class="form-control">
                    </div>
                </div>
            </template>
            <template #footer>
                <button type="button" class="btn btn-secondary btn-sm" @click="cerrarModal">Cerrar</button>
                <button type="button" v-show="crear" class="btn btn-primary btn-sm" @click.prevent="agregarEmpleador">Guardar</button>
                <button type="button" v-show="editar" class="btn btn-primary btn-sm" @click.prevent="agregarEmpleador(id)">Editar</button>
            </template>
        </BootstrapModal>
        <!-- Modal -->
        <div class="modal fade" id="EmpleadorModalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eliminarModalLabel">Eliminar Ubicación</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div :class="'alert '+alerta" v-if="respuesta">{{mensajes}}</div>
                                <p>¿Desea Eliminar Empleador?</p>
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
import BootstrapModal from '../../../components/modalComponent.vue';
import Paginate   from "../../../components/paginate.vue";
export default {
    components:{
        BootstrapModal,
        Paginate
    },
    data() {
        return {
            empleadores:[],
            editar:false,
            crear:false,
            id:0,
            alerta:'',
            mensajes:'',
            inputClass:'form-control mb-4',
            errorsClass:'',
            respuesta:false,
            codigo_empleador:'',
            nombre_empresa:'',
            rut_empresa:'',
            direccion:'',
            comuna:'',
            rut_representante:'',
            representante_legal:''
        }
    },
    mounted() {
        this.cargarEmpleador()
    },
    methods:{
       async cargarEmpleador(){
          await  axios.get('/empleador').then(res=>{
                this.empleadores = res.data
            })
        },
        openModalCreate:function(){
            this.editar = false
            this.crear = true
            this.codigo_empleador = ''
            this.nombre_empresa = ''
            $('#EmpleadorModelAdd').modal('show')
        },
        openModalEditar:function(id){
            this.crear = false
            this.editar = true
            this.id = id
            let empleador = this.empleadores.find((item) => item.id === this.id);
            this.codigo_empleador = empleador.codigo_empresa
            this.nombre_empresa = empleador.nombre_empleador
            this.rut_empresa = empleador.rut
            this.direccion = empleador.direccion
            this.comuna = empleador.comuna

            $('#EmpleadorModelAdd').modal('show')
        },
        openModalEliminar:function(id){
            this.id = id
            //console.log(this.id)
            $('#EmpleadorModalDelete').modal('show')
        },
        async agregarEmpleador(id = 0){
           console.log(id)
           let url = '/empleadores'
            const formData = new FormData();

            formData.append('codigo_empresa', this.codigo_empleador);
            formData.append('nombre_empleador', this.nombre_empresa);
            formData.append('rut_empresa', this.rut_empresa);
            formData.append('direccion', this.direccion);
            formData.append('comuna', this.comuna);
            formData.append('rut_representante', this.rut_representante);
            formData.append('representante_legal', this.representante_legal);

            if (id > 0) {
                console.log('editar')
                url = '/empleadores/'+id
            }

           await axios.post(url,formData).then((res)=>{
                this.respuesta = true
                this.alerta= 'alert-success'
                this.mensajes = 'Empleador Creado exitosamente'
                this.cargarEmpleador()
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
           await axios.delete('/empleadores/'+id).then((res)=>{
                this.respuesta = true
                this.alerta= 'alert-danger'
                this.mensajes = 'Empleador eliminada exitosamente'
                this.cargarEmpleador()
            }).catch((error)=>{
                this.respuesta = true
                this.alerta= 'alert-danger'
                this.mensajes = 'Error al eliminar'
                // this.errorsClass = 'form-control is-invalid';
            })
        },

        cerrarModal()
        {
            this.mensajes = ''
            this.respuesta = false
            this.errorsClass = ''
            this.resetForm()
            $('#EmpleadorModelAdd').modal('hide')
        },
        resetForm(){
            this.codigo_empleador = '';
            this.nombre_empresa = '';
            this.rut_empresa = '';
            this.direccion = '';
            this.comuna = '';
            this.rut_representante = '';
            this.representante_legal = '';
        }
    }
}
</script>

<style scoped>

</style>
