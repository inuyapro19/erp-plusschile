<template>

   <div>
       <div class="card pt-5 mt-5">
           <div class="card-header">
               <h2>Reporte de historial de tripulante</h2>
           </div>
           <div class="card-body pt-0">
               <div class="row mt-3">
                   <div class="col-md-6 form-group">
                       <label class="required fs-6 fw-semibold mb-2" for="trabajador_id">Nombre Tripulante</label>
                       <select name="trabajador_id"
                               class="form-select mb-2 form-select-solid fw-bold"
                               data-control="select2"
                               data-placeholder="Seleccione trabajador"
                               data-allow-clear="true"
                               id="trabajador_id">
                           <option value="">--------</option>
                           <option v-for="({TRABAJADOR_ID,RUT,NOMBRE_COMPLETO}, index) in trabajadores_list"  :value="TRABAJADOR_ID">{{RUT+' - '+NOMBRE_COMPLETO}}</option>

                       </select>
                   </div>
                   <div class="col-md-6 form-group">
                       <label class="required fs-6 fw-semibold mb-2" for="tipo_reporte">Tipo de reporte</label>
                       <select name="tipo_reporte"
                               class="form-select mb-2 form-select-solid fw-bold"
                               data-control="select2"
                               data-placeholder="Seleccione tipo de reporte"
                               data-allow-clear="true"
                               id="tipo_reporte">
                           <option value="">--------</option>
                           <option v-for="tipo in tipo_array" :value="tipo">{{tipo}}</option>
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
               <button class="btn btn-secondary bt-sm mb-4" @click="imprimir()">IMPRIMIR</button>

               <table  class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
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
                   <tr v-for="({ID_TRABAJADOR, BUS,RUT ,NOMBRE_COMPLETO ,TIPO,CARGO,FECHA_FIN},index) in historial">
                       <td></td>
                       <td>{{RUT}}</td>
                       <td>{{NOMBRE_COMPLETO}}</td>
                       <td>{{CARGO}}</td>
                       <td>{{BUS}}</td>
                       <td v-html="getColorType(TIPO)"></td>
                       <td>{{FECHA_FIN}}</td>
                   </tr>
                   </tbody>
               </table>
           </div>
       </div>
   </div>




</template>

<script>

const COLOR_CLASSES = {
    'LICENCIA MEDICA': 'badge-primary',
    'VACACIONES': 'badge-success',
    'PERMISO ESPECIALES': 'badge-warning',
    'FALLA': 'badge-danger',
    'VIAJE': 'badge-info',
    'DIAS LIBRES': 'badge-dark',
};
export default {
    name: "IndexComponent",
    data() {
        return {
            tipo_array:['LICENCIA MEDICA','VACACIONES','PERMISO ESPECIALES','FALLA','VIAJE','DIAS LIBRES'],
            tipo_reporte: '',
            fecha_inicio: '',
            fecha_fin: '',
            historial: [],
            trabajadores_list: [],
            mostrarTabla: false,
        }
    },
    created() {
        this.getTrabajadores()
    },
    updated() {
        $('#trabajador_id').on('select2:select',this.selectTrabajador)
        $('#tipo_reporte').on('select2:select',this.selectTipoReporte)
    },
    methods: {
        selectTrabajador:function(e){
            const id = e.params.data.id
            this.trabajador_id = parseInt(id)

        },
        selectTipoReporte:function(e){
            const id = e.params.data.id
            this.tipo_reporte = id
        },
       async getHistorial() {
            try{
              //obtener el historico por fecha seleccionada query string
                this.mostrarTabla = false;
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
                if (this.trabajador_id > 0) {
                    url = url + '&filtro[ID_TRABAJADOR]=' + this.trabajador_id;
                }else{
                    //swal alert debe seleccionar trabajador
                    this.$swal({
                        title: 'Debe seleccionar un trabajador',
                        text: 'Debe seleccionar un trabajador para realizar la busqueda',
                        icon: 'warning',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#3085d6',
                    });
                    return;
                }

                //seleccionar el tipo de reporte
                if (this.tipo_reporte !== '') {
                    url = url + '&filtro[TIPO]=' + this.tipo_reporte;
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
        async getTrabajadores (){
            try{
                const {data, status} = await axios.get('/lista-tripulacion?opciones=all')

                if (status === 200){
                    this.trabajadores_list = data
                }

            }catch (e) {
                console.log(e)
            }
        },
        getColorType(tipo) {
            if (!COLOR_CLASSES.hasOwnProperty(tipo)) {
                throw new Error(`Tipo ${tipo} no es válido`);
            }

            const colorClass = COLOR_CLASSES[tipo];
            return `<span class="badge ${colorClass}">${tipo}</span>`;
        },
        imprimir(){
            const fecha_inicio = this.fecha_inicio
            const fecha_fin = this.fecha_fin
            const trabajador_id = this.trabajador_id
            const url = '/imprimirHistorialTripulacion?OPTIONS=TODOS&FECHA_INICIO='+fecha_inicio+'&FECHA_FIN='+fecha_fin+'&filtro[ID_TRABAJADOR]='+trabajador_id
            window.open(url, '_blank')
        },
        CloseCard(){
            this.$emit('change-boolean-value')
        }
    },
}
</script>

<style scoped>

</style>
