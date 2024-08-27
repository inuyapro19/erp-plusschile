<template>
    <div data-kt-stepper-element="content" class="current">
        <div>
            <div class="ficha-resumen">
                <div class="ficha-resumen-header">
                    <div>
                        <div class="label">BUS:</div>
                        <div class="value"> {{ busDescripcion }}</div>
                    </div>
                    <div>
                        <div class="label">FECHA:</div>
                        <div class="value">{{ fecha }}</div>
                    </div>
                    <div>
                        <div class="label">HORA SALIDA:</div>
                        <div class="value">{{ hora_salida }}</div>
                    </div>
                    <div>
                        <div class="label">TIPO SERVICIO:</div>
                        <div class="value">{{servicio}}</div>
                    </div>
                    <div>
                        <div class="label">CIUDAD ORIGEN:</div>
                        <div class="value">{{ destinoCiudad }}</div>
                    </div>
                    <div>
                        <div class="label">CIUDAD DESTINO:</div>
                        <div class="value">{{ destinoCiudad }}</div>
                    </div>

                </div>
            </div>

            <div class="d-flex flex-row flex-wrap justify-content-between">
                <item-component v-for="(item, itemKey) in currentCategoryItems.items"
                                :key="itemKey"
                                :item="item"
                                :respuestas="respuestas"
                                :imagePreviews="imagePreviews"
                                :IsSeatMap="IsSeatMap"
                                :tipoBusSeleccionado="tipoBusSeleccionado"

                                :nroAsientosCama="nroAsientosCama"
                                :nroAsientosSemicama="nroAsientosSemicama"
                                :nroAsientosPremium="nroAsientosPremium"
                                :nroAsientosMixto="nroAsientosMixto"

                                @updateRespuestas="updateRespuestas"
                                @handleFileUpload="handleFileUpload"


                >
                </item-component>

            </div>
        </div>
    </div>
</template>

<script>
import ItemComponent from './ItemComponent.vue'; // Asegúrate de importar correctamente

export default {
    components: {
        ItemComponent
    },
    props: {
        currentCategoryItems: {
            type: Object,
            required: true
        },
        respuestas: {
            type: Object,
            required: true
        },
        imagePreviews: {
            type: Object,
            required: true
        },
        IsSeatMap: {
            type: Boolean,
            required: false
        },
        tipoBusSeleccionado: {
            type: String,
            required: false,
            default: '' // Puedes definir un valor por defecto si es necesario
        },
        nroAsientosCama: {
            type: Number,
            required: false,
            default: 0
        },
        nroAsientosSemicama: {
            type: Number,
            required: false,
            default: 0
        },
        nroAsientosPremium: {
            type: Number,
            required: false,
            default: 0
        },
        nroAsientosMixto: {
            type: Number,
            required: false,
            default: 0
        },
        buses: {
            type: Array,
            required: false,
            default: () => []
        },
        bus_id: {
            type: Number,
            required: false,
            default: 0
        },
        fecha: {
            type: String,
            required: false,
            default: ''
        },
        hora_salida: {
            type: String,
            required: false,
            default: ''
        },
        servicio: {
            type: String,
            required: false,
            default: ''
        },
        destinos: {
            type: Array,
            required: false,
            default: () => []
        },
        destino_id: {
            type: Number,
            required: false,
            default: 0
        },

    },
    computed: {
        busDescripcion() {
            const bus = this.buses.find(bus => bus.id === this.bus_id);
            return bus ? `${bus.numero_bus}-${bus.patente}` : 'Bus no encontrado';
        },
        destinoCiudad() {
            const destino = this.destinos.find(destino => destino.id === this.destino_id);
            return destino ? destino.ciudad : 'Destino no encontrado';
        },
    },
    data() {
        return {
            seats: Array.from({length: 60}, (_, i) => i + 1),
            seat_selected: [],
            conductores: [],
            auxiliares: [],
            primer_conductor: '',
            segundo_conductor: '',
            primer_auxiliar: '',
        }
    },
    methods: {
        parseOptions(options) {
            return options.split(',');
        },
        updateRespuestas(itemId, fieldId, option) {
            this.$emit('updateRespuestas', itemId, fieldId, option);
        },
        handleFileUpload(event, itemId) {
            this.$emit('handleFileUpload', event, itemId);
        },
        toggleSeat(seat, itemId) {
            if (this.respuestas[itemId].respuesta !== 'NO') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Debe seleccionar la opción NO para poder seleccionar asientos',
                })
                return;
            }
            // Convertir la cadena en un array, considerando la posibilidad de que esté vacía
            let seatsArray = this.respuestas[itemId].respuesta_add
                ? this.respuestas[itemId].respuesta_add.split('-').map(Number)
                : [];

            let index = seatsArray.indexOf(seat);
            if (index !== -1) {
                // Quitar el asiento si ya está en el array
                seatsArray.splice(index, 1);
            } else {
                // Agregar el asiento si no está en el array
                seatsArray.push(seat);
            }

            // Ordenar y actualizar la propiedad observaciones
            this.respuestas[itemId].respuesta_add = seatsArray.sort((a, b) => a - b).join('-');
            localStorage.setItem('respuestas', JSON.stringify(this.respuestas));
        },

        isSeatSelected(seat, itemId) {
            // Convertir la cadena de observaciones en un array para la comprobación
            let seatsArray = this.respuestas[itemId].respuesta_add
                ? this.respuestas[itemId].respuesta_add.split('-').map(Number)
                : [];
            localStorage.setItem('respuestas', JSON.stringify(this.respuestas));

            return seatsArray.includes(seat);
        },

    }
}
</script>
<style scoped>
.content-item {
    width: 300px !important;
    margin-bottom: 20px;
}

.content-item label {
    font-size: 13px;
    font-weight: 600;
}

.seat-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    width: 300px;
    height: 300px;
    border: 1px solid black;
    margin-top: 5px;
}

.seat-map {
    width: 25px;
    height: 25px;
    background-color: white;
    border: 1px solid black;
    color: black;
    /*separacion entre asientos*/
    margin: 2px;
    /**alinea el numero al centro del cuadro*/
    display: flex;
    justify-content: center;
    align-items: center;
}

.seat-map.selected {
    background-color: green;
    color: white;
}

.disabled {
    cursor: not-allowed;
    pointer-events: all !important;
}
.ficha-resumen {
    display: flex;
    flex-direction: column;
    flex-wrap: wrap;
    justify-content: space-between;
    width: 100%;
    margin: 20px auto;

}
.ficha-resumen-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}
.ficha-resumen-header > div {
    flex: 1;
    text-align: left;
}
.ficha-resumen-header > div:not(:last-child) {
    margin-right: 10px;
}
.label {
    font-weight: bold;
    margin-bottom: 2px;
}
.value {
    font-size: 1em;
}
</style>

