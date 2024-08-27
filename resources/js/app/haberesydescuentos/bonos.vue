<template>
    <div class="col-lg-11 mx-auto">
        <button type="button" class="btn btn-success btn-sm" @click="modal_agregar_abrir"><i class="fa fa-plus"></i> Agregar</button>
        <div class="row mt-3">
            <div class="col-md-4">
                <select class="form-control form-control-sm" v-model="estado_filtro" @change.prevent="getBonos">
                    <option value="">--------</option>
                    <option value="activo" selected>Activo</option>
                    <option value="inactivo">Inactivo</option>
                </select>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                    <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th>#</th>
                            <th v-if="datos.descripcion">Descripcion</th>
                            <th v-if="datos.monto">Monto</th>
                            <th v-if="datos.tipo">Tipo</th>
                            <th v-if="datos.factor">Factor</th>
                            <th v-if="datos.clasificacion">Clasificación</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        <tr v-for="(bono, index) in bonos">
                            <td>{{index+1}}</td>
                            <td v-if="datos.descripcion" >{{bono.DESCRIPCION}}</td>
                            <td v-if="datos.monto" >{{bono.MONTO}}</td>
                            <td v-if="datos.tipo" >{{bono.TIPO}}</td>
                            <td v-if="datos.factor">{{bono.FACTOR}}</td>
                            <td v-if="datos.clasificacion" >{{bono.CLASIFICACION}}</td>
                            <td v-if="bono.ESTADO === 'activo' "><span class="badge badge-success">{{bono.ESTADO}}</span></td>
                            <td v-else><span class="badge badge-danger">{{bono.ESTADO}}</span></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info"   @click="modal_agregar_abrir(bono.ID)" title="Editar"><i class="fa fa-edit"></i></button>
                                <button type="button" class="btn btn-sm btn-danger" @click="eliminar_bono(bono.ID)"  title="Eliminar"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" :id="modelName" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Bono</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-12" v-if="datos.descripcion">
                                <label for="descripcion_bono">Descripcion</label>
                                <input type="text" id="descripcion_bono" v-model='descripcion_bono' class="form-control">
                            </div>

                            <div class="col-md-12 mt-2" v-if="datos.monto">
                                <label for="monto">Monto</label>
                                <input type="text" id="monto" v-model='monto' class="form-control">
                            </div>

                            <div class="col-md-12 mt-2" v-if="datos.tipo">
                                <label for="monto">Tipo</label>
                                <select class="form-control" v-model="tipo" id="">
                                    <option value="">----------</option>
                                    <option v-for="tipo in tipos" :value="tipo">{{tipo}}</option>
                                </select>
                            </div>
                            <div class="col-md-12 mt-2" v-if="datos.clasificacion">
                                <label for="monto">Clasificación</label>
                                <select class="form-control" v-model="clasificacion" id="">
                                    <option value="">----------</option>
                                    <option v-for="clasificacion in clasificaciones" :value="clasificacion">{{clasificacion}}</option>
                                </select>
                            </div>
                            <div class="col-md-12 mt-2" v-if="datos.factor">
                                <label for="monto">Factor</label>
                                <input type="text" id="factor" v-model='factor' class="form-control">
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
    name: "bonos",
    props:{
        isBono:{
            type:Boolean,
            required:true,
            default:false
        },
        categoria:{
            type: String,
            required: true
        },
        modelName:{
            type:String,
            required:true
        },
        datos:{
            type:Object,
            required:false
        }
    },
    data() {
        return {
            bonos: [],
            descripcion_bono:'',
            monto:0,
            gratificacion:false,
            anticipable:false,
            tipos:['PROPORCIONAL','SIMPLE'],
            tipo:'',
            clasificaciones:['LIQUIDO','BRUTO','AJUSTE'],
            clasificacion:'',
            hora_extra:false,
            factor:0,
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
            let url;

            if (this.categoria == 'BONOS'){
                 url = '/bonos-disponibles?opciones=paginate'
            }

            if (this.categoria == 'ANTICIPOS'){
                url = '/anticipo-disponibles?opciones=paginate'
            }

            if (this.categoria == 'HORAS EXTRAS'){
                url = '/horas-extras-disponibles?opciones=paginate'
            }

            if (this.categoria == 'HABERES NO IMPONIBLES'){
                url = '/haberes-no-imponibles-disponibles?opciones=paginate'
            }

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
            this.tipo = ''
            this.clasificacion = ''
            this.gratificacion = false
            this.anticipable = false
            this.hora_extra = false
            this.id = id
            if (this.id > 0){
                this.editar = true
                let bono = this.bonos.find((item) => item.ID === id)

                this.descripcion_bono = bono.DESCRIPCION
                this.monto = bono.MONTO ? bono.MONTO : 0
                this.tipo = bono.TIPO ? bono.TIPO : ''
                this.clasificacion = bono.CLASIFICACION ? bono.CLASIFICACION : ''
                this.factor = bono.FACTOR ? bono.FACTOR : 0
                this.gratificacion = bono.APLICA_GRATIFICACION === 'SI' ? true : false
                this.anticipable = bono.APLICA_ANTICIPABLE === 'SI' ? true : false
                this.hora_extra = bono.APLICA_HORA_EXTRA === 'SI' ? true : false
                this.estado = bono.ESTADO === 'activo' ? true : false
            }else{
                this.editar = false
            }

            $('#'+this.modelName).modal('show')
        },
        async enviar_formulario(){
            let url = '/agregar-bonos'

            if(this.editar){
                url = url + '/'+this.id
            }



            axios.post(url,{
                descripcion_bono:this.descripcion_bono,
                monto:this.monto,
                tipo:this.tipo,
                factor:this.factor,
                clasificacion:this.clasificacion,
                gratificacion:this.gratificacion,
                anticipable:this.anticipable,
                hora_extra:this.hora_extra,
                categoria:this.categoria,
                estado:this.estado
            }).then( res =>{
                this.resetear_form()
                this.$swal('Bono Agregado')
                this.getBonos()
                $('#'+this.modelName).modal('hide')
            }).catch(error=>{
                this.$swal('Error al enviar Formulario')
            })
        },
        async eliminar_bono(id){
            await axios.delete('/eliminar-bonos/'+id).then(res => {
                this.$swal('Registro eliminado correctamente')
                this.getBonos()
            }).catch(error =>{
                this.$swal('Error al eliminar registros')
            })
        },
        resetear_form(){
            this.descripcion_bono = ''
            this.monto = 0
            this.tipo = ''
            this.clasificacion = ''
            this.gratificacion = false
            this.anticipable = false
            this.hora_extra = false
            this.id = 0
            this.editar = false
        }
    }
}
</script>

<style scoped>

</style>
