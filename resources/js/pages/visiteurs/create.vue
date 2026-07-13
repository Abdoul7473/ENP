<template>
<admin-layout>
    <Toolbar Title="Enregistrement de visiteur">
    </Toolbar>
    <v-card>
        <v-card-text>
            <v-form ref="myForm" @submit.prevent="submit">
                <v-row>
                    <v-col cols="12" sm="4">
                        <TextField label="Nom" rules="required" name="Nom" v-model="form.nom" required outlined dense color="secondary" autocomplete="false"></TextField>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <TextField label="Prénom" rules="required" name="Prénom" v-model="form.prenom" required outlined dense color="secondary" autocomplete="false"></TextField>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <TextField label="E-mail" type="email"  name="E-mail" v-model="form.email"  outlined dense color="secondary" autocomplete="false"></TextField>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" sm="4">
                        <selectField label="Sexes" required v-model="form.sexe" outlined name="Sexe" color="secondary" :items="sexes" item-text="name" item-value="id" autocomplete="false" chips></selectField>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <TextField label="Téléphone" rules="required" name="tel" type="number" v-model="form.tel" required outlined dense color="secondary" autocomplete="false"></TextField>
                    </v-col>
                    <v-menu v-model="menu" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="auto">
                        <template v-slot:activator="{ on, attrs }">
                            <v-text-field v-model="form.date_naiss" label="Date de naissance" prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on"></v-text-field>
                        </template>
                        <v-date-picker v-model="form.date_naiss" @input="menu = false"></v-date-picker>
                    </v-menu>
                </v-row>
                <v-row>
                    <v-col cols="12" sm="4">
                        <v-menu ref="menu1" v-model="menu1" :close-on-content-click="false" :nudge-right="40" :return-value.sync="form.heure_arrive" transition="scale-transition" offset-y max-width="290px" min-width="290px">
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field v-model="form.heure_arrive" label="Heure d'arrivée" prepend-icon="mdi-clock-time-four-outline" readonly v-bind="attrs" v-on="on"></v-text-field>
                            </template>
                            <v-time-picker format="24hr" v-if="menu1" v-model="form.heure_arrive" full-width @click:minute="$refs.menu1.save(form.heure_arrive)"></v-time-picker>
                        </v-menu>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <v-menu ref="menu2" v-model="menu2" :close-on-content-click="false" :nudge-right="40" :return-value.sync="form.heure_depart" transition="scale-transition" offset-y max-width="290px" min-width="290px">
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field v-model="form.heure_depart" label="Heure de depart" prepend-icon="mdi-clock-time-four-outline" readonly v-bind="attrs" v-on="on"></v-text-field>
                            </template>
                            <v-time-picker format="24hr" v-if="menu2" v-model="form.heure_depart" full-width @click:minute="$refs.menu2.save(form.heure_depart)"></v-time-picker>
                        </v-menu>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <selectField label="Lieu" required v-model="form.localite" outlined name="localite" color="secondary" :items="localites" item-text="name" item-value="name" autocomplete="false" chips></selectField>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="8">
                        <v-textarea counter label="Motif" required v-model="form.motif"></v-textarea>
                    </v-col>
                </v-row>
                <v-card-actions>
                    <v-spacer />
                    <v-btn :loading="form.processing" @click="goBack()" color="error"> Annuler</v-btn>
                    <v-btn :loading="form.processing" type="submit" color="primary"> Enregistrer</v-btn>
                </v-card-actions>
            </v-form>
        </v-card-text>
    </v-card>
</admin-layout>
</template>

<script>
import AdminLayout from "../../layouts/AdminLayout.vue"
export default {
    components: {
        AdminLayout
    },
    props: ["users"],
    data() {
        return {
            form: this.$inertia.form({
                nom: '',
                prenom: '',
                email: '',
                sexe: 1,
                tel: null,
                motif: '',
                heure_depart: null,
                heure_arrive: null,
                date_naiss: null,
                localite: null
            }),
            menu1: false,
            menu2: false,
            modal2: false,
            menu: false,
            sexes: [{
                    'id': 1,
                    'name': 'Masculin'
                },
                {
                    'id': 2,
                    'name': 'Feminin'
                }
            ],
            localites: [{
                    name: "DENP"
                },
                {
                    name: "Magasin"
                },
                {
                    name: "Infirmerie"
                },
                {
                    name: "Ciblerie"
                },
                {
                    name: "CUISINE"
                },
                {
                    name: "Surveillance"
                },
                {
                    name: "Bibliothèque"
                },
                {
                    name: "Salle Informatique"
                },
                {
                    name: "Salle de Gym"
                }
            ]
        }
    },
    methods: {
        submit() {
            this.$alert.confirm('Etes-vous sûr ?', "Vous allez enregistrer ce visiteur", () => {
                this.form.post(route("visiteurs.store"), {
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

    }
}
</script>
