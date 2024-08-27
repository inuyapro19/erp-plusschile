<template>
    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
        <thead>
            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                <th v-for="column in columns" :key="column.field">{{ column.title }}</th>
            </tr>
        </thead>
        <tbody class="fw-semibold text-gray-600">
            <tr v-for="(row, index) in data" :key="index">
                <td v-for="column in columns" :key="column.field">
                    <!-- Aquí es donde accedemos a la relación -->
                    <span v-if="column.field.includes('.')">
                        {{ getNestedValue(row, column.field) }}
                    </span>
                    <span v-else>
                        {{ row[column.field] }}
                    </span>
                </td>
                <td>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-danger" @click="$emit('delete', row.id)"  title="Eliminar"><i class="fa fa-trash"></i></button>
                        <button type="button" class="btn btn-sm btn-info"  @click="$emit('edit', row.id)"   title="Editar"><i class="fa fa-edit"></i></button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    props: {
        data: {
            type: Array | Object,
            required: true
        },
        columns: {
            type: Array,
            required: true
        }
    },
    methods: {
        getNestedValue(obj, path) {
            return path.split('.').reduce((o, p) => (o || {})[p], obj);
        }
    }
}
</script>

<style scoped>

</style>



