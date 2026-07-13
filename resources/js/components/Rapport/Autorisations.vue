<template>
    
<v-card v-if="item.key == 2" class="px-2" color="basil" flat elevation="2" outlined>
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
    <v-card-text class="text-color">
        <v-row dense>
            <v-col>
                <selectField v-model="form.requestSelected" outlined :items="requests" label="Sélectionnez la requête souhaitée" name="Sélectionnez la requête souhaitée" item-text="libelle" item-value="id" rules="required" required></selectField>
            </v-col>
            <v-col md="5" v-if="form.requestSelected !== null">
                <dateRangePicker v-model="form.date" :label="Datefield" name="Date" :required="getRequiredStatus(form.item)" dense></dateRangePicker>
            </v-col>
            <v-col v-if="form.requestSelected == 5">
                <selectField v-model="form.postulant" outlined :items="postulants" label="Sélectionnez le postulant" name="Sélectionnez le postulant" item-text="nom_raison_sociale" item-value="id" rules="required" required></selectField>
            </v-col>
            <v-col v-if="form.requestSelected == 2">
                <selectField v-model="form.type_autoridstion" outlined :items="type_autoridstions" label="Sélectionnez le type d'autorisation" name="Sélectionnez le type d'autorisation" item-text="libelle" item-value="id" rules="required" required></selectField>
            </v-col>
        </v-row>
        <v-row dense v-if="form.requestSelected == 3 || form.requestSelected == 4">
            <v-col>
                <selectField v-model="form.operateurSelected" outlined :items="operateurs" label="Sélectionnez l'opération souhaitée" name="Sélectionnez l'opération souhaitée" item-text="explication" item-value="operation" rules="required" required></selectField>
            </v-col>
            <v-col>
                <TextField v-model="form.nombre" currency required :label="text" hide-details dense>
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
        <Resultat v-if="resultat != null" :type="'autorisation'" :resultat="resultat" :headers="headers"></Resultat>
    </v-card-text>
</v-card>
</template>

<script>
export default {
    props: {
        item: {

        },
        type_autoridstions: {},
        postulants: {}
    },
    computed: {
        Datefield() {
            const request = this.requests.find(request => request.id === this.form.requestSelected);
            this.form.item = request
            return request ? request.datefield : "";
        },
        text() {
            const request = this.requests.find(request => request.id === this.form.requestSelected);
            return request ? request.text : "";
        }
    },
    data: () => ({
        alert: false,
        resultat: null,
        form: {
            date: null,
            requestSelected: null,
            user: null,
            operateurSelected: null,
            nombre: null,
            type_autoridstion: null,
            item: null
        },
        requests: [{
                id: 1,
                libelle: "Les autorisations entre deux dates spécifique",
                datefield: "Sélectionnez la plage de dates d'autorisation",
                required: true
            },
            {
                id: 2,
                libelle: "Les autorisations par type et à une date spécifique",
                datefield: "Sélectionnez la plage de dates d'approbation",
                required: true
            },
            {
                id: 3,
                libelle: "Les autorisations pour un nombre de route et à une date spécifique",
                datefield: "Sélectionnez la plage de dates de survol",
                text: "Saisissez le nombre de route"
            },
            {
                id: 4,
                libelle: "Les autorisations par montant total et à une date spécifique",
                datefield: "Sélectionnez la plage de dates d'autorisation",
                text: "Saisissez le montant"
            },
            {
                id: 5,
                libelle: "Les autorisations par postutant à une date spécifique",
                datefield: "Sélectionnez la plage de dates de demande",
                required: false
            },
        ],
        operateurs: [{
                id: 1,
                explication: "Égal à",
                operation: "="
            },
            {
                id: 2,
                explication: "Supérieur ou égal à",
                operation: ">="
            },
            {
                id: 3,
                explication: "Inférieur ou égal à",
                operation: "<="
            },
            {
                id: 4,
                explication: "Différent de",
                operation: "!="
            },
        ],
        headers: [{
                text: "No",
                value: "id",
                sortable: false
            },
            {
                text: "Date autorisation",
                value: "date_autorisation"
            },
            {
                text: "Date du vol",
                value: "date_vol"
            },
            {
                text: "Nombre de route",
                value: "nombre_route"
            },
            {
                text: "Postulant",
                value: "postulant"
            },
            {
                text: "Montant total",
                value: "montant_total"
            },
            {
                text: "Immatriculation",
                value: "imatriculation"
            },
            {
                text: "Call sign",
                value: "cal"
            },
            {
                text: "Numéro d'autorisation",
                value: "num"
            },
            {
                text: "Type d'autorisation",
                value: "type_autorisation.libelle"
            },
        ],
    }),
    methods: {
        submit() {
            axios.post(route("query.store", {
                type_rapport: 'Autorisations',
                data: this.form
            })).then((res) => {
                if (typeof res.data === "string") {
                    this.$toast.error(res.data);
                } else {
                    this.resultat = res.data
                    console.log('resultat', this.resultat);
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
