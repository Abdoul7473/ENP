<template>
<admin-layout>
    <Toolbar Title="Gestion des utilisateurs">
    </Toolbar>

    <v-card>
        <v-tabs v-model="tab" background-color="primary" centered dark icons-and-text>
            <v-tabs-slider></v-tabs-slider>

            <v-tab href="#tab-1">
                Roles
                <v-icon>mdi-lock-alert-outline</v-icon>
            </v-tab>

            <v-tab href="#tab-2">
                Permissions
                <v-icon>mdi-lock-open-variant</v-icon>
            </v-tab>
        </v-tabs>

        <v-tabs-items v-model="tab">
            <v-tab-item value="tab-1">
                <CustomDataTable :headers="headers" :items="roles">
                    <template v-slot:addBtn>
                        <v-btn @click="create" v-permission="'manage_system'" small color="primary">
                            <v-icon left>mdi-plus-circle</v-icon> Ajouter
                        </v-btn>
                    </template>
                    <template v-slot:item.permission="{ item }">
                        <v-chip-group column selected-class="text-purple">
                            <v-chip outlined  color="primary" :key="i"  v-for="(p, i) in item.permissions">{{ p.description }}
                                <v-icon end size="large" v-permission="'manage_system'" color="red" class="me-3" title="Supprimer" @click="deletePermission(p,item)">mdi-close-circle
                                </v-icon>
                            </v-chip>
                        </v-chip-group>

                    </template>
                    <template v-slot:item.action="{item}"> 
                        <BtnAction icon display-icon="mdi-plus-circle" v-permission="'manage_system'"   title="Ajouter permissions" @click="ajout(item)" color="primary" small />
                        <BtnAction icon display-icon="mdi-pencil" title="Modifier" v-permission="'manage_system'" @click="editItem(item)" color="warning" small />
                        <BtnAction icon display-icon="mdi-delete" title="Supprimer" v-permission="'manage_system'" @click="deleteItem(item)" color="error" small />
                    </template>
                </CustomDataTable>
            </v-tab-item>
            <v-tab-item value="tab-2">
                <CustomDataTable :headers="header_permissions" :items="permissions">
                </CustomDataTable>
            </v-tab-item>
        </v-tabs-items>
    </v-card>
    <v-dialog v-model="dialog" persistent max-width="600">
        <v-card>
            <v-toolbar dense dark color="primary" class="text-h6">{{ title }}</v-toolbar>
            <v-card-text class="pt-12">
                <v-row>
                    <v-col cols="12">
                        <TextField required label="Nom" hide-details dense v-model="form.name">
                        </TextField>
                    </v-col>
                    <v-col cols="12">
                        <selectField  label="Permissions" required v-model="form.permissions" outlined name="Permissions" color="secondary" :items="AllPermissions" item-text="description" item-value="id" autocomplete="false" multiple chips></selectField>
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
    <v-dialog v-model="dialog_permission" persistent max-width="600">
        <v-card>
            <v-toolbar dense dark color="primary" class="text-h6">Attacher autres permissions</v-toolbar>
            <v-card-text class="pt-12">
                <v-row>
                    <v-col cols="12">
                        <selectField label="Permissions" required v-model="form.permissions" outlined name="Permissions" color="secondary" :items="filter_permissions" item-text="description" item-value="id" autocomplete="false" multiple chips></selectField>
                    </v-col>
                </v-row>
                <v-col class="pt-5">
                    <v-card-actions>
                        <v-spacer />
                        <v-btn @click="dialog_permission = false" color="red">Annuler</v-btn>
                        <v-btn @click="create_permission()" color="primary">Enregistrer</v-btn>
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
    props: ["roles", "permissions", "AllPermissions"],
    data() {
        return {
            // userPermissions : [],
            dialog_permission: false,
            filter_permissions: [],
            id_permissions: [],
            tab: null,
            dialog: false,
            title: "Nouvel rôle",
            form: this.$inertia.form({
                id: null,
                name: null,
                permissions: []
            }),
            form_permission: this.$inertia.form({
                id: null,
                permission: null
            }),
            headers: [{
                    text: "No",
                    value: "id",
                    sortable: false
                },
                {
                    text: "Nom ",
                    value: "name"
                },
                {
                    text: "Permissions",
                    value: "permission"
                },
                {
                    text: "Actions",
                    value: "action",
                    sortable: false
                },
            ],
            header_permissions: [{
                    text: "No",
                    value: "id",
                    sortable: false
                },
                {
                    text: "Nom",
                    value: "name"
                },
                {
                    text: "Descriptions",
                    value: "description"
                },
            ],

        }
    },
    methods: {
        create() {
            // console.log(this.$page.props.user_permissions)
            this.dialog = true
        },
        submit() {
            if (this.form.id) {
                this.$alert.confirm('Etes-vous sûr ?', "Vous allez modifié ce rôle", () => {
                    this.form.put(route("roles.update", this.form.id), {
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
            } else {
                this.$alert.confirm('Etes-vous sûr ?', "Vous allez créer ce rôle", () => {
                    this.form.post(route("roles.store"), {
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
                this.form.reset()
        },
        editItem(item) {
            // console.log(item.permissions)
            this.form.id = item.id
            this.form.name = item.name,
                this.form.permissions = item.permissions.map((el) => el.id)
            this.dialog = true
            this.title = "Modifier rôle"

        },
        deleteItem(item){
            this.$alert.confirm('Etes-vous sûr ?', "Vous allez supprimer ce rôle", () => {
                this.form.delete(route('roles.destroy',item.id), {
                    onSuccess: () => {
                        if (this.$page.props.flash.success) {
                            this.$alert.success(this.$page.props.flash.success)
                        }
                        if (this.$page.props.flash.error) {
                            this.$toast.error(this.$page.props.flash.error)
                        }
                        this.dialog_permission = false
                        this.form.reset()
                    },
                    onError: this.$alert.messages
                })
            })
        },
        ajout(item) {
            this.form.id = item.id
            this.dialog_permission = true;
            this.id_permissions = item.permissions.map((el) => el.id);
            this.filter_permissions = this.AllPermissions.filter(el => !this.id_permissions.includes(el.id));
        },
        create_permission() {
            this.$alert.confirm('Etes-vous sûr ?', "Vous allez attacher ces permissions à ce rôle", () => {
                this.form.post(route("roles.create_permission"), {
                    onSuccess: () => {
                        if (this.$page.props.flash.success) {
                            this.$alert.success(this.$page.props.flash.success)
                        }
                        if (this.$page.props.flash.error) {
                            this.$toast.error(this.$page.props.flash.error)
                        }
                        this.dialog_permission = false
                        this.form.reset()
                    },
                    onError: this.$alert.messages
                })
            })
        },
        deletePermission(p, item) {
            // console.log(p)
            this.form_permission.id = item.id,
                this.form_permission.permission = p.id
            this.$alert.confirm('Etes-vous sûr ?', "De vouloir retirer cette permission", () => {
                this.form_permission.post(route("roles.delete_permission"), {
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
        }
    },
    created() {
        // console.log(this.permissions)
        if (this.$page.props.flash.error) {
            this.$toast.success(this.$page.props.flash.error)

        }
    },
    // mounted(){
    //     this.$gates.setPermissions(this.$page.props.permissions);
    // }
    
}
</script>
