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
                   :disabled="isEdit || isProgramacion" >

        </div>
        <div class="col-md-5 mb-5">
            <label class="fs-6 fw-semibold mb-2" for="">Tipo de servicio</label>
            <select
                class="form-select form-select-solid"
                v-model="servicio"
                :disabled="isEdit || isProgramacion" >
                >
                <option v-for="servicio in servicios" :value="servicio">
                    {{ servicio }}
                </option>
            </select>
        </div>
        <div class="col-md-5 mb-5">
            <label class="fs-6 fw-semibold mb-2" for="">Destinos</label>
            <select
                class="form-select form-select-solid"
                v-model="destino_id"
                :disabled="isEdit || isProgramacion" >
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
        bus_id: {
            type: Number,
            required: true
        },
        fecha: {
            type: String,
            required: true
        },
        servicio: {
            type: String,
            required: true
        },
        destino_id: {
            type: Number,
            required: true
        },
        hora_salida: {
            type: String,
            required: true
        },
        isEdit: {
            type: Boolean,
            required: true
        },
        isProgramacion: {
            type: Boolean,
            required: true
        },
        buses: {
            type: Array,
            required: true
        },
        destinos: {
            type: Array,
            required: true
        },
        servicios: {
            type: Array,
            required: true
        }
    },
    computed: {
        formattedBuses() {
            return this.buses.map(bus => {
                return {
                    id: bus.id,
                    label: bus.numero_bus + ' - ' + bus.patente
                }
            })
        }
    }
}
</script>

