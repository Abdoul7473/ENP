<template>
<admin-layout>
    <Toolbar Title="Gestion des utilisateurs">
    </Toolbar>

    <v-card>
        <v-tabs v-model="tab" background-color="primary" centered dark icons-and-text>
            <v-tabs-slider></v-tabs-slider>

            <v-tab href="#tab-1">
                Utilisateurs
                <v-icon>mdi-account-group</v-icon>
            </v-tab>
        </v-tabs>

        <v-tabs-items v-model="tab">
            <v-tab-item value="tab-1">
                <CustomDataTable :headers="headers" :items="users">
                    <template v-slot:addBtn>
                        <v-btn @click="create" small color="primary">
                            <v-icon left>mdi-plus-circle</v-icon> Ajouter
                        </v-btn>
                    </template>
                    <template v-slot:item.statut="{item}">
                        <v-chip color="primary" v-if="item.statut == 1">
                            Actif
                        </v-chip>
                        <v-chip color="warning" v-else>
                            Non actif
                        </v-chip>
                    </template>
                    <template v-slot:item.action="{item}">
                        <BtnAction icon display-icon="mdi-close" v-if="item.statut == 1 && item.id !=1" v-permission:any="'manage_system'" title="Désactiver" @click="desactive(item)" color="error" small />
                        <BtnAction icon display-icon="mdi-check" v-permission:any="'manage_system'" v-if="item.statut == 0 && item.id !=1" title="Activer" @click="active(item)" color="primary" small />
                        <BtnAction icon display-icon="mdi-pencil" title="Modifier" v-permission:any="'manage_system'" @click="editItem(item)" color="warning" small />
                        <BtnAction icon display-icon="mdi-delete" title="Supprimer" v-if="item.statut == 1 && item.id !=1" v-permission:any="'manage_system'" @click="deleteItem(item)" color="error" small />
                        <BtnAction icon display-icon="mdi-rotate-right" title="Réinitialiser password" v-if="item.statut == 1 && item.id !=1" v-permission:any="'manage_system'" @click="reset(item)" color="primary" small />
                    </template>
                </CustomDataTable>
            </v-tab-item>
            <v-tab-item value="tab-2">
                <CustomDataTable :headers="header_postulant" :items="user_postulant">
                    <template v-slot:item.statut="{item}">
                        <v-chip color="primary" v-if="item.statut == 1">
                            Actif
                        </v-chip>
                        <v-chip color="warning" v-else>
                            Non actif
                        </v-chip>
                    </template>
                    <template v-slot:item.action="{item}">
                        <BtnAction icon display-icon="mdi-close" v-if="item.statut == 1" v-permission:any="'manage_system'" title="Désactiver" @click="desactive(item)" color="error" small />
                        <BtnAction icon display-icon="mdi-check" v-if="item.statut == 0" v-permission:any="'manage_system'" title="Activer" @click="active(item)" color="primary" small />
                        <BtnAction icon display-icon="mdi-delete" title="Supprimer" v-permission:any="'manage_system'" @click="deleteItem(item)" color="error" small />
                        <BtnAction icon display-icon="mdi-rotate-right" title="Réinitialiser password" v-permission:any="'manage_system'" @click="reset(item)" color="primary" small />
                        <BtnAction icon display-icon="mdi-file-eye" v-if="item.postulant.type_postulant_id == 2" title="Voir document" v-permission:any="'manage_system'" @click="document(item)" color="dark" small />
                        <v-switch v-model="item.terme == 1 ? true : false" v-permission:any="'manage_system'" :label="item.terme == 1 ? 'A terme' : 'Au comptant'" @click="confirmChange(item)"></v-switch>
                    </template>
                </CustomDataTable>
            </v-tab-item>
            <v-tab-item value="tab-3">
                <CustomDataTable :headers="header_demandes" :items="demandes">
                    <template v-slot:item.userVerif="{item}">
                        <div color="secondary" v-if="item.user_verif">
                            {{ item.user_verif.name }}
                        </div>
                        <div color="secondary" v-else>
                            Pas encore vérifié
                        </div>
                    </template>
                    <template v-slot:item.userAppro="{item}">
                        <div color="secondary" v-if="item.user_appro">
                            {{ item.user_appro.name }}
                        </div>
                        <div color="secondary" v-else>
                            Pas encore apprové
                        </div>
                    </template>
                    <template v-slot:item.userAutoriser="{item}">
                        <div color="secondary" v-if="item.user_autoriser">
                            {{ item.user_autoriser.name }}
                        </div>
                        <div color="secondary" v-else>
                            Pas encore autorisé
                        </div>
                    </template>
                    <template v-slot:item.immatriculation="{item}">
                        <div v-for="(tag, index) in item.aeronefs" :key="index" small color="secondary">
                            {{ tag.imatriculation }}
                        </div>
                    </template>
                    <template v-slot:item.call="{item}">
                        <div v-for="(tag, index) in item.aeronefs" :key="index" small color="secondary">
                            {{ tag.indicatif_appel }}
                        </div>
                    </template>

                </CustomDataTable>
            </v-tab-item>
        </v-tabs-items>
    </v-card>
    <v-dialog v-model="dialogPdf" max-width="800" persistent>
        <v-toolbar dense dark color="primary" class="text-h6">Détail
            <v-spacer></v-spacer>
            <v-icon title="Fermer" size="x-large" style="margin:10px" color="white" @click="dialogPdf = false">mdi-close-circle</v-icon>
        </v-toolbar>
        <v-card v-if="url">
            <v-card-text>
                <vue-pdf-app style="height: 100vh;" :pdf="url"></vue-pdf-app>
            </v-card-text>
        </v-card>
        <v-card v-else>
            <v-card-text><span style="color: red;"> Pas de document</span></v-card-text>
        </v-card>
    </v-dialog>
