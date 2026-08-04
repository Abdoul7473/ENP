<template>
  <admin-layout>
    <Toolbar Title="Tableau de bord" :breadcrumbs="breadcrumbs" >

    </Toolbar>
    <v-row>
      <v-col >
        <Bar1  :items="nbr_personne_grade" />
      </v-col>
    </v-row>

  </admin-layout>
</template>

<script>
import AdminLayout from "../layouts/AdminLayout.vue"
import Agenda from '../components/Agenda.vue'
import Chart from 'chart.js/auto'
import Bar1 from "../components/Chart/bar1.vue";
export default {
  components: { AdminLayout, Agenda,Bar1,  },
  props: ["items", "nbr_personne_grade"],
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
    methods: {
     
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
