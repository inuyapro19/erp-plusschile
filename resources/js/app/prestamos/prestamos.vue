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
                <table class="table table-striped">
                    <thead>
                    <th>ID</th>
                    <th>Descripcion</th>
                    <th>Monto</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                    </thead>
                    <tbody >
                    <tr v-for="(prestamo, index) in prestamos">
                        <td>{{prestamo.id}}</td>
                        <td>{{prestamo.descripcion}}</td>
                        <td>{{prestamo.monto}}</td>

                        <td v-if="prestamo.estado === 'pagado' "><span class="badge badge-success">{{prestamo.estado}}</span></td>
                        <td v-else><span class="badge badge-danger">{{prestamo.estado}}</span></td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger" @click="eliminar_bono(prestamo.id)"  title="Eliminar"><i class="fa fa-trash"></i></button>
                            <button type="button" class="btn btn-sm btn-info"   @click="modal_agregar_abrir(prestamo.id)" title="Editar"><i class="fa fa-edit"></i></button>
                        </td>
                    </tr>
                    </tbody>

                </table>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="prestamosModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Prestamos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mt-2">
                                <label for="monto">Monto</label>
                                <select name="trabajador_id" class="form-control selectpicker" v-model="trabajador_id" ref="trabajadores" data-size="10"  data-live-search="true" id="choferes_select">
                                    <option value="">--------</option>
                                    <option v-for="(trabajador, index) in trabajadores"  :value="trabajador.id">{{trabajador.rut+' '+trabajador.primer_nombre +' '+ trabajador.primer_apellido + ' ' +trabajador.segundo_apellido}}</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label for="descripcion_bono">Descripcion</label>
                                <input type="text" id="descripcion_bono" v-model='descripcion' class="form-control">
                            </div>

                            <div class="col-md-12 mt-2">
                                <label for="monto">Monto</label>
                                <input type="text" id="monto" v-model='monto' class="form-control">
                            </div>

                            <div class="col-md-12 mt-2">
                                <label for="cuotas">Cuotas</label>
                                <input type="text" id="cuotas" v-model='cuotas' class="form-control">
                            </div>

                            <div class="col-md-12 mt-2">
                                <label for="tipo">Tipo</label>
                                <select v-model="tipo" id="tipo" class="form-control">
                                    <option value="">---------</option>
                                    <option value="caja">CAJA</option>
                                    <option value="empresa">Empresa</option>
                                </select>
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="periodo_pago">Periodo de pago</label>
                                <select v-model="periodo_pago" id="periodo_pago" class="form-control">
                                    <option value="">---------</option>

                                </select>
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="cuota_inicial">Cuota Inicial</label>
                                <input type="text" id="cuota_inicial" v-model='cuota_inicial' class="form-control">
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
    name: "prestamos",
    data() {
        return {
            prestamos: [],
            monto:0,
            cuotas:0,
            tipos:[],
            tipo:'',
            trabajador_id:0,
            descripcion:'',
            periodo_pago:'',
            cuota_inicial:0,
            editar:false,
            estado:true,
            estado_filtro:'',
            trabajadores:[]
        }
    },
    mounted() {
        this.getBonos()
        this.getTrabajadores()
    },
    updated() {
        this.refrescar()
    },
    methods:{
        refrescar:function(){
            $(this.$refs.trabajador).selectpicker('refresh')
        },
        getTrabajadores:function (){
            axios.get('/lista-trabajadores').then((res)=>{
                this.trabajadores = res.data
            }).catch((error)=>{
                console.log(error)
            })
        },
        async getPrestamos(){
            //bonos paginados de 10 en 10
            let url = '/prestamos-disponibles?opciones=paginate'

            if (this.estado_filtro){
                url = url +'&estado=' +this.estado_filtro
            }

            await axios.get(url).then(res =>{
                this.prestamos = res.data.data
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
