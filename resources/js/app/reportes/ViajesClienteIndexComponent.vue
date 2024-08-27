<template>

   <div>
       <div class="card pt-5 mt-5">
           <div class="card-header">
               <h2>Reporte de Clientes</h2>
           </div>
           <div class="card-body pt-0">
               <div class="row mt-3">
                   <div class="col-md-6 form-group">
                       <label class="required fs-6 fw-semibold mb-2" for="trabajador_id">Bus</label>
                       <select name="bus_id"
                               class="form-select mb-2 form-select-solid fw-bold"
                               data-control="select2"
                               data-placeholder="Seleccione Cliente"
                               data-allow-clear="true"
                               id="cliente_id">
                           <option value="">--------</option>
                           <option v-for="({id,nombre_cliente}, index) in cliente_all"  :value="id">{{nombre_cliente}}</option>

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
    updated() {
        $('#cliente_id').on('select2:select',this.selectCliente)
    },
    methods: {
        selectCliente:function(e){
            const id = e.params.data.id
            this.cliente_id = parseInt(id)
        },
       async getHistorial() {
            try{
              //obtener el historico por fecha seleccionada query string
                this.mostrarTabla = false;
                let url = '/getViajesMineria?OPTIONS=TODOS';

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
                if (this.cliente_id > 0) {
                    url = url + '&filtro[CLIENTE_ID]=' + this.cliente_id;
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
                window.open(url, '_blank');

            }catch (error) {
                console.log(error);
            }
        },
        async cargarClientes(){
            try {
                const {data , status} = await axios.get('/clientes')
                if (status == 200) {
                    this.cliente_all = data
                }
            }catch (error){
                console.log(error)
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
