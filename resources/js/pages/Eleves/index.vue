<template>
<admin-layout>
    <Toolbar Title="Elèves" :breadcrumbs="breadcrumbs">
        <v-progress-linear v-model="knowledge" height="25">
            <strong>{{ Math.ceil(knowledge) }}%</strong>
        </v-progress-linear>
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
    <v-menu v-model="menu" :close-on-content-click="false" :nudge-width="200" offset-x>
        <template v-slot:activator="{ on, attrs }">
            <v-btn color="indigo" dark v-bind="attrs" v-on="on">
                Menu as Popover
            </v-btn>
        </template>

        <v-card>
            <v-list>
                <v-list-item>
                    <v-list-item-avatar>
                        <img src="https://cdn.vuetifyjs.com/images/john.jpg" alt="John">
                    </v-list-item-avatar>

                    <v-list-item-content>
                        <v-list-item-title>John Leider</v-list-item-title>
                        <v-list-item-subtitle>Founder of Vuetify</v-list-item-subtitle>
                    </v-list-item-content>

                    <v-list-item-action>
                        <v-btn :class="fav ? 'red--text' : ''" icon @click="fav = !fav">
                            <v-icon>mdi-heart</v-icon>
                        </v-btn>
                    </v-list-item-action>
                </v-list-item>
            </v-list>

            <v-divider></v-divider>

            <v-list>
                <v-list-item>
                    <v-list-item-action>
                        <v-switch v-model="message" color="purple"></v-switch>
                    </v-list-item-action>
                    <v-list-item-title>Enable messages</v-list-item-title>
                </v-list-item>

                <v-list-item>
                    <v-list-item-action>
                        <v-switch v-model="hints" color="purple"></v-switch>
                    </v-list-item-action>
                    <v-list-item-title>Enable hints</v-list-item-title>
                </v-list-item>
            </v-list>

            <v-card-actions>
                <v-spacer></v-spacer>

                <v-btn text @click="menu = false">
                    Cancel
                </v-btn>
                <v-btn color="primary" text @click="menu = false">
                    Save
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-menu>

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
        close() {
            this.dialog = false
            this.dialogDetail = false
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
        }
    }
}
</script>
