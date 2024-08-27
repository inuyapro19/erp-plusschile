<template>
    <div class="row mb-5">
        <div class="col-md-5 mb-5" v-if="isEdit">
            <label class="fs-6 fw-semibold mb-2" for="">Bus</label>
            <select
                v-model="bus_id"
                class="form-select form-select-solid"
                :disabled="true"

            >
                <option
                    v-for="(bus, index) in buses"
                    :key="bus.id"
                    :value="bus.id">
                    {{ bus.numero_bus + ' - ' + bus.patente }}
                </option>
            </select>

        </div>
        <div class="col-md-5 mb-5" v-else>
            <label class="fs-6 fw-semibold mb-2" for="">Bus</label>
            <!--                    <select-2
                                    v-model="bus_id"
                                    dataType="number"
                                    label="Seleccione un bus"
                                >
                                    <option
                                        v-for="(bus, index) in buses"
                                        :key="bus.id"
                                        :value="bus.id">
                                        {{ bus.numero_bus + ' - ' + bus.patente }}
                                    </option>
                                </select-2>-->
            <v-select
                :options="formattedBuses"
                label="label"
                class="form-control form-control-solid"
                :reduce="bus => bus.id" v-model="bus_id"
                style="padding:0px !important"
            ></v-select>

        </div>
        <div class="col-md-5 mb-5">
            <label class="fs-6 fw-semibold mb-2" for="">Fecha</label>
            <input type="date"
                   v-model="fecha"
                   class="form-control form-control-solid disabled"
                   :disabled="true"
            >
        </div>
        <div class="col-md-5 mb-5">
            <label class="fs-6 fw-semibold mb-2" for="">Modelo</label>
            <input type="text"
                   v-model="modelo"
                   class="form-control form-control-solid disabled"
                   :disabled="true"
            >
        </div>
        <div class="col-md-5 mb-5">
            <label class="fs-6 fw-semibold mb-2" for="">Marca</label>
            <input type="text"
                   v-model="marca"
                   class="form-control form-control-solid disabled"
                   :disabled="true"
            >
        </div>
        <div class="col-md-5 mb-5">
            <label class="fs-6 fw-semibold mb-2" for="">Kilometraje Anterior</label>
            <input type="text"
                   v-model="kilometraje_ant"
                   class="form-control form-control-solid disabled"
                   :disabled="true"
            >
        </div>
        <div class="col-md-5 mb-5">
            <label class="fs-6 fw-semibold mb-2" for="">Kilometraje Actual</label>
            <input type="number"
                   v-model="kilometrajeInput"
                   class="form-control form-control-solid"
            >
            <p class="text-danger" v-if="kilometrajeError">{{ kilometrajeError }}</p>
        </div>

    </div>
</template>

