<template>
<admin-layout>
    <Toolbar Title="Modification d'un élève">
    </Toolbar>
    <v-card>
        <v-card-text>
            <v-form ref="myForm" @submit.prevent="submit">
                <v-row>
                    <v-col cols="3">
                        <picture-input ref="pictureInput" v-model="form.photo" width="200" height="200" margin="16" accept="image/jpeg,image/png" size="10" button-class="btn" :custom-strings="{  }" @change="onChange">
                        </picture-input>
                    </v-col>
                    <v-col cols="9">
                        <v-row>
                            <v-col cols="12" sm="4">
                                <TextField label="Matricule" rules="required" name="matricule" v-model="form.matricule" disabled outlined dense color="secondary" autocomplete="false"></TextField>
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
                                <TextField label="Groupe sanguin" name="groupe_sanguin" v-model="form.groupe_sanguin" outlined dense color="secondary" autocomplete="false"></TextField>
                            </v-col>
                        </v-row>
                    </v-col>

                </v-row>
                <v-row>
                    <v-col cols="1">
                    </v-col>
                    <v-col>
                        <v-progress-circular model-value="100" color="primary" :size="100" :width="2" class="" v-if="photo">
                            <v-avatar size="150">
                                <v-img :src="'/eleves/' + photo" alt="John"></v-img>
                            </v-avatar>
                        </v-progress-circular>
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
import PictureInput from 'vue-picture-input'
export default {
    components: {
        AdminLayout,
        PictureInput
    },
    props: ["eleve"],
    data() {
        return {
            photo : this.eleve?.photo,
            form: this.$inertia.form({
                id: this.eleve?.id,
                nom: this.eleve?.nom,
                prenom: this.eleve?.prenom,
                matricule: this.eleve?.matricule,
                sexe: this.eleve?.sexe,
                tel: this.eleve?.tel,
                date_naiss: this.eleve?.date_naiss,
                lieu_naiss: this.eleve?.lieu_naiss,
                groupe_sanguin: this.eleve?.groupe_sanguin,
                photo: null
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
            ]
        }
    },
    methods: {
        submit() {
            this.$alert.confirm('Etes-vous sûr ?', "De vouloir modifier cet élève?", () => {

                this.form.post(route("eleve.update", {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }), {
                    onSuccess: () => {
                        if (this.$page.props.flash.success) {
                            this.$alert.success(this.$page.props.flash.success)
                        }
                        if (this.$page.props.flash.error) {
                            this.$toast.error(this.$page.props.flash.error)
                        }
                        this.close()
                        this.form.reset();
                    },
                    onError: this.$alert.messages

                });
            })
        },
        onChange(image) {
            console.log('New picture selected!')
            if (image) {
                console.log('Picture loaded.')
                this.form.photo = image
            } else {
                console.log('FileReader API not supported: use the <form>, Luke!')
            }
        },

    }
}
</script>
