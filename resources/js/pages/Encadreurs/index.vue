<template>
<admin-layout>
    <Toolbar Title="Encadreurs" :breadcrumbs="breadcrumbs">

    </Toolbar>
    <CustomDataTable :headers="headers" :items="encadreurs">
        <template v-slot:addBtn>
            <v-btn @click="creer()" small color="primary">
                <v-icon left>mdi-plus-circle</v-icon> Ajouter
            </v-btn>
        </template>
        <template v-slot:item.action="{ item }">
            <BtnAction icon display-icon="mdi-eye" title="Détail de l'encadreur" @click="detail(item)" color="green" small />
        </template>
    </CustomDataTable>
    <v-dialog v-model="dialog" max-width="1000" persistent>
        <v-card>
            <v-toolbar dense dark color="primary" class="text-h6"> Détail</v-toolbar>
            <v-card-text>
                <br>
                <div class="invitation-container">
                    <div>
                        <div class="content">
                            <v-row>
                                <v-col cols="12" sm="4">
                                    <TextField label="Matricule" name="matricule" :value="items?.matricule" disabled outlined dense color="secondary" autocomplete="false"></TextField>
                                </v-col>
                                <v-col cols="12" sm="4">
                                    <TextField label="Nom" name="Nom" :value="items?.nom" disabled outlined dense color="secondary" autocomplete="false"></TextField>
                                </v-col>
                                <v-col cols="12" sm="4">
                                    <TextField label="Prénom" name="Prénom" :value="items?.prenom" disabled outlined dense color="secondary" autocomplete="false"></TextField>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="12" sm="4">
                                    <TextField label="Sexe" name="sexe" :value="items?.sexe" disabled outlined dense color="secondary" autocomplete="false"></TextField>
                                </v-col>
                                <v-col cols="12" sm="4">
                                    <TextField label="Téléphone" name="tel" type="number" :value="items?.tel" disabled outlined dense color="secondary" autocomplete="false"></TextField>
                                </v-col>
                                <v-col cols="12" sm="4">
                                    <TextField label="E-mail" disabled type="email" name="E-mail" :value="items?.email" outlined dense color="secondary" autocomplete="false"></TextField>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="12" sm="4">
                                    <TextField label="Date de naissance" name="date" :value="items?.date_naiss" disabled outlined dense color="secondary" autocomplete="false"></TextField>
                                </v-col>
                                <v-col cols="12" sm="4">
                                    <TextField label="Lieu de naissance" name="lieu" :value="items?.lieu_naiss" disabled outlined dense color="secondary" autocomplete="false"></TextField>
                                </v-col>
                                <v-col cols="12" sm="4">
                                    <TextField label="Groupe Sanguin" disabled name="groupt" :value="items?.groupe_sanguin" outlined dense color="secondary" autocomplete="false"></TextField>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="12" sm="4">
                                    <TextField label="Grade" name="grade" :value="items?.grade?.libelle" disabled outlined dense color="secondary" autocomplete="false"></TextField>
                                </v-col>
                                <v-col cols="12" sm="4">
                                    <v-checkbox label="Le commandant de compagnie ?" color="primary" :value="items?.is_commandant" hide-details></v-checkbox>
                                </v-col>
                            </v-row>
                            <v-card class="mx-auto my-12">
                                <v-card-title>Historique de compagnies</v-card-title>
                                <v-card-text>
                                    <v-chip-group column selected-class="text-purple">
                                        <v-chip  outlined color="primary" :key="i" v-for="(a, i) in items?.affectations">{{ a.compagnie.nom }}
                                            <v-icon right v-if="a.statut == 1">
                                                mdi-checkbox-marked-circle
                                            </v-icon>
                                        </v-chip>
                                    </v-chip-group>
                                </v-card-text>

                            </v-card>
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
    props: ["encadreurs"],
    data() {
        return {
            dialog: false,
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
            items: [],
            selectedMonth: null,
            headers: [{
                    text: 'Matricule',
                    align: 'start',
                    sortable: false,
                    value: 'matricule',
                },
                {
                    text: 'Nom',
                    value: 'nom'
                },
                {
                    text: 'Prénom',
                    value: 'prenom'
                },
                {
                    text: 'téléphone',
                    value: 'tel'
                },
                {
                    text: 'Grade',
                    value: 'grade.libelle'
                },
                {
                    text: 'Actions ',
                    value: 'action'
                },
            ]
        }

    },
    mounted() {
        // console.log(this.qr);

    },
    methods: {
        close() {
            this.dialog = false
        },
        detail(item) {
            this.dialog = true
            this.items = item

        },
        creer() {
            this.$inertia.get(route('encadreur.create'))
        }
    }
}
</script>
