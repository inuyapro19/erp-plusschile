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
        <div v-else-if="item.field.field_type === 'text' || item.field.field_type === 'number' || item.field.field_type === 'date'">
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

      /*  respuestas: {
            deep: true,
            handler(newRespuestas) {
                const fechaActualStr = this.obtenerFechaActualEnFormatoISO();
                const idsFechasVencimiento = [206, 295].concat(this.range(173, 177));

                for (const itemId in newRespuestas) {
                    const numItemId = parseInt(itemId);

                    if (idsFechasVencimiento.includes(numItemId)) {
                        const fechaVencimientoStr = newRespuestas[itemId].respuesta;
                        const diasDiferencia = this.diferenciaEnDias(fechaActualStr, fechaVencimientoStr);

                        // Si faltan 15 días o menos para el vencimiento
                        if (diasDiferencia <= 15 && diasDiferencia >= 0) {
                            this.respuestas[itemId].valor = 'NO';
                            this.respuestas[itemId].observaciones = `Faltan ${diasDiferencia} días por vencerse el certificado`;
                        } else if (fechaActualStr > fechaVencimientoStr) {
                            // Si ya está vencido
                            this.respuestas[itemId].valor = 'NO';
                            this.respuestas[itemId].observaciones = 'Certificado vencido';
                        } else {
                            // Si no está dentro de los 15 días y no está vencido
                            this.respuestas[itemId].valor = 'SI';
                            this.respuestas[itemId].observaciones = 'Certificado válido';
                        }
                    }
                }
                const idsMilimetrajeRuedas = [284, 287, 291, 293, 296, 298, 302, 305];
                idsMilimetrajeRuedas.forEach(id => {
                    const milimetraje = newRespuestas[id].respuesta;
                    if (milimetraje <= 25) {
                        this.respuestas[id].valor = 'NO';
                        this.respuestas[id].observaciones = 'El milimetraje de las ruedas es menor a 2mm';
                    } else {
                        this.respuestas[id].valor = 'SI';
                        this.respuestas[id].observaciones = 'El milimetraje de las ruedas es mayor a 2mm';
                    }
                });

                //indique la fecha de la proxima revision , avisar un mes antes de la fecha de vencimiento item  206 347
                const idsFechasProximaRevision = [206, 347];
                idsFechasProximaRevision.forEach(id => {
                    const fechaProximaRevision = newRespuestas[id].respuesta;
                    const diasDiferencia = this.diferenciaEnDias(fechaActualStr, fechaProximaRevision);
                    if (diasDiferencia <= 30 && diasDiferencia >= 0) {
                        this.respuestas[id].valor = 'NO';
                        this.respuestas[id].observaciones = `Faltan ${diasDiferencia} días para la próxima revisión`;
                    } else {
                        this.respuestas[id].valor = 'SI';
                        this.respuestas[id].observaciones = 'Próxima revisión en fecha';
                    }
                });

            }
        }*/
        respuestas: {
            deep: true,
            handler(newRespuestas) {
                let updates = []; // Array to store updates to be applied after checks
                const fechaActualStr = this.obtenerFechaActualEnFormatoISO();
                const idsFechasVencimiento = [].concat(this.range(173, 177));

                // Checks for 'idsFechasVencimiento'
                idsFechasVencimiento.forEach(itemId => {
                    const fechaVencimientoStr = newRespuestas[itemId]?.respuesta;
                    if (fechaVencimientoStr) {
                        const diasDiferencia = this.diferenciaEnDias(fechaActualStr, fechaVencimientoStr);
                        let valor, observaciones;

                        if (diasDiferencia <= 15 && diasDiferencia >= 0) {
                            valor = 'NO';
                            observaciones = `Faltan ${diasDiferencia} días por vencerse el certificado`;
                        } else if (fechaActualStr > fechaVencimientoStr) {
                            valor = 'NO';
                            observaciones = 'Certificado vencido';
                        } else {
                            valor = 'SI';
                            observaciones = 'Certificado válido';
                        }
                        updates.push({ itemId, valor, observaciones });
                    }
                });

                // Checks for 'idsMilimetrajeRuedas'
                const idsMilimetrajeRuedas = [284, 287, 291, 293, 296, 298, 302, 305];
                idsMilimetrajeRuedas.forEach(itemId => {
                    const milimetraje = newRespuestas[itemId]?.respuesta;
                    if (milimetraje) {
                        let valor, observaciones;
                        if (milimetraje <= 25) {
                            valor = 'NO';
                            observaciones = 'El milimetraje de las ruedas es menor a 2mm';
                        } else {
                            valor = 'SI';
                            observaciones = 'El milimetraje de las ruedas es mayor a 2mm';
                        }
                        updates.push({ itemId, valor, observaciones });
                    }
                });

                // Checks for 'idsFechasProximaRevision'
                const idsFechasProximaRevision = [206, 347];
                idsFechasProximaRevision.forEach(itemId => {
                    const fechaProximaRevision = newRespuestas[itemId]?.respuesta;
                    if (fechaProximaRevision) {
                        const diasDiferencia = this.diferenciaEnDias(fechaActualStr, fechaProximaRevision);
                        let valor, observaciones;

                        if (diasDiferencia <= 30 && diasDiferencia >= 0) {
                            valor = 'NO';
                            observaciones = `Faltan ${diasDiferencia} días para la próxima revisión`;
                        } else {
                            valor = 'SI';
                            observaciones = 'Próxima revisión en fecha';
                        }
                        updates.push({ itemId, valor, observaciones });
                    }
                });

                // Apply all collected updates
                if (updates.length) {
                    this.$nextTick(() => {
                        this.applyRespuestasUpdates(updates);
                    });
                }
            }
        }

    },
    methods: {
        applyRespuestasUpdates(updates) {
            updates.forEach(({ itemId, valor, observaciones }) => {
                this.respuestas[itemId].valor = valor;
                this.respuestas[itemId].observaciones = observaciones;
            });
        },
        obtenerFechaActualEnFormatoISO() {
            const hoy = new Date();
            const año = hoy.getFullYear();
            const mes = (hoy.getMonth() + 1).toString().padStart(2, '0');
            const día = hoy.getDate().toString().padStart(2, '0');
            return `${año}-${mes}-${día}`;
        },
        diferenciaEnDias(fecha1, fecha2) {
            const MILISEGUNDOS_POR_DIA = 1000 * 60 * 60 * 24;
            let diff = new Date(fecha2) - new Date(fecha1);
            return Math.floor(diff / MILISEGUNDOS_POR_DIA);
        },
        range(start, end) {
            return Array(end - start + 1).fill().map((_, idx) => start + idx);
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



