<template>
    <div class="col-lg-11 mx-auto">
        <button type="button" class="btn btn-success btn-sm" @click="modal_agregar_abrir"><i class="fa fa-plus"></i> Agregar</button>
        <div class="row mt-3">
            <div class="col-md-4">
                <select class="form-control form-control-sm" v-model="estado_filtro" @change.prevent="getBonos">
                    <option value="">--------</option>
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                </select>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                    <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th>ID</th>
                            <th>Descripcion</th>
                            <th>Monto</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        <tr v-for="(bono, index) in bonos">
                            <td>{{bono.id}}</td>
                            <td>{{bono.descripcion}}</td>
                            <td>{{bono.monto}}</td>

                            <td v-if="bono.estado === 'activo' "><span class="badge badge-success">{{bono.estado}}</span></td>
                            <td v-else><span class="badge badge-danger">{{bono.estado}}</span></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger" @click="eliminar_bono(bono.id)"  title="Eliminar"><i class="fa fa-trash"></i></button>
                                <button type="button" class="btn btn-sm btn-info"   @click="modal_agregar_abrir(bono.id)" title="Editar"><i class="fa fa-edit"></i></button>
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="anticiposModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Anticipos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-12">
                                <label for="descripcion_bono">Descripcion</label>
                                <input type="text" id="descripcion_bono" v-model='descripcion_bono' class="form-control">
                            </div>

                            <div class="col-md-12 mt-2">
                                <label for="monto">Monto</label>
                                <input type="text" id="monto" v-model='monto' class="form-control">
                            </div>

                        </div>
                        <div class="row mt-3" v-if="editar">
                            <div class="col-md-5">
                                <label for="tiene_licencia_conducir" class="form-check-label">Cambio de estado</label>
                            </div>
                            <div class="col-md-3">

                                <label class="switch s-icons s-outline s-outline-success  mr-2">
                                    <input type="checkbox" id="tiene_licencia_conducir" v-model="estado" :value="estado"   checked>
                                    <span class="slider"></span>
                                </label>
                            </div>
                            <div class="col-md-4">

                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                        <button type="button" @click.prevent="enviar_formulario"  class="btn btn-primary btn-sm">Guardar</button>

                    </div>
                </div>
            </div>
        </div>


    </div>
</template>

<script>
export default {
    name: "anticipos",
    data() {
        return {
            bonos: [],
            descripcion_bono:'',
            monto:0,
            id:0,
            editar:false,
            estado:true,
            estado_filtro:'activo'
        }
    },
    mounted() {
        this.getBonos()
    },
    methods:{
        async getBonos(){
            //bonos paginados de 10 en 10
            let url = '/anticipo-disponibles?opciones=paginate'

            if (this.estado_filtro){
                url = url +'&estado=' +this.estado_filtro
            }

            await axios.get(url).then(res =>{
                this.bonos = res.data.data
            }).catch(error=>{
                console.log('error')
            })
        },
        modal_agregar_abrir(id = 0){

            console.log(id)

            this.descripcion_bono = ''
            this.monto = 0

            this.id = id
            if (this.id > 0){
                this.editar = true
                let bono = this.bonos.find((item) => item.id === id)

                this.descripcion_bono = bono.descripcion
                this.monto = bono.monto

                this.estado = bono.estado === 'activo' ? true : false
            }else{
                this.editar = false
            }

            $('#anticiposModal').modal('show')
        },
        async enviar_formulario(){
            let url = '/agregar-anticipos'

            if(this.editar){
                url = url + '/'+this.id
            }



            axios.post(url,{
                descripcion:this.descripcion_bono,
                monto:this.monto,

                estado:this.estado
            }).then( res =>{
                this.resetear_form()
                this.$swal('Anticipo Agregado')
                this.getBonos()
                $('#anticiposModal').modal('hide')
            }).catch(error=>{
                this.$swal('Error al enviar Formulario')
            })
        },
        async eliminar_bono(id){
            await axios.delete('/eliminar-anticipo/'+id).then(res => {
                this.$swal('Registro eliminado correctamente')
                this.getBonos()
            }).catch(error =>{
                this.$swal('Error al eliminar registros')
            })
        },
        resetear_form(){
            this.descripcion_bono = ''
            this.monto = 0
            this.id = 0
            this.editar = false
        }
    }
}
</script>

<style scoped>

</style>
