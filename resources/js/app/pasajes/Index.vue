<template>
    <div>

        <div class="row mt-3">
            <div class="col-md-3">
                <div class="form-group">
                    <select name="numero_bus" class="form-control selectpicker" ref="nro_viajes" @change="getPasajes()" data-live-search="true" data-size="10" v-model="viaje_id" id="numero_bus">
                        <option value="">--------- NRO VIAJE -------------</option>
                        <option  v-for="(bus, index) in viajes" :value="bus.id">{{bus.nro_viaje  }}</option>
                    </select>
                </div>
            </div>
           <!-- <div class="col-md-3">
                <div class="form-group">
                    <input type="date" v-model="fecha_desde_filtro" class="form-control">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <input type="date" v-model="fecha_hasta_filtro" class="form-control">
                </div>
            </div>-->
        </div>

        <div class="row">
            <div class="col-md-3">
                <button class="btn btn-sm btn-success" @click.prevent="abrirModalPasajes()" >Agregar pasajes</button>
            </div>
        </div>

        <div class="row mt-3">
            <table class="table table-bordered table-striped">
                <thead>
                    <th>Nro de viaje</th>
                    <th>Ciudad Origen</th>
                    <th>Ciudad Destino</th>
                    <th>FECHA VIAJE</th>
                    <th>Nº documento</th>
                    <th>Monto</th>
                    <th>Fecha venta</th>
                </thead>
                <tbody>

                    <tr v-for="(pasaje, index) in pasajes">
                        <td>{{pasaje.NRO_VIAJE}}</td>
                        <td>{{pasaje.CIUDAD_ORIGEN}}</td>
                        <td>{{pasaje.CIUDAD_DESTINO}}</td>
                        <td>{{pasaje.fecha_viaje | formato_fecha}}</td>
                        <td>{{pasaje.NRO_DOCUMENTO}}</td>
                        <td>${{pasaje.MONTO | formatPrice}}</td>
                        <td>{{pasaje.FECHA_VENTA | formato_fecha}}</td>
                        <!--<td><button class="btn btn-primary"><i class="fa fa-eye-dropper"></i></button></td>-->
                    </tr>
                   <tr v-if="viaje_id > 0">

                        <td></td>
                        <td></td>
                        <td> </td>
                        <td></td>
                        <td style="font-weight: bolder;color: #000;font-size: 20px">Total</td>
                        <td style="font-weight: bolder;color: #000;font-size: 20px">${{total | formatPrice}}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="pasajesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Entregar monto </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="">Nro de viaje</label>
                                <input type="text" class="form-control" v-model="nro_viaje" :disabled="true">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <button class="btn btn-primary btn-sm mb-1" @click="addPasaje()"><i class="fa fa-plus-circle"></i></button>
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
                            <table class="table table-bordered table-striped">
                                <thead>
                                <th>Nº documento</th>
                                <th>Monto</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                                </thead>
                                <tbody>
                                <tr v-for="(pasaje, index) in pasajes_add">
                                    <td>
                                        <input  class="form-control" type="text" v-model="pasaje.nro_documento">
                                    </td>
                                    <td>
                                        <input class="form-control" type="number" @keypress.enter="calcular_total()" v-model="pasaje.monto">
                                    </td>

                                    <td><input type="date" v-model="pasaje.fecha" class="form-control"></td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" @click="quitarPasaje(pasaje.id)"> <i class="fa fa-trash"></i></button>
                                    </td>

                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td><input type="number" class="form-control" :disabled="true" v-model="total"></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                        <button type="button"  class="btn btn-primary btn-sm" @click.prevent="enviar_formulario()" >Guardar</button>

                    </div>
                </div>
            </div>
        </div>

    </div>


</template>

<script>
import moment from "moment";

export default {
    data() {
        return {
            pasajes: [],
            pasajes_add:[],
            monto:0,
            fecha:'',
            viaje_id:0,
            nro_documento:'',
            viajes:[],
            estado_filtro:'FINALIZADO',
            nro_viaje:'',
            fecha_desde_filtro:'',
            fecha_hasta_filtro:'',
            total:0,
        }
    },
    mounted() {
        this.getViajes()
        this.getPasajes()
    },
    updated() {
        this.refrescar()
    },
    methods:{
        refrescar:function(){
            $(this.$refs.nro_viajes).selectpicker('refresh')
          //  $(this.$refs.folios).selectpicker('refresh')
        },
        async getViajes(){

            let url = '/getViajes?opcion=1';

            if (this.estado_filtro !== ''){
                url = url + '&filtro[estado]='+this.estado_filtro
            }
            await axios.get(url).then(res => {
                this.viajes = res.data
            }).catch(error =>{
                console.log(error)
            })
        },
        async getPasajes(){

            let url = 'getPasajes?opcion=1'
            this.total = 0
            if (this.viaje_id > 0)
            {
                let viaje = this.viajes.find((item) => item.id === this.viaje_id)

                this.nro_viaje = viaje.nro_viaje

                /*this.pasajes = this.pasajes.find((item)=> item.VIAJE_ID === this.viaje_id)

                this.pasajes.forEach(item => {
                    this.total += parseInt(item.MONTO)
                })*/

                url = url + '&filtro[VIAJE_ID]='+this.viaje_id
            }

          axios.get(url).then((res)=>{

              this.pasajes = res.data.data

              this.pasajes.forEach((item)=>{
                  this.total += parseInt(item.MONTO)
              })

          }).catch((error)=>{
              console.log(error)
          })
        },
        abrirModalPasajes(){
            $('#pasajesModal').modal('show')
        },
        addPasaje(){
            this.pasajes_add.push({
                    id:Math.random(),
                    nro_documento:'',
                    monto:0,
                    fecha:'',
                    viaje_id:this.viaje_id
                }
            )
        },
        quitarPasaje(id){
           this.pasajes_add = this.pasajes_add.filter((item)=>item.id !== id)
        },
       async enviar_formulario(){

          await axios.post('/pasajes-en-camino',{datos:this.pasajes_add,viaje_id:this.viaje_id}).then((res)=>{
              this.getPasajes()
              $('#pasajesModal').modal('hide')
              this.pasajes_add = []
          }).catch((error)=>{
              console.log('error')
          })

        },
        calcular_total(){
            this.total = 0
            this.pasajes_add.forEach((item)=>{
                this.total += parseInt(item.monto)
            });
        }
    },
    filters:{
        formato_fecha(fecha){
            return moment(fecha).format('DD-MM-YYYY')
        },
        formatPrice(value) {
            let val = (value/1).toFixed(0).replace('.', ',')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        }
    }
}
</script>

<style scoped>

</style>
