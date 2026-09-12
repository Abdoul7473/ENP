<template>
<admin-layout>
    <Toolbar :Title="'Modules des élèves ' + corp.nom" :breadcrumbs="breadcrumbs">

    </Toolbar>
    <v-data-table :headers="headers" :items="modules" item-key="name" :search="search" dense class="my-3 pt-3" style="border: 1px solid rgb(245, 134, 52)">
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
        <template v-slot:item.action="{ item }">
            <!-- <BtnAction icon display-icon="mdi-account-group" title="Groupes" @click="VueGroupe(item)" color="primary" small /> -->
        </template>
    </v-data-table>
    <v-dialog v-model="dialog" max-width="600px" scrollable>
        <v-card>
            <v-toolbar dense dark color="primary" class="text-h6">Nouveau</v-toolbar>
            <div>
                <v-card-text class="pt-4">
                    <v-row>
                        <v-col cols="12">
                            <selectField label="Matières" v-model="form.matiere_id" outlined name="Matières" color="secondary" :items="matieres" item-text="libelle" item-value="id" autocomplete="false" chips></selectField>
                        </v-col>
                        <v-col cols="12">
                            <TextField label="Volume horaire (en H)" type="number" rules="required" name="Volume horaire (en H)" v-model="form.horaire" required outlined dense color="secondary" autocomplete="false"></TextField>
                        </v-col>
                        <v-col cols="12">
                            <TextField label="Coefficient" type="number" rules="required" name="Coefficient" v-model="form.coefficient" required outlined dense color="secondary" autocomplete="false"></TextField>
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
    props: ["modules", "corp","matieres","id"],
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
            selectedMonth: null,
            headers: [{
                    text: 'Matière',
                    value: 'matiere.libelle'
                },
                {
                    text: 'Volume horaire ',
                    value: 'horaire'
                },
                {
                    text: 'Coefficient',
                    value: 'coefficient'
                },
                {
                    text: 'Actions ',
                    value: 'action'
                },
            ],
            form: this.$inertia.form({
                corp_id : this.id,
                id : null,
                matiere_id: null,
                horaire: 0,
                coefficient: 0
            }),
        }

    },
    methods: {
        creer() {
            this.dialog = true
        },
        VueGroupe(item) {
            this.$inertia.get(route('groupe.index', item.id))
        },
        submit() {
            this.$alert.confirm('Etes-vous sûr ?', "Vous allez enregistrer cette affectation", () => {
                this.form.post(route("module.store"), {
                    onSuccess: () => {
                        if (this.$page.props.flash.success) {
                            this.$alert.success(this.$page.props.flash.success)
                        }
                        if (this.$page.props.flash.error) {
                            this.$toast.error(this.$page.props.flash.error)
                        }
                        this.close()

                    },
                    onError: this.$alert.messages

                })
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
