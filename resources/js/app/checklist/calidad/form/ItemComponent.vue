<!-- ItemComponent.vue -->
<template>
    <div class="content-item">
        <label class="mb-3" :for="`item-${item.id}`">{{ item.name }}</label>

        <div v-if="item.field.field_type === 'radio'">
            <div v-for="(option, optionKey) in parseOptions(item.field.options)" :key="optionKey">
                <label class="form-check form-check-custom form-check-solid mb-2">
                    <input class="form-check-input" type="radio" :value="option"
                           v-model="$parent.respuestas[item.id].respuesta" :name="`item-${item.id}-${item.id}`"
                           @change="$parent.updateRespuestas(item.id, item.field.id, option)">
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
                   :disabled="item.isDisable === 'si'"
            >

        </div>
        <!-- Renderizar items hijos si existen -->
        <div v-if="isVisible">

            <div v-if="item.children && item.children.length">
                <item-component
                    v-for="(child, childKey) in item.children"
                    :key="childKey"
                    :item="child"
                    :respuestas="respuestas"
                    :imagePreviews="imagePreviews"
                    :IsSeatMap="IsSeatMap"

                    :tipo-bus-seleccionado="tipoBusSeleccionado"

                    :nroAsientosCama="nroAsientosCama"
                    :nroAsientosSemicama="nroAsientosSemicama"
                    :nroAsientosPremium="nroAsientosPremium"
                    :nroAsientosMixto="nroAsientosMixto"

                    @updateRespuestas="updateRespuestas"
                    @handleFileUpload="handleFileUpload"
                    :tipoBusSeleccionado="tipoBusSeleccionado"
                >
                </item-component>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ItemComponent',
    props: {
        item: {
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

    },
    computed: {
        isVisible() {
            // Verificar si se debe ocultar los ítems hijos cuando el ítem padre es seleccionado
            if (this.item.hideChildrenOnSelect === 'si' && this.respuestas[this.item.id].respuesta === null || this.respuestas[this.item.id].respuesta === 'NO' || this.respuestas[this.item.id].respuesta === 'NA') {

                return false;
            }

            if (this.respuestas[this.item.id].respuesta === 'SI') {
                //en caso de poner no y haber escrito algo en observaciones resetea el campo
                this.respuestas[this.item.id].observaciones = '';
                this.respuestas[this.item.id].respuesta_add = '';
                return true;
            }

            if (this.respuestas[this.item.id].respuesta === 0) {
                return false;
            }

            // Mostrar si 'is_conteo' es 'no' o 'type_seats' es 'no aplica'
            if (this.item.is_conteo !== 'si' || this.item.type_seats === 'no aplica') {
                return true;
            }

            // Mostrar basado en la coincidencia entre 'type_seat' y 'tipoBusSeleccionado'
            if (this.item.type_seats === this.tipoBusSeleccionado) {
                return true;
            }

            // Por defecto, no mostrar el ítem
            return false;
        },
        respuestas107Respuesta() {
            return this.respuestas[107]?.respuesta;
        }
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
    watch: {
        /*'respuestas107Respuesta': function (newValue, oldValue) {
            // Lógica para manejar el cambio

            if (Number(this.respuestas[106].respuesta) === Number(newValue)) {
                this.respuestas[107].valor = 'SI';
            } else {
                this.respuestas[107].valor = 'NO';
            }
        }*/
       /* respuestas: {
            deep: true,
            handler(newRespuestas, oldRespuestas) {
                // Lógica para manejar cambios en las respuestas de los ítems hijos
                //console.log('Respuestas actualizadas:', newRespuestas[107].respuesta);
                for (const itemId in newRespuestas) {
                    console.log('Respuestas actualizadas:', newRespuestas[itemId].isConteo);
                    if (newRespuestas[itemId].isConteo) {
                       console.log('si se puede contar')
                    }else {
                        console.log('no se puede contar')
                    }
                }
            }
        },*/
        respuestas: {
            deep: true,
            handler(newRespuestas) {
                // Define los rangos de los hijos para cada padre
                const hijosDe106 = this.range(107, 115);
                const hijosDe116 = this.range(117, 125);
                const hijosDe126 = this.range(127, 135);

                for (const itemId in newRespuestas) {
                    const numItemId = parseInt(itemId);

                    // Determinar el padre del ítem actual, si tiene uno
                    let padreId = null;
                    if (hijosDe106.includes(numItemId)) padreId = 106;
                    else if (hijosDe116.includes(numItemId)) padreId = 116;
                    else if (hijosDe126.includes(numItemId)) padreId = 126;

                    // Solo aplicar la lógica si el ítem es hijo de un padre conocido y tiene isConteo en true
                    if (padreId && newRespuestas[itemId].isConteo) {
                        const valorPadre = parseInt(newRespuestas[padreId].respuesta, 10);
                        const valorHijo = parseInt(newRespuestas[itemId].respuesta, 10);

                        //sacar diferencia de los que falta
                        const diferencia = valorHijo === 0 ? valorPadre : valorPadre - valorHijo;

                        // Comparar el valor del hijo contra el valor del padre
                        if (valorHijo < valorPadre) {
                            this.respuestas[itemId].valor = 'NO';
                            this.respuestas[itemId].observaciones = `Faltan ${diferencia} de ${valorPadre}`;

                            // console.log('valor hijo menor que el padre')
                        } else if (valorHijo === valorPadre) {
                            this.respuestas[itemId].valor = 'SI';
                           // console.log('valor hijo igual que el padre')
                        } else if (valorHijo > valorPadre) {
                            // Mostrar un error si el valor del hijo es mayor que el del padre
                            Swal.fire({
                                icon: 'error',
                                title: 'Error en la validación',
                                text: `No debe superar el limite de asientos`,
                            });
                            // Opcionalmente, revertir el valor del hijo al del padre o tomar otra acción
                            this.respuestas[itemId].respuesta = this.respuestas[padreId].respuesta;
                        }

                    }
                }
            }
        },
    },
    methods: {
        range(start, end) {
            return Array.from({ length: (end - start + 1) }, (v, k) => k + start);
        },
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
        cargarValorInicial() {
            this.respuestas[106].respuesta = this.nroAsientosCama;
            this.respuestas[116].respuesta = this.nroAsientosSemicama;
            this.respuestas[126].respuesta = this.nroAsientosPremium;
        },
        shouldBeVisible(item) {
            // Asegurarse de que el valor es tratado como un número para la comparación
            const valor = Number(this.respuestas[item.id].respuesta);
            return valor !== 0;
        },
        esHijo(itemId) {
            // Implementa la lógica para determinar si el itemId corresponde a un hijo
            // Esto puede basarse en tu estructura de datos o en una convención específica
        },
        actualizarEstadoBasadoEnHijo(itemId, respuesta) {
            // Lógica para actualizar el estado basado en la respuesta de un ítem hijo
            // Esto podría incluir comparaciones con los valores de los padres y actualizaciones consecuentes
        },

    },

    mounted() {
        //this.cargarValorInicial();
    }
};
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
}</style>



