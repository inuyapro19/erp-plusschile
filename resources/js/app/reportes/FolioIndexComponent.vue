<template>

    <div>
        <div class="card pt-5 mt-5">
            <div class="card-header">
                <h2>Reporte de Viajes por folios</h2>
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
                                id="bus2_id">
                            <option value="">--------</option>
                            <option v-for="({id,numero_bus,patente}, index) in buses_all"  :value="id">{{numero_bus+' - '+patente}}</option>

                        </select>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="required fs-6 fw-semibold mb-2" for="trabajador_id">Folios</label>
                        <select name="folio_id"
                                class="form-select mb-2 form-select-solid fw-bold"
                                data-control="select2"
                                data-placeholder="Seleccione folios"
                                data-allow-clear="true"
                                id="folio_id">
                            <option value="">--------</option>
                            <option v-for="({id,nro_folio}, index) in folios_all"  :value="id">{{nro_folio}}</option>

                        </select>
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
                        <th>FOLIO</th>
                        <th>NRO VIAJE</th>
                        <th>NRO BUS</th>
                        <th>PATENTE</th>
                        <th>FECHA</th>
                        <th>DESTINO</th>
                        <th>DESTINO</th>



                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="({
                            VIAJE_ID,
                            NUMERO_VIAJE,
                            BUS_ID,
                            NUMERO_BUS,
                            PATENTE,
                            DESTINO_ID,
                            CIUDAD_DESTINO,
                            ORIGEN_ID,
                            CIUDAD_ORIGEN,
                            FECHA_SALIDA,
                            FECHA_LLEGADA,
                            FOLIO_ID,
                            NRO_FOLIO

                        },index) in historial">
                        <td></td>
                        <td>{{NRO_FOLIO}}</td>
                        <td>{{NUMERO_VIAJE}}</td>
                        <td>{{NUMERO_BUS}}</td>
                        <td>{{PATENTE}}</td>
                        <td>{{FECHA_SALIDA | formatoFecha}}</td>
                        <td>{{CIUDAD_ORIGEN}}</td>
                        <td>{{CIUDAD_DESTINO}}</td>

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
            folios_all: [],
            folio_id: 0,
        }
    },
    created() {
        this.getBusesAll()
        this.getFoliosAll()
    },
    updated() {
        $('#bus2_id').on('select2:select',this.selectBuses)
        $('#folio_id').on('select2:select',this.selectFolio)
    },
    //observa que la fecha inicio no se mayor a la fecha fin con swal

    methods: {
        selectBuses:function(e){
            const id = e.params.data.id
            this.bus_id = parseInt(id)

        },
        selectFolio:function(e){
            const id = e.params.data.id
            this.folio_id = parseInt(id)
        },
        async getHistorial() {
            try{
                //obtener el historico por fecha seleccionada query string
                this.mostrarTabla = false;
                let url = '/getViajesFolio?OPTIONS=TODOS';



                //seleccionar el trabajador id
                if (this.bus_id > 0) {
                    url = url + '&filtro[BUS_ID]=' + this.bus_id;
                }

                if (this.folio_id > 0) {
                    url = url + '&filtro[FOLIO_ID]=' + this.folio_id;
                }else{
                    this.$swal({
                        title: 'Resultado de la busqueda',
                        text: 'Debe seleccionar un folio',
                        icon: 'warning',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#3085d6',
                    });
                    return false;
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
        async getFoliosAll(){
            try {
                let  url = '/getFolios'


                const { data, status } = await axios.get(url)
                if (status === 200){
                    this.folios_all = data
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
        CloseCard(){
            this.$emit('change-boolean-value')
        }
    },
}
</script>

<style scoped>

</style>
