<template>
<admin-layout>
    <Toolbar Title="Liste des situations" :breadcrumbs="breadcrumbs">

    </Toolbar>
    <CustomDataTable :headers="headers" :items="situations">
        <template v-slot:addBtn>
            <v-btn @click="creer()" small color="primary">
                <v-icon left>mdi-plus-circle</v-icon> Ajouter
            </v-btn>
        </template>
        
        <template v-slot:item.date_heure="{ item }">
            {{ formatDate(item.created_at) }}
        </template>
        <template v-slot:item.effectif="{ item }">
                {{item.compagnie.effectif}}
        </template>
        <template v-slot:item.permissionnaire="{ item }">
            <v-chip-group column selected-class="text-purple" v-if="item.permissionnaires != []">
                <v-chip outlined color="primary" :key="i" v-for="(p, i) in item.permissionnaires" label>{{ p.eleve.matricule }} {{ p.eleve.nom }} {{ p.eleve.prenom }}
                </v-chip>
            </v-chip-group>
            <div v-else>0</div>
        </template>
        <template v-slot:item.absent="{ item }">
            <v-chip-group column selected-class="text-purple">
                <v-chip outlined color="primary" :key="i" v-for="(a, i) in item.absents" label>{{ a.eleve.matricule }} {{ a.eleve.nom }} {{ a.eleve.prenom }}
                </v-chip>
            </v-chip-group>
        </template>
        <template v-slot:item.malade="{ item }">
            <v-chip-group column selected-class="text-purple">
                <v-chip outlined color="primary" :key="i" v-for="(m, i) in item.malades" label>{{ m.eleve.matricule }} {{ m.eleve.nom }} {{ m.eleve.prenom }}
                </v-chip>
            </v-chip-group>
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
                                        <v-chip outlined color="primary" :key="i" v-for="(a, i) in items?.affectations">{{ a.compagnie.nom }}
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
    props: ["situations","id"],
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
            headers: [
                {
                    text: 'Date et heure',
                    align: 'start',
                    sortable: false,
                    value: 'date_heure',
                },
                {
                    text: 'Effectif théorique',
                    align: 'start',
                    sortable: false,
                    value: 'effectif',
                },
                {
                    text: 'Présent',
                    value: 'nombre_present'
                },
                {
                    text: 'Absents',
                    value: 'absent'
                },
                {
                    text: 'Malades',
                    value: 'malade'
                },
                {
                    text: 'Permissionnaires',
                    value: 'permissionnaire'
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
            this.$inertia.get(route('situation.create',this.id))
        },
        formatDate(dateString) {
            const date = new Date(dateString);
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0'); 
            const year = date.getFullYear();

            return `${day}/${month}/${year} à ${hours}:${minutes} `;
        },
    }
}
</script>
