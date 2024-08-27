<template>
    <CardComponent>
        <template #body>
            <apexchart type="bar" height="440" :options="chartOptions" :series="series"></apexchart>

        </template>
    </CardComponent>
</template>

<script>
import VueApexCharts from 'vue-apexcharts'
import CardComponent from "@/components/CardComponent.vue";

export default {
    components: {
        CardComponent,
        apexchart: VueApexCharts
    },
    data() {
        return {
            series: [{
                name: 'Checklists',
                data: [] // Datos de checklists
            }, {
                name: 'Tickets',
                data: [] // Datos de tickets
            }],
            chartOptions: {
                chart: {
                    type: 'bar',
                    height: 440,
                    stacked: true
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: [], // Fechas de los últimos 30 días
                    title: {
                        text: 'Días del mes'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Cantidad generada'
                    },
                    categorias: []
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val + " generados"
                        }
                    }
                }
            },
        }
    },
    mounted() {
        // Aquí deberías obtener tus datos, por ejemplo, utilizando Axios para hacer una solicitud a tu API de Laravel
        // y luego llenar las propiedades series y xaxis.categories con los datos obtenidos.
        this.fetchData();
    },
    methods: {
       async fetchData() {

         const {data, status} = await axios.get('/chartChecklistAndTicketsByDayCombined')

            if (status === 200) {
                this.series[0].data = data.map(item => item.TotalChecklists);
                this.series[1].data = data.map(item => item.TotalTickets);
                this.chartOptions = {
                    ...this.chartOptions, // Copia las opciones existentes
                    xaxis: {
                        categories: data.map(item => {
                            let date = new Date(item.Fecha);
                            return date.getDate(); // Esto devolverá el día del mes
                        }),
                    },
                };

            }

        }

    }
}
</script>
