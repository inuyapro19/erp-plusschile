<template>
    <div class="py-5">
        <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer" id="kt_customers_table">
            <thead>
            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                <th v-if="isCheck" class="w-10px pe-2">
                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                        <input type="checkbox" class="form-check-input" @click="toggleAll" />
                    </div>
                </th>
                <th v-for="column in filteredColumns" :key="column.id" @click="handleSort(column.key)" :class="{'table-sort-asc': sortAsc && sortedColumn === column.key, 'table-sort-desc': !sortAsc && sortedColumn === column.key}">
                    {{ column.label }}
                </th>
                <th v-if="isActions" class="text-center">Acciones</th>
            </tr>
            </thead>
            <tbody class="fw-semibold text-gray-600">
            <tr v-if="!items.length">
                <td colspan="100" class="text-center">No hay registros</td>
            </tr>
            <tr v-else class="odd" v-for="item in items" :key="item.id">
                <td v-if="isCheck">
                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                        <input type="checkbox" class="form-check-input" />
                    </div>
                </td>
                <td v-for="column in filteredColumns" :key="column.id">
                    <span v-if="column.badge" :class="['badge', getColorClass(item[column.key])]">{{ item[column.key] }}</span>
                    <span v-else>{{ getNestedValue(item, column.key) }}</span>
                </td>
                <td v-if="isActions" class="text-center">
                    <slot name="actions" :item="item"></slot>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: {
        columns: Array,
        items: Array,
        isCheck: {
            type: Boolean,
            default: false,
        },
        idKey: {
            type: String,
            default: 'id',
        },
        isActions: {
            type: Boolean,
            default: false,
        },
        color: Object,
        loading: {
            type: Boolean,
            default: false,
        },
        onSortChange: Function,
        visibleColumns: Object,
    },
    data() {
        return {
            sortAsc: true,
            sortedColumn: '',
            showMenu: false,
        };
    },
    computed: {
        filteredColumns() {
            return this.columns.filter(column => this.visibleColumns[column.id]);
        },
    },
    methods: {
        toggleAll(event) {
            // Lógica para seleccionar todos los checkboxes
        },
        getNestedValue(obj, path) {
            return path.split('.').reduce((acc, key) => {
                return acc && acc[key] ? acc[key] : 'Sin registro';
            }, obj);
        },
        getColorClass(type) {
            if (!this.color.hasOwnProperty(type)) {
                throw new Error(`Tipo ${type} no es válido`);
            }
            return this.color[type];
        },
        handleSort(columnKey) {
            const newSortAsc = this.sortedColumn === columnKey ? !this.sortAsc : true;
            this.sortAsc = newSortAsc;
            this.sortedColumn = columnKey;
            if (this.onSortChange) {
                this.onSortChange(columnKey, newSortAsc ? 'asc' : 'desc');
            }
        },
    },
};
</script>

<style scoped>
/* Estilos personalizados */
</style>
