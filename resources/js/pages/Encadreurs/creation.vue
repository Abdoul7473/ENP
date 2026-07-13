<template>
<admin-layout>
    <Toolbar Title="Enregistrement d'un encadreur">
    </Toolbar>
    <v-card>
        <v-card-text>
            <v-form ref="myForm" @submit.prevent="submit">
                <v-row>
                    <v-col cols="12" sm="4">
                        <TextField label="Matricule" rules="required" name="matricule" v-model="form.matricule" required outlined dense color="secondary" autocomplete="false"></TextField>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <TextField label="Nom" rules="required" name="Nom" v-model="form.nom" required outlined dense color="secondary" autocomplete="false"></TextField>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <TextField label="Prénom" rules="required" name="Prénom" v-model="form.prenom" required outlined dense color="secondary" autocomplete="false"></TextField>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" sm="4">
                        <selectField label="Sexes" required v-model="form.sexe" outlined name="Sexe" color="secondary" :items="sexes" item-text="name" item-value="name" autocomplete="false" chips></selectField>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <TextField label="Téléphone" rules="required" name="tel" type="number" v-model="form.tel" required outlined dense color="secondary" autocomplete="false"></TextField>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <TextField label="E-mail" type="email" name="E-mail" v-model="form.email" outlined dense color="secondary" autocomplete="false"></TextField>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="4">
                        <v-menu v-model="menu" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="auto">
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field v-model="form.date_naiss" label="Date de naissance" prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on"></v-text-field>
                            </template>
                            <v-date-picker v-model="form.date_naiss" @input="menu = false"></v-date-picker>
                        </v-menu>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <TextField label="Lieu de naissance" name="lieu_naiss" v-model="form.lieu_naiss" outlined dense color="secondary" autocomplete="false"></TextField>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <selectField label="Groupe Sanguin"  v-model="form.groupe_sanguin" outlined color="secondary" :items="groupe_sanguins" item-text="libelle" item-value="libelle" autocomplete="false" chips></selectField>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" sm="4">
                        <selectField label="Grades" required v-model="form.grade" outlined color="secondary" :items="grades" item-text="libelle" item-value="id" autocomplete="false" chips></selectField>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <selectField label="Compagnies" required v-model="form.compagnie" outlined color="secondary" :items="compagnies" item-text="nom" item-value="id" autocomplete="false" chips></selectField>
                    </v-col>
                    <v-col>
                        <v-checkbox v-model="form.is_commandant" label="Le commandant de compagnie ?" color="primary" value="1" hide-details></v-checkbox>
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
    props: ["grades", "compagnies"],
    data() {
        return {
            form: this.$inertia.form({
                nom: '',
                prenom: '',
                matricule: '',
                email: '',
                sexe: 'Masculin',
                tel: null,
                date_naiss: null,
                grade: null,
                compagnie: null,
                is_commandant: 2,
                lieu_naiss: null,
                groupe_sanguin: null
            }),
            menu1: false,
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
            groupe_sanguins : [
                {
                    'libelle' : 'O-'
                },
                {
                    'libelle' : 'O+'
                },
                {
                    'libelle' : 'A-'
                },
                {
                    'libelle' : 'A+'
                },
                {
                    'libelle' : 'B-'
                },
                {
                    'libelle' : 'B+'
                },
                {
                    'libelle' : 'AB-'
                },
                {
                    'libelle' : 'AB+'
                }
            ]
        }
    },
    methods: {
        submit() {
            this.form.post(route("encadreur.store"), {
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
        }

    }
}
</script>
