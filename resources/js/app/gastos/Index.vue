<template>
    <div class="p-3">
        <CardComponent>
            <template #body>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="btn-group">
                            <button class="btn btn-success btn-sm" @click="filtrar = !filtrar"> <i class="fa fa-filter"></i> Filtrar</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                        <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th>NRO VIAJE</th>
                            <th>ORIGEN</th>
                            <th>DESTINO</th>
                            <th style="width:200px">TRIPULACIÓN</th>
                            <th>FOLIOS</th>
                            <th>MONTO TOTAL</th>
                            <th>FECHA SALIDA</th>
                            <th>FECHA LLEGADA</th>
                            <th>ESTADOS</th>
                            <th>ACCIONES</th>
                        </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                        <tr v-show="filtrar">
                            <td colspan="2">
                                <select-2
                                    v-model="viaje_id"
                                    :dataType="'number'"
                                    @select-changed="getGastos()"
                                >
                                    <option
                                        v-for="(viaje, index) in viajes"
                                        :key="viaje.id"
                                        :value="viaje.id">
                                        {{ viaje.nro_viaje }}
                                    </option>
                                </select-2>
                            </td>

                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr v-for="(gasto, index) in gasto_viaje.data">
                            <td>{{gasto.NUMERO_VIAJE}}</td>
                            <td>{{gasto.CIUDAD_ORIGEN}}</td>
                            <td>{{gasto.CIUDAD_DESTINO}}</td>
                            <td><div v-html="gasto.TRIPULACION"></div></td>
                            <td>{{gasto.FOLIOS}}</td>
                            <td class="monto-total">$ {{gasto.MONTO_TOTAL | formatPrice}}</td>
                            <td>{{gasto.FECHA_SALIDA | FormatoFecha}}</td>
                            <td>{{gasto.FECHA_LLEGADA | FormatoFecha}}</td>
                            <td v-if="gasto.ESTADO_CONCILIACION === 'CONCILIADO'">
                                <span class="badge badge-success">{{gasto.ESTADO_CONCILIACION}}</span>
                            </td>
                            <td v-if="gasto.ESTADO_CONCILIACION === 'NO CONCILIADO'">
                                <span class="badge badge-warning">{{gasto.ESTADO_CONCILIACION}}</span>
                            </td>
                            <td v-if="gasto.ESTADO_CONCILIACION === 'SALDO A DEVOLVER'">
                                <span class="badge badge-danger">{{gasto.ESTADO_CONCILIACION}}</span>
                            </td>
                            <td><button class="btn btn-sm btn-primary" @click="abrirModalMontoFolio(gasto.VIAJE_ID)"><i class="fa fa-edit"></i></button></td>
                        </tr>
                        </tbody>
                    </table>

                    <paginate :pagination="gasto_viaje" :onPageChange="getGastos"></paginate>

                </div>
            </template>
        </CardComponent>
        <!-- Modal -->
        <div class="modal fade" id="gastosModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Entregar monto</h5>
                        <button type="button" class="close" @click="cerrar_modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="">Nro de viaje</label>
                                <input type="text" class="form-control" v-model="nro_viaje" :disabled="true">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Folio</label>
                                <input type="text" class="form-control" v-model="folios" :disabled="true">
                            </div>

                            <div class="form-group col-md-12">
                                <label for="">Monto Entregado</label>
                                <input type="number" class="form-control" :disabled="true" v-model="monto_disponible">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Responsable</label>
                                <select v-model="tripulacion_id" :disabled="editar" class="form-control">
                                    <option value="">------</option>
                                    <option v-for="tripulacion in tripulaciones" :value="tripulacion.id">{{tripulacion.primer_nombre + ' ' + tripulacion.segundo_nombre + ' ' + tripulacion.primer_apellido + ' ' +tripulacion.segundo_apellido}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-warning">
                                    *Al ingresar el monto debe presionar enter para que calcule el total
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <button class="btn btn-primary btn-sm mb-1" :disabled="editar" @click="addDocumento()"><i class="fa fa-plus-circle"></i></button>
                            </div>
                        </div>
                        <div class="row">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <th>Nº documento</th>
                                    <th>Monto</th>
                                    <th>Tipo gastos</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </thead>
                                <tbody>
                                    <tr v-for="(documento, index) in documentos">
                                        <td>
                                            <input  class="form-control" type="text" v-model="documento.nro_documento" :disabled="editar">
                                        </td>
                                        <td>
                                            <input class="form-control" @keyup="calcular_total()" type="number" v-model="documento.monto_gasto" :disabled="editar">
                                        </td>
                                        <td>
                                            <select  class="form-control" v-model="documento.tipo_id" :disabled="editar">
                                                <option v-for="tipo in tipos" :value="tipo.id">{{tipo.tipo_name}}</option>
                                            </select>
                                        </td>
                                        <td><input type="date" v-model="documento.fecha" class="form-control" :disabled="editar"></td>
                                        <td>
                                            <button class="btn btn-danger btn-sm" :disabled="editar" @click.prevent="quitarDocumento(documento.id)"> <i class="fa fa-trash"></i></button>
                                        </td>

                                    </tr>
                                <tr>
                                    <td><span class="monto-final">Total ${{monto_disponible | formatPrice}} - </span></td>
                                    <td><span class="monto-final">$ {{total | formatPrice}}</span></td>
                                    <td> <span class="monto-final">=</span> </td>
                                    <td><span class="monto-final">$ {{total_final | formatPrice}}</span></td>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" @click="cerrar_modal">Cerrar</button>
                        <button type="button" :disabled="editar" class="btn btn-primary btn-sm" @click="enviar_formulario()" >Guardar</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";
import CardComponent from "../../components/CardComponent.vue";
import Select2 from "../../components/Form/Select2.vue";
import Paginate from "../../components/paginate.vue";
export default {
    components: {
        CardComponent,
        Select2,
        Paginate
    },
    data() {
        return {
            viajes: [],
            viaje_id:0,
            activar:false,
            nro_viaje:'',
            folio:0,
            folio_id:0,
            folios:'',
            documentos:[],
            pasajes:[],
            tipo_documento:[
                'GASTOS',
                'BOLETOS EN EL CAMINO'
            ],
            tipo_filtro:'',
            gastos:[],
            gasto_viaje:[],
            fecha_desde_filtro:'',
            fecha_hasta_filtro:'',
            estado_filtro:'',
            monto_disponible:0,
            tipos:[],
            monto_declarado:0,
            subtotal:0,
            total:0,
            estado:'',
            filtrar:false,
            tripulaciones:[],
            tripulacion_id:0,
            total_final:0,
            isSaldo:false,
            editar:false,
            page:0,
            page_class:'page-item active',
            monto_viaje:[],
            monto_viaje_id:0,

        }
    },
    mounted() {
        this.getViajes()
        this.getGastos()
        this.getGastoTipo()
        this.getMontoViajes()
    },
    updated() {
        this.refrescar()
    },
    methods: {
        refrescar:function(){
            $(this.$refs.nro_viajes).selectpicker('refresh')
            $(this.$refs.folios).selectpicker('refresh')
        },
       async getViajes(){
            try {
                let url = '/getViajes?opcion=get';

               /* if (this.estado_filtro !== ''){
                    url = url + '&filtro[estado]='+this.estado_filtro
                }*/

              const {data ,status} = await axios.get(url)

               if (status === 200){
                   this.viajes = data
               }

            }catch (error) {
                console.log(error)
            }
        },
        async getGastos(){
           try{
               let url = 'getGastos?opcion=1'

               if (this.viaje_id >0){
                   url = url + '&filtro[VIAJE_ID]='+this.viaje_id
               }

             const {data , status} =  await axios.get(url)
                if (status === 200){
                    this.gasto_viaje = data
                }
           }catch (error) {
               console.log(error)
           }
        },
        async getMontoViajes(){
            try{
               let url = '/getMontoViaje'


                const {data , status} =  await axios.get(url)

                if (status === 200){
                    this.monto_viaje = data
                }
            }catch (error) {
                console.log(error)
            }
        },
        async getGastoTipo(){
            await axios.get('/getGastoTipo').then((res)=>{
                this.tipos = res.data
            }).catch((error)=>{
                console.log(error)
            })
        },
        abrirModalMontoFolio(viaje_id){
            console.log(this.viajes)
            let data = this.viajes
                .find(({ id }) => id === viaje_id);
           // const data  = this.gasto_viaje
            let gasto_viaje = this.gasto_viaje.data.find(({ VIAJE_ID }) => VIAJE_ID === viaje_id);
            //console.log(gasto_viaje)
            this.folios = gasto_viaje.FOLIOS
            this.monto_disponible = gasto_viaje.MONTO_TOTAL
            this.monto_viaje_id = gasto_viaje.MONTO_VIAJE_ID
            let monto_viaje_id = gasto_viaje.MONTO_VIAJE_ID
            this.tripulacion_id = gasto_viaje.RESPONSABLE_ID
            this.viaje_id = viaje_id
            this.nro_viaje = data.nro_viaje
            this.tripulaciones = data.trabajadores;
            //estado
            this.estado = gasto_viaje.ESTADO_CONCILIACION
            //si hay gastos de viajes
            console.log(this.monto_viaje_id)
            //recorrer el array de monto_viaje y buscar el id del monto_viaje_id
            let monto_viaje = this.monto_viaje.filter((item) => item.monto_viaje_id === monto_viaje_id)



           console.log(monto_viaje)
            if (monto_viaje !== undefined){
                this.documentos.push(monto_viaje)
                //console.log(this.documentos[0])
                this.documentos = this.documentos[0]
               // this.editar = true
                this.calcular_total()
            }else{
                this.monto_declarado = 0
                this.subtotal = 0
                this.total = 0
                this.total_final = 0
                this.tripulacion_id = 0
                this.editar = false
            }

            $('#gastosModal').modal('show')
        },
       cerrar_modal(){
            $('#gastosModal').modal('hide')
            this.viaje_id = 0
            this.folio_id = 0
            this.nro_viaje = ''
            this.documentos = []
            this.total = 0
            this.monto_declarado = 0
            this.subtotal = 0
            this.monto_disponible = 0
            this.total_final = 0
            this.tripulacion_id = 0
           this.editar = false
        },
        addDocumento() {
            if (this.estado !== 'CONCILIADO') {
                const newDocumento = {
                    id: Math.random(),
                    nro_documento: '',
                    monto_gasto: 0,
                    tipo_id: 0,
                    fecha: ''
                }
                this.documentos.push(newDocumento)
            } else {
                this.$swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'No se puede agregar documentos a un viaje conciliado',
                })
            }
        },
        quitarDocumento(id){
            //desea eliminar el documento
            this.$swal.fire({
                title: '¿Está seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Sí, bórralo!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.documentos = this.documentos.filter((item)=>item.id !== id)
                    this.calcular_total()
                  this.eliminarDocumento(id)
                    this.getMontoViajes()
                    this.$swal.fire(
                        '¡Eliminado!',
                        'El documento ha sido eliminado.',
                        'success'
                    )
                }
            })

        },
        //validaciones por fila
        validarDocumento(item){
            if (item.nro_documento === ''){
                this.$swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Debe ingresar un número de documento!',
                })
                return
            }
            if (item.monto_gasto === 0){
                this.$swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Debe ingresar un monto!',
                })
                return
            }
            if (item.tipo_id === 0){
                this.$swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Debe seleccionar un tipo de gasto!',
                })
                return
            }
            if (item.fecha === ''){
                this.$swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Debe ingresar una fecha!',
                })
                return
            }
        },
        async enviar_formulario(){
            try{

                //llamar a la validacion por final iteracion
                /*this.documentos.forEach((item) => {
                    this.validarDocumento(item)
                })*/

                // no permitir guardar hasta que el total final sea igual o menor a cero
                if (this.total_final > 0){
                    this.$swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'El monto final no puede ser mayor a 0!',
                    })
                    return
                }


                let url = '/ingreso-gastos-viaje'
                let formData = new FormData()

                formData.append('folio_id',this.folio_id)
                formData.append('viaje_id',this.viaje_id)
                formData.append('tripulacion_id',this.tripulacion_id)
                //monto disponible del viaje
                formData.append('monto_disponible',this.monto_disponible)
                //monto declarado
                formData.append('monto_declarado',this.monto_declarado)
                //monto total
                formData.append('total',this.total)
                //monto final
                formData.append('total_final',this.total_final)
                formData.append('datos',JSON.stringify(this.documentos))

                const { status }  =  await axios.post('/ingreso-gastos-viaje',formData)

                if (status === 200){
                    this.getGastos()
                    this.getViajes()
                    this.getMontoViajes()
                    $('#gastosModal').modal('hide')
                    this.gastos = []
                    this.documentos = []
                    this.folio_id = 0
                    this.tripulacion_id = 0
                    this.nro_viaje = ''
                    this.total = 0
                    this.monto_declarado = 0
                    this.total_final = 0

                    this.$swal.fire({
                        title: 'Exito',
                        text: 'Se ha registrado correctamente',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    })
                }
            }catch (error) {
                this.$swal.fire({
                    title: 'Error',
                    text: 'Ha ocurrido un error',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                })
            }
        },
        eliminarDocumento(id){
           try{
                let url = '/ingreso-gastos-viaje/'+id
                axios.delete(url)
           }catch (error) {
               console.log(error)
           }
        },

        seleccionar_folio(){
            let folio = this.folios.find((item) => item.id === this.folio_id)
            //this.folio = folio.nro_folio
            this.monto_disponible = folio.monto_asignado
            this.documentos = folio.gasto_pasaje_viaje
            this.tripulacion_id = folio.gasto_pasaje_viaje[0].tripulacion_id
            if (this.documentos.length > 0){
                this.editar = true
                this.calcular_total()
            }else{
                this.editar = false
            }
        },
        calcular_total(){
            this.total = 0
            /*this.documentos.forEach((item)=>{
                this.total += parseInt(item.monto_gasto)
            });*/
            //mismo ejemplo pero con reducer
            this.total = this.documentos.reduce((a,b)=>a + parseInt(b.monto_gasto),0)

            this.total_final = this.monto_disponible - this.total
        },
        getPaginate:function (page_number){
            this.page =  page_number
            this.page_class = 'page-item active'
            this.getGastos()
        }
    },
    filters:{
        formatPrice(value) {
            let val = (value/1).toFixed(0).replace('.', ',')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        }
    }
}
</script>

<style scoped>
thead tr th{
    background-color: #D3B560;
    color: white;
}

.remarcar{
    color:#000;
    font-weight: bold;
}
.monto-final{
    font-size: 20px;
    font-weight: bold;
}
.monto-total{
    font-size: 15px;
    font-weight: bold;
}
</style>
