<template>
    <div class="col-lg-11 mx-auto">
        <button type="button" class="btn btn-success btn-sm" @click="openModalCreate"><i class="fa fa-plus"></i> Agregar</button>
        <div class="row mt-3">
            <div class="col-md-12">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                    <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th>ID</th>
                            <th>Oficina</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        <tr v-for="(oficina, index) in oficinas">
                            <td>{{oficina.id}}</td>
                            <td>{{oficina.ciudad}}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger" @click="openModalEliminar(oficina.id)"  title="Eliminar"><i class="fa fa-trash"></i></button>
                                <button type="button" class="btn btn-sm btn-info"  @click="openModalEditar(oficina.id)"   title="Editar"><i class="fa fa-edit"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="OfinaModelAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Area</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div :class="'alert '+alerta" v-if="respuesta">{{mensajes}}</div>
                                <label for="nombre_area">Ofina</label>
                                <input type="text" v-model="oficina" id="nombre_area" class="form-control">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                        <button type="button" v-show="crear" class="btn btn-primary btn-sm" @click.prevent="agregarAreas">Guardar</button>
                        <button type="button" v-show="editar" class="btn btn-primary btn-sm" @click.prevent="editarAreas(id)">Editar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="OficinaModalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eliminarModalLabel">Eliminar Ofinas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div :class="'alert '+alerta" v-if="respuesta">{{mensajes}}</div>
                                <p>¿Desea Eliminar Oficinas?</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary btn-sm" @click.prevent="eliminarAreas(id)">Eliminar</button>

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
            oficinas: [],
            editar:false,
            crear:false,
            id:0,
            alerta:'',
            mensajes:'',
            inputClass:'form-control mb-4',
            errorsClass:'',
            respuesta:false,
            oficina:''
        }
    },
    mounted() {
        this.cargarOficinas()
    },
    methods:{
        async cargarOficinas(){
            await axios.get('/getOficinas').then(res=>{
                this.oficinas = res.data
            }).catch(error=>{
                console.log('error')
            })
        },
        openModalCreate:function(){
            this.editar = false
            this.crear = true
            this.oficina = ''
            $('#OfinaModelAdd').modal('show')
        },
        openModalEditar:function(id){
            this.crear = false
            this.editar = true
            this.id = id
            let area = this.oficinas.find((item) => item.id === this.id);
            this.oficina = area.ciudad
            $('#OfinaModelAdd').modal('show')
        },
        openModalEliminar:function(id){
            this.id = id
            //console.log(this.id)
            $('#OficinaModalDelete').modal('show')
        },
        async agregarOficina(){
            await axios.post('/oficinas',{oficina:this.oficina}).then((res)=>{
                this.respuesta = true
                this.alerta= 'alert-success'
                this.mensajes = 'Oficina Creada exitosamente'
                this.cargarOficinas()
                this.descripcion = '';
                $('#AreasModelAdd').modal('hide')

            }).catch((error)=>{
                this.respuesta = true
                this.alerta= 'alert-danger'
                this.mensajes = 'Error al enviar el formulario'
                this.errorsClass = 'form-control is-invalid';

            })
        },
        async eliminarAreas(id){
            // alert(id)
            await axios.delete('/oficinas/'+id).then((res)=>{
                this.respuesta = true
                this.alerta= 'alert-danger'
                this.mensajes = 'Oficina eliminada exitosamente'
                this.cargarOficinas()
            }).catch((error)=>{
                this.respuesta = true
                this.alerta= 'alert-danger'
                this.mensajes = 'Error al eliminar'
                // this.errorsClass = 'form-control is-invalid';
            })
        },
        async editarAreas(id){
            await axios.put('/oficinas/'+id,{oficina:this.oficina}).then((res)=>{
                this.respuesta = true
                this.alerta= 'alert-success'
                this.mensajes = 'Oficina editada exitosamente'
                this.cargarOficinas()
            }).catch((error)=>{
                this.respuesta = true
                this.alerta= 'alert-danger'
                this.mensajes = 'Error al editar Oficinas'
                // this.errorsClass = 'form-control is-invalid';
            })
        }
    }
}
</script>

<style scoped>

</style>
