<template>

   <div>
       <div class="card pt-5 mt-5">
           <div class="card-header">
               <h2>Reporte de Buses por periodos</h2>
           </div>
           <div class="card-body pt-0">
               <div class="row mt-3">
                   <div class="col-md-6 form-group">
                       <label class="required fs-6 fw-semibold mb-2" for="trabajador_id">Bus</label>
                       <select name="bus_id"
                               class="form-select mb-2 form-select-solid fw-bold"
                               data-control="select2"
                               data-placeholder="Seleccione bus"
                               data-allow-clear="true"
                               id="buses_id">
                           <option value="">--------</option>
                           <option v-for="({id,numero_bus,patente}, index) in buses_all"  :value="id">{{numero_bus+' - '+patente}}</option>

                       </select>
                   </div>

               </div>

               <div class="row mt-5">
                   <div class="col-md-6 form-group">
                       <label class="required fs-6 fw-semibold mb-2" for="fecha_inicio">Fecha inicio</label>
                       <input type="date"
                              class="form-control mb-2 form-control-solid fw-bold"
                              id="fecha_inicio"
                              v-model="fecha_inicio"
                              name="fecha_inicio">
                   </div>
                   <div class="col-md-6 form-group">
                       <label class="required fs-6 fw-semibold mb-2" for="fecha_fin">Fecha fin</label>
                       <input type="date"
                              class="form-control mb-2 form-control-solid fw-bold"
                              id="fecha_fin"
                              v-model="fecha_fin"
                              name="fecha_fin">
                   </div>
               </div>

           </div>
           <div class="card-footer flex-center">
               <button
                   @click="getHistorial()"
                   class="btn btn-bg-primary fw-bold">
                   <span class="indicator-label">Buscar</span>
               </button>
               <button
                   @click="CloseCard()"
                   class="btn btn-bg-secondary">
                   Cerrar
               </button>
           </div>
       </div>

       <div class="card pt-5 mt-8" v-show="mostrarTabla">
           <div class="card-body pt-0">
               <table  class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                   <thead>
                       <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                              <th></th>
                              <th>FECHA</th>
                              <th>CONDUCTOR 1</th>
                              <th>CONDUCTOR 2</th>
                              <th>AUXILIAR</th>
                              <th>DESTINO</th>
                       </tr>
                   </thead>
                   <tbody>
                   <tr v-for="({
                           BUS_id,
                            NRO_BUS,
                            CONDUCTOR1_ID,
                            CONDUCTOR1,
                            CONDUCTOR2_ID,
                            CONDUCTOR2,
                            AUXILIAR_ID,
                            AUXILIAR,
                            CONDUCTOR1_REEMPLAZO_ID,
                            CONDUCTOR1_REEMPLAZO,
                            CONDUCTOR2_REEMPLAZO_ID,
                            CONDUCTOR2_REEMPLAZO,
                            AUXILIAR_REEMPLAZO_ID,
                            AUXILIAR_REEMPLAZO,
                            DESTINO,
                            FECHA_SALIDA
                        },index) in historial">
                       <td></td>
                       <td>{{FECHA_SALIDA | FormatoFecha}}</td>
                       <td>
                           <span class="trabajador-hover" @click="abrirModal(CONDUCTOR1_ID)">{{CONDUCTOR1}}</span><br>
                           <span class="trabajador-hover" v-if="CONDUCTOR1_REEMPLAZO" @click="abrirModal(CONDUCTOR1_REEMPLAZO_ID)">{{CONDUCTOR1_REEMPLAZO}} (REEMPLAZO)</span>
                       </td>
                       <td>
                           <span class="trabajador-hover" @click="abrirModal(CONDUCTOR2_ID)">{{CONDUCTOR2}}</span><br>
                           <span class="trabajador-hover" v-if="CONDUCTOR2_REEMPLAZO" @click="abrirModal(CONDUCTOR2_REEMPLAZO_ID)">{{CONDUCTOR2_REEMPLAZO}} (REEMPLAZO)</span>
                       </td>
                       <td>
                           <span class="trabajador-hover" @click="abrirModal(AUXILIAR_ID)">{{AUXILIAR}}</span><br>
                           <span class="trabajador-hover" v-if="AUXILIAR_REEMPLAZO" @click="abrirModal(AUXILIAR_REEMPLAZO_ID)">{{AUXILIAR_REEMPLAZO}} (REEMPLAZO)</span>
                       </td>
                       <td>{{DESTINO}}</td>
                   </tr>
                   </tbody>
               </table>
           </div>
       </div>

       <!--- MODAL DETALLE TRIPULANTE -->
       <div class="modal fade" id="modal-triuplacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
           <div class="modal-dialog modal-dialog-centered min-w-1000px">

               <div class="modal-content">
                   <div class="modal-header">

                       <h2 class="fw-bold">Historial Tripulante</h2>
                       <div id="trabajadorModal_close" @click="cerraroModal()" class="btn btn-icon btn-sm btn-active-icon-primary" >
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
                       <table  class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table" v-show="mostrarTablaModel">
                           <thead>
                           <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                               <th></th>
                               <th>RUT</th>
                               <th>NOMBRE</th>
                               <th>CARGO</th>
                               <th>BUS</th>
                               <th>TIPO</th>
                               <th>Fecha</th>

                           </tr>
                           </thead>
                           <tbody>
                           <tr v-for="({ID_TRABAJADOR, BUS,RUT ,NOMBRE_COMPLETO ,TIPO,CARGO,FECHA_FIN},index) in historial_tripulante">
                               <td></td>
                               <td>{{RUT}}</td>
                               <td>{{NOMBRE_COMPLETO}}</td>
                               <td>{{CARGO}}</td>
                               <td>{{BUS}}</td>
                               <td v-html="getColorType2(TIPO)"></td>
                               <td>{{FECHA_FIN | FormatoFecha}}</td>
                           </tr>
                           </tbody>
                       </table>
                   </div>
                   <div class="modal-footer">
                       <button type="button" class="btn btn-secondary btn-sm" @click="cerraroModal()" >Cerrar</button>
                   </div>
               </div>
           </div>
       </div>


   </div>




