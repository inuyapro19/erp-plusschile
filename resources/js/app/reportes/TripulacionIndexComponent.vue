<template>

   <div>
       <div class="card pt-5 mt-5">
           <div class="card-header">
               <h2>Reporte de historial de tripulante</h2>
           </div>
           <div class="card-body pt-0">
               <div class="row mt-3">
                   <div class="col-md-6 form-group">
                       <label class="required fs-6 fw-semibold mb-2" for="tipo_reporte">Tipo de reporte</label>
                       <select name="tipo_reporte"
                               class="form-select mb-2 form-select-solid fw-bold"
                               data-placeholder="Seleccione tipo de reporte"
                               v-model="tipo_reporte"
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
                   class="btn btn-bg-primary">
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
                       <th>RUT</th>
                       <th>NOMBRE</th>
                       <th>CARGO</th>
                       <th>FECHA INICIO</th>
                       <th>FECHA FINAL</th>
                       <th>DIAS</th>

                   </tr>
                   </thead>
                   <tbody>
                   <tr v-for="({ID_TRABAJADOR,
                                RUT,
                                NOMBRE_COMPLETO,
                                CARGO,
                                FECHA_INICIO,
                                FECHA_FIN,
                                DIAS,
                                TIPO
                                },index) in historial">
                       <td></td>
                       <td>{{RUT}}</td>
                       <td>{{NOMBRE_COMPLETO}}</td>
                       <td>{{CARGO}}</td>
                       <td>{{FECHA_INICIO | FormatoFecha}}</td>
                       <td>{{FECHA_FIN | FormatoFecha}}</td>
                       <td>{{DIAS}}</td>

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
    'DIAS LIBRES': 'badge-dark',
};
export default {
    name: "TripulacionIndexComponent",
    data() {
        return {
            tipo_array:['LICENCIA MEDICA','VACACIONES','PERMISO ESPECIALES','FALLA','DIAS LIBRES'],
            tipo_reporte: '',
            fecha_inicio: '',
            fecha_fin: '',
            historial: [],
            mostrarTabla: false,
        }
    },
    updated() {
       // $('#trabajador_id').on('select2:select',this.selectTrabajador)
        $('#tipo_reporte').on('select2:select',this.selectTipoReporte)
    },
    methods: {
        selectTipoReporte:function(e){
            const id = e.params.data.id
            console.log(id)
            this.tipo_reporte = id
        },
       async getHistorial() {
            try{
              //obtener el historico por fecha seleccionada query string
                this.mostrarTabla = false;
                let url = '/getHistorialPorConceptos?OPTIONS=TODOS';

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

                //seleccionar el tipo de reporte
                if (this.tipo_reporte !== '') {
                    url = url + '&filtro[TIPO]=' + this.tipo_reporte;
                }

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
        getColorType(tipo) {
            if (!COLOR_CLASSES.hasOwnProperty(tipo)) {
                throw new Error(`Tipo ${tipo} no es válido`);
            }

            const colorClass = COLOR_CLASSES[tipo];
            return `<span class="badge ${colorClass}">${tipo}</span>`;
        },
        CloseCard(){
            this.$emit('change-boolean-value')
        }
    },
}
</script>

<style scoped>

</style>
