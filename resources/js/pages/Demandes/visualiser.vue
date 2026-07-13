<template>
<Admin-layout>
    <Toolbar Title="Liste des autorisations" :breadcrumbs="breadcrumbs">
    </Toolbar>

    <CustomDataTable :headers="headers" :items="demandes_autorisees" style="margin-left: 2%;">
        <template v-slot:item.type="{item}">
            <div v-for="(tag, index) in item.aeronefs" :key="index" small color="secondary">
                {{ tag.type }}
            </div>
        </template>
        <template v-slot:item.exploit="{item}">
            <div v-for="(tag, index) in item.aeronefs" :key="index" small color="secondary">
                {{ tag.nom_exploitant }}
            </div>
        </template>
        <template v-slot:item.imatriculation="{item}">
            <div v-for="(tag, index) in item.aeronefs" :key="index" small color="secondary">
                {{ tag.imatriculation }}
            </div>
        </template>
        <template v-slot:item.annuler="{item}">
            <v-chip style="color:white" color="green" v-if="item.motif_annuler == null">
                Non
            </v-chip>
            <v-chip style="color:white" color="red" v-else>
                Oui
            </v-chip>
        </template>
        <template v-slot:item.call="{item}">
            <div v-for="(tag, index) in item.aeronefs" :key="index" small color="secondary">
                {{ tag.indicatif_appel }}
            </div>
        </template>
        <template v-slot:item.action="{item}">
            <BtnAction v-if="item.statut_id == 4 " icon display-icon="mdi-eye" title="Détail de l'autorisation" @click="dialogInfosDemande = false, detailAutorisationItem(item,1)" color="green" small />
        </template>
    </CustomDataTable>
    <v-dialog v-model="dialogDetailAutorisation" max-width="1200">
        <v-card>
            <v-toolbar dense dark color="primary" class="text-h6">Détail de l'autorisation</v-toolbar>
            <v-card-text>
                <br>
                <v-card-text>
                    <v-row>
                        <v-col cols="1">
                            <v-img :src="'../../qr_code/'+qrcode+'.svg'" contain max-height="90"></v-img>
                        </v-col>
                        <v-col cols="8"></v-col>
                        <!-- <v-col>
                            <v-card-title class="font-weight-bold">{{ 'Période : (VALIDE 72 HEURES/ VALID FOR 72 HOURS)'}}</v-card-title>
                        </v-col> -->
                        <v-col>
                            <v-card-title v-if="details['demande']?.type_vol_id != 4" class="font-weight-bold">
                                {{ details['demande']?.nbre_mois == null ? '(VALIDE 72H)' : 'Période: ' + (details['demande']?.nbre_mois) + 'Mois' }}
                            </v-card-title>
                            <v-card-title v-else class="font-weight-bold"></v-card-title>
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-card>
                    <v-card-text>
                        <v-row>
                            <div v-for="(numero,num) in details['numeros']" :key="num">
                                <v-col cols="12">
                                    <v-card-title class="font-weight-bold">{{numero}}</v-card-title>
                                </v-col>
                                <!-- <v-col cols="3">
                  </v-col> -->
                            </div>

                        </v-row>
                    </v-card-text>
                </v-card>
                <v-card flat>
                    <v-card-text>
                        <v-row>
                            <v-col cols="12">
                                <v-label class="font-weight-bold">REQUERANT/ APPLICANT : </v-label>
                                <v-label>{{details['demande']?.user?.postulant?.nom_raison_sociale}}</v-label>
                            </v-col>
                            <v-col cols="12">
                                <v-label class="font-weight-bold">TYPE AERONEF/ TYPE OF AIRCRAFT : </v-label>
                                <v-label>{{details['aeronef']?.type}}</v-label>
                            </v-col>
                            <v-col cols="12">
                                <v-label class="font-weight-bold">IMMATRICULATION/ REGISTRATION : </v-label>
                                <v-label>{{details['aeronef']?.imatriculation}}</v-label>
                            </v-col>
                            <v-col cols="12">
                                <v-label class="font-weight-bold">INDICATIF/ CALL SIGN : </v-label>
                                <v-label>{{details['aeronef']?.indicatif_appel}}</v-label>
                            </v-col>
                            <v-col cols="12">
                                <v-label class="font-weight-bold">PROPRIETAIRE/ AIRCRAFT OWNER : </v-label>
                                <v-label>{{details['aeronef']?.proprietaire_aeronef}}</v-label>
                            </v-col>
                            <v-col cols="12">
                                <v-label class="font-weight-bold">EXPLOITANT/ OPERATOR : </v-label>
                                <v-label>{{details['aeronef']?.nom_exploitant}}</v-label>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
                <v-card flat v-for="(items, date) in details['routes']" :key="date">
                    <v-card-title>
                        <v-row>
                            <v-col cols="5"></v-col>
                            <v-col>
                                <v-chip large class="font-weight-bold">{{ date }}</v-chip>
                            </v-col>
                        </v-row>
                    </v-card-title>
                    <v-card-text v-for="item in items" :key="item.id">
                        <!-- contenu des routes -->
                        <v-row>
                            <v-col>
                                <v-text-field label="Ville de départ" outlined :value="item?.ville_depart?.libelle" readonly></v-text-field>
                            </v-col>
                            <v-col>
                                <v-text-field label="Ville d'arrivé" outlined :value="item?.ville_arrive?.libelle" readonly></v-text-field>
                            </v-col>
                            <v-col>
                                <v-text-field label="Heure de départ" outlined :value="item?.heure_depart" readonly></v-text-field>
                            </v-col>
                            <v-col>
                                <v-text-field label="Heure d'arrivé" outlined :value="item?.heure_arrive" readonly></v-text-field>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-card-text>
            <v-card-actions>
                <v-spacer />
                <v-btn :disabled="form.processing" text color="error" @click="dialogDetailAutorisation = false">Fermer</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
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
</Admin-layout>
</template>

