
<template>
    <Card :title="title">
        <template #body>
            <apexchart
                type="pie"
                height="350"
                :options="chartOptions"
                :series="series"
            ></apexchart>
        </template>
    </Card>
</template>
<script>
import VueApexCharts from "vue-apexcharts";
import Card from "@/components/CardComponent.vue";
export default {
    components: {
        apexchart: VueApexCharts,
        Card
    },
    props: {
        url: {
            type: String,
            required: true
        },
        title:{
            type: String,
            required: true
        }
    },
    data() {
        return {
            series: [], // Initialize with a default value

            chartOptions: {
                labels: [], // Initialize with a default label
                // You can add more options here according to your needs
                // Tus otras opciones de chartOptions...
                colors: ['#E40303', '#FF8C00', '#FFED00', '#008026', '#004DFF', '#750787'], // LGBT flag colors

                dataLabels: {
                    enabled: true,
                    formatter: function (val) {
                        return val.toFixed(0) + "%"; // Ajusta el número de decimales según necesites
                    },
                    style: {
                        colors: ['#fff'], // Ajusta el color del texto según el diseño de tu gráfico
                    },
                },
            },
            data: []
        }
    },
    methods: {
        async fetchData() {
            const {data, status} = await axios.get(this.url) // Call your API method here
            if (data.length > 0) {
                this.series = data.map(item => item.no_count)
                // Reasignar chartOptions para asegurar reactividad
                this.chartOptions = {
                    ...this.chartOptions, // Copia las opciones existentes
                    labels: data.map(item => item.Labels), // Actualiza las labels
                };
            }

            console.log(this.series)
            console.log(this.chartOptions.labels)
        },
    },
    mounted() {
        this.fetchData()
    },
}
</script>


