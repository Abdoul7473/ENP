<template>
<admin-layout>
    <Toolbar Title="Tableau de bord" :breadcrumbs="breadcrumbs">

    </Toolbar>
    <v-row>
        <v-col cols="6">
            <Bar1 :items="nbr_personne_grade" />
            <h3 style="text-align: center;">Nombre des personnes par grade</h3>
        </v-col>
        <v-col cols="6">
            <Bar2 :items="nbr_eleve_corp" />
            <h3 style="text-align: center;">Nombre des élèves par corps</h3>
        </v-col>
    </v-row>
    <v-row>
        <v-col>
            <ChartLine :items="nbr_visiteur_mois" />
            <h3 style="text-align: center;">Nombre des visites par mois</h3>
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
import ChartLine from "../components/Chart/chartLine.vue";

export default {
    components: {
        AdminLayout,
        Agenda,
        Bar1,
        Bar2,
        ChartLine
    },
    props: ["items", "nbr_personne_grade", "nbr_eleve_corp", "nbr_visiteur_mois"],
    data() {
        return {
            e1: 1,
            steps: 2,
            breadcrumbs: [{
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
.v-card__title.costume-title {
    background: #037832;
}

.v-card__title.costume-title1 {
    background: #F37C20;
}

.v-data-table__wrapper .Total {
    background: #a0a2a3;
}
</style>
