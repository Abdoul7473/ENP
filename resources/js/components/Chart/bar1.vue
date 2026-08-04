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
                    label: "Nombre de personnel",
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
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
                    borderWidth: 2,
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
