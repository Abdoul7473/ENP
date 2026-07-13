<template>
<admin-layout>
    <Toolbar Title="Compagnies" :breadcrumbs="breadcrumbs">

    </Toolbar>
    <CustomDataTable :headers="headers" :items="compagnies">
        <template v-slot:addBtn>
            <v-btn @click="generate()" small color="primary">
                <v-icon left>mdi-plus-circle</v-icon> Ajouter
            </v-btn>
        </template>

        <template v-slot:item.color="{ item }">
            <div class="text-center">
                <div class="my-2">
                    <v-btn x-small elevation="2" :color="item.passant" dark>

                    </v-btn>
                </div>
            </div>
        </template>
        <template v-slot:item.action="{ item }">
            <BtnAction icon display-icon="mdi-account" title="Les élèves" @click="GetEtudiant(item)" color="green" small />
            <BtnAction icon display-icon="mdi-calendar" title="Situations" @click="Situation(item)" color="green" small />
        </template>
    </CustomDataTable>
    <v-dialog v-model="dialog" max-width="1000px" persistent>
        <v-card>
            <v-toolbar dense dark color="primary" class="text-h6">Nouvelle Compagnie</v-toolbar>
            <v-card-text>
                <br>
                <v-row>
                    <v-col md="6">
                        <TextField required label="Nom" hide-details dense v-model="form.nom">
                        </TextField>
                    </v-col>
                    <v-col md="6">
                        <TextField required label="Sigle/abléviation" hide-details dense v-model="form.sigle">
                        </TextField>
                    </v-col>
                    <v-col md="6">
                        <TextField required label="Effectif théorique" type="number" hide-details dense v-model="form.effectif">
                        </TextField>
                    </v-col>
                    <v-col>
                        <selectField label="Corps" required v-model="form.corp_id" outlined name="Sexe" color="secondary" :items="corps" item-text="nom" item-value="id" autocomplete="false" chips></selectField>

                    </v-col>
                    <v-col md="6">
                        <h3>Couleur du passant</h3>
                        <v-color-picker class="ma-2" show-swatches v-model="form.passant"></v-color-picker>
                    </v-col>
                </v-row>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn style="color: white;" color="red" @click="close()">
                    Fermer
                </v-btn>
                <v-btn color="primary" @click="submit">Enregistrer</v-btn>
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
    props: ["compagnies", "corps"],
    data() {
        return {
            dialog: false,
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
                    text: 'Nom',
                    align: 'start',
                    sortable: false,
                    value: 'nom',
                },
                {
                    text: 'Sigle/Abréviation',
                    value: 'sigle'
                },
                {
                    text: 'Effectif théorique',
                    value: 'effectif'
                },
                {
                    text: 'Couleur du passant',
                    value: 'color'
                },
                {
                    text: 'Corps',
                    value: 'corp.nom'
                },
                {
                    text: 'Actions ',
                    value: 'action'
                },
            ],
            form: this.$inertia.form({
                nom: '',
                sigle: '',
                effectif: null,
                passant: '',
                corp_id : null
            }),
        }

    },
    mounted() {
        // console.log(this.qr);

    },
    methods: {
        close() {
            this.dialog = false
            this.dialogDetail = false
            this.form.reset()
        },
        reserve() {
            this.loading = true

            setTimeout(() => (this.loading = false), 2000)
        },
        generate() {
            this.dialog = true
        },
        submit() {
            this.$alert.confirm('Etes-vous sûr ?', "De vouloir enregistrer cette compagnie?", () => {

                this.form.post(route("compagnie.store"), {
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
        Detail(item) {
            this.$inertia.get(route('carte.detail', item.id))
        },
        GetEtudiant(item) {
            this.$inertia.get(route('eleve.index', item.id))
        },
        Situation(item) {
            this.$inertia.get(route('situation.index', item.id))
        }
    }
}
</script>
