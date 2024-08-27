<template>
    <div>
        <div class="btn-group mb-3">
            <button  class="btn btn-primary btn-sm" @click="abrir_modal"><i class="fa fa-plus-circle"></i> Agregar</button>
            <button class="btn btn-sm btn-secondary" @click="printDatos"><i class="fa fa-print"></i> Imprimir</button>
            <button type="button" class="btn btn-success btn-sm" @click="filtrar = !filtrar"><i class="fa fa-filter"></i> Filtrar</button>
        </div>
        <div class="form-group col-md-3 mb-3">
            <input type="date" v-model="fecha_filtro" @change="getGastoCajas" class="form-control">
        </div>
        <table class="table table-striped table-bordered table-condensed">
            <thead>
            <tr>
                <th>FECHA</th>
                <th>NRO DOCUMENTO</th>
                <th>MONTO</th>
                <th>OBSERVACION</th>
                <th>EMPRESA</th>
                <th>RESPONSABLE</th>
                <th>ENTREGADO POR</th>
            </tr>
            </thead>
            <tbody>
            <tr v-show="filtrar">
                <td>
                    <input type="date" v-model="fecha_filtro" @change="getGastoCajas" class="form-control">
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    <select-2
                        v-model="trabajador_id_filtro"
                        :dataType="'number'"
                        @select-changed="getGastoCajas()"
                    >
                        <option
                            v-for="({id,rut,primer_nombre,segundo_nombre,primer_apellido, segundo_apellido}, index) in trabajadores"
                            :value="id"
                        >
                            {{rut+' - '+primer_nombre +' '+ segundo_nombre +' '+ primer_apellido+ ' ' +segundo_apellido}}
                        </option>

                    </select-2>
                </td>
                <td></td>
                <td></td>

            </tr>
            <tr v-for="({ID_GASTO_EGRESO_CAJA,
                            FECHA_EGRESO,
                            NRO_DOCUMENTO,
                            MONTO,
                            OBSERVACION,
                            EMPLEADOR_ID,
                            EMPLEADOR,
                            TRABAJADOR_ID,
                            NOMBRE_COMPLETO,
                            USER_ID,
                            USER_NAME
                        } , index) in gastoCajas.data">
                <td>{{FECHA_EGRESO | FormatoFecha}}</td>
                <td>{{NRO_DOCUMENTO}}</td>
                <td>{{MONTO}}</td>
                <td>{{OBSERVACION}}</td>
                <td>{{EMPLEADOR}}</td>
                <td>{{NOMBRE_COMPLETO}}</td>
                <td>{{USER_NAME}}</td>
            </tr>
            </tbody>
        </table>

        <!--- MODAL CREAR DOCUMENTO VIAJE -->
        <div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered min-w-1000px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="fw-bold" id="exampleModalLabel">EGRESO CAJA</h2>
                        <div id="trabajadorModal_close" @click="cerrarModal()" class="btn btn-icon btn-sm btn-active-icon-primary" >
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
                        <div class="row ">
                            <div class="form-group col-md-6 mb-5">
                                <label for="">FECHA</label>
                                <input type="date" v-model="fecha" :disabled="true" class="form-control">
                            </div>
                            <div class="form-group col-md-6 mb-5">
                                <label for="">NRO DOCUMENTO</label>
                                <input type="text" class="form-control" v-model="nro_documento">
                            </div>
                            <div class="form-group col-md-6 mb-5">
                                <label for="">MONTO</label>
                                <input type="number" class="form-control" v-model="monto">
                            </div>
                            <div class="form-group col-md-6 mb-5">
                                <label for="">EMPRESA</label>
                                <select
                                    class="form-select mb-2"
                                    id="empleador_id"
                                    v-model="empleador_id"
                                >
                                    <option value="">------</option>
                                    <option v-for="empleador in empleadores" :value="empleador.id">{{empleador.nombre_empleador}}</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6 mb-5">
                                <label for="">RESPONSABLE</label>
                                <select
                                    name="trabajador_id"
                                    class="form-select mb-2"
                                    data-control="select2"
                                    data-placeholder="Seleccionar trabajador"
                                    data-allow-clear="true"
                                    id="trabajador_id"
                                    data-dropdown-parent="#modalCreate"
                                >
                                    <option value="">--------</option>

                                    <option
                                        v-for="({id,rut,primer_nombre,segundo_nombre,primer_apellido, segundo_apellido}, index) in trabajadores"
                                        :value="id"
                                    >
                                        {{rut+' - '+primer_nombre +' '+ segundo_nombre +' '+ primer_apellido+ ' ' +segundo_apellido}}
                                    </option>

                                </select>
                            </div>
                            <div class="form-group col-md-6 mb-5">
                                <label for="">AUTORIZADO POR</label>
                                <select
                                    class="form-select mb-2"
                                    id="autorizado_id"
                                    v-model="autorizado_id"
                                   >
                                    <option value="">--------</option>
                                    <option v-for="({TRABAJADOR_ID, NOMBRE}, index) in autorizados"
                                            :value="TRABAJADOR_ID">
                                                    {{NOMBRE}}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group col-md-12 mt-3">
                                <label for="">OBSERVACION</label>
                                <textarea class="form-control" v-model="observacion"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" @click="cerrarModal()">Cerrar</button>
                        <button type="button" class="btn btn-primary btn-sm" @click.prevent="enviar_formulario()">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
        <!--- MODAL CREAR DOCUMENTO VIAJE -->
        <div class="modal fade" id="modalCierreCaja" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">CIERRE DE CAJA</h5>
                        <button type="button" class="close"  @click="cerrar_modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="">FECHA</label>
                                <input type="date" v-model="fecha" class="form-control">
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-sm" @click="cerrar_modal">Cerrar</button>
                        <button type="button" class="btn btn-primary btn-sm" @click.prevent="enviar_cierre_caja()">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment';
