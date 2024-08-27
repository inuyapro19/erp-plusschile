<template>

   <div>
       <div class="card pt-5 mt-5">
           <div class="card-header">
               <h2>Reporte de Viajes</h2>
           </div>
           <div class="card-body pt-0">


               <div class="row mt-5">
                   <div class="col-md-6 form-group">
                       <label class="required fs-6 fw-semibold mb-2" for="fecha_inicio">Fecha</label>
                       <input type="date"
                              class="form-control mb-2 form-control-solid fw-bold"
                              id="fecha_inicio"
                              v-model="fecha_inicio"
                              name="fecha_inicio">
                   </div>

               </div>

           </div>
           <div class="card-footer flex-center">
               <button
                   @click="getHistorial()"
                   class="btn btn-bg-primary fw-bold">
                      Buscar
               </button>
               <button
                   @click="CloseCard()"
                   class="btn btn-bg-secondary">
                   Cerrar
               </button>
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
            cliente_all: [],
            mostrarTabla: false,
            cliente_id: 0,
        }
    },
    created() {
        this.cargarClientes()
    },
    methods: {

       async getHistorial() {
            try{
              //obtener el historico por fecha seleccionada query string
                this.mostrarTabla = false;
                let url = '/getViajesMineria?OPTIONS=TODOS';

               if (this.fecha_inicio === '') {
                    //swal alert debe ingresar fechas
                    this.$swal({
                        title: 'Debe ingresar fecha',
                        text: 'Debe ingresar fechas para realizar la busqueda',
                        icon: 'warning',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#3085d6',
                    });
                    return;
                }else {
                    url = url + '&filtro[FECHA_VIAJE]=' + this.fecha_inicio;
                }

                window.open(url, '_blank');

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