</template>

<script>

const COLOR_CLASSES = {
    'DISPONIBLE': 'badge-primary',
    'EN RUTA': 'badge-success',
    'FINALIZADO': 'badge-warning',
};

const COLOR_CLASSES_MODEL = {
    'LICENCIA MEDICA': 'badge-primary',
    'VACACIONES': 'badge-success',
    'PERMISO ESPECIALES': 'badge-warning',
    'FALLA': 'badge-danger',
    'VIAJE': 'badge-info',
    'DIAS LIBRES': 'badge-dark',
};
export default {
    name: "BusesPeriodosIndexComponent",
    data() {
        return {
            tipo_reporte: '',
            fecha_inicio: '',
            fecha_fin: '',
            historial: [],
            historial_tripulante: [],
            buses_all: [],
            mostrarTabla: false,
            bus_id: 0,
            tripulante_id: 0,
            mostrarTablaModel: false,
        }
    },
    created() {
        this.getBusesAll()
    },
    updated() {
        $('#buses_id').on('select2:select',this.selectBuses)
    },
    methods: {
        selectBuses:function(e){
            const id = e.params.data.id
            this.bus_id = parseInt(id)

        },
        selectTipoReporte:function(e){
            const id = e.params.data.id
            this.tipo_reporte = id
        },
       async getHistorial() {
            try{
              //obtener el historico por fecha seleccionada query string
                this.mostrarTabla = false;
                let url = '/getBusesPeridos?OPTIONS=TODOS';

               if (this.fecha_inicio === '' && this.fecha_fin === '') {
                    //swal alert debe ingresar fechas
                    this.$swal({
                        title: 'Debe ingresar fechas',
                        text: 'Debe ingresar fechas para realizar la busqueda',
                        icon: 'warning',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#3085d6',
                    });
                    return;
                }else {
                    url = url + '&FECHA_INICIO=' + this.fecha_inicio + '&FECHA_FIN=' + this.fecha_fin;
                }

                //seleccionar el trabajador id
                if (this.bus_id > 0) {
                    url = url + '&filtro[BUS_ID]=' + this.bus_id;
                }else{
                    //swal alert debe seleccionar trabajador
                    this.$swal({
                        title: 'Debe seleccionar un bus',
                        text: 'Debe seleccionar un bus para realizar la busqueda',
                        icon: 'warning',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#3085d6',
                    });
                    return;
                }



                //SWAL alert cargando
            /*   this.$swal({
                    title: 'Cargando',
                    text: 'Cargando datos',
                    icon: 'info',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showConfirmButton: false,
                    showCancelButton: false,
                    showCloseButton: false,
                    showLoaderOnConfirm: true,
                    willOpen: () => {
                        Swal.showLoading()
                    },
                });*/

                const {data, status} = await axios.get(url);

                if (status === 200) {
                    //console.log(data)   //mostrar tabla
                    this.historial = data;

                    //si hay datos en el historial
                    if (this.historial.length > 0) {
                        //SWAL alert cargando
                        this.mostrarTabla = true;
                    } else {

                        this.$swal({
                            title: 'Resultado de la busqueda',
                            text: 'No se encontraron datos',
                            icon: 'warning',
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor: '#3085d6',
                        });
                        this.mostrarTabla = false;
                    }

                }

            }catch (error) {
                console.log(error);
            }
        },
        async getHistorialTripulante() {
            try{
                //obtener el historico por fecha seleccionada query string
                //this.mostrarTabla = false;
                let url = '/getHistorialTripulacion?OPTIONS=TODOS';

                if (this.fecha_inicio === '' && this.fecha_fin === '') {
                    //swal alert debe ingresar fechas
                    this.$swal({
                        title: 'Debe ingresar fechas',
                        text: 'Debe ingresar fechas para realizar la busqueda',
                        icon: 'warning',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#3085d6',
                    });
                    return;
                }else {
                    url = url + '&FECHA_INICIO=' + this.fecha_inicio + '&FECHA_FIN=' + this.fecha_fin;
                }

                //seleccionar el trabajador id
                if (this.tripulante_id > 0) {
                    url = url + '&filtro[ID_TRABAJADOR]=' + this.tripulante_id;
                }

                const {data, status} = await axios.get(url);

                if (status === 200) {
                    //console.log(data)   //mostrar tabla
                    this.historial_tripulante = data;

                }

            }catch (error) {
                console.log(error);
            }
        },
        imprimir(){
            const fecha_inicio = this.fecha_inicio
            const fecha_fin = this.fecha_fin
            const bus_id = this.bus_id
            const url = '/imprimirHistorialTripulacion?OPTIONS=TODOS&FECHA_INICIO='+fecha_inicio+'&FECHA_FIN='+fecha_fin+'&filtro[BUS_ID]='+bus_id
            window.open(url, '_blank')
        },
        async getBusesAll(){
            try {
                let  url = '/getBusesLista?operador=lista'


                const { data, status } = await axios.get(url)
                if (status === 200){
                    this.buses_all = data
                    //console.log(this.buses_all)
                }

            }catch (e) {
                console.log(e)
            }
        },
        abrirModal(id) {
            this.tripulante_id = parseInt(id);
            this.getHistorialTripulante();
            this.mostrarTablaModel = true;
            $('#modal-triuplacion').modal('show');
        },
        cerraroModal() {
            this.tripulante_id = 0;
            this.mostrarTablaModel = false;
            this.historial_tripulante = [];
            $('#modal-triuplacion').modal('hide');
        },
        getColorType(tipo) {
            if (!COLOR_CLASSES.hasOwnProperty(tipo)) {
                throw new Error(`Tipo ${tipo} no es válido`);
            }

            const colorClass = COLOR_CLASSES[tipo];
            return `<span class="badge ${colorClass}">${tipo}</span>`;
        },
        getColorType2(tipo) {
            if (!COLOR_CLASSES_MODEL.hasOwnProperty(tipo)) {
                throw new Error(`Tipo ${tipo} no es válido`);
            }

            const colorClass = COLOR_CLASSES_MODEL[tipo];
            return `<span class="badge ${colorClass}">${tipo}</span>`;
        },
        CloseCard(){
            this.$emit('change-boolean-value')
        }
    },
}
</script>

<style scoped>
.trabajador-hover {
    cursor: pointer;
}
</style>
