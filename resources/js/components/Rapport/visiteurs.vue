<template>
<v-card class="px-2" color="basil" flat elevation="2" outlined>
    <v-divider class="mx-4"></v-divider>
    <div>
        <br />
        <v-alert border="bottom" colored-border color="orange" type="warning" elevation="2" v-model="alert" icon="mdi-warning" dismissible>
            Dans cette section, vous pouvez choisir plusieurs requêtes déjà préparées. Notez que les dates ne sont pas obligatoires dans certains cas ; vous pouvez choisir soit une date unique, soit une plage de dates. Le bouton "Voir le résultat" vous permet de soumettre la requête sélectionnée et d'afficher les résultats.
            Le bouton "Réinitialiser" vous permet de vider tous les champs et de recommencer.
        </v-alert>

        <div class="text-center">
            <v-btn v-if="!alert" color="info" @click="alert = true">
                <v-icon color="info darken-2">
                    mdi mdi-information-outline
                </v-icon> Info
            </v-btn>
        </div>
    </div>
    <v-card-text class="text-color" dense>
        <v-row dense>
            <v-col>
                <selectField v-model="form.requestSelected" outlined :items="requests" label="Sélectionnez la requête souhaitée" name="Sélectionnez la requête souhaitée" item-text="libelle" item-value="id" rules="required" required></selectField>
            </v-col>
            <v-col md="5" v-if="form.requestSelected == 1">
                <dateRangePicker v-model="form.date_interval" :label="Datefield" name="Date" dense></dateRangePicker>
            </v-col>
            <v-col md="4" v-if="form.selectField == 1">
                <v-menu v-model="modal1" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="auto">
                    <template v-slot:activator="{ on, attrs }">
                        <v-text-field v-model="form.date" outlined :label="Datefield" prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on"></v-text-field>
                    </template>
                    <v-date-picker outlined range v-model="form.date"></v-date-picker>
                </v-menu>
            </v-col>
        </v-row>
        <v-row dense>
            <v-col cols="10" class="p-0">
                <v-btn color="primary" :disabled="!form.requestSelected" @click="submit">
                    <v-icon color="primary darken-2">
                        mdi mdi-eye
                    </v-icon> Voir le résultat
                </v-btn>
            </v-col>
            <v-col cols="2" class="d-flex justify-end">
                <v-btn color="primary" @click="reset">
                    <v-icon color="primary darken-2">
                        mdi mdi-restore
                    </v-icon> Réinitialiser
                </v-btn>
            </v-col>
        </v-row>
        <Resultat v-if="resultat != null"  :resultat="resultat" :headers="headers"></Resultat>
    </v-card-text>
</v-card>
</template>

<script>
export default {
    props: {

    },
    data: () => ({
        alert: false,
        resultat: null,
        modal1: false,
        form: {
            date: null,
            requestSelected: null,
            date_interval: null
        },
        requests: [{
                id: 1,
                libelle: "Les visites entre deux dates",
                datefield: "Sélectionnez la plage de dates de visites",
                required: true
            },
            {
                id: 2,
                libelle: "Les visites d'une date donnéé",
                datefield: "Sélectionnez la dates des visites",
                required: true
            },
        ],
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
                text: 'Heure d\'arriivé',
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
    }),
    computed: {
        field() {
            const request = this.requests.find(request => request.id === this.form.requestSelected);
            this.form.item = request
            return request ? request.nextfield : "";
        },
        Datefield() {
            const request = this.requests.find(request => request.id === this.form.requestSelected);
            this.form.item = request
            return request ? request.datefield : "";
        },
        nbr() {
            const request = this.requests.find(request => request.id === this.form.requestSelected);
            return request ? request.filednbr : "";
        }
    },
    methods: {
        submit() {
            axios.get(route("rapport.query", {
                data: this.form
            })).then((res) => {
                this.resultat = res.data
            });
        },
        reset() {
            Object.keys(this.form).forEach(key => {
                this.form[key] = null;
            });

            this.resultat = null;
        },
        getRequiredStatus(item) {
            return item.required ? "required" : "";
        }
    },
}
</script>

<style>

</style>
