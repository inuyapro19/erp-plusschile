<template>
    <div class="row">
        <div class="col-md-12" v-for="(observacion, index) in observaciones" :key="index">
            <label class="fs-6 fw-semibold mb-2">Observacion {{ index + 1 }}</label>
            <textarea
                v-model="observaciones[index]"
                @input="updateObservacion(index, observaciones[index])"
                class="form-control form-control-solid">
      </textarea>
            <button @click="removeObservacion(index)" type="button" class="btn btn-danger mt-2"><i class="fa fa-trash"></i></button>
        </div>
        <div class="col-md-12" v-if="observaciones.length < 10">
            <button @click="addObservacion" type="button" class="btn btn-primary mt-2"><i class="fa fa-plus-circle"></i></button>
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
        observaciones: {
            type: Array,
            default: () => []
        }
    },
    watch: {
        observaciones: {
            handler(newObservaciones) {
                this.$emit('update', {prop: 'observaciones', value: newObservaciones});
            },
            deep: true
        }
    },
    methods: {
        addObservacion() {
            this.observaciones.push('');
        },
        removeObservacion(index) {
            this.observaciones.splice(index, 1);
        },
        updateObservacion(index, value) {
            const updatedObservaciones = [...this.observaciones];
            updatedObservaciones[index] = value;
            this.$emit('update:observaciones', updatedObservaciones);
        }
    }
}
</script>
