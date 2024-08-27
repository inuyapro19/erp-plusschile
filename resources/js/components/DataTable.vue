<template>
    <div class="table-responsive py-5">
        <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer" id="kt_customers_table">
            <thead>
            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                <th class="w-10px pe-2" v-show="isCheck">
                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                        <input class="form-check-input" type="checkbox" data-kt-check="true"
                               data-kt-check-target="#kt_customers_table .form-check-input" value="1"/>
                    </div>
                </th>
                <th v-for="column in columns"
                    @click="column.sortable && sortTable(column.key)"
                    :class="{ 'table-sort-asc': sortAsc && orderBy === column.key, 'table-sort-desc': !sortAsc && orderBy === column.key }"
                    :key="column.key">
                    {{ column.label }}
                </th>
                <slot>
                    <th>Acciones</th>
                </slot>
            </tr>
            </thead>
            <tbody class="fw-semibold text-gray-600">
            <slot name="filtros"></slot>
            <slot name="empty" v-if="items.length === 0">
                <tr>
                    <td colspan="100%" class="text-center">No hay registros</td>
                </tr>
            </slot>
            <slot name="loading">
                <div class="table-loading-message">
                    Cargando...
                </div>
            </slot>

            <tr class="odd" v-for="item in items" :key="item.id">
                <td v-show="isCheck">
                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                        <input class="form-check-input" type="checkbox" value="1"/>
                    </div>
                </td>
                <td v-for="column in columns"
                    :key="column.key" v-html="
                        column.badge ? getColorType(item[column.key]) : getNestedValue(item, column.key)"
                >

                </td>
                <td class="text-center">
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
        columns: {
            type: [Array, Object],
            required: true,
            default: () => [],
        },
        items: {
            type: [Array, Object],
            required: true,
            default: () => [],
        },
        isCheck: {
            type: Boolean,
            default: false,
            required: false,
        },
        selectArray: {
            type: Array,
            default: () => [],
            required: false,
        },
        colores: {
            type: Array,
            default: () => ({}),
            required: false,
        },
        loading: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            sortAsc: true,
            orderBy: '', // Agregar esto
        };
    },
    methods: {
        getNestedValue(obj, path) {
            //console.log(path)
            //return path.split('.').reduce((obj, key) => obj && obj[key], obj);
            return path.split('.').reduce((obj, key) => {
                if (obj && obj[key]) {
                    return obj[key];
                }
                return 'Sin registro';
            }, obj);
        },
        getColorType(status) {
            const colorClass = this.colores.find((item) => item.status === status);

            if (!colorClass) {
                throw new Error(`Tipo ${status} no es válido`);
            }

            return `<span class="badge badge-${colorClass.color}">${colorClass.label}</span>`;
        },
        getSortValue() {
            return this.sortAsc ? 'asc' : 'desc';
        },
        sortTable(column) {
            if(this.orderBy === column) {
                this.sortAsc = !this.sortAsc; // Cambiar la dirección si es la misma columna
            } else {
                this.sortAsc = true; // Por defecto a asc si cambiamos de columna
            }
            this.orderBy = column; // Establecer la nueva columna de orden
            console.log(this.orderBy, this.getSortValue());
            // Emitir evento con los valores actuales de ordenamiento
            this.$emit('sort-order', {
                orderBy: this.orderBy,
                order: this.getSortValue(),
            });
        },

    },
};
</script>

