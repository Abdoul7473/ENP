<template>
<div>
    <Bar :chart-options="chartOptions" :chart-data="chartData" :chart-id="chartId" :dataset-id-key="datasetIdKey" :css-classes="cssClasses" :styles="styles" :width="width" :height="height" />
</div>
</template>

<script>
import {
    Bar
} from 'vue-chartjs/legacy'
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale
} from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)
export default {
    name: 'BarChart',
    components: {
        Bar,
    },
    props: {
        eye: {
            type: Boolean
        },
        chartId: {
            type: String,
            default: 'bar-chart'
        },
        items: {
            type: [],
            // required: true
        },
        datasetIdKey: {
            type: String,
            default: 'label'
        },
        width: {
            type: Number,
            default: 380
        },
        height: {
            type: Number,
            default: 380
        },
        cssClasses: {
            default: '',
            type: String
        },
        styles: {
            type: Object,
            default: () => {}
        },
        plugins: {
            type: Array,
            default: () => []
        },
    },
    data() {
        return {
            chartData: {
                labels: this.items.label,
                datasets: [{
                    label: "Nombre d'éleve par corps",
                    backgroundColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 205, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(201, 203, 207, 1)'
                    ],
                    borderColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)'
                    ],
                    borderWidth: 1,
                    pointBorderColor: '#2554FF',
                    data: this.items.data
                }],
            },
            legend: {
                display: true
            },
            chartOptions: {
                responsive: true,
                maintainAspectRatio: false
            },
            data: [],
        }
    },
    methods: {
        formatNumber(value) {
            if (value !== undefined && value !== null) {
                let num = parseFloat(value).toFixed(2);
                let [integerPart, decimalPart] = num.split('.');
                integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
                return `${integerPart}.${decimalPart}`;
            }
            return '';
        },
    }
}
</script>
