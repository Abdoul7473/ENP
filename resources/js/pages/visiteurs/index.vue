<template>
<admin-layout>
    <Toolbar Title="Visiteurs" :breadcrumbs="breadcrumbs">

    </Toolbar>
    <v-tabs v-model="tab" background-color="primary" centered dark icons-and-text>
        <v-tabs-slider></v-tabs-slider>

        <v-tab href="#tab-1">
            Visiteurs
            <v-icon>mdi-account-group</v-icon>
        </v-tab>
        <v-tab href="#tab-2">
            Rếquettes
            <v-icon>mdi-database-outline</v-icon>
        </v-tab>
    </v-tabs>

    <v-tabs-items v-model="tab">
        <v-tab-item value="tab-1">
            <v-data-table :headers="headers" :items="visiteurs" item-key="name" dense class="my-3 pt-3" :search="search" style="border: 1px solid rgb(245, 134, 52)">
                <template v-slot:top>
                    <v-row>

                        <v-col cols="8" class="pt-8">
                            <v-btn @click="create()" small color="primary">
                                <v-icon left>mdi-plus-circle</v-icon> Ajouter
                            </v-btn>
                        </v-col>
                        <v-col class="pt-8" cols="4">
                            <v-text-field v-model="search" prepend-inner-icon="mdi-search-web" single-line outlined dense clearable label="Récherecher" placeholder="Récherecher" class="mx-3"></v-text-field>
                        </v-col>
                    </v-row>
                </template>
                <template v-slot:item.action="{ item }">
                    <BtnAction icon display-icon="mdi-toggle-switch-off" title="Notifier le départ" @click="Notifier(item.id)" v-if="item.statut == 0" color="green" small />
                </template>
            </v-data-table>
        </v-tab-item>
        <v-tab-item value="tab-2">
            <visiteurs />
        </v-tab-item>
    </v-tabs-items>
</admin-layout>
</template>

<script>
import AdminLayout from "../../layouts/AdminLayout.vue"
import visiteurs from "../../components/Rapport/visiteurs.vue";
export default {
    components: {
        AdminLayout,
        visiteurs
    },
    props: ["visiteurs"],
    data() {
        return {
            tab: null,
            dialog: false,
            loading: false,
            dialogDetail: false,
            selection: 1,
            e1: 1,
            steps: 2,
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
                    text: 'N° carte d\'identité',
                    align: 'start',
                    sortable: false,
                    value: 'num_carte',
                },
                {
                    text: 'Matricule du vehicule',
                    align: 'start',
                    sortable: false,
                    value: 'mat_vehicule',
                },
                {
                    text: 'Nom',
                    align: 'start',
                    sortable: false,
                    value: 'nom',
                },
                {
                    text: 'Prénom',
                    value: 'prenom'
                },
                {
                    text: 'Date de naissance',
                    value: 'date_naiss'
                },
                {
                    text: 'Lieu',
                    value: 'localite'
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
                    text: 'Actions ',
                    value: 'action'
                },
            ],
            form: this.$inertia.form({
                id: 0
            }),
        }

    },
    methods: {
        create() {
            this.$inertia.get(route('visiteurs.create'))
        },
        detail(item) {
            this.dialogDetail = true
        },
        Notifier(id) {
            this.form.id = id
            this.$alert.confirm('Etes-vous sûr ?', "Vous allez notifier le depart", () => {
                this.form.post(route("visiteur.notifier"), {
                    onSuccess: () => {
                        if (this.$page.props.flash.success) {
                            this.$alert.success(this.$page.props.flash.success)
                        }
                        if (this.$page.props.flash.error) {
                            this.$toast.error(this.$page.props.flash.error)
                        }
                    },
                    onError: this.$alert.messages
                })
            })
        }
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
