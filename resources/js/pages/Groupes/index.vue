<template>
<admin-layout>
    <Toolbar :Title="'Groupes des élèves ' + corp.nom" :breadcrumbs="breadcrumbs">

    </Toolbar>
    <v-data-table :headers="headers" :items="groupes" item-key="name" :search="search" dense class="my-3 pt-3" style="border: 1px solid rgb(245, 134, 52)">
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
    <v-dialog v-model="dialog" max-width="900px" scrollable>
        <v-card>
            <v-toolbar dense dark color="primary" class="text-h6">Nouveau groupe</v-toolbar>
            <div>
                <v-card-text class="pt-4">
                    <v-row>
                        <v-col cols="12">
                            <TextField label="Libelle" rules="required" name="Libelle" v-model="form.libelle" required outlined dense color="secondary" autocomplete="false"></TextField>
                        </v-col>
                        <v-col cols="12">
                            <TextField label="Effectif théorique" type="number" rules="required" name="Effectif théorique" v-model="form.effectif" required outlined dense color="secondary" autocomplete="false"></TextField>
                        </v-col>
                        <v-col cols="12">
                            <selectField label="Elèves" v-model="form.eleves" multiple outlined name="Elèves" color="secondary" :items="eleves" :item-text="item => `${item.matricule} ${item.nom} ${item.prenom}`" item-value="id" autocomplete="false" chips></selectField>
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
    props: ["groupes", "eleves","corp","id"],
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
                    text: 'Libelle',
                    value: 'libelle'
                },
                {
                    text: 'Effectif ',
                    value: 'effectif'
                },
                {
                    text: 'Actions ',
                    value: 'action'
                },
            ],
            form: this.$inertia.form({
                corp_id : this.id,
                libelle: null,
                effectif: 0,
                eleves: []
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
            this.$alert.confirm('Etes-vous sûr ?', "Vous allez enregistrer ce groupe", () => {
                this.form.post(route("groupe.store"), {
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
        close(){
            this.dialog = false
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
