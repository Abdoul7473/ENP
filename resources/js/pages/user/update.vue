<template>
<admin-layout>
    <Toolbar Title="Gestion des utilisateurs"></Toolbar>
    <v-banner class="mb-4">
        <div class="d-flex flex-wrap justify-space-between">
            <h5 class="text-h5 font-weight-bold">Modification de compte Utilisateur</h5>
        </div>
    </v-banner>
    <v-card>
        <v-card-text>
            <v-form ref="myForm" @submit.prevent="submit">
                <v-row>
                    <v-col cols="12" sm="4">
                        <TextField label="Nom" rules="required" name="Nom et Prenom" v-model="form.nom" required outlined dense color="secondary" autocomplete="false"></TextField>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <TextField label="E-mail" type="email" rules="required" name="E-mail" v-model="form.email" required outlined dense color="secondary" autocomplete="false"></TextField>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <selectField label="Type Utilisateur" required v-model="form.type" outlined name="Type Utilisateur" color="secondary" :items="types" item-text="libelle" item-value="id" autocomplete="false"></selectField>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <selectField label="Rôles" required v-model="form.role" outlined name="Rôles" color="secondary" :items="roles" item-text="name" item-value="id" autocomplete="false" chips></selectField>
                    </v-col>
                </v-row>
                <v-card-actions>
                    <v-spacer />
                    <v-btn :loading="form.processing" @click="goBack()" color="error"> Annuler</v-btn>
                    <v-btn :loading="form.processing" type="submit" color="primary"> Enregistrer</v-btn>
                </v-card-actions>
            </v-form>
        </v-card-text>
    </v-card>
</admin-layout>
</template>

    
<script>
import AdminLayout from "../../layouts/AdminLayout.vue"
export default {
    components: {
        AdminLayout
    },
    props: ["types", "roles", "user"],
    data() {
        return {
              form: this.$inertia.form({
                nom: null,
                email: '',
                type: null,
                role: null
            }),
        }
    },
    methods: {
        submit() {
            this.$alert.confirm('Etes-vous sûr ?', "Vous allez créer ce compte", () => {
                this.form.put(route("user.update", this.form.id), {
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
        goBack() {
            this.$inertia.get(route("user.index"))
        }
    },
    mounted() {
        this.form.id = this.user.id
        this.form.email = this.user.email
        this.form.nom = this.user.name
        this.form.type = this.user.type_user_id
        this.form.role = this.user.roles[0].id
    }
}
</script>
