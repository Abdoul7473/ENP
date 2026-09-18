<template>
<admin-layout>
    <Toolbar :Title="'Notation des élèves du ' + enseignement.groupe.libelle + ' en ' + enseignement.modulo.matiere.libelle ">

    </Toolbar>
    <div style="">
        <v-data-table :headers="headers" :items="notes" v-if="notes.length>=1" sort-by="calories" class="elevation-1" :search="search">
            <template v-slot:top>
                <v-row>
                    <v-col cols="8" class="pt-8">
                    </v-col>
                    <v-col class="pt-8" cols="4">
                        <v-text-field v-model="search" prepend-inner-icon="mdi-search-web" single-line outlined dense clearable label="Réchercher" placeholder="Réchercher" class="mx-3"></v-text-field>
                    </v-col>
                </v-row>
            </template>
            <template v-slot:item.actions="{ item }">
                <v-icon small class="mr-2" @click="editItem(item)">
                    mdi-pencil
                </v-icon>
                <v-icon small @click="deleteItem(item)">
                    mdi-delete
                </v-icon>
            </template>
        </v-data-table>
    </div>
    <v-card class="mx-auto" max-width="1700" style="border: 2px solid primary;margin: 20px" v-if="eleves.length>=1 && notes.length == 0">
        <v-card-title style="color: white; background-color: rgb(0, 73, 128)">Saisissez les notes</v-card-title>
        <v-virtual-scroll :items="eleves" :item-height="64" height="600">

            <template v-slot:default="{ item }">
                <v-list-item>

                    <v-list-item-content>
                        <strong>{{ item.matricule }}</strong>
                        <v-list-item-title>{{ item.prenom }} {{ item.nom }} </v-list-item-title>
                    </v-list-item-content>

                    <v-list-item-action>
                        <v-text-field label="Note" v-model="form.notes[item.id]" :rules="[(v) => !(Math.sign(v) == -1) || 'La note doit être positif' ,(v) => !!v || 'Veuillez renseigner la note!', (v) =>  v <= 20 || 'La note ne doit pas dépasser 20']"></v-text-field>
                    </v-list-item-action>
                </v-list-item>
                <v-divider></v-divider>

            </template>

        </v-virtual-scroll>
        <v-card-actions>
            <v-spacer />
            <v-btn :loading="form.processing" @click="submit()" variant="outlined" color="green">
                <v-icon></v-icon> Enreistrer
            </v-btn>
        </v-card-actions>
    </v-card>

</admin-layout>
</template>

<script>
import AdminLayout from "../../layouts/AdminLayout.vue"
export default {
    components: {
        AdminLayout
    },
    props: ["notes", "eleves", "corp", "id", "enseignement"],
    data() {
        return {
            search : null,
            form: this.$inertia.form({
                notes: [],
                id: this.id
            }),
            headers: [{
                    text: 'Matricule',
                    value: 'eleve.matricule'
                },
                {
                    text: 'Prénom ',
                    value: 'eleve.prenom'
                },
                {
                    text: 'Nom ',
                    value: 'eleve.nom'
                },
                {
                    text: 'Note ',
                    value: 'note'
                },
                {
                    text: 'Actions ',
                    value: 'action'
                },
            ],
        }
    },
    methods: {
        submit() {
            console.log(this.form);

            this.$alert.confirm('Etes-vous sûr ?', "Vous allez enregistrer ces notes", () => {
                this.form.post(route("note.store"), {
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
