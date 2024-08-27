<template>
    <div>
        <CardComponent>
            <template #body>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="btn-group">
                            <button class="btn btn-success btn-sm" @click="filtrar = !filtrar"> <i class="fa fa-filter"></i> Filtrar</button>
                        </div>
                    </div>
                </div>

                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                    <thead>
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th>NRO VIAJE</th>
                        <th>FOLIOS</th>
                        <th>BUS</th>
                        <th style="width:200px">TRIPULACIÓN</th>
                        <th>ORIGEN</th>
                        <th>DESTINO</th>
                        <th>FECHA SALIDA</th>
                        <th>FECHA LLEGADA</th>
                        <th>NRO DOCUMENTO CHECKLIST</th>
                        <th>NRO DOCUMENTO H. RUTA</th>
                        <th>ESTADOS</th>
                        <th>ACCIONES</th>
                    </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                    <tr v-show="filtrar">
                        <td colspan="2">
                            <select-2
                                v-model="viaje_id_filtro"
                                :dataType="'number'"
                                @select-changed="getViajesDocumento()"
                            >
                                <option
                                    v-for="(viaje, index) in viajes"
                                    :key="viaje.id"
                                    :value="viaje.id">
                                    {{ viaje.nro_viaje }}
                                </option>
                            </select-2>
                        </td>

                        <td>

                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr v-for="({VIAJE_ID,
                            NUMERO_VIAJE,
                            FOLIOS,
                            BUS,
                            TRIPULACION,
                            CIUDAD_DESTINO,
                            CIUDAD_ORIGEN,
                            FECHA_SALIDA,
                            FECHA_LLEGADA,
                            NRO_DOCUMENTO_CHECK_LIST,
                            NRO_DOCUMENTO_HOJA_RUTA,
                            ESTADO_CHECK_LIST,
                            ESTADO_HOJA_RUTA
                        } , index) in viajesDocumento.data">
                        <td><span class="remarcar">{{NUMERO_VIAJE}}</span></td>
                        <td><span class="remarcar">{{FOLIOS}}</span></td>
                        <td><span class="remarcar">{{BUS}}</span></td>
                        <td><div v-html="TRIPULACION"></div></td>
                        <td>{{CIUDAD_ORIGEN}}</td>
                        <td>{{CIUDAD_DESTINO}}</td>
                        <td>{{FECHA_SALIDA | FormatoFecha}}</td>
                        <td>{{FECHA_LLEGADA | FormatoFecha}}</td>
                        <td>{{NRO_DOCUMENTO_CHECK_LIST}}</td>
                        <td>{{NRO_DOCUMENTO_HOJA_RUTA}}</td>
                        <td>{{ESTADO_CHECK_LIST}} - {{ESTADO_HOJA_RUTA}}</td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-primary" @click="openModalCreate(VIAJE_ID)"><i class="fa fa-edit"></i></button>
                            </div>

                        </td>
                    </tr>
                    </tbody>
                </table>

                <paginate :pagination="viajesDocumento" :onPageChange="getViajesDocumento"></paginate>
            </template>
        </CardComponent>


        <!--- MODAL CREAR DOCUMENTO VIAJE -->
        <div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Documento viaje</h5>
                        <button type="button" class="close"  @click="cerrar_modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="">NRO CHECKLIST</label>
                                <input type="text" class="form-control" v-model="nro_doc_checklist">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Entregado</label>
                                <select v-model="estado_check" class="form-control">
                                    <option value="">------</option>
                                    <option value="1">SI</option>
                                    <option value="0">NO</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">NRO HOJA DE RUTA</label>
                                <input type="text" class="form-control" v-model="nro_doc_hoja_ruta">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Entregado</label>
                                <select v-model="estado_hoja" class="form-control">
                                    <option value="">------</option>
                                    <option value="1">SI</option>
                                    <option value="0">NO</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">Responsable</label>
                                <select v-model="tripulacion_id" class="form-control">
                                    <option value="">------</option>
                                    <option v-for="tripulacion in tripulaciones" :value="tripulacion.id">{{tripulacion.primer_nombre + ' ' + tripulacion.segundo_nombre + ' ' + tripulacion.primer_apellido + ' ' +tripulacion.segundo_apellido}}</option>
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" @click="cerrar_modal">Cerrar</button>
                        <button type="button" class="btn btn-primary btn-sm" @click.prevent="enviar_formulario()">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

</template>

<script>
import moment from "moment";

