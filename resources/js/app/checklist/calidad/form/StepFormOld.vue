<template>

    <div data-kt-stepper-element="content" class="current">


        <!-- Contenido dinámico basado en la categoría actual -->
        <div>
            <h2 class="fw-bold text-dark">{{ currentCategoryItems.name }}</h2>
            <div class="d-flex flex-row flex-wrap justify-content-between">
                <!-- Itera sobre los items de la categoría actual -->
                <div class="content-item" v-for="(item, itemKey) in currentCategoryItems.items"
                     :key="itemKey">
                    <label class="mb-3" :for="`item-${item.id}`">{{ item.name }}</label>
                    <div v-if="item.field.field_type === 'radio'">
                        <div v-for="(option, optionKey) in parseOptions(item.field.options)"
                             :key="optionKey">
                            <label class="form-check form-check-custom form-check-solid mb-2">
                                <input class="form-check-input" type="radio" :value="option"
                                       v-model="respuestas[item.id].respuesta"
                                       :name="`item-${item.id}-${currentCategoryItems.id}`"
                                       @change="updateRespuestas(item.id, item.field.id, option)">
                                <span class="form-check-label">{{ option }}</span>
                            </label>
                        </div>
                        <div class="content-item py-3 px-2" v-show="respuestas[item.id].respuesta === 'NO'">

                            <input type="text" class="form-control form-control-solid mb-8"
                                   v-model="respuestas[item.id].observaciones"
                                   :disabled="respuestas[item.id].respuesta !== 'NO'"
                                   v-show="respuestas[item.id].respuesta === 'NO' && item.is_observations ==='si'"
                                   placeholder="Observaciones"
                                   :class="{ 'disabled': respuestas[item.id].respuesta !== 'NO' }"
                            >

                            <input v-show="respuestas[item.id].respuesta === 'NO' && item.is_seats ==='si'" type="text"
                                   class="form-control form-control-solid mb-8 disabled"
                                   v-model="respuestas[item.id].respuesta_add"
                                   placeholder="Asientos"
                                   :disabled="true"
                            >
                            <div v-show="respuestas[item.id].respuesta === 'NO' && item.is_seats ==='si'"
                                 class="seat-container">
                                <div class="seat-map" v-for="(seat, index) in seats" :key="index"
                                     @click="respuestas[item.id].respuesta === 'NO' ? toggleSeat(seat, item.id) : null"
                                     :class="{ 'selected': isSeatSelected(seat, item.id) }">
                                    {{ seat }}
                                </div>
                            </div>

                            <input v-show="respuestas[item.id].respuesta === 'NO' && item.is_attachement ==='si'"
                                   type="file" class="form-control form-control-solid mt-2"
                                   @change="handleFileUpload($event, item.id)"
                                   :disabled="respuestas[item.id].respuesta !== 'NO'"
                                   :class="{ 'disabled': respuestas[item.id].respuesta !== 'NO' }"
                            >


                            <img
                                class="mt-2"
                                width="100px"
                                v-if="imagePreviews[item.id]"
                                :src="imagePreviews[item.id]"
                                alt="Image preview">
                            <img
                                class="mt-2"
                                width="100px"
                                v-if="respuestas[item.id].images"
                                :src="'/storage/'+respuestas[item.id].images"
                                alt="Image preview">
                        </div>
                    </div>

                    <div v-else-if="item.field.field_type === 'text' || item.field.field_type === 'number'">
                        <input :type="item.field.field_type" class="form-control form-control-solid mb-8"
                               v-model="respuestas[item.id].respuesta"
                         >

                    </div>




                </div>



            </div>
        </div>
    </div>
</template>

<script>

export default {
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
        },

        isSeatSelected(seat, itemId) {
            // Convertir la cadena de observaciones en un array para la comprobación
            let seatsArray = this.respuestas[itemId].respuesta_add
                ? this.respuestas[itemId].respuesta_add.split('-').map(Number)
                : [];
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
</style>
