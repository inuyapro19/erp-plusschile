<template>
    <select
        ref="select"
        v-bind="$attrs"
        v-on="listeners"
        class="form-select form-select-solid form-select-lg"
        aria-label="Selecciona"
        data-control="select2"
        data-placeholder="Selecciona.."
    >
        <option value="" disabled selected>{{ texto }}</option>
        <slot></slot>
    </select>
</template>

<script>
import $ from 'jquery';
import 'select2';
import 'select2/dist/css/select2.css';

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
            if (this.isMultiple) {
                if (this.dataType === 'number') {
                    return value.map(v => parseInt(v, 10));
                }
                return value;
            } else {
                if (this.dataType === 'number') {
                    return parseInt(value, 10);
                }
                return value;
            }
        },
    },
    mounted() {
        let select2Options = {
            multiple: this.isMultiple,
        };

        if (this.modalId) {
            select2Options.dropdownParent = $(`#${this.modalId}`);
        }
        select2Options.theme = 'bootstrap5';
        const vm = this;
        if ($.fn.select2) {
            $(this.$refs.select)
                .select2(select2Options)
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
.select2-container .select2-selection--single{
    height: calc(2.75rem + 2px) !important;
    padding: 0.5rem 1rem !important;
    font-size: 1rem !important;
    line-height: 1.5 !important;
    border-radius: 0.42rem !important;
    border: 1px solid #ced4da !important;
}
</style>




