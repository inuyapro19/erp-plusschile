<template>

   <div>
       <div class="card pt-5 mt-5">
           <div class="card-header">
               <h2>Reporte de Buses por Viajes</h2>
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
                               id="bus_id">
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
               <button class="btn btn-secondary bt-sm mb-4" @click="imprimir()">IMPRIMIR</button>
               <table  class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                   <thead>
                   <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                       <th></th>
                       <th>FECHA</th>
                       <th>HORA</th>
                       <th>DESTINO</th>
                       <th>MONTO</th>
                       <th>OBSERVACIONES</th>


                   </tr>
                   </thead>
                   <tbody>
                   <tr v-for="({
                            DESTINO,
                            FECHA_VIAJE,
                            HORA_SALIDA,
                            MONTO_TOTAL,
                            NOTA_VIAJE
                        },index) in historial">
                       <td></td>
                       <td>{{FECHA_VIAJE | FormatoFecha}}</td>
                       <td>{{HORA_SALIDA}}</td>
                       <td>{{DESTINO}}</td>
                       <td>{{MONTO_TOTAL}}</td>
                       <td>{{NOTA_VIAJE}}</td>
                   </tr>
                   </tbody>
               </table>
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
export default {
    name: "BusesIndexComponent",
    data() {
        return {
            tipo_reporte: '',
            fecha_inicio: '',
            fecha_fin: '',
            historial: [],
            buses_all: [],
            mostrarTabla: false,
            bus_id: 0,
        }
    },
    created() {
        this.getBusesAll()
    },
    updated() {
        $('#bus_id').on('select2:select',this.selectBuses)
    },
    //observa que la fecha inicio no se mayor a la fecha fin con swal

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
                let url = '/getHistorialBuses?OPTIONS=TODOS';

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
            const bus_id = this.bus_id
            const url = '/imprimirHistorialBuses?OPTIONS=TODOS&FECHA_INICIO='+fecha_inicio+'&FECHA_FIN='+fecha_fin+'&filtro[BUS_ID]='+bus_id
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
