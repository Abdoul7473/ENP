<template>
<admin-layout>
    <Toolbar :Title="'Progression du module ' +  enseignement.modulo.matiere.libelle" :breadcrumbs="breadcrumbs">

    </Toolbar>
    <v-data-table :headers="headers" :items="avancements" item-key="name" :search="search" dense class="my-3 pt-3" style="border: 1px solid rgb(245, 134, 52)">
        <template v-slot:top>
            <v-row>

                <v-col cols="8" class="pt-8">
                    <v-btn @click="creer()" small color="primary">
                        <v-icon left>mdi-plus-circle</v-icon> Ajouter
                    </v-btn>
                </v-col>
                <v-col class="pt-8" cols="4">
                    <v-text-field v-model="search" prepend-inner-icon="mdi-search-web" single-line outlined dense clearable label="Réchercher" placeholder="Réchercher" class="mx-3"></v-text-field>
                </v-col>
            </v-row>
        </template>
        <template v-slot:item.date="{ item }">
            {{ formatDate(item.date) }}
        </template>
        <template v-slot:item.action="{ item }">
            <!-- <BtnAction icon display-icon="mdi-antenna" title="Matières"  @click="VueModule(item)" color="blue" small />
            <BtnAction icon display-icon="mdi-account-group" title="Groupes"  @click="VueGroupe(item)" color="primary" small /> -->
        </template>
    </v-data-table>
</admin-layout>
</template>

<script>
import AdminLayout from "../../layouts/AdminLayout.vue"
export default {
    components: {
        AdminLayout
    },
    props: ["avancements", "enseignement","id"],
    data() {
        return {
            dialog: false,
            search: null,
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
            headers: [{
                    text: 'Date',
                    value: 'date'
                },
                {
                    text: 'Heure d\'arrivée',
                    value: 'heure_arrive'
                },
                {
                    text: 'Heure de depart',
                    value: 'heure_depart'
                },
                {
                    text: 'Objectif général',
                    value: 'objectif_general'
                },
                {
                    text: 'Objectif spécific',
                    value: 'objectif_specific'
                },
                {
                    text: 'Progression',
                    value: 'progression'
                },
                {
                    text: 'Nombre d\'heure',
                    value: 'nombre_heure'
                }
            ],
            form: this.$inertia.form({
                donnees: [],
            }),
        }

    },
    methods: {
        creer() {
            this.$inertia.get(route('avancement.create',this.id))
        },
        formatDate(dateString) {
            const date = new Date(dateString);
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();

            return `${day}/${month}/${year}`;
        },
    },
    created() {
        this.headers.forEach((item, i, items) => {
            if (i === 0) {
                item.class = 'primary white--text rounded-l-xl'
            } else if (i === items.length - 1) {
                item.class = 'primary white--text rounded-r-xl'
            } else {
                item.class = 'primary white--text'
            }
            item.divider = true
        })
    },
}
</script>

<style>
.custom-primary {
    background-color: rgba(225, 230, 210, 1) !important;
    color: black !important;
    /* pour s'assurer que le texte reste visible */
}
</style>
