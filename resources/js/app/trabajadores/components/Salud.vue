<template>
    <div class="row my-5 mx-5">
        <div class="col-md-6 mb-2">
            <label class="fs-6 fw-semibold mb-2">Entidad de Salud</label>
            <select v-model="form.salud_id" class="form-select form-select-solid">
                <option disabled value="">-----</option>
                <option v-for="item in previsionSalud" :key="item.id" :value="item.id">
                    {{ item.nombre_salud }}
                </option>
            </select>
        </div>
        <div class="col-md-6 mb-2">
            <label class="fs-6 fw-semibold mb-2">¿Cotiza 7%?</label>
            <label class="form-check form-switch form-check-custom form-check-solid">
                <input
                    type="checkbox"
                    class="form-check-input"
                    v-model="cotizaSietePorciento"
                    :disabled="form.salud_id === 7"
                    @change="handleCotizaSietePorcientoChange"
                />
                <span class="form-check-label fw-semibold text-muted">Si</span>
            </label>
        </div>

        <div class="col-md-6 mb-2" v-if="form.salud_id !== 7">
            <label class="fs-6 fw-semibold mb-2">Tipo de Plan</label>
            <select v-model="form.tipo_plan_salud" class="form-select form-select-solid" @change="handleIsPeso">
                <option disabled value="">-----</option>
                <option v-for="item in planSalud" :key="item" :value="item">{{ item }}</option>
            </select>
        </div>

        <div class="col-md-6 mb-2" v-if="isPeso">
            <label class="fs-6 fw-semibold mb-2">Monto Peso</label>
            <input type="number" v-model="form.monto_peso" class="form-control"/>
        </div>

        <div class="col-md-6 mb-2" v-if="isUf">
            <label class="fs-6 fw-semibold mb-2">Monto UF</label>
            <input type="number" v-model="form.monto_uf" class="form-control"/>
        </div>
    </div>
</template>

<script>
import { mapState, mapActions } from 'vuex';

export default {
    props: {
        form: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            /*form: {
                salud_id: 7,
                tipo_plan_salud: '',
                monto_peso: null,
                monto_uf: null,
            },*/
            isCotizaSiete: false,
            isPeso: false,
            isUf: false,
            planSalud: [],
            cotizaSietePorciento: false,

        };
    },
    computed: {
        ...mapState({
            previsionSalud: (state) => state.previsionSalud.salud,
        }),


    },
    watch: {
        // Tus watchers...
        cotizaSietePorciento(newVal, oldVal) {
            // Opcionalmente, puedes reaccionar a cambios directamente aquí si es necesario
        },
        'form.salud_id':function (newVal) {
            // Asegúrate de que este watcher se actualiza para manejar la lógica relacionada con entidadSalud
            if (newVal === 7) {
                this.cotizaSietePorciento = false;
                this.isUf = false;
                this.isPeso = false;
                // Asume que no se puede cotizar 7% si la entidad es específica
            }else{
                this.handleCotizaSietePorcientoChange();
            }
        },
    },
    methods: {
        ...mapActions({
            getPrevisionSalud: 'previsionSalud/fetchPrevisionSalud',
        }),
        handleIsPeso(event) {
            const tipoPlanSalud = event.target.value;
            this.form.monto_peso = 0;
            this.form.monto_uf = 0;
            this.isPeso = ['PESOS', 'PESO + UF', 'COTIZA 7% + PESO'].includes(tipoPlanSalud);
            this.isUf = ['UF', 'PESO + UF', 'COTIZA 7% + UF'].includes(tipoPlanSalud);
        },
        handleCotizaSietePorcientoChange() {
            if (this.cotizaSietePorciento) {
                this.isCotizaSiete = true;
                this.planSalud = ['COTIZA 7% + UF', 'COTIZA 7% + PESO'];
            } else {
                this.isCotizaSiete = false;
                this.planSalud = ['PESOS', 'UF', 'PESO + UF'];
            }
        },
    },
    mounted() {
        this.getPrevisionSalud();
    },
};
</script>

