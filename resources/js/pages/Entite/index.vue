<template>
<admin-layout>
    <Toolbar Title="Entités" :breadcrumbs="breadcrumbs">

    </Toolbar>
    <v-data-table :headers="headers" :items="entites" item-key="name" :search="search" dense class="my-3 pt-3" style="border: 1px solid rgb(245, 134, 52)">
        <template v-slot:top>
            <v-row>

                <v-col cols="8" class="pt-8">
                    <v-btn @click="creer()" small color="primary">
                        <v-icon left>mdi-plus-circle</v-icon> Ajouter
                    </v-btn>
                </v-col>
                <v-col class="pt-8" cols="4">
                    <v-text-field v-model="search" prepend-inner-icon="mdi-search-web" single-line outlined dense clearable label="Récherecher" placeholder="Récherecher" class="mx-3"></v-text-field>
                </v-col>
            </v-row>
        </template>

    </v-data-table>
    <v-dialog v-model="dialog" max-width="600px" scrollable>
        <v-card>
            <v-toolbar dense dark color="primary" class="text-h6">Nouvelle Entité</v-toolbar>
            <div>
                <v-card-text class="pt-4">
                    <v-row>
                        <v-col md="12">
                            <TextField label="Libelle" rules="required" name="Libelle" v-model="form.libelle" required outlined dense color="secondary" autocomplete="false"></TextField>
                        </v-col>
                        <v-col md="12">
                            <selectField label="Tutelle"  v-model="form.entite_id" outlined name="Tutelle" color="secondary" :items="entites" item-text="libelle" item-value="id" autocomplete="false" chips></selectField>
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
        AdminLayout
    },
    props: ["entites"],
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
            selectedMonth: null,
            headers: [{
                    text: 'Libelle',
                    value: 'libelle'
                },
                {
                    text: 'Tutelle',
                    align: 'start',
                    sortable: false,
                    value: 'entite.libelle',
                },
                {
                    text: 'Actions ',
                    value: 'action'
                },
            ],
            form: this.$inertia.form({
                id: null,
                libelle: null,
                entite_id: null
            })
        }

    },
    mounted() {
        // console.log(this.qr);

    },
    methods: {
        close() {
            this.dialog = false
            this.dialogDetail = false
            this.dialogSignature = false
            this.form.reset()
        },
        reserve() {
            this.loading = true

            setTimeout(() => (this.loading = false), 2000)
        },
        creer() {
            this.dialog = true
        },
        submit() {
            this.$alert.confirm('Etes-vous sûr ?', "De vouloir enrgistrer cette entité?", () => {

                this.form.post(route("entite.store"), {
                    onSuccess: () => {
                        if (this.$page.props.flash.success) {
                            this.$alert.success(this.$page.props.flash.success)
                        }
                        if (this.$page.props.flash.error) {
                            this.$toast.error(this.$page.props.flash.error)
                        }
                        this.close()
                        this.form.reset();
                    },
                    onError: this.$alert.messages

                });
            })
        },
        ActiverOrCloturer(item, type) {
            this.form.id = item.id
            this.form.type = type
            console.log(type);

            const message = type == 2 ? "De vouloir clôturer cette année?" : "De vouloir activer cette année?"
            this.$alert.confirm('Etes-vous sûr ?', message, () => {

                this.form.post(route("annee.cloture"), {
                    onSuccess: () => {
                        if (this.$page.props.flash.success) {
                            this.$alert.success(this.$page.props.flash.success)
                        }
                        if (this.$page.props.flash.error) {
                            this.$toast.error(this.$page.props.flash.error)
                        }
                        this.close()
                        this.form.reset();
                    },
                    onError: this.$alert.messages

                });
            })
        },
        formatTime(dateString) {
            const date = new Date(dateString);
            let options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
            };
            return date.toLocaleDateString('fr-FR', options);
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
