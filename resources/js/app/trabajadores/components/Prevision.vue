<template>
    <div class="row my-5 mx-5">
        <div class="col-md-6 mb-2">
            <label class="fs-6 fw-semibold mb-2">Tipo de Entidad</label>
            <select v-model="form.tipo_entidad" class="form-select form-select-solid">
                <option disabled value="">-----</option>
                <option value="afp">AFP</option>
                <option value="inp">INP</option>
            </select>
        </div>

        <div v-if="isAfp" class="col-md-6 mb-2">
            <label class="fs-6 fw-semibold mb-2">AFP</label>
            <select v-model="form.prevision_id" class="form-select form-select-solid">
                <option disabled value="">-----</option>
                <option v-for="prevision in previsionesAfp" :key="prevision.id" :value="prevision.id">
                    {{ prevision.nombre_prevision }}
                </option>
            </select>
        </div>

        <div v-else class="col-md-6 mb-2">
            <label class="fs-6 fw-semibold mb-2">INP</label>
            <select v-model="form.prevision_inp_id" class="form-select form-select-solid">
                <option disabled value="">-----</option>
                <option v-for="prevision in previsionesInp" :key="prevision.id" :value="prevision.id">
                    {{ prevision.nombre }}
                </option>
            </select>
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
            tipoEntidad: '',
            /*form: {
                prevision_id: '',
                prevision_inp_id: '',
            },*/
        };
    },
    computed: {
        ...mapState({
            previsionesAfp: state => state.prevision.previsiones,
            previsionesInp: state => state.prevision.previsiones_inp,
        }),
        isAfp() {
            return this.form.tipo_entidad === 'afp';
        },
    },
    watch: {
        tipoEntidad(newVal) {
            // Lógica adicional si es necesario reaccionar a cambios
        },
    },
    methods: {
        ...mapActions({
            getPrevision: 'prevision/fetchPrevision',
            getPrevisionInp: 'prevision/fetchPrevisionInp',
        }),
    },
    mounted() {
        this.getPrevision();
        this.getPrevisionInp();
    },
};
</script>
