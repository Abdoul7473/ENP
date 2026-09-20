<template>
<admin-layout>
    <Toolbar :Title="'Liste des évaluations du ' + groupe.libelle " :breadcrumbs="breadcrumbs">

    </Toolbar>
    <v-data-table :headers="headers" :items="evaluations" item-key="name" :search="search" dense class="my-3 pt-3" style="border: 1px solid rgb(245, 134, 52)">
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
            <BtnAction icon display-icon="mdi-email" title="Notes" @click="VueNote(item)" color="primary" small />
        </template>
        <template v-slot:item.assistants="{ item }">
            <v-chip outlined color="primary" label> {{ item.assistant1}}
            </v-chip>
            <v-chip outlined color="primary" label> {{ item.assistant2}}
            </v-chip>
        </template>
    </v-data-table>
    <v-dialog v-model="dialog" max-width="700px" scrollable persistent>
        <v-card>
            <v-toolbar dense dark color="primary" class="text-h6">Nouvelle évaluation</v-toolbar>
            <div>
                <v-card-text class="pt-4">
                    <v-row>
                        <v-col cols="12">
                            <TextField label="Date de l'évaluation" type="date" rules="required" name="Date de l'évaluation" v-model="form.date_evaluation" required outlined dense color="secondary" autocomplete="false"></TextField>
                        </v-col>
                        <v-col cols="12">
                            <TextField label="Assistant 1" name="Assistant 1" v-model="form.assistant1" outlined dense color="secondary" autocomplete="false"></TextField>
                        </v-col>
                        <v-col cols="12">
                            <TextField label="Assistant 2" name="Assistant 2" v-model="form.assistant2" outlined dense color="secondary" autocomplete="false"></TextField>
                        </v-col>
                        <v-col cols="12">
                            <selectField label="Type d'évaluation" v-model="form.type" outlined name="Type d'évaluation" color="secondary" :items="types" item-text="libelle" item-value="libelle" autocomplete="false" chips></selectField>
                        </v-col>
                        <v-col cols="12">
                            <selectField label="Matières" v-model="form.enseignement_id" outlined name="Matières" color="secondary" :items="enseignements" :item-text="item => `${item?.modulo?.matiere?.libelle}`" item-value="id" autocomplete="false" chips></selectField>
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
    props: ["evaluations", "groupe", "id", "enseignements"],
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
                    text: 'Date de l\'évaluation',
                    value: 'date_evaluation'
                },
                {
                    text: 'Matière ',
                    value: 'enseignant_groupe_modulo.modulo.matiere.libelle'
                },
                {
                    text: 'Type d\'évaluation ',
                    value: 'type_evaluation'
                },
                {
                    text: 'Assistants ',
                    value: 'assistants'
                },
                {
                    text: 'Actions ',
                    value: 'action'
                },
            ],
            form: this.$inertia.form({
                date_evaluation: null,
                type: null,
                enseignement_id: null,
                assistant1: null,
                assistant2: null,
                id: this.id
            }),
            types: [{
                    libelle: "Dévoir"
                },
                {
                    libelle: "Examen"
                }
            ]
        }

    },
    methods: {
        creer() {
            this.dialog = true
        },
        VueNote(item) {
            this.$inertia.get(route('note.index', item.id))
        },
        submit() {
            this.$alert.confirm('Etes-vous sûr ?', "Vous allez enregistrer cette évaluation", () => {
                this.form.post(route("evaluation.store"), {
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
