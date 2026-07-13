<template>
  <admin-layout>
    <Toolbar Title="Tableau de bord" :breadcrumbs="breadcrumbs" >

    </Toolbar>
    

  </admin-layout>
</template>

<script>
import AdminLayout from "../layouts/AdminLayout.vue"
import Agenda from '../components/Agenda.vue'
import Chart from 'chart.js/auto'
export default {
  components: { AdminLayout, Agenda  },
  props: ["items", "totalDemandesSoumises", "totalDemandesAutorisees", "totalDemandesRejetees", "demandesParMois"],
  data() {
    return {
      e1: 1,
        steps: 2,
      breadcrumbs: [
        {
          text: "App",
          disabled: false,
          href: "/home",
        },
        {
          text: "Home",
          disabled: true,
          href: "/home",
        },
      ],
      selectedMonth: null,
    }
  },
  mounted() {
    this.$nextTick(() => {
      this.createChart();
    });
  },

  watch: {
      steps (val) {
        if (this.e1 > val) {
          this.e1 = val
        }
      },
    },

    methods: {
      nextStep (n) {
        if (n === this.steps) {
          this.e1 = 1
        } else {
          this.e1 = n + 1
        }
      },
      createChart() {
        const ctx = document.getElementById('demandesChart').getContext('2d');

        const chartData = {
          labels: this.demandesParMois.map(month => month.mois),
          datasets: [{
            label: 'Nombre de demandes',
            data: this.demandesParMois.map(month => month.nombre_demandes),
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
          }]
        };

        new Chart(ctx, {
          type: 'line',
          data: chartData,
          options: {
            animations: {
              tension: {
                duration: 1000,
                easing: 'linear',
                from: 1,
                to: 0,
                loop: true
              },
              onProgress: function(animation) {
                progress.value = animation.currentStep / animation.numSteps;
              }
            },
            scales: {
              y: {
                beginAtZero: true,
                precision: 0
              }
            },
            plugins: {
              tooltip: {
                enabled: false
              }
            },
            onHover: (event, chartElement) => {
              if (chartElement.length > 0) {
                const monthIndex = chartElement[0].index;
                this.selectedMonth = this.demandesParMois[monthIndex].mois;
                this.createMonthChart(monthIndex);
              } else {
                this.selectedMonth = null;
                this.destroyMonthChart();
              }
            }
          }
        });
      },
      async fetchDemandesParJour(mois) {
        try {
          const response = await axios.get(`/demandes-par-jour/${mois}`);
          return response.data;
        } catch (error) {
          console.error("Erreur lors de la récupération des demandes par jour :", error);
          throw error;
        }
      },
      async createMonthChart(monthIndex) {
        const mois = this.demandesParMois[monthIndex].mois;
        const demandesParJour = await this.fetchDemandesParJour(mois);
        const ctx = document.getElementById('monthChart').getContext('2d');
        this.destroyMonthChart();
        const monthData = {
          labels: demandesParJour.map(day => day.jour),
          datasets: [{
            label: 'Demandes par jour',
            data: demandesParJour.map(day => day.nombre_demandes),
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
          }]
        };
        this.monthChart = new Chart(ctx, {
          type: 'bar',
          data: monthData,
          options: {
            scales: {
              y: {
                beginAtZero: true,
                precision: 0
              }
            }
          }
        });
      },
      destroyMonthChart() {
        if (this.monthChart) {
          this.monthChart.destroy();
          this.monthChart = null;
        }
      },
      handleMouseMove(event) {
        // Masquer la barre de défilement
        event.target.style.cursor = 'pointer';
      }
    },

}
</script>
<style>
.v-card__title.costume-title{
  background:  #037832;
}
.v-card__title.costume-title1{
  background:  #F37C20;
}
.v-data-table__wrapper .Total{
  background:  #a0a2a3;
}
</style>
