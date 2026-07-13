<template>
<admin-layout>
    <Toolbar Title="Visiteurs" :breadcrumbs="breadcrumbs">

    </Toolbar>
    <CustomDataTable :headers="headers" :items="visiteurs">
        <template v-slot:addBtn>
            <v-btn @click="create()" small color="primary">
                <v-icon left>mdi-plus-circle</v-icon> Ajouter
            </v-btn>
        </template>
        <template v-slot:item.action="{ item }">
            <BtnAction icon display-icon="mdi-pencil" title="Détail du lot"  color="green" small />
            <BtnAction icon display-icon="mdi-delete" title="Supprimer" @click="deleteItem(item)" color="error" small />
            <BtnAction icon display-icon="mdi-eye" title="Détail" @click="detail(item)" color="primary" small />
        </template>
    </CustomDataTable>
    <v-dialog v-model="dialogDetail" max-width="1000" persistent>
        <v-card>
            <!-- <v-toolbar dense dark color="primary" class="text-h6"></v-toolbar> -->
            <v-card-text>
                <br>
                <div class="invitation-container">
                    <div>
                        <div class="header">
                            <h1> INVITATION</h1>
                        </div>

                        <div class="content">
                            <p>
                                Vous êtes cordialement invité à participer à notre événement.
                            </p>

                            <!-- <div class="event-info">
                                <p><strong>Date :</strong> le 19 septembre 2026</p>
                                <p><strong>Lieu :</strong> eeee</p>
                            </div>

                            <div class="qr-section">
                                <div v-html="carte.qr"></div>
                            </div> -->

                        </div>
                    </div>
                </div>

            </v-card-text>
            <v-card-actions>
                <v-spacer />
                <v-btn @click="close()">Fermer</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</admin-layout>
</template>

<script>
import AdminLayout from "../../layouts/AdminLayout.vue"
export default {
    components: {
        AdminLayout
    },
    props: ["visiteurs"],
    data() {
        return {
            dialog: false,
            loading: false,
            dialogDetail: false,
            selection: 1,
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
            headers: [{
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
                    text: 'E-mail',
                    value: 'email'
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
                    text: 'Heure d\'arriivé',
                    value: 'heure_arrive'
                },
                {
                    text: 'Heure de depart',
                    value: 'heure_arrive'
                },
                {
                    text: 'Actions ',
                    value: 'action'
                },
            ],
            form: this.$inertia.form({
                nombre: 0
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
    }
}
</script>
