<template>
<postulant-layout>
    <Toolbar :Title="$t('welcome.list_authorized')" :breadcrumbs="breadcrumbs">
    </Toolbar>

    <CustomDataTable :headers="headers" :items="demandes_autorisees" style="margin-left: 2%;">
        <template v-slot:addBtn>
            <!-- <v-btn @click="create()" small color="primary">
                    <v-icon left>mdi-plus-circle</v-icon> Ajouter
                </v-btn> -->
        </template>
        <template v-slot:item.action="{item}">
            <BtnAction icon display-icon="mdi-cash" v-if="(item.type_vol_id != 4 && item.payer == null && item.statut_id == 4)" :title="$t('table.payment')" @click="payer(item)" color="black" small />
            <!-- <BtnAction icon display-icon="mdi-send" v-if="item.statut_id == null" title="Soumettre" @click="soumetItem(item)" color="primary" small /> -->
            <a :href="route('demande.pdf', { id: item.id})" target="__blank">
                <v-icon size="small" class="me-2" :title="$t('table.print')" icon="mdi-printer" color="info" small>mdi-printer</v-icon>
            </a>

            <a :href="route('autorisation.pdf', { id: item.id})" download v-if="($page.props.auth.user.terme == 0 && (item.statut_id == 4 && item.payer != null)) || ($page.props.auth.user.terme == 1 && item.statut_id == 4)" style="font-size: large;">
                <v-icon :title="$t('table.download_authorization')" color="black">mdi-download</v-icon>
            </a>

            <!-- <BtnAction tion icon display-icon="mdi-pencil" v-if="item.statut_id == 4 && (item.payer != null || item.user.terme == 1) " title="Revision" @click="editItem(item)" color="warning" small /> -->
            <!-- <BtnAction icon display-icon="mdi-pencil" v-if="item.statut_id == 6 || item.statut_id == null" title="Modifier" @click="editItem(item)" color="warning" small />
            <BtnAction icon display-icon="mdi-delete" v-if="item.statut_id == 6 || item.statut_id == null || item.statut_id == 1|| item.statut_id == 2" title="Annuler" @click="deleteItem(item)" color="error" small /> -->
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
        <template v-slot:item.annuler="{item}">
            <v-chip style="color:white" color="green" v-if="item.motif_annuler == null">
                {{$t('table.no')}}
            </v-chip>

            <v-chip style="color:white" color="red" v-else @click="detail(item),dialog_over = true">
                {{$t('table.yes')}} &nbsp; &nbsp;<v-icon left>mdi-eye</v-icon>
            </v-chip>
        </template>
    </CustomDataTable>

    <v-dialog v-model="dialogDelete" max-width="500">
        <v-card>
            <v-toolbar dense dark color="primary" class="text-h6">Annuler la demande</v-toolbar>
            <v-card-text class="text-h6">vous etes sur d'annuler cette demande ?</v-card-text>
            <v-card-actions>
                <v-spacer />
                <v-btn :disabled="form.processing" text color="error" @click="dialogDelete = false">{{$t('table.no')}}</v-btn>
                <v-btn :loading="form.processing" text color="primary" @click="destroy">{{$t('table.yes')}}</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
    <v-dialog v-model="dialog_over" max-width="600" class="mx-auto">
        <v-card flat class="mx-auto">
            <v-toolbar dense dark color="primary" class="text-h6">Motif d'annulation</v-toolbar>
            <br>
            <v-card-text>
                <v-textarea disabled v-model="motif" outlined label="Motif"></v-textarea>
            </v-card-text>
        </v-card>
    </v-dialog>
</postulant-layout>
</template>

<!-- quant c'est pas un modal -->
<!-- <NavigationBtn :href="$route('employee.create')"  color="primary" small><v-icon left>mdi-plus-circle</v-icon> ajouter</NavigationBtn> -->

<script>
import PostulantLayout from "../../layouts/PostulantLayout.vue";
//  import useToast from "vue-toastification";
//  const toast = useToast();
export default {
    props: ["demandes_autorisees", "nbre_renvoi", "nbre_rejet", "nbre_auto", "nbre_annule"],
    components: {
        PostulantLayout
    },
    data() {
        return {
            motif: null,
            dialog_over: false,
            dialogDelete: false,
            itemId: null,
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
                    text: this.$t('welcome.list_authorized'),
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
        detail(item) {
            this.motif = item.motif_annuler
        },
        payer(item) {
            this.$inertia.get(route("demande.paye", item.id));
        },
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
        }
    }
};
</script>