<script>
export default {
    props: {
        isEdit: {
            type: Boolean,
            default: false
        },
        bus_id: {
            type: Number,
            default: null
        },
        buses: {
            type: Array,
            default: () => []
        },
        fecha: String,
        modelo: String,
        marca: String,
        isProgramacion: Boolean,
        hora_salida: {
            type: String,
            default: '00:00'
        },
        servicio: {
            type: String,
            default: 'SIN PROGRAMACION'
        },
        servicios: {
            type: Array,
            default: () => []
        },
        origen_id: {
            type: Number,
            default: null
        },
        destino_id: Number,
        destinos: {
            type: Array,
            default: () => []
        },
        numero_pisos: {
            type: Number,
            default: 2
        },
        kilometraje_ant: {
            type: Number,
            default: 0
        },
        kilometraje_act: {
            type: Number,
            default: 0
        },
        kilometrajeError: {
            type: String,
            default: ''
        },
    },
    watch: {
        // Observa los cambios en isProgramacion
        bus_id(newBusId) {
            this.$emit('update', { prop: 'bus_id', value: newBusId });
            localStorage.setItem('bus_id', newBusId);
            const selectedBus = this.buses.find(bus => bus.id === newBusId);
            //console.log(selectedBus)
            if (selectedBus) {
                this.modelo = selectedBus.modelo_carroceria;
                localStorage.setItem('modelo', this.modelo);
                this.$emit('update', { prop: 'modelo', value: this.modelo });

                this.marca = selectedBus.marca_carroceria;
                localStorage.setItem('marca', this.marca);
                this.$emit('update', { prop: 'marca', value: this.marca });
                this.numero_pisos = selectedBus.numero_piso;
                localStorage.setItem('numero_pisos', this.numero_pisos);
                this.$emit('update', { prop: 'numero_pisos', value: this.numero_pisos });
                if (this.numero_pisos === 1) {
                    //elimina el id 5
                   this.checklistItems = this.checklistItems.filter(item => item.id !== 18 && item.id !== 19);
                    this.$emit('update', { prop: 'checklistItems',  value:this.checklistItems });

                } else {
                    //emit evento
                    this.$emit('fetchChecklistData');
                    //this.fetchChecklistData()
                }
                console.log(this.numero_pisos)
                //emit evento
                this.$emit('getRevisionData');
                this.$emit('getAllItemReported');
                ///this.getAllItemReported()
            }
        },
        fecha(newFecha) {
            localStorage.setItem('fecha', newFecha);
            this.$emit('update', { prop: 'fecha', value: newFecha });
        },
        hora_salida(newHoraSalida) {
            this.$emit('update', { prop: 'hora_salida', value: newHoraSalida });
        },
        servicio(newServicio) {
            this.$emit('update', { prop: 'servicio', value: newServicio });
        },
        origen_id(newOrigenId) {
            this.$emit('update', { prop: 'origen_id', value: newOrigenId });
        },
        destino_id(newDestinoId) {
            this.$emit('update', { prop: 'destino_id', value: newDestinoId });
        },
        modelo(newModelo) {
            localStorage.setItem('modelo', newModelo);
            this.$emit('update', { prop: 'modelo', value: newModelo });
        },
        marca(newMarca) {
            localStorage.setItem('marca', newMarca);
            this.$emit('update', { prop: 'marca', value: newMarca });
        },
        numero_pisos(newNumeroPisos) {
            localStorage.setItem('numero_pisos', newNumeroPisos);
            this.$emit('update', { prop: 'numero_pisos', value: newNumeroPisos });
        }
    },
    methods: {
        obtenerAsientosYTipo() {
            // Lógica para obtener los asientos y el tipo
            this.$emit('obtenerAsientosYTipo', this.bus_id);
        },
        cargarDatos(){
            let bus_id = localStorage.getItem('bus_id');
            let fecha = localStorage.getItem('fecha');
            let marca = localStorage.getItem('marca');
            let modelo = localStorage.getItem('modelo');
            let numero_pisos = localStorage.getItem('numero_pisos');
            let kilometraje_ant = localStorage.getItem('kilometraje_ant');
            let kilometraje_act = localStorage.getItem('kilometraje_act');
            if (bus_id) {
                this.$emit('update', { prop: 'bus_id', value: parseInt(bus_id) });
            }

            if (fecha) {
                this.$emit('update', { prop: 'fecha', value: fecha });
            }

            if (marca) {
                this.$emit('update', { prop: 'marca', value: marca });
            }

            if (modelo) {
                this.$emit('update', { prop: 'modelo', value: modelo });
            }

            if (numero_pisos) {
                this.$emit('update', { prop: 'numero_pisos', value: parseInt(numero_pisos) });
            }

            if (kilometraje_ant) {
                this.$emit('update', { prop: 'kilometraje_ant', value: parseInt(kilometraje_ant) });
            }

            if (kilometraje_act) {
                this.$emit('update', { prop: 'kilometraje_act', value: parseInt(kilometraje_act) });
            }

        }
    },
    computed: {
        formattedBuses() {
            return this.buses.map(bus => ({
                id: bus.id,
                label: bus.numero_bus + ' - ' + bus.patente
            }));
        },
        kilometrajeInput: {
            get() {
                // Devuelve el valor actual de kilometraje_act para el input.
                return this.kilometraje_act;
            },
            set(value) {
                // Realiza la validación cuando el usuario intenta cambiar el valor.
                if (value >= this.kilometraje_ant) {
                    // Si el nuevo valor es válido, actualiza kilometraje_act.
                    localStorage.setItem('kilometraje_ant', this.kilometraje_ant);
                    this.kilometraje_act = value;
                    localStorage.setItem('kilometraje_act', value);
                    this.$emit('update', { prop: 'kilometraje_act', value: value });
                    this.kilometrajeError = '';
                    this.$emit('update', { prop: 'kilometrajeError', value: '' });
                } else {
                    // Si el nuevo valor no es válido, establece un mensaje de error.
                    // No necesitas cambiar kilometraje_act aquí.
                    this.kilometrajeError = 'El kilometraje actual no puede ser menor que el kilometraje anterior';
                    this.$emit('update', { prop: 'kilometrajeError', value: 'El kilometraje actual no puede ser menor que el kilometraje anterior' });
                }
            }
        }
    },
    mounted() {
        this.cargarDatos();
    }
}
</script>

<style scoped>
/* Tus estilos específicos para este componente */
</style>

