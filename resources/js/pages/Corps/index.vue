<template>
<admin-layout>
    <Toolbar Title="Corps" :breadcrumbs="breadcrumbs">

    </Toolbar>
    <v-data-table :headers="headers" :items="corps" item-key="name" :search="search" dense class="my-3 pt-3" style="border: 1px solid rgb(245, 134, 52)">
        <template v-slot:top>
            <v-row>

                <v-col cols="8" class="pt-8">
                   
                </v-col>
                <v-col class="pt-8" cols="4">
                    <v-text-field v-model="search" prepend-inner-icon="mdi-search-web" single-line outlined dense clearable label="Réchercher" placeholder="Réchercher" class="mx-3"></v-text-field>
                </v-col>
            </v-row>
        </template>
        <template v-slot:item.action="{ item }">
            <BtnAction icon display-icon="mdi-antenna" title="Matières"  @click="VueModule(item)" color="blue" small />
            <BtnAction icon display-icon="mdi-account-group" title="Groupes"  @click="VueGroupe(item)" color="primary" small />
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
    props: ["corps"],
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
                    text: 'Libelle',
                    value: 'nom'
                },
                {
                    text: 'Actions ',
                    value: 'action'
                },
            ],
            form: this.$inertia.form({
                donnees: [],
            }),
        }

    },
    methods: {
       VueGroupe(item) {
            this.$inertia.get(route('groupe.index', item.id))
        },
         VueModule(item) {
            this.$inertia.get(route('module.index', item.id))
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
