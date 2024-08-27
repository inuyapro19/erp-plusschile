<template>
        <div>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <div class="form-group">
                        <select name="viaje_id"
                                id="viaje_id"
                                class="form-select mb-2"
                                data-control="select2"
                                data-placeholder="Seleccione Viaje"
                                data-allow-clear="true"
                        >
                            <option value="">--------- NRO VIAJE -------------</option>
                            <option  v-for="(bus, index) in viajes" :value="bus.id">{{bus.nro_viaje  }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <select
                        name="folio"
                        class="form-select mb-2"
                        data-control="select2"
                        data-placeholder="Seleccione Folio"
                        data-allow-clear="true"
                        id="folio">
                        <option value="">---------  FOLIOS -------------</option>
                        <option  v-for="(folio, index) in folios" :value="folio.id">{{folio.nro_folio}}</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <button class="btn btn-sm btn-success" @click.prevent="abrirModalMontoFolio()" >Agregar</button>
                </div>
            </div>
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                   <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th>Nro viaje</th>
                                <th>Folio</th>
                                <th>Monto Aprobado</th>
                                <th>Monto Entregados</th>
                                <th>Fecha Entrega</th>
                                <th>Ingresado por</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        <tr v-for="(viaje, index) in entregados">
                            <td>{{viaje.NRO_VIAJE}}</td>
                            <td>
                                {{viaje.NRO_FOLIO}}
                            </td>
                            <td>
                                $ {{viaje.MONTO_ASIGNADO | formatPrice}}
                            </td>
                            <td>
                               $ {{viaje.MONTO_ENTREGADOS | formatPrice}}
                            </td>
                            <td>
                                {{viaje.FECHA_ENTREGA | FormatoFecha}}
                            </td>
                            <td>{{viaje.NOMBRE + ' ' + viaje.APELLIDOS +' - ' +viaje.UBICACION}}</td>
                            <td>
                               <span :class="viaje.ESTADO_MONTO === 'APROBADO'?'badge badge-success':'badge badge-warning'">{{viaje.ESTADO_MONTO}}</span>
                            </td>
                            <!--BOTON SOLO DEBE APARECER PARA EL ROL JEFE DE OFICINA O ADMINISTRADOR-->
                           <td>
                               <button class="btn btn-primary btn-sm" @click="abrirModelEstado(viaje.MONTO_ENTREGADO_ID)"><i class="fa fa-edit"></i></button>
                           </td>

                        </tr>
                            <tr v-if="folio_id > 0">
                                <td> </td>
                                <td></td>
                                <td style="font-weight: bolder;color: #000;font-size: 20px">Saldo</td>
                                <td style="font-weight: bolder;color: #000;font-size: 20px">${{saldo}}</td>
                                <td></td>
                            </tr>
                    </tbody>

            </table>
            <!-- Modal -->
            <div class="modal fade" id="foliosModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="fw-bold" >Entregar monto </h2>
                            <div id="trabajadorModal_close" @click="cerrarModalImprimir()" class="btn btn-icon btn-sm btn-active-icon-primary" >
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                <span class="svg-icon svg-icon-1">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
								    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
								</svg>
                            </span>
                                <!--end::Svg Icon-->
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="">Nro de viaje</label>
                                    <input type="text" class="form-control" v-model="nro_viaje" :disabled="true">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="">Folio</label>
                                    <input type="text" class="form-control" v-model="folio" :disabled="true">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="">Nota</label>
                                    <input type="text" class="form-control" v-model="nota">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="">Monto aprobado</label>
                                    <input type="number" class="form-control" :disabled="true" v-model="monto_disponible">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="">Saldo disponible</label>
                                    <input type="number" class="form-control" :disabled="true" v-model="saldo">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="">Monto solicitado</label>
                                    <input type="number" class="form-control" v-model="monto_entregado">
                                    <button class="btn btn-info mt-1" @click.prevent="validar_montos()">Validar</button>
                                </div>

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-sm" @click="cerrarModalImprimir()">Cerrar</button>
                            <button type="button"  class="btn btn-primary btn-sm" @click.prevent="enviar_formulario()" :disabled="activar_boton">Guardar</button>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal solo rol admin y jefe de oficina -->
            <div class="modal fade" id="AprobarMontoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Aprobar Monto </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="">Nro de viaje</label>
                                    <input type="text" class="form-control" v-model="nro_viaje" :disabled="true">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="">Folio</label>
                                    <input type="text" class="form-control" v-model="folio" :disabled="true">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="">Nota</label>
                                    <input type="text" class="form-control" v-model="nota">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="">Monto aprobado</label>
                                    <input type="number" class="form-control" :disabled="true" v-model="monto_disponible">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="">Monto solicitado</label>
                                    <input type="number" :disabled="true" class="form-control" v-model="monto_entregado">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="">Estado</label>
                                    <select name="estado_monto"  class="form-control" v-model="estado_monto" id="">
                                        <option value="PENDIENTE DE APROBACION">PENDIENTE DE APROBACION</option>
                                        <option value="APROBADO">APROBADO</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
                            <button type="button"  class="btn btn-primary btn-sm" @click.prevent="cambiarEstado(monto_entregado_id)" >Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>


import moment from 'moment';
export default {

    data() {
        return {
            viajes: [],
            viaje_id:0,
            entregados:[],
            folios:[],
            monto_entregado:0,
            folio:'',
            folio_id:0,
           // fecha_entrega:'',
            estados:['sin entrega','% de entrega','finalizado'],
            nota:'',
            activar:true,
            activar_boton:true,
            nro_viaje:'',
            saldo:0,
            monto_disponible:0,
            oficiana_id:0,
            estado_monto:'PENDIENTE DE APROBACION',
            monto_entregado_id:0
        }
    },
    mounted() {
        this.getViajes()
        this.getMontoEntregados()
    },
    updated() {
        this.refrescar()
        $('#viaje_id').on('select2:select', this.selectedViaje );
        $('#folio_id').on('select2:select', this.selectedFolio );
    },
    methods:{
        refrescar:function(){
            $(this.$refs.nro_viajes).selectpicker('refresh')
            $(this.$refs.folios).selectpicker('refresh')
        },
        selectedViaje:function(e){
            this.viaje_id = parseInt(e.params.data.id)
            this.seleccionar_viaje()
        },
        selectedFolio:function(e){
            this.folio_id = parseInt(e.params.data.id)
            this.getMontoEntregados()
        },
        estado_finalizado:function (){
            if (this.finalizados){
                this.estado_filtro = 'FINALIZADO'
            }
        },
        async getMontoEntregados(){

            let url = '/getMontoEntregado?opcion=1'

            if(this.folio_id>0)
            {
                let folio = this.folios.find((item) => item.id === this.folio_id)
                this.folio = folio.nro_folio
                this.monto_disponible = folio.monto_asignado
                // busca y suma los saldos
                let suma = 0
                let saldo = folio.monto_entregado.forEach((item) => {
                    suma = suma + item.monto_entregado
                })

                this.saldo = this.monto_disponible - suma

                url  = url + '&filtro[FOLIO_ID]='+this.folio_id

            }

            await axios.get(url).then((res) =>{
                this.entregados = res.data
            }).catch((error)=>{
                console.log(error)
            })
        },
        async getViajes(){

            let url = '/getViajes?opcion=1';

          /*  if (this.nro_viaje_filtro !== ''){
                url = url + '&filtro[nro_viaje]='+this.nro_viaje_filtro
            }

            //filtro por bus
            if (this.filtroporBus !== ''){
                url = url + '&filtroporBus='+this.filtroporBus
            }

            if (this.tipo_viaje_filtro !== ''){
                url = url + '&filtro[tipo_viaje]='+this.tipo_viaje_filtro
            }

            if (this.estado_filtro !== ''){
                url = url + '&filtro[estado]='+this.estado_filtro
            }else{
                url = url + '&estado_activos=EN RUTA'
            }*/

            url = url + '&filtro[estado]=EN RUTA'



            await axios.get(url).then(res => {
                this.viajes = res.data
            }).catch(error =>{
                console.log(error)
            })
        },
        async getFolios(){

            let  url = '/getMontoEntregado'

            await axios.get(url).then((res)=>{

                this.folio = res.data

            }).catch((error)=>{
                console.log(error)
            })
        },
        abrirModalMontoFolio(){
            $('#foliosModal').modal('show')
        },
        cerrarModalImprimir(){
            $('#foliosModal').modal('hide')
        },
        seleccionar_viaje(){
           let viaje = this.viajes.find((item) => item.id === this.viaje_id )
            this.nro_viaje = viaje.nro_viaje
            console.log(viaje)
            this.folios = viaje.monto_asignaciones
            this.activar = false
        },
        seleccionar_folio(){


        },
        validar_montos(){
           if(this.monto_entregado > this.saldo){
               alert('monto a entregar no debe ser mayor al monto saldo')
               this.activar_boton = true
           }else{
               alert('Monto entregado validado, ingrese el monto a entregar')
               this.activar_boton = false
           }
        },
        async enviar_formulario(){
           await axios.post('/montos-entregados',{
               monto_asignado_id:this.folio_id,
               monto_entregado:this.monto_entregado,
           }).then((res)=>{
              this.getViajes()
               this.getFolios()

               $('#foliosModal').modal('hide')
               this.viaje_id = 0
               this.monto_entregado = 0
               this.saldo = 0
               this.monto_disponible = 0
               this.folio_id = 0
               this.activar_boton = true
               this.activar = true
               this.getMontoEntregados()
               this.$swal('monto entregado exitosamente')
            }).catch((error) =>{
               this.$swal('error al entregar monto')
                console.log(error)
            })
        },
        abrirModelEstado(id){
            let monto_entregados = this.entregados.find((item) => item.MONTO_ENTREGADO_ID === id )
            this.monto_entregado_id = id
            this.monto_entregado = monto_entregados.MONTO_ENTREGADOS
            $('#AprobarMontoModal').modal('show')
        },
        async cambiarEstado(id){
          await axios.post('/cambiar-estado-aprobado-rechazado/'+id,{estado:this.estado_monto}).then((res)=>{
              this.$swal('El monto ha sido aprobado')
              this.estado_monto = ''
              this.getMontoEntregados()
              $('#AprobarMontoModal').modal('hide')
          }).catch((error)=>{
              console.log(error)
          });
        }

    },
    /*filters:{
        formato_fecha(fecha){
            return moment(fecha).format('DD-MM-YYYY')
        },
        formatPrice(value) {
            let val = (value/1).toFixed(0).replace('.', ',')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        }
    }*/

}
</script>

<style scoped>
th{
    font-weight: bolder!important;
    color: #fff!important;
}
th a:hover{
    cursor: pointer;
    color: #222222!important;
}

thead tr th{
    background-color: #D3B560;
    color: white;
}
</style>
