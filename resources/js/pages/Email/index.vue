<template>
<admin-layout>
    <Toolbar Title="Gestion des E-mails">
    </Toolbar>
    <v-card>
        <v-tabs v-model="tab" background-color="primary" centered dark icons-and-text>
            <v-tabs-slider></v-tabs-slider>
            <v-tab v-for="tab in tabs" :key="tab.href" :href="tab.href">
                <v-tooltip color="orange" top>
                    <template v-slot:activator="{ on, attrs }">
                    <div v-bind="attrs" v-on="on">
                        <v-icon left>{{ tab.icon }}</v-icon>
                        {{ tab.label }}
                    </div>
                    </template>
                    <div style="width: 350px">{{ tab.tooltip }}</div>
                </v-tooltip>
            </v-tab>
        </v-tabs>
        <v-tabs-items v-model="tab">
            <v-tab-item value="tab-1">
                <CustomDataTable :headers="headers" :items="Email">
                    <template v-slot:addBtn>
                        <v-btn @click="create" small v-permission="'manage_system'" color="primary">
                            <v-icon left>mdi-plus-circle</v-icon> Ajouter
                        </v-btn>
                    </template>
                    <template v-slot:item.action="{item}">
                        <BtnAction icon display-icon="mdi-pencil" v-permission="'manage_system'" title="Modifier" @click="editItem(item)" color="warning" small />
                        <BtnAction icon display-icon="mdi-delete" v-permission="'manage_system'" title="Supprimer" @click="deleteItem(item)" color="error" small />
                    </template>
                </CustomDataTable>
            </v-tab-item>
            <v-tab-item value="tab-2">
                <CustomDataTable :headers="headers_config" :items="config">
                    <template v-slot:addBtn>
                        <v-btn @click="create_config" small v-permission="'manage_system'" color="primary" v-if="config.total==0">
                            <v-icon left>mdi-plus-circle</v-icon> Ajouter
                        </v-btn>
                    </template>
                    <template v-slot:item.action="{item}">
                        <BtnAction icon display-icon="mdi-pencil" v-permission="'manage_system'" title="Modifier" @click="editItem(item)" color="warning" small />
                    </template>
                </CustomDataTable>
            </v-tab-item>
            <v-tab-item value="tab-3">
                <br>
                <div class="row">
                    <v-col md="5"></v-col>
                    <v-col>
                        <v-btn @click="getRelance" v-permission="'manage_system'" color="primary"><v-icon left>mdi-send</v-icon> Relancer</v-btn>
                    </v-col>
                </div>
                <br>
            </v-tab-item>
        </v-tabs-items>
    </v-card>
    <v-card>

    </v-card>
    <v-dialog v-model="dialog" persistent max-width="600">
        <v-card>
            <v-toolbar dense dark color="primary" class="text-h6">Nouvel E-mail</v-toolbar>
            <v-card-text class="pt-12">
                <v-row :key="donnee.id" v-for="(donnee, i) in form.donnees">
                    <v-col md="11">
                        <TextField v-model="donnee.name" outlined label="E-mail" placeholder="E-mail" dense @input="verify(donnee)"></TextField>
                    </v-col>
                    <v-col md="1">
                        <v-btn :disabled="!(form.donnees.length > 1)" icon @click="removeRow(donnee)" ffab small color="error">
                            <v-icon>mdi-close-circle</v-icon>
                        </v-btn>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col offset-md="11" md="1">
                        <v-btn icon @click="addRow()" fab small color="secondary">
                            <v-icon>mdi-plus-circle</v-icon>
                        </v-btn>
                    </v-col>
                </v-row>
                <v-col class="pt-5">
                    <v-card-actions>
                        <v-spacer />
                        <v-btn @click="close()" color="red">Annuler</v-btn>
                        <v-btn @click="submit()" color="primary">Enregistrer</v-btn>
                    </v-card-actions>
                </v-col>
            </v-card-text>
        </v-card>
    </v-dialog>
    <v-dialog v-model="dialog_config" persistent max-width="800">
        <v-card>
            <v-toolbar dense dark color="primary" class="text-h6">Nouvel E-mail</v-toolbar>
            <v-card-text class="pt-12">
                <v-row>
                    <v-col md="6">
                        <TextField v-model="form.name" required outlined label="E-mail" placeholder="E-mail" dense></TextField>
                        <TextField v-model="form.password" required outlined label="PASSWORD" placeholder="PASSWORD" dense></TextField>
                        <TextField v-model="form.port" required outlined label="PORT" placeholder="PORT" dense></TextField>
                        <TextField v-model="form.mail_from" required outlined label="Mail expéditeur" placeholder="Mail expéditeur" dense></TextField>
                    </v-col>
                    <v-col md="6">
                        <TextField v-model="form.mailer"  required outlined label="MAILER" placeholder="MAILER" dense></TextField>
                        <TextField v-model="form.host" required outlined label="HOST"  placeholder="HOST" dense></TextField>
                        <TextField v-model="form.encryption" required outlined label="ENCRYPTION" placeholder="ENCRYPTION" dense></TextField>
                        <TextField v-model="form.name_from" required outlined label="Nom expéditeur" placeholder="Nom expéditeur" dense></TextField>
                    </v-col>
                </v-row>
                <v-col class="pt-5">
                    <v-card-actions>
                        <v-spacer />
                        <v-btn @click="close()" color="red">Annuler</v-btn>
                        <v-btn @click="submit()" color="primary">Enregistrer</v-btn>
                    </v-card-actions>
                </v-col>
            </v-card-text>
        </v-card>
    </v-dialog>
    <v-dialog v-model="dialogEdit" persistent max-width="600">
        <v-card>
            <v-toolbar dense dark color="primary" class="text-h6">Modifier E-mail</v-toolbar>
            <v-card-text class="pt-12">

                <v-col md="12" v-if="statut !== 1">
                    <TextField v-model="form.name" required outlined label="E-mail" placeholder="E-mail" dense></TextField>
                </v-col>
                <v-row v-if="statut == 1">
                <v-col md="6">
                    <TextField v-model="form.name" required outlined label="E-mail" placeholder="E-mail" dense></TextField>
                    <TextField v-model="form.password" required  outlined label="PASSWORD" placeholder="PASSWORD" dense></TextField>
                    <TextField v-model="form.port" required  outlined label="PORT" placeholder="PORT" dense></TextField>
                    <TextField v-model="form.mail_from" required outlined label="Mail expéditeur" placeholder="Mail expéditeur" dense></TextField>
                </v-col>
                <v-col md="6">
                    <TextField v-model="form.mailer" required  outlined label="MAILER" placeholder="MAILER" dense></TextField>
                    <TextField v-model="form.host" required  outlined label="HOST" placeholder="HOST" dense></TextField>
                    <TextField v-model="form.encryption" required  outlined label="ENCRYPTION" placeholder="ENCRYPTION" dense></TextField>
                    <TextField v-model="form.name_from" required outlined label="Nom expéditeur" placeholder="Nom expéditeur" dense></TextField>
                </v-col>
                </v-row>
                <v-col class="pt-5">
                    <v-card-actions>
                        <v-spacer />
                        <v-btn @click="closeEdit()" color="red">Annuler</v-btn>
                        <v-btn @click="submit()" color="primary">Enregistrer</v-btn>
                    </v-card-actions>
                </v-col>
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
    props: ["Email", "config"],
    data() {
        return {
            statut: null,
            tab: null,
            dialog: false,
            dialog_config: false,
            dialogEdit: false,
            tab: null,
            tabs: [
                {
                href: "#tab-1",
                label: "E-mail",
                icon: "mdi-email",
                tooltip: "Permet de configurer les mails qui seront en copies en générant une autorisation"
                },
                {
                href: "#tab-2",
                label: "Config-Email",
                icon: "mdi-cog",
                tooltip: "Permet de parametrer le mail expediteur,le nom du logiciel et les configurations du fichier .env"
                },
                {
                href: "#tab-3",
                label: "Relancer-Email",
                icon: "mdi-mail",
                tooltip: "Permet de relancer les mails des utilisateurs qui ont des instances"
                }
            ],
            form: this.$inertia.form({
                id: null,
                name: null,
                donnees: [],
                port: null,
                password: null,
                mailer: null,
                encryption: null,
                host: null,
                name_from: null,
                mail_from: null
            }),
            headers: [{
                    text: "No",
                    value: "id",
                    sortable: false
                },
                {
                    text: "E-mail",
                    value: "name"
                },
                {
                    text: "Actions",
                    value: "action",
                    sortable: false
                },
            ],
            headers_config: [{
                    text: "No",
                    value: "id",
                    sortable: false
                },
                {
                    text: "E-mail",
                    value: "name"
                },
                {
                    text: "Password",
                    value: "password"
                },
                {
                    text: "Mailer",
                    value: "mailer"
                },
                {
                    text: "Port",
                    value: "port"
                },
                {
                    text: "Host",
                    value: "host"
                },
                {
                    text: "Encryption",
                    value: "encryption"
                },
                {
                    text: "Mail exp",
                    value: "mail_from"
                },
                {
                    text: "Nom exp",
                    value: "name_from"
                },
                {
                    text: "Actions",
                    value: "action",
                    sortable: false
                },
            ],
        }
    },
    methods: {
        create() {
            this.addRow();
            this.dialog = true
        },
        create_config() {
            this.dialog_config = true
        },
        getRelance(){
            this.$alert.confirm('Etes-vous sûr ?', "Vous allez relancer les mails", () => {
                this.isLoading = true
                axios.get(route('relancer_email'))
                .then(res => {
                    console.log('donnees',res.data.donnees)
                    this.isLoading = false
                    if(res.data.code == 1){
                        this.$alert.success('La relance a été effectuée avec succès')
                    }else{
                        this.$toast.info('Aucune demande en instance!')
                    }
                })
            })
        },
        submit() {
            if (this.form.id) {
                this.$alert.confirm('Etes-vous sûr ?', "Vous allez modifié ces E-mails", () => {
                    this.form.put(route("email.update", this.form.id), {
                        onSuccess: () => {
                            if (this.$page.props.flash.success) {
                                this.$alert.success(this.$page.props.flash.success)
                            }
                            if (this.$page.props.flash.error) {
                                this.$toast.error(this.$page.props.flash.error)
                            }
                            this.closeEdit()
                        },
                        onError: this.$alert.messages
                    })
                })
            } else {
                this.$alert.confirm('Etes-vous sûr ?', "Vous allez créer ces E-mails", () => {
                    this.form.post(route("email.store"), {
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
            }
        },
        close() {
            this.dialog = false,
                this.dialog_config = false,
                this.form.reset()
        },
        closeEdit() {
            this.dialogEdit = false,
                this.form.reset()
        },
        editItem(item) {
            // console.log(item.permissions)
            this.form.id = item.id
            this.form.name = item.name,
                this.form.port = item.port,
                this.form.password = item.password,
                this.form.host = item.host,
                this.form.mailer = item.mailer,
                this.form.encryption = item.encryption,
                this.form.mail_from = item.mail_from,
                this.form.name_from = item.name_from,
                this.statut = item.statut
            this.dialogEdit = true

        },
        deleteItem(item) {
            this.$alert.confirm('Etes-vous sûr ?', "De vouloir supprimer cet E-mail", () => {
                this.form.delete(route("email.destroy", item.id), {
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
        },
        addRow() {
            this.form.donnees.push({
                name: null,
            });
            // console.log(this.form.donnees)
        },

        removeRow(p) {
            this.form.donnees = this.form.donnees.filter((product) => product !== p)
        },

        async verify(p) {
            const array = this.form.donnees.filter(el => el.name !== null && el.name == p.name)
            if (array.length > 1) {
                this.removeRow(p)

            } else {
                return true
            }
        },
    },
}
</script>
