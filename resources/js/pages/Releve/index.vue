<template>
<admin-layout>
    <Toolbar Title="Rélevé des notes">

    </Toolbar>
    <v-card>
        <v-toolbar dense dark color="primary" class="text-h6"> Génération de rélevé de notes</v-toolbar>
        <v-card-text>
            <br>
            <div class="invitation-container">
                <div>
                    <div class="content">
                        <v-row>
                            <v-col cols="5">
                                <selectField label="Corps" required v-model="form.corp_id" outlined name="Corps" color="secondary" :items="corps" item-text="nom" item-value="id" autocomplete="false" chips @input="GetGroupe(form.corp_id)"></selectField>
                            </v-col>
                            <v-col cols="5">
                                <selectField :disabled="!form.corp_id" label="Groupes" required v-model="form.groupe_id" outlined name="Groupes" color="secondary" :items="groupes" item-text="libelle" item-value="id" autocomplete="false" chips @input="GetReleve(form.groupe_id)"></selectField>
                            </v-col>
                            <v-col cols="2" class="pt-4">
                                <v-btn :disabled="releves.length != 0 || !form.groupe_id" @click="genere(item)" small color="primary">
                                    <v-icon left>mdi-search-web</v-icon> générer
                                </v-btn>
                            </v-col>
                        </v-row>

                    </div>
                </div>
            </div>
        </v-card-text>
    </v-card>
    <v-data-table :headers="headers" :items="releves" v-if="releves.length>=1" dense class="my-3 pt-3" style="border: 1px solid rgb(245, 134, 52)" :search="search">
        <template v-slot:top>
            <v-row>
                <v-col cols="8" class="pt-8">
                </v-col>
                <v-col class="pt-8" cols="4">
                    <v-text-field v-model="search" prepend-inner-icon="mdi-search-web" single-line outlined dense clearable label="Réchercher" placeholder="Réchercher" class="mx-3"></v-text-field>
                </v-col>
            </v-row>
        </template>
        <template v-slot:item.eleves="{ item }">
            <p>{{ item.eleve.matricule }} {{ item.eleve.prenom }} {{ item.eleve.nom }}</p>
        </template>
        <template v-slot:item.action="{ item }">
            <a :href="route('releve.pdf', { id: item.id})" target="__blank" title="Imprimer le relever">
                <v-icon size="small" class="me-2" icon="mdi-printer" color="info" small>mdi-printer</v-icon>
            </a>
        </template>

    </v-data-table>
    <v-dialog v-model="isLoading" persistent width="400">
        <v-card>
            <v-card-text style="text-align: center;">
                <v-progress-circular :size="70" :width="7" color="purple" class="pt-2" indeterminate></v-progress-circular>
            </v-card-text>
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
    props: ["corps", "groupes", "releves"],
    data() {
        return {
            search: null,
            form: this.$inertia.form({
                corp_id: null,
                groupe_id: null
            }),
            isLoading: false,
            headers: [{
                    text: 'Nom et Prenom',
                    value: 'eleves'
                },
                {
                    text: 'Note de classe ',
                    value: 'total_note_classe'
                },
                {
                    text: 'Note de classe coefficientée',
                    value: 'total_note_coefficiente_classe'
                },
                {
                    text: 'Noyenne de classe ',
                    value: 'moyenne_classe'
                },
                {
                    text: 'Note d\'examen ',
                    value: 'total_note_examen'
                },
                {
                    text: 'Note d\'examen coefficientée',
                    value: 'total_note_coefficiente_examen'
                },
                {
                    text: 'Noyenne d\'examen ',
                    value: 'moyenne_examen'
                },
                {
                    text: 'Actions ',
                    value: 'action'
                },
            ],
        }
    },
    methods: {
        GetGroupe(item) {
            this.$inertia.replace(this.$page.url, {
                data: {
                    corp_id: item
                }
            })
        },
        GetReleve(item) {
            this.$inertia.replace(this.$page.url, {
                data: {
                    groupe_id: item
                }
            })
        },
        async genere() {
            this.isLoading = true
            await axios.get(route('releve.generate', {
                    groupe_id: this.form.groupe_id,
                    corp_id: this.form.corp_id
                }))
                .then(res => {
                    this.isLoading = false

                })
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
