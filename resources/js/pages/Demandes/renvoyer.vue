<template>
<postulant-layout>
    <Toolbar :Title="$t('welcome.list_returned')" :breadcrumbs="breadcrumbs">
    </Toolbar>

    <CustomDataTable :headers="headers" :items="demandes_renvoyees" style="margin-left: 2%;">
        <template v-slot:addBtn>
            <!-- <v-btn @click="create()" small color="primary">
                    <v-icon left>mdi-plus-circle</v-icon> Ajouter
                </v-btn> -->
        </template>
        <template v-slot:item.action="{item}">
            <a :href="route('demande.pdf', { id: item.id})" target="__blank">
                <v-icon size="small" class="me-2" title="Imprimer" icon="mdi-printer" color="info" small>mdi-printer</v-icon>
            </a>
            <!-- <BtnAction icon display-icon="mdi-download" title="télécharger autorisation" @click="" color="black" small /> -->
            <BtnAction icon display-icon="mdi-pencil" title="Modifier" @click="editItem(item)" color="warning" small />
            <BtnAction icon display-icon="mdi-eye" title="Motifs" @click="motif(item)" color="success" small />
            <BtnAction icon display-icon="mdi-delete" title="Annuler" @click="deleteItem(item)" color="error" small />
        </template>
        <template v-slot:item.immatriculation="{item}">
          <div v-for="(tag, index) in item.aeronefs" :key="index" small color="secondary">
             {{ tag.imatriculation }}
          </div >
        </template>
        <template v-slot:item.call="{item}">
          <div v-for="(tag, index) in item.aeronefs" :key="index" small color="secondary">
             {{ tag.indicatif_appel }}
          </div >
        </template>
    </CustomDataTable>

    <v-dialog v-model="dialogDelete" max-width="500">
        <v-card>
            <v-toolbar dense dark color="primary" class="text-h6">Annuler la demande</v-toolbar>
            <v-card-text class="text-h6">vous etes sur d'annuler cette demande ?</v-card-text>
            <v-card-actions>
                <v-spacer />
                <v-btn :disabled="form.processing" text color="error" @click="dialogDelete = false">NON</v-btn>
                <v-btn :loading="form.processing" text color="primary" @click="destroy">OUI</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
    <v-dialog v-model="dialog_motif" persistent max-width="700">
        <v-card>
            <v-toolbar dense dark color="primary" class="text-h6">Differents motif de renvoi
                <v-spacer></v-spacer>
            <v-icon  title="Fermer" size="x-large" style="margin:10px" color="white" @click="dialog_motif = false">mdi-close-circle</v-icon>

            </v-toolbar>
            <v-card-text class="pt-12">
                <v-row :key="m.id" v-for="(m,i) in motif_renvoi">
                    <v-col cols="12">
                        <v-textarea class="mx-2" disabled :label="m.date_renvoi"  :value="m.motif_renvoi"  outlined rows="3" row-height="25" shaped></v-textarea>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </v-dialog>
</postulant-layout>
</template>

<!-- quant c'est pas un modal -->
<!-- <NavigationBtn :href="$route('employee.create')"  color="primary" small><v-icon left>mdi-plus-circle</v-icon> ajouter</NavigationBtn> -->

<script>
import axios from "axios";
import PostulantLayout from "../../layouts/PostulantLayout.vue";
//  import useToast from "vue-toastification";
//  const toast = useToast();
export default {
    props: ["demandes_renvoyees", "nbre_renvoi", "nbre_rejet", "nbre_auto", "nbre_annule"],
    components: {
        PostulantLayout
    },
    data() {
        return {
            dialogDelete: false,
            itemId: null,
            motif_renvoi: [],
            dialog_motif: false,
            headers: [{
                    text: "No",
                    value: "id",
                    sortable: false
                },
                {
                    text: this.$t('table.date_request'),
                    value: "date_demande"
                },
                {
                    text: this.$t('table.done_in'),
                    value: "ville_fait"
                },
                {
                    text: "Immat.",
                    value: "immatriculation",
                    sortable: false
                },
                {
                    text: this.$t('table.call_sign'),
                    value: "call"
                },
                // {
                //     text: "N° ordre",
                //     value: "numero_ordre"
                // },
                {
                    text: this.$t('table.nature_request'),
                    value: "type_demande.libelle"
                },
                {
                    text: this.$t('table.reason_thef'),
                    value: "type_vol.libelle"
                },
                {
                    text: "Actions",
                    value: "action",
                    sortable: false
                },
            ],
            form: this.$inertia.form({

            }),
            breadcrumbs: [{
                    text: this.$t('welcome.home'),
                    disabled: false,
                    href: "/homepostulant",
                },
                {
                    text: this.$t('welcome.list_returned'),
                    disabled: true,
                    href: "/homepostulant",
                },
            ],
        }
    },
    computed: {
        formTitle() {
            return this.isUpdate ? "Edit Employee" : "Create Employee";
        },
    },
    watch: {
        options: function (val) {
            this.params.page = val.page;
            this.params.page_size = val.itemsPerPage;
            if (val.sortBy.length != 0) {
                this.params.sort_by = val.sortBy[0];
                this.params.order_by = val.sortDesc[0] ? "desc" : "asc";
            } else {
                this.params.sort_by = null;
                this.params.order_by = null;
            }
            this.updateData();
        },
        search: function (val) {
            this.params.search = val;
            this.updateData();
        },
    },
    created() {
        if (this.$page.props.flash.success) {
            // toast.success(this.$page.props.flash.success)
            // console.log('tost',this.$page.props.flash.success);

        }
    },
    methods: {
        updateData() {
            this.isLoadingTable = true
            this.$inertia.get("/demande", this.params, {
                preserveState: true,
                preverseScroll: true,
                onSuccess: () => {
                    this.isLoadingTable = false
                },
            });
        },
        create() {
            // this.dialog = true;
            // this.form.reset();
            // this.form.clearErrors();
            this.$inertia.get("/demande/create");
        },
        editItem(item) {
            console.log('item', item.id);
            // this.itemId=item.id
            this.$inertia.get(route("demande.modifier", item.id));
            // this.form.clearErrors();
            // this.form.name = item.name;
            // this.form.email = item.email;
            // this.form.job_title = item.job_title;
            // this.form.address = item.address;
            // this.isUpdate = true;
            // this.itemId = item.id;
            // this.dialog = true;
        },
        deleteItem(item) {
            this.itemId = item.id;
            this.dialogDelete = true;
        },
        destroy() {
            this.form.delete(route("demande.destroy", this.itemId), {
                preverseScroll: true,
                onSuccess: () => {
                    this.itemId = null;
                },
            })
        },
        motif(item) {
            axios.get(route('demande.renvoyer', {
                demande_id: item.id
            })).then(res => {
                this.motif_renvoi = res.data
                // console.log(this.motif_renvoi)
            });
            this.dialog_motif = true
        }
    }
};
</script>
