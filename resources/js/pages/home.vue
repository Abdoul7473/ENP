<template>
  <admin-layout>
    <Toolbar Title="Tableau de bord" :breadcrumbs="breadcrumbs" >

    </Toolbar>
    <v-row>
      <v-col cols="6">
        <Bar1  :items="nbr_personne_grade" />
      </v-col>
      <v-col cols="6">
        <Bar2  :items="nbr_eleve_corp" />
      </v-col>
    </v-row>

  </admin-layout>
</template>

<script>
import AdminLayout from "../layouts/AdminLayout.vue"
import Agenda from '../components/Agenda.vue'
import Chart from 'chart.js/auto'
import Bar1 from "../components/Chart/bar1.vue";
import Bar2 from "../components/Chart/bar2.vue";
export default {
  components: { AdminLayout, Agenda,Bar1,Bar2  },
  props: ["items", "nbr_personne_grade","nbr_eleve_corp"],
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
