<template>
    <div class="row mb-5">
        <div class="col-md-5 mb-5" v-if="isEdit">
            <label class="fs-6 fw-semibold mb-2">Bus</label>
            <select v-model="bus_id" class="form-select form-select-solid" :disabled="true">
                <option v-for="bus in buses" :key="bus.id" :value="bus.id">
                    {{ bus.numero_bus + ' - ' + bus.patente }}
                </option>
            </select>
        </div>
        <div class="col-md-5 mb-5" v-else>
            <label class="fs-6 fw-semibold mb-2">Bus</label>
            <v-select
                :options="formattedBuses"
                label="label"
                class="form-control form-control-solid"
                :reduce="bus => bus.id"
                v-model="bus_id"
                @input="obtenerAsientosYTipo()"
                style="padding:0px !important">
            </v-select>
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
        <div class="col-md-5">
            <label for="tiene_discapacidad" class="fs-6 fw-semibold mb-2">¿Viaje sin programación?</label>
            <div class="form-check form-switch form-check-custom form-check-solid">
                <input class="form-check-input"
                       type="checkbox"
                       id="tiene_discapacidad"
                       v-model="isProgramacion"
                />
                <label class="form-check-label fw-semibold text-gray-400 ms-3" for="status"></label>
            </div>
        </div>

        <div class="col-md-5 mb-5">
            <label class="fs-6 fw-semibold mb-2" for="">Hora de salida</label>
            <input type="time"
                   v-model="hora_salida"
                   class="form-control form-control-solid disabled"
                   :disabled="isEdit || isProgramacion">

        </div>
        <div class="col-md-5 mb-6">
            <label class="fs-6 fw-semibold mb-2" for="">Tipo de servicio</label>
            <select
                class="form-select form-select-solid"
                v-model="servicio"
                :disabled="isEdit || isProgramacion">
                >
                <option v-for="servicio in servicios" :value="servicio">
                    {{ servicio }}
                </option>
            </select>
        </div>
        <div class="col-md-5 mb-5">
            <label class="fs-6 fw-semibold mb-2" for="">Origen</label>
            <select
                class="form-select form-select-solid"
                v-model="origen_id"
                :disabled="isEdit || isProgramacion">
                >
                <option v-for="destino in destinos" :value="destino.id">
                    {{ destino.ciudad }}
                </option>
            </select>
        </div>
        <div class="col-md-5 mb-5">
            <label class="fs-6 fw-semibold mb-2" for="">Destinos</label>
            <select
                class="form-select form-select-solid"
                v-model="destino_id"
                :disabled="isEdit || isProgramacion">
                >
                <option v-for="destino in destinos" :value="destino.id">
                    {{ destino.ciudad }}
                </option>
            </select>
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
    },
    watch: {
        // Observa los cambios en isProgramacion
        isProgramacion(newVal) {
            //console.log('isProgramacion changed to: ', newVal);
            localStorage.setItem('isProgramacion', newVal);
            if (newVal) {
                // Si el checkbox no está marcado, ajusta los valores
                this.hora_salida = '00:00'; // Setea la hora de salida a 00:00
                this.servicio = 'SIN PROGRAMACION'; // Setea el servicio a SIN PROGRAMACION
                this.destino_id = 13; // Setea el destino_id a 13
                this.origen_id = 13; // Setea el origen_id a 13

                //localstorage
                localStorage.setItem('hora_salida', this.hora_salida);
                localStorage.setItem('servicio', this.servicio);
                localStorage.setItem('destino_id', this.destino_id);
                localStorage.setItem('origen_id', this.origen_id);

                this.$emit('update', { prop: 'hora_salida', value: this.hora_salida });
                this.$emit('update', { prop: 'servicio', value: this.servicio });
                this.$emit('update', { prop: 'destino_id', value: this.destino_id });
                this.$emit('update', { prop: 'origen_id', value: this.origen_id });
                this.$emit('update', { prop: 'isProgramacion', value: newVal });

            } else {
                // Si el checkbox está marcado, puedes ajustar los valores a otros estados iniciales si es necesario
                // Por ejemplo, resetear a valores por defecto o dejarlos vacíos
                this.hora_salida = ''; // Resetear o ajustar según necesidad
                this.servicio = ''; // Resetear o ajustar según necesidad
                this.destino_id = null; // Resetear o ajustar según necesidad
                this.origen_id = null; // Resetear o ajustar según necesidad
                localStorage.setItem('hora_salida', this.hora_salida);
                localStorage.setItem('servicio', this.servicio);
                localStorage.setItem('destino_id', this.destino_id);
                localStorage.setItem('origen_id', this.origen_id);


                this.$emit('update', { prop: 'hora_salida', value: this.hora_salida });
                this.$emit('update', { prop: 'servicio', value: this.servicio });
                this.$emit('update', { prop: 'destino_id', value: this.destino_id });
                this.$emit('update', { prop: 'origen_id', value: this.origen_id });
                this.$emit('update', { prop: 'isProgramacion', value: newVal });

            }
        },
        bus_id(newBusId) {
            this.$emit('update', { prop: 'bus_id', value: newBusId });
            localStorage.setItem('bus_id', newBusId);
            const selectedBus = this.buses.find(bus => bus.id === newBusId);
            console.log(selectedBus)
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
                    this.checklistItems = this.checklistItems.filter(item => item.id !== 5);
                    this.$emit('update', { prop: 'checklistItems',  value:this.checklistItems });
                } else {
                    //emit evento
                    this.$emit('fetchChecklistData');
                    //this.fetchChecklistData()
                }
                console.log(this.numero_pisos)
                //emit evento
                this.$emit('getAllItemReported');
                ///this.getAllItemReported()
            }
        },
        fecha(newFecha) {
            localStorage.setItem('fecha', newFecha);
            this.$emit('update', { prop: 'fecha', value: newFecha });
        },
        hora_salida(newHoraSalida) {
            localStorage.setItem('hora_salida', newHoraSalida);
            this.$emit('update', { prop: 'hora_salida', value: newHoraSalida });
        },
        servicio(newServicio) {
            localStorage.setItem('servicio', newServicio);
            this.$emit('update', { prop: 'servicio', value: newServicio });
        },
        origen_id(newOrigenId) {
            localStorage.setItem('origen_id', newOrigenId);
            this.$emit('update', { prop: 'origen_id', value: newOrigenId });
        },
        destino_id(newDestinoId) {
            localStorage.setItem('destino_id', newDestinoId);
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
        cargarDatos() {
            // Lógica para cargar los datos
            let bus_id = localStorage.getItem('bus_id');
            let fecha = localStorage.getItem('fecha');
            let hora_salida = localStorage.getItem('hora_salida');
            let servicio = localStorage.getItem('servicio');
            let origen_id = localStorage.getItem('origen_id');
            let destino_id = localStorage.getItem('destino_id');
            let numero_pisos = localStorage.getItem('numero_pisos');
            //console.log(numero_pisos)
            let marca = localStorage.getItem('marca');
            let modelo = localStorage.getItem('modelo');
            let isProgramacion = localStorage.getItem('isProgramacion');
            if (bus_id) {
                this.$emit('update', { prop: 'bus_id', value: parseInt(bus_id) });
            }

            if (fecha) {
                this.$emit('update', { prop: 'fecha', value: fecha });
            }

            //sigue con los otros
            if (hora_salida) {
                this.$emit('update', { prop: 'hora_salida', value: hora_salida });
            }

            if (servicio) {
                this.$emit('update', { prop: 'servicio', value: servicio });
            }

            if (origen_id) {
                this.$emit('update', { prop: 'origen_id', value: parseInt(origen_id) });
            }

            if (destino_id) {
                this.$emit('update', { prop: 'destino_id', value: parseInt(destino_id) });
            }

            if (numero_pisos) {
                this.$emit('update', { prop: 'numero_pisos', value: parseInt(numero_pisos) });
                console.log( 'cargue el numero de pisos:'+numero_pisos)

                if(numero_pisos === 1){
                    //elimina el id 5
                    this.checklistItems = this.checklistItems.filter(item => item.id !== 5);
                    this.$emit('update', { prop: 'checklistItems',  value:this.checklistItems });
                }else{
                    //emit evento
                    this.$emit('fetchChecklistData');
                    //this.fetchChecklistData()
                }

            }

            if (marca) {
                this.$emit('update', { prop: 'marca', value: marca });
            }

            if (modelo) {
                this.$emit('update', { prop: 'modelo', value: modelo });
            }

            if (isProgramacion) {
                this.$emit('update', { prop: 'isProgramacion', value: isProgramacion });
            }

        }
    },
    computed: {
        formattedBuses() {
            return this.buses.map(bus => ({
                id: bus.id,
                label: bus.numero_bus + ' - ' + bus.patente
            }));
        }
    },
    mounted() {
        //carga los localstorege actualizando los emit igual
        this.cargarDatos()

    }
}
</script>

<style scoped>
/* Tus estilos específicos para este componente */
</style>

