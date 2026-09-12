<template>
<admin-layout>
    <Toolbar Title="Elèves" :breadcrumbs="breadcrumbs">

    </Toolbar>

    <CustomDataTable :headers="headers" :items="eleves">
        <template v-slot:addBtn>
            <v-btn @click="Import()" class="ma-2" outlined type="button" small color="primary">
                <v-icon left>mdi-xlx</v-icon> Importer par excel
            </v-btn>
            <v-btn class="ma-2" outlined type="button" small color="primary" href="/eleves.xlsx" download>
                Télécharger le Modèle
            </v-btn>
            <form action="/carte/pdf" method="GET" target="_blank" enctype="multipart/form-data">
                <input type="hidden" name="compagnie_id" :value="id" />
                <input type="hidden" name="_token" :value="csrf" />
                <input type="hidden" name="_method" value="GET">
                <v-btn type="submit" class="ma-2" outlined small color="primary" download>
                    <v-icon left>mdi-download</v-icon> éditer les cartes
                </v-btn>
            </form>
            <!-- <v-btn class="ma-2" outlined type="button" small color="primary" @click="InputPhoto()" download>
                téléverser les photos
            </v-btn> -->

        </template>
        <template v-slot:item.action="{ item }">
            <BtnAction icon display-icon="mdi-pencil" title="Les élèves" @click="Edit(item)" color="green" small />
            <BtnAction icon display-icon="mdi-eye" title="Détail de l'encadreur" @click="detail(item)" color="primary" small />
            <BtnAction icon display-icon="mdi-call-split" title="Autres actions" @click="OthersActions(item)" color="blue" small />
        </template>
    </CustomDataTable>
    <v-dialog v-model="dialog" max-width="600px" persistent>
        <v-toolbar dense dark color="primary" class="text-h6"> Importation de fichier excel</v-toolbar>
        <v-card>
            <v-card-text>
                <br>
                <v-file-input clearable v-model="form.fichier" @change="form.fichier = $event" required label="Charger le fichier des élèves" variant="solo-inverted"></v-file-input>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn style="color: white;" color="red" @click="close()">
                    Fermer
                </v-btn>
                <v-btn color="primary" @click="submit()">Enregistrer</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

    <v-dialog v-model="dialogFiles" max-width="600px" persistent>
        <v-toolbar dense dark color="primary" class="text-h6"> Importation les photos</v-toolbar>
        <v-card>
            <v-card-text>
                <br>
                <v-file-input clearable v-model="form.photos" multiple label="Charger les photos" variant="solo-inverted"></v-file-input>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn style="color: white;" color="red" @click="close()">
                    Fermer
                </v-btn>
                <v-btn color="primary" @click="Enregistrer()">Enregistrer</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
    <v-dialog v-model="dialogDetail" max-width="800" persistent>
        <v-card>
            <v-toolbar dense dark color="primary" class="text-h6"> Détail</v-toolbar>
            <v-card-text>
                <br>
                <div class="invitation-container">
                    <div>
                        <div class="content">
                            <v-row>
                                <v-col cols="12" sm="4">
                                    <TextField label="Matricule" name="matricule" :value="items?.matricule" disabled outlined dense color="secondary" autocomplete="false"></TextField>
                                </v-col>
                                <v-col cols="12" sm="4">
                                    <TextField label="Nom" name="Nom" :value="items?.nom" disabled outlined dense color="secondary" autocomplete="false"></TextField>
                                </v-col>
                                <v-col cols="12" sm="4">
                                    <TextField label="Prénom" name="Prénom" :value="items?.prenom" disabled outlined dense color="secondary" autocomplete="false"></TextField>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="12" sm="4">
                                    <TextField label="Sexe" name="sexe" :value="items?.sexe" disabled outlined dense color="secondary" autocomplete="false"></TextField>
                                </v-col>
                                <v-col cols="12" sm="4">
                                    <TextField label="Téléphone" name="tel" type="number" :value="items?.tel" disabled outlined dense color="secondary" autocomplete="false"></TextField>
                                </v-col>
                                <v-col cols="12" sm="4">
                                    <TextField label="E-mail" disabled type="email" name="E-mail" :value="items?.email" outlined dense color="secondary" autocomplete="false"></TextField>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="12" sm="4">
                                    <TextField label="Date de naissance" name="date" :value="items?.date_naiss" disabled outlined dense color="secondary" autocomplete="false"></TextField>
                                </v-col>
                                <v-col cols="12" sm="4">
                                    <TextField label="Lieu de naissance" name="lieu" :value="items?.lieu_naiss" disabled outlined dense color="secondary" autocomplete="false"></TextField>
                                </v-col>
                                <v-col cols="12" sm="4">
                                    <TextField label="Groupe Sanguin" disabled name="groupt" :value="items?.groupe_sanguin" outlined dense color="secondary" autocomplete="false"></TextField>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="4">
                                    <v-progress-circular model-value="100" color="primary" :size="100" :width="2" class="">
                                        <v-avatar size="150">
                                            <v-img :src="'/eleves/' + items?.photo" alt="John"></v-img>
                                        </v-avatar>
                                    </v-progress-circular>
                                </v-col>
                            </v-row>
                        </div>
                    </div>
                </div>

            </v-card-text>
            <v-card-actions>
                <v-spacer />
                <v-btn @click="close()">Fermer</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
    <v-dialog v-model="dialogOtherActions" max-width="800" persistent>
        <v-card>
            <v-toolbar dense dark color="primary" class="text-h6"> Autres Actions</v-toolbar>
            <v-card-text>
                <br>
                <div class="invitation-container">
                    <v-container fluid>
                        <v-row>
                            <v-col cols="12" sm="4" md="4">
                                <v-switch v-model="other_actions.deceder" label="Déceder" color="red" hide-details></v-switch>
                                <v-switch v-model="other_actions.inapter" label="Inapte" color="red darken-3" hide-details></v-switch>
                            </v-col>
                            <v-col cols="12" sm="4" md="4">
                                <v-switch v-model="other_actions.demissionner" label="Démissioner" color="indigo" hide-details></v-switch>
                                <v-switch v-model="other_actions.suspendre" label="Suspendre" color="indigo darken-3" hide-details></v-switch>
                            </v-col>
                            <v-col cols="12" sm="4" md="4">
                                <v-switch v-model="other_actions.evader" label="Evader" color="primary" hide-details></v-switch>
                                <v-switch v-model="other_actions.revoquer" label="Révoquer" color="orange darken-3" hide-details></v-switch>
                            </v-col>
                        </v-row>

                        <v-row class="mt-12">
                            <v-col cols="12" sm="4" md="4">

                            </v-col>
                        </v-row>
                    </v-container>
                </div>
            </v-card-text>
            <v-card-actions>
                <v-spacer />
                <v-btn @click="close()" color="red">Annuler</v-btn>
                <v-btn @click="Persister()" color="primary">Enregistrer</v-btn>
            </v-card-actions>
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
    props: ["eleves", "id"],
    data() {
        return {
            items: [],
            ex11: null,
            dialogFiles: false,
            dialogDetail: false,
            csrf: null,
            dialog: false,
            loading: false,
            dialogDetail: false,
            selection: 1,
            dialogExecel: false,
            dialogOtherActions: false,
            e1: 1,
            steps: 2,
            knowledge: 50,
            fav: true,
            menu: false,
            message: false,
            hints: true,
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
                    text: 'Matricule',
                    align: 'start',
                    sortable: false,
                    value: 'matricule',
                },
                {
                    text: 'Prénom',
                    value: 'prenom'
                },
                {
                    text: 'Nom',
                    value: 'nom'
                },

                {
                    text: 'Date de Naissance',
                    value: 'date_naiss'
                },
                {
                    text: 'Lieu de naissance',
                    value: 'lieu_naiss'
                },
                {
                    text: 'Sexe',
                    value: 'sexe'
                },
                {
                    text: 'Actions ',
                    value: 'action'
                },
            ],
            form: this.$inertia.form({
                fichier: null,
                compagnie_id: this.id,
                photos: []
            }),
            other_actions: this.$inertia.form({
                eleve_id: null,
                deceder: false,
                evader: false,
                revoquer: false,
                demissionner: false,
                suspendre: false,
                inapter: false
            })
        }

    },
    mounted() {
        this.csrf = this.$page.props.csrf_token
    },
    methods: {
        InputPhoto() {
            this.dialogFiles = true
        },
        Enregistrer() {
            this.form.compagnie_id = this.id
            this.form.post(route("eleve.input_file"), {
                forceFormData: true,
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
        },
        Persister() {
            this.$alert.confirm('Etes-vous sûr ?', "De vouloir apporter ces modification?", () => {

                this.other_actions.post(route("eleve.updateStatus"), {
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
            this.dialogDetail = false
            this.dialogOtherActions = false
            this.form.reset()
        },
        reserve() {
            this.loading = true

            setTimeout(() => (this.loading = false), 2000)
        },
        Import() {
            this.dialog = true
        },
        submit() {
            this.form.post(route("eleve.import"), {
                forceFormData: true,
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
        },
        Detail(item) {
            this.$inertia.get(route('carte.detail', item.id))
        },
        Edit(item) {
            this.$inertia.get(route('eleve.edit', item.id))
        },
        detail(item) {
            this.dialogDetail = true
            this.items = item
        },
        OthersActions(item) {
            this.dialogOtherActions = true
            this.other_actions.eleve_id = item.id
            this.other_actions.deceder = item.deces
            this.other_actions.inapter = item.inapte
            this.other_actions.suspendre = item.suspendu
            this.other_actions.demissionner = item.demission
            this.other_actions.evader = item.evade
            this.other_actions.revoquer = item.revoque
        }
    }
}
</script>
