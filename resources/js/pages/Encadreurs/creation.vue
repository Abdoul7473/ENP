<template>
<admin-layout>
    <Toolbar Title="Enregistrement d'un personnel">
    </Toolbar>
    <v-card>
        <v-card-text>
            <v-form ref="myForm" @submit.prevent="submit">
                <v-stepper v-model="e1">
                    <v-stepper-header>
                        <v-stepper-step :complete="e1 > 1" step="1">
                            Information personnelle
                        </v-stepper-step>

                        <v-divider></v-divider>

                        <v-stepper-step :complete="e1 > 2" step="2">
                            Affectation
                        </v-stepper-step>

                        <v-divider></v-divider>

                    </v-stepper-header>

                    <v-stepper-items>
                        <v-stepper-content step="1">
                            <v-row class="pt-8">
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
                                <v-col cols="4">
                                    <v-menu v-model="menu" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="auto">
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field v-model="form.date_naiss" label="Date de naissance" prepend-icon="mdi-calendar" readonly v-bind="attrs" v-on="on"></v-text-field>
                                        </template>
                                        <v-date-picker v-model="form.date_naiss" @input="menu = false"></v-date-picker>
                                    </v-menu>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="12" sm="4">
                                    <TextField label="Lieu de naissance" name="lieu_naiss" v-model="form.lieu_naiss" outlined dense color="secondary" autocomplete="false"></TextField>
                                </v-col>
                                <v-col cols="12" sm="4">
                                    <selectField label="Groupe Sanguin" v-model="form.groupe_sanguin" outlined color="secondary" :items="groupe_sanguins" item-text="libelle" item-value="libelle" autocomplete="false" chips></selectField>
                                </v-col>
                                <v-col cols="12" sm="4">
                                    <selectField label="Grades" required v-model="form.grade" outlined color="secondary" :items="grades" item-text="libelle" item-value="id" autocomplete="false" chips>
                                        <template #selection="data">
                                            <div class="d-flex align-center">
                                                <img :src="'/galon/' + data.item.galon" alt="Flag" class="flag mr-2" />
                                                {{ data.item.libelle }}
                                            </div>
                                        </template>
                                        <template #item="data">
                                            <div class="d-flex align-center">
                                                <img :src="'/galon/' + data.item.galon" alt="Flag" class="flag mr-2" />
                                                {{ data.item.libelle }}
                                            </div>
                                        </template>
                                    </selectField>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="12" sm="4">
                                    <selectField label="Type personnel" required v-model="form.type" outlined color="secondary" :items="types" item-text="libelle" item-value="id" autocomplete="false" chips></selectField>
                                </v-col>
                                <v-col cols="12" sm="4" v-if="form.type == 2">
                                    <selectField label="Compagnies" required v-model="form.compagnie" outlined color="secondary" :items="compagnies" item-text="nom" item-value="id" autocomplete="false" chips></selectField>
                                </v-col>
                                <v-col v-if="form.type == 2">
                                    <v-checkbox v-model="form.is_commandant" label="Le commandant de compagnie ?" color="primary" value="1" hide-details></v-checkbox>
                                </v-col>
                            </v-row>

                            <v-btn color="primary" @click="e1 = 2">
                                Suivant
                                <v-icon>mdi-arrow-right</v-icon>
                            </v-btn>
                        </v-stepper-content>

                        <v-stepper-content step="2">
                            <v-row class="pt-8">
                                <v-col cols="12" sm="4">
                                    <TextField label="Date d'affectation" type="date" rules="required" name="Date d'affectation" v-model="form.date_affectation" required outlined dense color="secondary" autocomplete="false"></TextField>
                                </v-col>
                                <v-col cols="12" sm="4">
                                    <selectField label="Entités" v-model="form.entite_id" outlined color="secondary" :items="entites" item-text="libelle" item-value="id" autocomplete="false" chips></selectField>
                                </v-col>
                                <v-col cols="12" sm="4">
                                    <selectField label="Profils" v-model="form.profil_id" outlined color="secondary" :items="profils" item-text="libelle" item-value="id" autocomplete="false" chips></selectField>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="12" sm="4">
                                    <TextField label="N° de décision" rules="required" name="N° de décision" v-model="form.num_decision" required outlined dense color="secondary" autocomplete="false"></TextField>
                                </v-col>
                                <v-col cols="12" sm="4">
                                    <v-file-input label="Téléverser la décision en PDF" v-model="form.decision"></v-file-input>
                                </v-col>
                                <v-col cols="12" sm="4">
                                    <v-file-input label="Téléverser le document en PDF" v-model="form.document"></v-file-input>
                                </v-col>
                            </v-row>
                            <v-btn color="primary" @click="e1 = 1">
                                <v-icon>mdi-arrow-left</v-icon>
                                Précedent
                            </v-btn>
                            <v-card-actions>
                                <v-spacer />
                                <v-btn :loading="form.processing" @click="goBack()" color="error"> Annuler</v-btn>
                                <v-btn :loading="form.processing" type="submit" color="primary"> Enregistrer</v-btn>
                            </v-card-actions>
                        </v-stepper-content>
                    </v-stepper-items>
                </v-stepper>
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
    props: ["grades", "compagnies", "entites", "profils"],
    data() {
        return {
            form: this.$inertia.form({
                nom: '',
                prenom: '',
                matricule: '',
                sexe: 'Masculin',
                tel: null,
                date_naiss: null,
                grade: null,
                compagnie: null,
                is_commandant: 2,
                lieu_naiss: null,
                groupe_sanguin: null,
                type: 1,
                date_affectation : null,
                entite_id : null,
                profil_id : null,
                num_decision : null,
                decision : null,
                document : null
            }),
            e1: 1,
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
            groupe_sanguins: [{
                    'libelle': 'O-'
                },
                {
                    'libelle': 'O+'
                },
                {
                    'libelle': 'A-'
                },
                {
                    'libelle': 'A+'
                },
                {
                    'libelle': 'B-'
                },
                {
                    'libelle': 'B+'
                },
                {
                    'libelle': 'AB-'
                },
                {
                    'libelle': 'AB+'
                }
            ],
            types: [{
                    'id': 1,
                    'libelle': 'Administré'
                },
                {
                    'id': 2,
                    'libelle': 'Encadreur'
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

<style>
.language-option {
    display: flex;
    align-items: center;
}

.flag {
    width: 20px;
    height: 14px;
    margin-right: 8px;
}
</style>