</admin-layout>
</template>

<script>
import AdminLayout from "../../layouts/AdminLayout.vue";
import VuePdfApp from "vue-pdf-app";
import "vue-pdf-app/dist/icons/main.css";
export default {
    components: {
        AdminLayout,
        VuePdfApp
    },
    props: ["users", "user_postulant", "demandes"],
    data() {
        return {
            dialogPdf: false,
            tab: null,
            switch1: true,
            url: null,
            form: this.$inertia.form({
                id: null,
                type: null
            }),
            headers: [{
                    text: "No",
                    value: "id",
                    sortable: false
                },
                {
                    text: "Nom et Prénom",
                    value: "name"
                },
                {
                    text: "Type",
                    value: "type_user.libelle"
                },
                {
                    text: "E-mail",
                    value: "email"
                },
                {
                    text: "Statut",
                    value: "statut"
                },
                {
                    text: "Actions",
                    value: "action",
                    sortable: false
                },
            ],
            header_postulant: [{
                    text: "No",
                    value: "id",
                    sortable: false
                },
                {
                    text: "Nom/Raison Sociale",
                    value: "postulant.nom_raison_sociale"
                },
                {
                    text: "E-mail",
                    value: "email"
                },
                {
                    text: "Statut",
                    value: "statut"
                },
                {
                    text: "Actions",
                    value: "action",
                    sortable: false
                },
            ],
            header_demandes: [{
                    text: "Immatriculation",
                    value: "immatriculation",
                    sortable: false
                },
                {
                    text: "Indicatif d'appel",
                    value: "call"
                },
                {
                    text: "Date demande",
                    value: "created_at"
                },
                {
                    text: "Type demande",
                    value: "type_demande.libelle"
                },
                {
                    text: "Deposant",
                    value: "user.postulant.nom_raison_sociale"
                },
                {
                    text: "Vérifiant",
                    value: "userVerif"
                },
                {
                    text: "approvant",
                    value: "userAppro"
                },
                {
                    text: "Autorisant",
                    value: "userAutoriser"
                },
            ],

        }
    },
    methods: {
        document(item) {
            // console.log(item);
            this.url = '../documents/operateurs/' + item.postulant.fichier
            this.dialogPdf = true
        },
        active(item) {
            this.form.id = item.id
            this.$alert.confirm('Etes-vous sûr ?', "Vous allez activer ce compte", () => {
                this.form.post(route("user.active"), {
                    onFinish: () => {
                        if (this.$page.props.flash.success) {
                            this.$alert.success(this.$page.props.flash.success)
                        }
                        if (this.$page.props.flash.error) {
                            this.$alert.error(this.$page.props.flash.error)
                        }
                    },
                    onError: this.$alert.messages
                });
            })
        },
        confirmChange(item) {
            console.log('item', item);
            this.form.id = item.id
            this.form.type = item.terme == true ? 0 : 1
            console.log('form', this.form.type);
            this.$alert.confirm('Etes-vous sûr ?', "Vous allez modifier ce compte", () => {
                this.form.post(route("terme"), {
                    onFinish: () => {
                        if (this.$page.props.flash.success) {
                            this.$alert.success(this.$page.props.flash.success)
                        }
                        if (this.$page.props.flash.error) {
                            this.$alert.error(this.$page.props.flash.error)
                        }

                    },
                    onError: this.$alert.messages
                });
            })
        },
        desactive(item) {
            this.form.id = item.id
            this.$alert.confirm('Etes-vous sûr ?', "Vous allez desactiver ce compte", () => {
                this.form.post(route("user.desactive"), {
                    onFinish: () => {
                        if (this.$page.props.flash.success) {
                            this.$alert.success(this.$page.props.flash.success)
                        }
                        if (this.$page.props.flash.error) {
                            this.$alert.error(this.$page.props.flash.error)
                        }

                    },
                    onError: this.$alert.messages
                });
            })
        },
        create() {
            this.$inertia.get(route("user.create"))
        },
        editItem(item) {
            this.form.id = item.id
            this.$inertia.get(route('user.edit', item.id))
        },
        deleteItem(item) {
            this.$alert.confirm('Etes-vous sûr ?', "Vous allez supprimer ce compte", () => {
                this.form.delete(route("user.destroy", item.id), {
                    onFinish: () => {
                        if (this.$page.props.flash.success) {
                            this.$alert.success(this.$page.props.flash.success)
                        }
                        if (this.$page.props.flash.error) {
                            this.$alert.error(this.$page.props.flash.error)
                        }

                    },
                    onError: this.$alert.messages
                });
            })
        },
        reset(item) {
            this.form.id = item.id
            this.$alert.confirm('Etes-vous sûr ?', "Vous allez réinitialiser le mot de passe de ce compte", () => {
                this.form.post(route("user.reset_password"), {
                    onFinish: () => {
                        if (this.$page.props.flash.success) {
                            this.$alert.success(this.$page.props.flash.success)
                        }
                        if (this.$page.props.flash.error) {
                            this.$alert.error(this.$page.props.flash.error)
                        }

                    },
                });
            })
        }
    },
    created() {
        if (this.$page.props.flash.error) {
            this.$toast.success(this.$page.props.flash.error)

        }
    }
}
</script>
