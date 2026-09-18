<template>
<admin-layout>
    <Toolbar :Title="'Modules enseignés dans le ' + groupe.libelle + ' des éléves ' + groupe.corp?.nom" :breadcrumbs="breadcrumbs">

    </Toolbar>
    <v-data-table :headers="headers" :items="enseignements" item-key="name" :search="search" dense class="my-3 pt-3" style="border: 1px solid rgb(245, 134, 52)">
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
            <BtnAction icon display-icon="mdi-chart-line" title="Avancements des modules" @click="VueAvancement(item)" color="primary" small />
            <!-- <BtnAction icon display-icon="mdi-antenna" title="Matières" @click="VueModule(item)" color="blue" small /> -->
        </template>
        <template v-slot:item.enseignant="{ item }">
            <v-chip label>{{ item.enseignant.nom }} {{ item.enseignant.prenom }}</v-chip>
        </template>
        <template v-slot:item.avancement="{ item }">
            <v-progress-linear :value="Avancement(item)" :color="GetColor(Avancement(item))" height="20" striped>
                <strong>{{ Math.ceil(Avancement(item)) }}%</strong>
            </v-progress-linear>
        </template>
    </v-data-table>
    <v-dialog v-model="dialog" max-width="600px" scrollable>
        <v-card>
            <v-toolbar dense dark color="primary" class="text-h6">Nouveau enseignement</v-toolbar>
            <div>
                <v-card-text class="pt-4">
                    <v-row>
                        <v-col cols="12">
                            <selectField label="Matières" v-model="form.module_id" outlined name="Matières" color="secondary" :items="modules" :item-text="item => `${item.matiere.libelle}`" item-value="id" autocomplete="false" chips></selectField>
                        </v-col>
                        <v-col cols="12">
                            <selectField label="Enseignants" v-model="form.enseignant_id" outlined name="Enseignants" color="secondary" :items="enseignants" :item-text="item => `${item.nom} ${item.prenom}`" item-value="id" autocomplete="false" chips></selectField>
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
    props: ["enseignements", "groupe", "id", "modules", "enseignants"],
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
            headers: [{
                    text: 'Matière',
                    value: 'modulo.matiere.libelle'
                },
                {
                    text: 'Enseignant',
                    value: 'enseignant'
                },
                {
                    text: 'Avancement (%)',
                    value: 'avancement'
                },
                {
                    text: 'Actions ',
                    value: 'action'
                },
            ],
            form: this.$inertia.form({
                module_id: null,
                enseignant_id: null,
                groupe_id: this.id
            }),
        }

    },
    methods: {
        creer() {
            this.dialog = true
        },
        submit() {
            this.$alert.confirm('Etes-vous sûr ?', "De vouloir faire cet enregistrement", () => {
                this.form.post(route("enseignement.store"), {
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
        },
        Avancement(item) {
            let horaire_total = parseInt(item.modulo.horaire)
            let somme_horaire = item?.avancements?.reduce((acc, item) => acc + parseInt(item.nombre_heure), 0)
            let pourcentage = (somme_horaire * 100) / horaire_total
            return pourcentage??0
        },
        GetColor(item){
            if (item <=25){
                return 'red'
            }
            if (item >25 && item<=50){
                return 'orange'
            }
            if (item>50 && item <=75){
                return 'green'
            }
            if(item <= 100){
                return 'blue'
            }
        },
        VueAvancement(item){
            this.$inertia.get(route('avancement.index', item.id))
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
