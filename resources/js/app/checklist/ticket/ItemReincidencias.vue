<template>


        <CardComponent :title="'Item con Incidencias'">
            <template #body>
                <data-table
                    :items="items"
                    :columns="columns"
                >

                </data-table>
            </template>
        </CardComponent>

</template>

<script>
import CardComponent from "@/components/CardComponent.vue";
import DataTable from "@/components/DataTable.vue";

export default {
    components: {
        CardComponent,
        DataTable
    },
    data() {
        return {
            columns:[
                {
                    key: 'ITEM_NAME',
                    label: 'Nombre'
                },
                {
                    key: 'BUS',
                    label: 'Bus'
                },
                {
                    key: 'NROS_TICKET',
                    label: 'Folios'
                },
                {
                    key: 'TOTAL_TICKET',
                    label: 'Total Ticket'
                }
            ],
            items: []

        };
    },
    mounted() {
        this.getAllItemReported();
    },
    methods: {
        //GET getAllItemReported
        async getAllItemReported() {
            try{
                // this.loading = true;
                const {data, status} =   await axios.get('/getAllItemReported')

                if(status === 200) {
                    this.items = data;
                }

            }
            catch (error) {
                console.log(error);
            }
            finally {
                // this.loading = false;
            }
        }

    }
};
</script>
