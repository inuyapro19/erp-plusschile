<template>
    <Card>
        <template #body>
            <p>
                <label><b>Select Theme Palette</b> </label> &nbsp;
                <select @change="updateTheme">
                    <option value="palette1">palette1</option>
                    <option value="palette2">palette2</option>
                    <option value="palette3">palette3</option>
                    <option value="palette4">palette4</option>
                    <option value="palette5">palette5</option>
                    <option value="palette6">palette6</option>
                    <option value="palette7">palette7</option>
                    <option value="palette8">palette8</option>
                    <option value="palette9">palette9</option>
                    <option value="palette10">palette10</option>
                </select>
            </p>
            <apexcharts
                width="100%"
                height="350"
                type="bar"
                :options="chartOptions"
                :series="series"
            ></apexcharts>
        </template>


    </Card>
</template>

<script>
import VueApexCharts from "vue-apexcharts";
import Card from "@/components/CardComponent.vue";
export default {
    name: "Chart",
    components: {
        apexcharts: VueApexCharts,
        Card
    },
    data: function() {
        return {
            chartOptions: {
                chart: {
                    id: "basic-bar",
                    animations: {
                        speed: 200
                    }
                },
                dataLabels: {
                    enabled: false
                },
                plotOptions: {
                    bar: {
                        distributed: true
                    }
                },
                xaxis: {
                    categories: [1991, 1992, 1993, 1994, 1995]
                }
            },
            series: [
                {
                    name: "series-1",
                    data: [30, 40, 45, 30, 49]
                }
            ]
        };
    },
    methods: {
        updateTheme(e) {
            this.chartOptions = {
                theme: {
                    palette: e.target.value
                }
            };
        }
    }
};
</script>