<!-- quant c'est pas un modal -->
<!-- <NavigationBtn :href="$route('employee.create')"  color="primary" small><v-icon left>mdi-plus-circle</v-icon> ajouter</NavigationBtn> -->

<script>
import AdminLayout from "../../layouts/AdminLayout.vue";
//  import useToast from "vue-toastification";
//  const toast = useToast();
export default {
    props: ["demandes_autorisees", "nbre_renvoi", "nbre_rejet", "nbre_auto", "nbre_annule"],
    components: {
        AdminLayout
    },
    data() {
        return {
            url: null,
            currentYear: new Date().getFullYear(),
            motif: '',
            qrcode: '',
            revisionItem: null,
            donnees: [],
            details: [],
            code: null,
            ready: false,
            dialogConfirmRevision: false,
            dialogInfosDemande: false,
            type_autorisation: null,
            dialogGenerer: false,
            // numGenerer: null,
            dialogMotif: false,
            dialogDetailAutorisation: false,
            dialogAutorisation: false,
            postulant: null,
            demande: null,
            checkbox: true,
            reponse_ajax: false,
            fichiers: [],
            routes: [],
            aeronef: null,
            dialogDelete: false,
            itemId: null,
            headers: [{
                    text: "No",
                    value: "id",
                    sortable: false
                },
                {
                    text: "Date du vol",
                    value: "date_prevu_vol"
                },
                {
                    exploit: 'data',
                    text: "Exploitant",
                    value: 'exploit'
                },
                {
                    type: 'data',
                    text: "type aeronefs",
                    value: 'type'
                },
                {
                    imatriculation: 'data',
                    text: "Immatriculations",
                    value: 'imatriculation',
                },
                {
                    text: "Call sign",
                    value: 'call',
                },
                {
                    text: "Nature du la demande",
                    value: "type_demande.libelle"
                },
                {
                    text: "Motif du vol",
                    value: "type_vol.libelle"
                },
                {
                    text: "Annuler",
                    value: "annuler"
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
                    text: "Home postulant",
                    disabled: false,
                    href: "/homepostulant",
                },
                {
                    text: "Liste des demandes autorisées",
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
        console.log('auto', this.demandes_autorisees.data);
        if (this.$page.props.flash.success) {
            // toast.success(this.$page.props.flash.success)
            // console.log('tost',this.$page.props.flash.success);

        }
    },
    methods: {
        async detailAutorisationItem(item, code) {
            this.dialogInfosDemande = false
            this.isLoading = true
            await axios.get(route('getDetailAutorisation', {
                    id: item.id,
                    code: code
                }))
                .then(res => {
                    console.log('donnees', res.data.donnees)
                    this.isLoading = false
                    this.dialogDetailAutorisation = true
                    this.details = res.data.donnees
                    this.qrcode = res.data.donnees['autorisation'].qr_code

                })
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
