<template>
<admin-layout>
    <Toolbar Title="Enseignants" :breadcrumbs="breadcrumbs">

    </Toolbar>
    <v-data-table :headers="headers" :items="enseignants" item-key="name" :search="search" dense class="my-3 pt-3" style="border: 1px solid rgb(245, 134, 52)">
        <template v-slot:top>
            <v-row>
                <v-col cols="8" class="pt-8">
                    <v-btn @click="creer()" small color="primary">
                        <v-icon left>mdi-plus-circle</v-icon> Ajouter
                    </v-btn>
                </v-col>
                <v-col class="pt-8" cols="4">
                    <v-text-field v-model="search" prepend-inner-icon="mdi-search-web" single-line outlined dense clearable label="Réchercher" placeholder="Réchercher" class="mx-3"></v-text-field>
                </v-col>
            </v-row>
        </template>
        <!-- <template v-slot:item.action="{ item }">
            <BtnAction icon display-icon="mdi-account-group" title="Groupes"  @click="VueGroupe(item)" color="primary" small />
            <BtnAction icon display-icon="mdi-antenna" title="Matières"  @click="VueModule(item)" color="blue" small />
        </template> -->
    </v-data-table>
    <v-dialog v-model="dialog" max-width="900px" scrollable>
        <v-card>
            <v-toolbar dense dark color="primary" class="text-h6">Nouveau enseignant</v-toolbar>
            <div>
                <v-card-text class="pt-4">
                    <v-row>
                        <v-col cols="12" sm="6">
                            <TextField label="Nom" rules="required" name="Nom" v-model="form.nom" required outlined dense color="secondary" autocomplete="false"></TextField>
                        </v-col>
                        <v-col cols="12" sm="6">
                            <TextField label="Prénom" rules="required" name="Prénom" v-model="form.prenom" required outlined dense color="secondary" autocomplete="false"></TextField>
                        </v-col>
                        <v-col cols="12" sm="6">
                            <selectField label="Sexes" required v-model="form.sexe" outlined name="Sexe" color="secondary" :items="sexes" item-text="name" item-value="id" autocomplete="false" chips></selectField>
                        </v-col>
                        <v-col cols="12" sm="6">
                            <TextField label="Téléphone" type="number" name="Téléphone" v-model="form.telephone" outlined dense color="secondary" autocomplete="false"></TextField>
                        </v-col>
                        <v-col cols="12" sm="6">
                            <TextField label="Date de naissance" type="date" name="Date de naissance" v-model="form.date_naiss" outlined dense color="secondary" autocomplete="false"></TextField>
                        </v-col>
                        <v-col cols="12" sm="6">
                            <TextField label="Lieu de naissance" name="Lieu de naissance" v-model="form.lieu_naiss" outlined dense color="secondary" autocomplete="false"></TextField>
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-card-actions class="mt-2">
                    <v-spacer></v-spacer>
                    <v-btn dark small type="button" color="error" @click="close()">
                        <v-icon left>mdi-cancel</v-icon> Annuler
                    </v-btn>
                    <v-btn dark small color="green" @click="submit()">
                        <v-icon left>mdi-check-circle</v-icon> Enregistrer
                    </v-btn>
                </v-card-actions>
            </div>
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
    props: ["enseignants"],
    data() {
        return {
            dialog: false,
            search: null,
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
            sexes: [{
                    'id': 'Masculin',
                    'name': 'Masculin'
                },
                {
                    'id': 'Féminin',
                    'name': 'Féminin'
                }
            ],
            headers: [{
                    text: 'Nom',
                    value: 'nom'
                },
                {
                    text: 'Prénom',
                    value: 'prenom'
                },
                {
                    text: 'Sexe',
                    value: 'sexe'
                },
                {
                    text: 'Téléphone',
                    value: 'telephone'
                },
                {
                    text: 'Date de naissance',
                    value: 'date_naiss'
                },
                {
                    text: 'Lieu de naissance',
                    value: 'lieu_naiss'
                },
                {
                    text: 'Actions ',
                    value: 'action'
                },
            ],
            form: this.$inertia.form({
                nom: null,
                prenom: null,
                date_naiss: null,
                lieu_naiss: null,
                telephone: null,
                sexe: null
            }),
        }

    },
    methods: {
        creer() {
            this.dialog = true
        },
        submit() {
            this.$alert.confirm('Etes-vous sûr ?', "Vous allez enregistrer cet enseignant", () => {
                this.form.post(route("enseignant.store"), {
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
                this.close()
            })
        },
        close() {
            this.dialog = false
            this.form.reset()
        }
    },
    created() {
        this.headers.forEach((item, i, items) => {
            if (i === 0) {
                item.class = 'primary white--text rounded-l-xl'
            } else if (i === items.length - 1) {
                item.class = 'primary white--text rounded-r-xl'
            } else {
                item.class = 'primary white--text'
            }
            item.divider = true
        })
    },
}
</script>

<style>
.custom-primary {
    background-color: rgba(225, 230, 210, 1) !important;
    color: black !important;
    /* pour s'assurer que le texte reste visible */
}
</style>
