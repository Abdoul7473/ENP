<template>
<admin-layout>
    <Toolbar Title="Matières" :breadcrumbs="breadcrumbs">

    </Toolbar>
    <v-data-table :headers="headers" :items="matieres" item-key="name" :search="search" dense class="my-3 pt-3" style="border: 1px solid rgb(245, 134, 52)">
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
            <BtnAction icon display-icon="mdi-pencil" title="Modifier" v-permission:any="'manage_system'" @click="editItem(item)" color="warning" small />
        </template>
    </v-data-table>
    <v-dialog v-model="dialog" max-width="600px" scrollable persistent>
        <v-card>
            <v-toolbar dense dark color="primary" class="text-h6">Nouvelle Matière</v-toolbar>
            <div>
                <v-card-text class="pt-4">
                    <br>
                    <v-row :key="donnee.id" v-for="(donnee, i) in form.donnees">
                        <v-col md="11" class="pt-2">
                            <v-text-field v-model="donnee.libelle" outlined label="Libelle" placeholder="Libelle" dense @input="verify(donnee)"></v-text-field>
                        </v-col>
                        <v-col md="1" class="pt-4">
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
                </v-card-text>
            </div>
            <v-card-actions >
                <v-spacer></v-spacer>
                <v-btn dark small type="button" color="error" @click="close">
                    <v-icon left>mdi-cancel</v-icon>
                    Annuler
                </v-btn>
                <v-btn dark small color="green" @click="submit">
                    <v-icon left>mdi-check-circle</v-icon>
                    Enregistrer
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
    props: ["matieres"],
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
                    text: 'Actions ',
                    value: 'action'
                },
            ],
            form: this.$inertia.form({
                donnees: [],
            }),
        }

    },
    mounted() {
        // console.log(this.qr);

    },
    methods: {
        close() {
            this.dialog = false
            this.form.reset()
        },
        reserve() {
            this.loading = true

            setTimeout(() => (this.loading = false), 2000)
        },
        creer() {
            this.addRow()
            this.dialog = true
        },
        submit() {
            // console.log(this.form);

            this.$alert.confirm('Etes-vous sûr ?', "De vouloir enrgistrer ces matières?", () => {

                this.form.post(route("matiere.store"), {
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
        addRow() {
            this.form.donnees.push({
                libelle: null,
            });
            // console.log(this.form.donnees)
        },

        removeRow(p) {
            this.form.donnees = this.form.donnees.filter((product) => product !== p)
        },

        async verify(p) {
            const array = this.form.donnees.filter(el => el.libelle !== null && el.libelle == p.libelle)
            if (array.length > 1) {
                this.removeRow(p)

            } else {
                return true
            }
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