import Select2 from "../../components/Form/Select2.vue";
export default {
    name: "Index",
    components: {Select2},
    data() {
        return {
            fecha: '',
            fecha_filtro: '',
            nro_documento: '',
            monto:0,
            observacion: '',
            empleador_id: 0,
            trabajador_id:0,
            gastoCajas: [],
            trabajadores:[],
            empleadores:[],
            filtrar: false,
            fecha_reporte_inicio: '',
            fecha_reporte_fin: '',
            autorizados: [],
            autorizado_id: 0,
            trabajador_id_filtro: 0,
        }
    },
    created() {
        this.fecha_hoy()
    },
    mounted() {
        this.getGastoCajas();
        this.getTrabajadores();
        this.getAutorizados();
        this.cargarEmpleador();
    },
    updated() {
        //this.refrescar()
        $('#trabajador_id').on('select2:select', this.onSelectTraabajador)
        $('#trabajador_id_filtro').on('select2:select', this.onSelectTraabajadorFiltro)
       // $('#autorizado_id').on('select2:select', this.onSelectAutorizado)
    },
    methods: {
        refrescar:function(){
           // $(this.$refs.trabajadores).selectpicker('refresh')
        },
        onSelectTraabajador:function(e){
            this.trabajador_id =parseInt(e.params.data.id);
        },
        onSelectTraabajadorFiltro:function(e){
            this.trabajador_id =parseInt(e.params.data.id);
            this.getGastoCajas()
        },

        async getGastoCajas() {
           try{
               let url = 'getEgresoCajas?opciones=1'

               if (this.fecha_filtro != '') {
                   url = 'getEgresoCajas?opciones=2&filtro[FECHA_EGRESO]=' + this.fecha_filtro
               }

                if (this.trabajador_id_filtro > 0) {
                     url = url+'&filtro[TRABAJADOR_ID]=' + this.trabajador_id_filtro
                }


               const {data ,status} = await axios.get(url);
               if (status == 200) {
                   this.gastoCajas = data;
               }
           }catch (error) {
               console.log(error);
           }
        },
        async getTrabajadores(){
            try {

                let url = '/lista-trabajadores?opciones=all'

                const {data , status}  = await axios.get(url)
                if (status === 200){
                    this.trabajadores = data
                }

            }catch (error) {
                console.log(error)
            }
        },
        async getAutorizados(){
            try {
                let url = '/trabajadores-autorizados'

                const {data, status} = await axios.get(url)

                if (status === 200){
                    this.autorizados = data
                }
            }catch (error) {
                console.log(error)
            }
        },
        async cargarEmpleador(){
            try {
                const {data, status} = await axios.get('/empleador')
                if (status === 200){
                    this.empleadores = data
                }
            }
            catch (e) {
                console.log(e)
            }
        },
        fecha_hoy(){
            //moment fecha actual
            let fecha = moment().format('YYYY-MM-DD')
            this.fecha = fecha
            this.fecha_filtro = fecha
        },
        abrir_modal(){
            $('#modalCreate').modal('show')
        },
        cerrar_modal(){
            $('#modalCreate').modal('hide')
        },
      async enviar_formulario() {
            try{
                let formData = new FormData();
                formData.append('fecha', this.fecha);
                formData.append('nro_documento', this.nro_documento);
                formData.append('monto', this.monto);
                formData.append('observacion', this.observacion);
                formData.append('empleador_id', this.empleador_id);
                formData.append('trabajador_id', this.trabajador_id);

               const {status} = await axios.post('/save-egreso-caja', formData)
                if(status == 200){
                    //limpiar
                    await this.getGastoCajas();
                    this.fecha = '';
                    this.nro_documento = '';
                    this.monto = 0;
                    this.observacion = '';
                    this.empleador_id = 0;
                    this.trabajador_id = 0;
                    this.autorizado_id = 0;
                    this.fecha_hoy();
                    //limipiar select 2
                    $('#trabajador_id').val(null).trigger('change');

                    //cargar valor en select 2
                   // $('#trabajador_id').val(229).trigger('change');

                     this.$swal.fire({
                        title: 'Exito',
                        text: 'Se ha registrado el egreso de caja',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                     })
                    //cerrar bootstrap modal
                   this.cerrar_modal();

                }
            }catch (error) {
                this.$swal.fire({
                    title: 'Error',
                    text: 'No se ha registrado el egreso de caja',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                })
            }
        },
        printDatos(){
            //redireccionar a la vista de impresion
            window.open('/reporte-cierre-caja?fecha='+this.fecha_filtro,'_blank');
        },
        cerrarModal(){
            $('#modalCreate').modal('hide')
        },
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
