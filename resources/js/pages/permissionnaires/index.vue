<template>
<admin-layout>
    <Toolbar Title="Permissionnaires" :breadcrumbs="breadcrumbs">

    </Toolbar>

    <v-data-table :headers="headers" :items="permissionnaires" item-key="name" dense class="my-3 pt-3" :search="search" style="border: 1px solid rgb(245, 134, 52)">
        <template v-slot:top>
            <v-row>

                <v-col cols="8" class="pt-8">
                    <v-btn @click="create()" small color="primary">
                        <v-icon left>mdi-plus-circle</v-icon> Ajouter
                    </v-btn>
                </v-col>
                <v-col class="pt-8" cols="4">
                    <v-text-field v-model="search" prepend-inner-icon="mdi-search-web" single-line outlined dense clearable label="Récherecher" placeholder="Réchercher" class="mx-3"></v-text-field>
                </v-col>
            </v-row>
        </template>
        <template v-slot:item.loading="{ item }">
        </template>
        <template v-slot:item.action="{ item }">
             <a :href="route('permissionnaire.pdf', { id: item.id})" target="__blank" title="Imprimer la demande">
                <v-icon size="small" class="me-2" icon="mdi-printer" color="info" small>mdi-printer</v-icon>
            </a>
        </template>
         <template v-slot:item.datedebut="{ item }">
            {{ formatDate(item.date_debut) }}
        </template>
        <template v-slot:item.perm="{ item }">
            {{ item.eleve.matricule }} {{ item.eleve.nom }} {{ item.eleve.prenom }}
        </template>
    </v-data-table>
    <v-dialog v-model="dialog" max-width="1000px" scrollable>
        <v-card>
            <v-toolbar dense dark color="primary" class="text-h6">Nouvelle Permission</v-toolbar>
            <div>
                <v-card-text class="pt-4">
                    <v-row>
                        <v-col cols="6">
                            <TextField label="Date début" type="date" rules="required" name="Date début" v-model="form.date_debut" required outlined dense color="secondary" autocomplete="false"></TextField>
                        </v-col>
                        <v-col cols="6">
                            <TextField label="Nombre de jour" type="number" :disabled="!form.date_debut" @input="Incremented(form.nombre_jour)" rules="required" name="Nombre de jour" v-model="form.nombre_jour" required outlined dense color="secondary" autocomplete="false"></TextField>
                        </v-col>

                    </v-row>
                    <v-row>
                        <v-col cols="6">
                            <TextField label="Date fin" rules="required" type="date" name="Date fin" v-model="form.date_fin" disabled required outlined dense color="secondary" autocomplete="false"></TextField>
                        </v-col>
                        <v-col md="6">
                            <selectField label="Elèves" v-model="form.eleve" outlined name="Elèves" color="secondary" :items="eleves" :item-text="item => `${item.matricule} ${item.nom} ${item.prenom}`" item-value="id" autocomplete="false" chips></selectField>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col md="6">
                            <v-menu ref="menu1" v-model="menu1" :close-on-content-click="false" :nudge-right="40" :return-value.sync="form.heure_arrive" transition="scale-transition" offset-y max-width="290px" min-width="290px">
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field v-model="form.heure_arrive" label="Heure d'arrivée" prepend-icon="mdi-clock-time-four-outline" readonly v-bind="attrs" v-on="on"></v-text-field>
                                </template>
                                <v-time-picker format="24hr" v-if="menu1" v-model="form.heure_arrive" full-width @click:minute="$refs.menu1.save(form.heure_arrive)"></v-time-picker>
                            </v-menu>
                        </v-col>
                        <v-col cols="6">
                            <TextField label="Lieu" rules="required" name="Lieu" v-model="form.lieu" required outlined dense color="secondary" autocomplete="false"></TextField>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-textarea counter label="Motif" required v-model="form.motif"></v-textarea>

                        </v-col>
                    </v-row>
                </v-card-text>
            </div>
            <v-card-actions class="mt-2">
                <v-spacer></v-spacer>
                <v-btn dark small type="button" color="error" @click="close()">
                    <v-icon left>mdi-cancel</v-icon> Annuler
                </v-btn>
                <v-btn dark small color="green" @click="submit()">
                    <v-icon left>mdi-check-circle</v-icon> Enregistrer
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</admin-layout>
</template>

<script>
import AdminLayout from "../../layouts/AdminLayout.vue"
export default {
    components: {
        AdminLayout,
    },
    props: ["permissionnaires", "eleves"],
    data() {
        return {
            tab: null,
            dialog: false,
            dialogDetail: false,
            selection: 1,
            menu1: false,
            e1: 1,
            steps: 2,
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
                    text: 'Permissionnaire',
                    align: 'start',
                    sortable: false,
                    value: 'perm',
                },
                {
                    text: 'Date debut',
                    align: 'start',
                    sortable: false,
                    value: 'datedebut',
                },
                {
                    text: 'Date fin',
                    align: 'start',
                    sortable: false,
                    value: 'datefin',
                },
                {
                    text: 'Nombre de jour',
                    value: 'nombre_jour'
                },
                {
                    text: 'Heure d\'arrivée',
                    value: 'heure_arrive'
                },
                {
                    text: 'Lieu',
                    value: 'lieu'
                },
                
                {
                    text: 'Motif',
                    value: 'motif'
                },
                 {
                    text: 'Progression',
                    value: 'loading'
                },
                {
                    text: 'Actions ',
                    value: 'action'
                },
            ],
            form: this.$inertia.form({
                date_debut: '',
                date_fin: '',
                nombre_jour: 0,
                heure_arrive: '',
                lieu: '',
                motif: '',
                eleve: null
            }),
        }

    },
    methods: {
        close() {
            this.dialog = false
            this.form.reset()
        },
        submit() {
            this.$alert.confirm('Etes-vous sûr ?', "Vous allez enregistrer cette permission", () => {
                this.form.post(route("permissionnaire.store"), {
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
            })
             this.close()
        },
        create() {
            this.dialog = true
        },
        detail(item) {
            this.dialogDetail = true
        },
        Incremented(item) {
            let date = new Date(this.form.date_debut);
            date.setDate(date.getDate() + parseInt(item));
            let incrementedDate = date.toISOString().split('T')[0];
            this.form.date_fin = incrementedDate
        },
        formatDate(dateString) {
            const date = new Date(dateString);
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();

            return `${day}/${month}/${year}`;
        },
        progression(item){
            console.log(item);
            
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
