<template>
    <select
        ref="select"
        class="form-select form-select-solid form-select-lg fw-semibold"
        v-bind="$attrs"
        v-on="listeners"
        style="width: 100%!important;
                padding: 50px!important;
                margin-bottom: 100px!important;"
    >
        <option value="" disabled selected>{{ texto }}</option>
        <slot></slot>
    </select>
</template>

<script>
import $ from 'jquery';
import 'select2';
//import 'select2/dist/css/select2.css';

export default {
    props: {
        value: [String, Number, Array],
        dataType: {
            type: String,
            default: 'string',
        },
        texto: {
            type: String,
            default: 'Seleccione lista',
        },
        modalId: {
            type: String,
            default: '',
        },
        isMultiple: {
            type: Boolean,
            default: false,
        },
    },
    computed: {
        listeners() {
            return {
                ...this.$listeners,
                change: event => {
                    const selectedValue = $(this.$refs.select).val();
                    const convertedValue = this.convertValue(selectedValue);
                    this.$emit('input', convertedValue);
                    this.$emit('select-changed');
                },
            };
        },
    },
    methods: {
        convertValue(value) {
            if (this.dataType === 'number') {
                return parseInt(value, 10);
            }
            return value;
        },

    },
    mounted() {
        /*const vm = this;
        $(this.$refs.select)
            .select2()
            .val(this.value)
            .trigger('change')
            .on('change', function () {
                const selectedValue = $(this).val();
                const convertedValue = vm.convertValue(selectedValue);
                vm.$emit('input', convertedValue);
                vm.$emit('select-changed');
            });*/

        const vm = this;
        if ($.fn.select2) {
            $(this.$refs.select)
                .select2({
                    dropdownParent: $(`#${this.modalId}`), // Usa el ID del modal
                    multiple: this.isMultiple, // Habilita la selección múltiple si isMultiple es verdadero
                })
                .val(this.value)
                .trigger('change')
                .on('change', function () {
                    const selectedValue = $(this).val();
                    const convertedValue = vm.convertValue(selectedValue);
                    vm.$emit('input', convertedValue);
                    vm.$emit('select-changed');
                });
        } else {
            console.error('Error: .select2 is not available. Please make sure to import the select2 library.');
        }
    },
    watch: {
        value(newVal) {
            $(this.$refs.select).val(newVal).trigger('change');
        },
    },
    beforeDestroy() {
        $(this.$refs.select).select2('destroy');
    },
};
</script>

<style scoped>
.custom-select {
    width: 100%!important;
    padding: 0.375rem 0.75rem!important;
    margin-bottom: 1rem!important;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    background-color: #fff;
    background-clip: padding-box;
    font-size: 1rem;
    line-height: 1.5;
    color: #495057;
    display: block;
}

.select2-dropdown select2-dropdown--below{
    z-index: 999;
}
</style>




