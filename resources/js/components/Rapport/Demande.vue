<template>
<v-card v-if="item.key == 1" class="px-2" color="basil" flat elevation="2" outlined>
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
            <v-col md="5" v-if="form.requestSelected !== null">
                <dateRangePicker v-model="form.date" :label="Datefield" name="Date" :required="getRequiredStatus(form.item)" dense></dateRangePicker>
            </v-col>
        </v-row>
        <v-row dense>
            <v-col v-if="form.requestSelected == 5">
                <selectField v-model="form.type_demande" outlined :items="type_demandes" :label="field" :name="field" item-text="libelle" item-value="id" rules="required" required></selectField>
            </v-col>
            <v-col v-if="form.requestSelected == 20">
                <selectField v-model="form.type_vol" outlined :items="type_vols" :label="field" :name="field" item-text="libelle" item-value="id" rules="required" required></selectField>
            </v-col>
            <v-col v-if="form.requestSelected >= 14 && form.requestSelected <= 17">
                <selectField v-model="form.user" outlined :items="users" :label="field" :name="field" item-text="name" item-value="id" rules="required" required></selectField>
            </v-col>
            <v-col v-if="form.requestSelected == 22">
                <selectField v-model="form.postulant" outlined :items="postulants" :label="field" :name="field" item-text="nom_raison_sociale" item-value="id" rules="required" required></selectField>
            </v-col>
            <v-col v-if="form.requestSelected == 19">
                <TextField v-model="form.ville" required label="Saisissez la ville en question" hide-details rules="required" dense>
                </TextField>
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
        <Resultat v-if="resultat != null" :type="'demande'" :resultat="resultat" :headers="headers"></Resultat>
    </v-card-text>
</v-card>
</template>

<script>
export default {
    props: {
        item: {

        },
        type_demandes: {},
        users: {},
        type_vols: {},
        postulants: {}
    },
    data: () => ({
        alert: false,
        resultat: null,
        form: {
            date: null,
            requestSelected: null,
            type_demande: null,
            user: null,
            postulant: null,
            type_vol: null,
            ville: null,
            item: null
        },
        requests: [{
                id: 1,
                libelle: "Les demandes entre deux dates spécifique",
                datefield: "Sélectionnez la plage de dates de demande",
                required: true
            },
            {
                id: 2,
                libelle: "Les demandes entre deux dates prévue de survol spécifique",
                datefield: "Sélectionnez la plage de dates de survol",
                required: true
            },
            {
                id: 3,
                libelle: "Les demandes entre deux dates d'approbation spécifique",
                datefield: "Sélectionnez la plage de dates d'approbation",
                required: true
            },
            {
                id: 4,
                libelle: "Les demandes pour un date d'autorisation spécifique",
                datefield: "Sélectionnez la plage de dates d'autorisation",
                required: true
            },
            {
                id: 5,
                libelle: "Les demandes pour un type et une date spécifique",
                nextfield: "Sélectionnez le type de demande",
                datefield: "Sélectionnez la plage de dates de demande",
                required: false
            },
            {
                id: 6,
                libelle: "Les demandes en attente et une date spécifique",
                datefield: "Sélectionnez la plage de dates de demande",
                required: false
            },
            {
                id: 7,
                libelle: "Les demandes vérifiée à une date spécifique",
                datefield: "Sélectionnez la plage de dates de demande",
                required: false
            },
            {
                id: 8,
                libelle: "Les demandes approuvées à une date spécifique",
                datefield: "Sélectionnez la plage de dates de demande",
                required: false
            },
            {
                id: 9,
                libelle: "Les demandes autorisées à une date spécifique",
                datefield: "Sélectionnez la plage de dates de demande",
                required: false
            },
            {
                id: 10,
                libelle: "Les demandes rejetées à une date spécifique",
                datefield: "Sélectionnez la plage de dates de demande",
                required: false
            },
            {
                id: 11,
                libelle: "Les demandes renvoyée et une date spécifique",
                datefield: "Sélectionnez la plage de dates de demande",
                required: false
            },
            {
                id: 12,
                libelle: "Les demandes annulée à une date spécifique",
                datefield: "Sélectionnez la plage de dates de demande",
                required: false
            },
            {
                id: 13,
                libelle: "Les demandes révisée à une date spécifique",
                datefield: "Sélectionnez la plage de dates de demande",
                required: false
            },
            {
                id: 14,
                libelle: "Les demandes vérifiée par un utilisateur à une date spécifique",
                nextfield: "Sélectionnez l'utilisateur",
                datefield: "Sélectionnez la plage de dates de demande",
                required: false
            },
            {
                id: 15,
                libelle: "Les demandes approuvées par un utilisateur à une date spécifique",
                datefield: "Sélectionnez la plage de dates de demande",
                nextfield: "Sélectionnez l'utilisateur",
                required: false
            },
            {
                id: 16,
                libelle: "Les demandes autorisées par un utilisateur à une date spécifique",
                datefield: "Sélectionnez la plage de dates de demande",
                nextfield: "Sélectionnez l'utilisateur",
                required: false
            },
            {
                id: 17,
                libelle: "Les demandes rejetées par un utilisateur à une date spécifique",
                nextfield: "Sélectionnez l'utilisateur",
                datefield: "Sélectionnez la plage de dates de demande",
                required: false
            },
            // { id: 18, libelle: "Les demandes renvoyée par un utilisateur à une date spécifique", nextfield: "Sélectionnez l'utilisateur", datefield: "Sélectionnez la plage de dates de demande", required: false },
            {
                id: 18,
                libelle: "Les demandes urgentes à une date spécifique",
                datefield: "Sélectionnez la plage de dates de demande",
                required: false
            },
            {
                id: 19,
                libelle: "Les demandes d'une ville spécifique à une date spécifique",
                datefield: "Sélectionnez la plage de dates de demande",
                required: false
            },
            {
                id: 20,
                libelle: "Les demandes pour un type de vole à une date spécifique",
                nextfield: "Sélectionnez le type de vol",
                datefield: "Sélectionnez la plage de dates de demande",
                required: false
            },
            {
                id: 21,
                libelle: "Les demandes non soumis à une date spécifique",
                datefield: "Sélectionnez la plage de dates de demande",
                required: false
            },
            {
                id: 22,
                libelle: "Les demandes par postutant à une date spécifique",
                nextfield: "Sélectionnez le postulant",
                datefield: "Sélectionnez la plage de dates de demande",
                required: false
            },
        ],
        headers: [{
                text: "Date demande",
                value: "created_at"
            },
            {
                text: "Date du vol",
                value: "date_prevu_vol",
                sortable: false
                
            },
            {
                text: "Immatriculation",
                value: "immatriculation"
            },
            {
                text: "Indicatif d'appel ",
                value: "call"
            },
            {
                text: "Postulant",
                value: "user.postulant.nom_raison_sociale"
            },
            {
                text: "Nature de la demande",
                value: "type_demande"
            },
            {
                text: "Motif du vol",
                value: "motif"
            },
            {
                text: "statut",
                value: "statut.libelle"
            },
            {
                text: "Actions",
                value: "action",
                sortable: false
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
            axios.post(route("query.store", {
                type_rapport: 'Demande',
                data: this.form
            })).then((res) => {
                console.log(res.data)
                if (typeof res.data === "string") {
                    this.$toast.error(res.data);
                } else {
                    this.resultat = res.data
                }
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