import CardComponent from "../../components/CardComponent.vue";
import Paginate from "../../components/paginate.vue";
import Select2 from "../../components/Form/Select2.vue";
export default {
    components: {
        Select2,
        CardComponent,
        Paginate
    },
    data() {
        return {
            viajesDocumento: [],
            viajes:[],
            tripulaciones:[],
            id:0,
            nro_doc:'',
            fecha_de_entrega:'',
            tipo:'',
            viaje_id:0,
            tripulacion_id:0,
            user_id:0,
            estado:'',
            viaje_id_filtro:0,
            bus_id_filter:0,
            filtrar:false,
            nro_doc_checklist:'',
            nro_doc_hoja_ruta:'',
            buses:[],
            id_checklist:0,
            id_hoja_ruta:0,
            estado_check:1,
            estado_hoja:1,
        }
    },
    created() {
        this.getViajesDocumento();
        this.getViajes();
        this.getBuses();
    },
    methods:{
        async getViajesDocumento(page = 1){
            try{
                let url = '/getDocumentoViaje?option=1';

                if (this.viaje_id_filtro > 0) {
                    url += '&filtro[VIAJE_ID]=' + this.viaje_id_filtro;
                }

                if (this.bus_id_filter > 0) {
                    url += '&filtro[BUS_ID]=' + this.bus_id_filter;
                }

                if (page > 0){
                    url = url + '&page='+page
                }

                const {data , status} = await axios.get(url);
                if (status == 200) {
                    this.viajesDocumento = data;
                }

            } catch (error) {
                console.log(error);
            }
        },
        async getViajes(){
           try{
                let url = '/getViajes?opcion=get';



                const {data ,status} = await axios.get(url);
                 if (status == 200) {
                     this.viajes = data;
                 }

              } catch (error) {
                console.log(error);
           }
        },
        async getBuses(){
            try {
                //obtiene buses
                const { data, status } = await axios.get('/getBusesLista');

                if(status == 200) {
                    this.buses = data;
                }

            }catch (error) {
                console.log(error);
            }
        },
        //abrir modal para crear un nuevo documento
        async openModalCreate(viaje_id){
            //BUSCA DETALLE DEL VIAJE DOCUMENTO
           let data = this.viajes
                .find(({ id }) => id === viaje_id);
           let documentoviaje = this.viajesDocumento.data
                .find(({ VIAJE_ID }) => VIAJE_ID === viaje_id);
            this.tripulaciones = data.trabajadores;
            this.nro_doc_checklist = documentoviaje.NRO_DOCUMENTO_CHECK_LIST;
            this.nro_doc_hoja_ruta = documentoviaje.NRO_DOCUMENTO_HOJA_RUTA;
            this.id_checklist = documentoviaje.ID_CHECK_LIST;
            this.id_hoja_ruta = documentoviaje.ID_HOJA_RECORRIDO;
            this.viaje_id = viaje_id;
            this.tripulacion_id = documentoviaje.TRIPULACION_ID;

            //estados
            this.estado_check = documentoviaje.ESTADO_CHECK_LIST === 'entregado' ? '0' : '1';
           this.estado_hoja = documentoviaje.ESTADO_HOJA_RUTA === 'entregado' ? '0' : '1';

            console.log( this.tripulaciones);
            $('#modalCreate').modal('show');
        },
        cerrar_modal(){
            this.tripulaciones = [];
            this.viaje_id = 0;

            $('#modalCreate').modal('hide');
        },

        async enviar_formulario(){
            try {
                //new formData
                const formData = new FormData();

                formData.append('viaje_id', this.viaje_id);
                formData.append('nro_doc_checklist', this.nro_doc_checklist);
                formData.append('nro_doc_hoja_ruta', this.nro_doc_hoja_ruta);
                formData.append('tripulacion_id', this.tripulacion_id);
                formData.append('id_doc_checklist', this.id_checklist);
                formData.append('id_doc_hoja_ruta', this.id_hoja_ruta);

                //entregados
                if (this.estado_check == 1) {
                    formData.append('estado_check', 1);
                }else{
                    formData.append('estado_check', 0);
                }
                if (this.estado_hoja == 1) {
                    formData.append('estado_hoja', 1);
                }else{
                    formData.append('estado_hoja', 0);
                }

                //enviar datos
                const { status } = await axios.post('/documentos-viaje', formData);
                if (status == 200) {

                    this.id = 0;
                    this.nro_doc = '';
                    this.fecha_de_entrega = '';
                    this.tipo = '';
                    this.viaje_id = 0;
                    this.tripulacion_id = 0;
                    this.user_id = 0;
                    this.estado = '';

                    this.getViajesDocumento();
                    this.cerrar_modal();

                    this.$swal.fire({
                        title: 'Exito!',
                        text: 'Datos guardados correctamente',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    });

                }

            }catch (error) {
               this.$swal.fire({
                     title: 'Error!',
                     text: 'Error al guardar los datos',
                     icon: 'error',
                     confirmButtonText: 'Aceptar'
                });
            }
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
</style>
