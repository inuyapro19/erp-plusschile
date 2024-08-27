<template>
    <div class="custom-select-with-slots">
        <input
            type="text"
            v-model="searchQuery"
            @input="filterOptions"
            placeholder="Buscar..."
        />
        <select v-model="selected" class="form-select form-select-solid" @change="emitChange">
            <slot :filtered-options="computedFilteredOptions"></slot>
        </select>
    </div>
</template>

<script>
export default {
    data() {
        return {
            searchQuery: '',
            selected: '',
            options: [], // Se espera que este sea actualizado por el slot.
        };
    },
    props: {
        value: [String, Number],
        optionsProp: {
            type: Array,
            required: true
        },
    },
    computed: {
        computedFilteredOptions() {
            if (!this.searchQuery) {
                return this.optionsProp;
            } else {
                return this.optionsProp.filter(option =>
                    option.text.toLowerCase().includes(this.searchQuery.toLowerCase())
                );
            }
        }
    },
    watch: {
        value(newValue) {
            this.selected = newValue;
        },
    },
    methods: {
        filterOptions() {
            // La lógica de filtrado se maneja ahora en computedFilteredOptions

        },
        emitChange() {
            this.$emit('input', this.selected);
        },
    },
    mounted() {
        this.selected = this.value;
    }
};
</script>

<style scoped>

</style>

