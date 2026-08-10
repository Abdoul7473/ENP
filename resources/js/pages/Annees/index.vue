<template>
<admin-layout>
    <Toolbar Title="Années" :breadcrumbs="breadcrumbs">

    </Toolbar>
    <CustomDataTable :headers="headers" :items="annees">
        <template v-slot:addBtn>
            <v-btn @click="creer()" small color="primary" v-permission:any="'annee.create'">
                <v-icon left>mdi-plus-circle</v-icon> Ajouter
            </v-btn>
        </template>
        <template v-slot:item.debut="{item}">
            {{ formatTime(item.date_debut) }}
        </template>
        <template v-slot:item.fin="{item}">
            {{ formatTime(item.date_fin) }}
        </template>
        <template v-slot:item.statut="{item}">
            <div v-if="item.statut == 0">
                <v-chip color="primary" align="center">
                    En attente
                </v-chip>
            </div>
            <div v-if="item.statut == 1">
                <v-chip color="primary" align="center">
                    Encours
                </v-chip>
            </div>
            <div v-if="item.statut == 2">
                <v-chip color="red" align="center">
                    Clôturer
                </v-chip>
            </div>
        </template>
        <template v-slot:item.action="{item}">
            <BtnAction icon display-icon="mdi-toggle-switch-off" title="Activer" @click="ActiverOrCloturer(item,1)" v-if="item.statut == 0" color="green" small v-permission="'annee.cloture'" />
            <BtnAction icon display-icon="mdi-toggle-switch" title="Clôturer" @click="ActiverOrCloturer(item,2)" v-if="item.statut == 1" color="red" small v-permission="'annee.active'"/>
        </template>
    </CustomDataTable>
    <v-dialog v-model="dialog" max-width="600px" scrollable>
        <v-card>
            <v-toolbar dense dark color="primary" class="text-h6">Année Académique</v-toolbar>
            <div>
                <v-card-text class="pt-4">
                    <v-row>
                        <v-col md="12">
                            <v-text-field v-model="form.date_debut" type="date" outlined label="Date de la rentrée" placeholder="Date de la rentrée" dense></v-text-field>
                        </v-col>
                        <v-col md="12">
                            <v-text-field v-model="form.date_fin" type="date" outlined label="Date fin" placeholder="Date fin" dense></v-text-field>
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
    props: ["annees"],
    data() {
        return {
            dialog: false,
            dialogSignature: false,
            loading: false,
            dialogDetail: false,
            selection: 1,
            e1: 1,
            steps: 2,
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
                    text: 'Date de la rentrée',
                    align: 'start',
                    sortable: false,
                    value: 'debut',
                },

                {
                    text: 'date fin',
                    value: 'fin'
                },
                {
                    text: 'Statut',
                    value: 'statut'
                },
                {
                    text: 'Actions ',
                    value: 'action'
                },
            ],
            form: this.$inertia.form({
                id: null,
                libelle: null,
                date_debut: null,
                date_fin: null,
                type: null,
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
            this.$alert.confirm('Etes-vous sûr ?', "De vouloir enrgistrer cette année?", () => {

                this.form.post(route("annee.store"), {
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
        ActiverOrCloturer(item,type) {
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
    }
}
</script>
