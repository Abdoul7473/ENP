<template>
<admin-layout>
    <div>
        <v-card outlined width="100%" height="70px" color="white" class="mb-2">
            <v-card outlined width="100%" height="3px" color="orange"></v-card>
            <v-toolbar color="white" class="px-2">
                <v-btn text class="ma-0 mr-2" color="orange" @click="onClickLeftButton">
                    <v-icon>mdi-reply</v-icon>
                </v-btn>
                <v-icon class="mr-2" color="secondary" size="20">mdi-home</v-icon>
                <v-toolbar-title style="color: rgb(243, 124, 32);">{{formTitle}}</v-toolbar-title>
                <v-btn text v-if="$page.props.auth.user.type_user_id==3" @click="signature()" class="costume-title" style="color: white; background-color: green; margin-left: 300px;">charger signature</v-btn>
                <v-spacer></v-spacer>
                <v-breadcrumbs :items="breadcrumbs" class="pa-0 custom-breadcrumbs"></v-breadcrumbs>
            </v-toolbar>
            <v-card outlined width="100%" height="3px" color="primary"></v-card>
        </v-card>
    </div>
    <!-- Tableaux de données -->

    <v-card flat>
        <v-card-text>
            <CustomDataTable :headers="headers" :items="demandes" class="elevation-1 custom-table">
                <template v-slot:item.type="{item}">
                    <div color="secondary" v-if="item.permanant == 1">
                        BLOC
                    </div>
                    <div color="secondary" v-else>
                        SIMPLE
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
                <template v-slot:item.action="{item}">
                    <BtnAction icon display-icon="mdi-eye" v-permission:any="'demande.read'" title="Détail" @click="detailItem(item)" color="warning" small />
                    <BtnAction v-if="item.statut_id == 4 && $page.props.auth.user.type_user_id != 1 " icon display-icon="mdi-qrcode" title="Détail de l'autorisation" @click="dialogInfosDemande = false, detailAutorisationItem(item,1)" color="green" small />
                    <!-- <BtnAction icon display-icon="mdi-delete" title="Supprimer" @click="deleteItem(item)" color="error" small/> -->
                    <a :href="route('demande.pdf', { id: item.id})" target="__blank" title="Imprimer la demande">
                        <v-icon size="small" class="me-2" icon="mdi-printer" color="info" small>mdi-printer</v-icon>
                    </a>
                    <a :href="route('autorisation.pdf', { id: item.id})" target="__blank" v-if="item.statut_id == 4" title="Imprimer l'autorisation">
                        <v-icon title="Imprimer l'autorisation" icon="mdi-printer" color="info" small>mdi-printer</v-icon>
                    </a>
                    <BtnAction icon display-icon="mdi-check-bold" v-if="item.statut_id == 8 && $page.props.auth.user.type_user_id != 1" title="Valider la révision" @click="revisionItem = item, dialogConfirmRevision = true, dialogInfosDemande = false" color="success" small />
                    <BtnAction v-if="item.statut_id == 4 && $page.props.auth.user.type_user_id != 1 && item.motif_annuler == null " icon display-icon="mdi-cancel" title="Annuler" @click="recupItem(item)" color="red" small />
                </template>
                <template v-slot:item.payer="{item}">
                    <div v-if="item.type_vol_id != 4">
                        <v-chip v-if="item.payer !== 1" color="red">
                            <v-icon left>mdi-close</v-icon>
                        </v-chip>
                        <v-chip v-else color="green">
                            <v-icon left>mdi-check</v-icon>
                        </v-chip>
                    </div>
                </template>

                <template v-slot:item.urgence="{item}">
                    <td class="urgence-width">
                        <v-chip v-if="item.urgence  <= 4" color="red">U</v-chip>
                    </td>
                </template>
                <template v-slot:item.revise="{item}">
                    <td class="revise-width">
                        <v-chip v-if="item.revise == 1" color="green">R</v-chip>
                    </td>
                </template>
            </CustomDataTable>
        </v-card-text>
    </v-card>

    <!-- confirmation revision -->
    <v-dialog v-model="dialogConfirmRevision" max-width="600">
        <v-card>
            <v-toolbar dense dark color="primary" class="text-h6">confirmation de la revision </v-toolbar>
            <v-card-text class="text-h6">Etes-vous sur de bien vouloir valider cette revision ?</v-card-text>
            <v-card-actions>
                <v-spacer />
                <v-btn :disabled="form.processing" text color="error" @click="dialogConfirmRevision = false">Annuler</v-btn>
                <v-btn :loading="form.processing" text color="primary" @click="revision(revisionItem)">Valider</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
    <!-- confirmation revision -->

    <!-- Tableaux de données -->

    <dialog-infos :donnees="donnees" :dialogInfosDemande="dialogInfosDemande" @modal-motif="openModalMotif" @modal-generer="openModalGenerer"></dialog-infos>
    <!-- fin Tableaux de données -->

    <!-- DialogMotif -->
    <v-dialog v-model="dialogMotif" max-width="600">
        <v-card>
            <v-toolbar dense dark color="primary" class="text-h6">Motif du {{ code == 0 ? 'rejet' : 'renvoi' }} </v-toolbar>
            <v-card-text>
                <br>
                <v-row>

                    <v-col>
                        <v-textarea v-model="motif" outlined clearable clear-icon="mdi-close-circle" label="Motif"></v-textarea>
                    </v-col>

                </v-row>
            </v-card-text>
            <v-card-actions>
                <v-spacer />
                <v-btn :disabled="form.processing" text color="error" @click="closeModel()">Annuler</v-btn>
                <v-btn :loading="form.processing" text color="primary" @click="changeStatus(donnees?.demande,code)">Enregistrer</v-btn>
                <!-- <v-btn v-if="$page.props.auth.user.type_user_id == 3" :loading="form.processing" text color="primary" @click="rejeterLast(donnees?.demande,code)">Enregistrer</v-btn> -->
            </v-card-actions>
        </v-card>
    </v-dialog>
    <v-dialog v-model="dialog_model" max-width="600">
        <v-card>
            <v-toolbar dense dark color="primary" class="text-h6">Motif  d'annulation </v-toolbar>
            <v-card-text>
                <br>
                <v-row>

                    <v-col>
                        <v-textarea v-model="form.motif" required outlined clearable clear-icon="mdi-close-circle" label="Motif"></v-textarea>
                    </v-col>

                </v-row>
            </v-card-text>
            <v-card-actions>
                <v-spacer />
                <v-btn :disabled="form.processing" text color="error" @click="closeModel()">Annuler</v-btn>
                <v-btn :loading="form.processing" text color="primary" @click="deleteItem()">Enregistrer</v-btn>
                <!-- <v-btn v-if="$page.props.auth.user.type_user_id == 3" :loading="form.processing" text color="primary" @click="rejeterLast(donnees?.demande,code)">Enregistrer</v-btn> -->
            </v-card-actions>
        </v-card>
    </v-dialog>
    <!-- DialogMotif -->

    <!-- DialogDetailAutorisation -->
    <v-dialog v-model="dialogDetailAutorisation" max-width="1200">
        <v-card>
            <v-toolbar dense dark color="primary" class="text-h6">Détail de l'autorisation</v-toolbar>
            <v-card-text>
                <br>
                <v-card-text>
                    <v-row>
                        <!-- <v-img :src="require('@/qr_code/' + items.image)" height="200px"></v-img> -->
                        <!-- qrcode24-03-0611-04-431 -->
                        <!-- <img :src="require('@/assets/'+qrcode+'.png')" alt="Exemple d'image"> -->
                        <!-- <v-img :src="`${process.env.BASE_URL}/qr_code/`+qrcode+`.png`" alt="Exemple d'image"></v-img> -->
                        <!-- <img src=" ./assets/qrcode24-03-0611-04-431.png " alt="Exemple d'image"> -->
                        <v-col cols="1">
                            <v-img :src="'../../qr_code/'+qrcode+'.svg'" contain max-height="90"></v-img>
                        </v-col>
                        <v-col cols="8"></v-col>
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
                                <v-chip large class="font-weight-bold">{{ formatTime(date) }}</v-chip>
                            </v-col>
                        </v-row>
                    </v-card-title>
                    <v-card-text v-for="item in items" :key="item.id">
                        <!-- contenu des routes -->
                        <v-row>
                            <v-col>
                                <v-text-field label="Ville de départ" outlined :value="item?.ville_depart?.libelle" disabled></v-text-field>
                            </v-col>
                            <v-col>
                                <v-text-field label="Ville d'arrivé" outlined :value="item?.ville_arrive?.libelle" disabled></v-text-field>
                            </v-col>
                            <v-col>
                                <v-text-field label="Heure de départ" outlined :value="item?.heure_depart" disabled></v-text-field>
                            </v-col>
                            <v-col>
                                <v-text-field label="Heure d'arrivé" outlined :value="item?.heure_arrive" disabled></v-text-field>
                            </v-col>
                            <v-checkbox v-permission:any="'chef_departement|chef_service'" v-if=" (donnees?.demande?.statut_id == 3 || donnees?.demande?.statut_id == 4) " v-model="item.check" disabled @change="autoriser(item,item.check,donnees?.routes)" :label="item?.check ? 'Générer' : ''"></v-checkbox>
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
    <!-- DialogDetailAutorisation -->

    <!-- DialogPdf -->
    <v-dialog v-model="dialogGenerer" persistent max-width="1200" class="mx-auto">
        <v-card flat class="mx-auto">
            <v-toolbar dense dark color="primary" class="text-h6">GENERATION DES AUTORISATIONS</v-toolbar>
            <br>
            <!-- contenu des demande -->
            <v-card-text>

                <br>
                <v-card-text v-for="(items, date) in donnees?.routes" :key="date">
                    <v-card-title>
                        <v-row>
                            <v-col cols="5"></v-col>
                            <v-col>
                                <v-chip large class="font-weight-bold">{{ formatTime(date)}}</v-chip>
                            </v-col>
                        </v-row>
                    </v-card-title>
                    <!-- contenu des routes -->
                    <v-row v-for="item in items" :key="item.id">
                        <v-col cols="3">
                            <v-text-field label="Ville de départ" outlined :value="item?.ville_depart?.libelle" readonly></v-text-field>
                        </v-col>
                        <v-col cols="3">
                            <v-text-field label="Ville d'arrivé" outlined :value="item?.ville_arrive?.libelle" readonly></v-text-field>
                        </v-col>
                        <v-col cols="2">
                            <v-text-field label="Heure de départ" outlined :value="item?.heure_depart" readonly></v-text-field>
                        </v-col>
                        <v-col cols="2">
                            <v-text-field label="Heure d'arrivé" outlined :value="item?.heure_arrive" readonly></v-text-field>
                        </v-col>
                        <v-checkbox v-model="item.check" @change="autoriser(item,item.check,donnees?.routes)" :label="item?.check ? 'Généré' : ''"></v-checkbox>
                    </v-row>
                </v-card-text>
            </v-card-text>
            <v-card-actions>
                <v-spacer />
                <v-btn v-if="donnees?.demande?.statut_id == 3" :disabled="form.processing" v-permission="'chef_departement'" color="error" @click="dialogGenerer = false">Annuler</v-btn>
                <v-btn v-if="donnees?.demande?.statut_id == 2" :disabled="form.processing" v-permission="'chef_service'" color="error" @click="annuleGeneration(donnees?.demande)">Annuler</v-btn>
                <v-btn v-if="donnees?.demande?.statut_id == 2 && ready":disabled="form.processing" v-permission="'chef_service'" color="yellow" @click="changeStatus(donnees?.demande,2)">Enregistrer</v-btn>
                <v-btn v-if="donnees?.demande?.statut_id == 3 && ready && $page.props.auth.user.type_user_id != 1" :disabled="form.processing" v-permission="'chef_departement'" color="primary" @click="valideGeneration(donnees?.demande)">Valider</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
    <!-- DialogPdf -->

    <v-dialog v-model="isLoading" persistent width="400">
        <v-card>
            <v-card-text>
                Patienter un instant ...
                <v-progress-linear indeterminate color="primary" height="10" rounded class="mb-0">
                    <template v-slot:prepend>
                        <v-icon color="primary">mdi-loading</v-icon>
                    </template>
                </v-progress-linear>
            </v-card-text>
        </v-card>
    </v-dialog>
    <v-dialog v-model="dialog" max-width="500px">
        <v-card style="margin-top: 3%;">
            <v-card-title color="primary">chargement et affichage de signature</v-card-title>
            <v-card-text style="margin-top: 3%;">
                <v-row>
                    <v-col>
                        <v-file-input label="Signature et cache/Signature and stamp" outlined prepend-icon="mdi-camera" accept="image/*" dense v-model="form_signe.signature_cache"></v-file-input>
                    </v-col>
                </v-row>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn style="color: white;" color="red" @click="dialog = false">
                    Fermer
                </v-btn>
                <v-btn color="primary" @click="submit()">Enregistrer</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</admin-layout>
</template>

<script>
import AdminLayout from "../../layouts/AdminLayout.vue";
import VuePdfApp from "vue-pdf-app";
import DialogInfos from "../../components/Demande/DialogInfos.vue";
// import this to use default icons for buttons
import "vue-pdf-app/dist/icons/main.css";
export default {
    props: ["demandes", "type"],
    components: {
        AdminLayout,
        VuePdfApp,
        DialogInfos
    },
    data() {
        return {
            url: null,
            currentYear: new Date().getFullYear(),
            motif: '',
            qrcode: '',
            dialog_model : false,
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
            headers: [{
                    text: "Urgence",
                    value: "urgence"
                },
                {
                    text: "Révision",
                    value: "revise"
                },
                {
                    text: "Type",
                    value: "type",
                    sortable: false
                },
                {
                    text: "Immatriculation",
                    value: "immatriculation",
                    sortable: false
                },
                {
                    text: "Indicatif d'appel",
                    value: "call"
                },
                {
                    text: "Date demande",
                    value: "created_at"
                },
                {
                    text: "Date soumise",
                    value: "date_soumis"
                },
                {
                    text: "Date du vol",
                    value: "date_prevu_vol"
                },
                {
                    text: "Type demande",
                    value: "type_demande.libelle"
                },
                {
                    text: "Postulant",
                    value: "user.postulant.nom_raison_sociale"
                },
                // { text: "Date S/A", value: "job_title" },
                {
                    text: "Annuler",
                    value: "annuler"
                },
                {
                    text: "Payer",
                    value: "payer"
                },
                // { text: "Created At", value: "created_at" },
                {
                    text: "Actions",
                    value: "action",
                    sortable: false
                },
            ],
            breadcrumbs: [{
                    text: "App",
                    disabled: false,
                    href: "/home",
                },
                {
                    text: "Demandes",
                    disabled: true,
                    href: "/demandes",
                },
            ],
            tab: null,
            detail: null,
            dialogPdf: false,
            dialogDelete: false,
            isUpdate: false,
            isLoading: false,
            isLoadingTable: false,
            itemId: null,
            options: {},
            search: null,
            params: {},
            demandeNotOpen: null,
            dialog: false,
            form_signe: this.$inertia.form({
                signature_cache: null,
            }),
            form: this.$inertia.form({
                id: null,
                motif: null,
                name: null,
                job_title: null,
                email: null,
                address: null,
            }),
        };
    },
    computed: {
        formTitle() {
            if (this.type == 1) {
                return "EN ATTENTE"
            } else if (this.type == 2) {
                return "VERIFIEES"
            } else if (this.type == 3) {
                return "APPROUVEES"
            } else if (this.type == 4) {
                return "AUTORISEES"
            } else if (this.type == 5) {
                return "REJETEES"
            } else if (this.type == 6) {
                return "RENVOYEES"
            } else if (this.type == 7) {
                return "ANNULEES"
            }
        },
    },

    created() {
        window.Echo.channel('events').listen('ChangeStatusDemande', (response) => {
            console.log('temps reel response', response);
            // msg.value.push({
            //     message: response.message.message,
            //     user: response.user
            // });
            // alert('Show without refresh!')
        });
    },
    methods: {
        closeModel() {
            this.dialogMotif = false,
            this.dialog_model = false,
            this.motif = '',
            this.form.reset()
        },
        recupItem (item){
            this.form.id = item.id
            this.dialog_model = true
        },
        deleteItem(item) {
            this.$alert.confirm('Etes-vous sûr ?', "vous etes sûr de vouloir d'annuler cette autorisation?", () => {
                this.form.post(route('delete.autorisation'), {
                    onSuccess: () => {
                        this.closeModel()
                        if (this.$page.props.flash.success) {
                            this.$alert.success(this.$page.props.flash.success)
                        }
                    },
                })
            })
        },
        formatTime(dateString) {
            const date = new Date(dateString);
            let options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            return date.toLocaleDateString('fr-FR', options);
        },
        signature() {
            this.dialogInfosDemande = false
            this.dialog = true
        },
        submit() {
            this.$alert.confirm('Etes-vous sûr ?', "vous etes sûr de vouloir enregistrer?", () => {
                if (this.form_signe.signature_cache !== null) {
                    this.form_signe.post(route("signature"), {
                        onSuccess: () => {
                            this.form_signe.reset();
                            this.dialog = false
                            this.$toast.success("Signature chargée avec succès", {
                                position: "top-center",
                            });
                        },
                    });
                }
            })
        },
        onClickLeftButton() {
            let previousRoute = window.history.state ? window.history.state.url : null;
            let previousRouteName;

            if (previousRoute) {
                previousRouteName = previousRoute.includes("/") ? previousRoute.split("/").pop() : null;
            }
        },
        openModalMotif(code) {
            this.dialogMotif = true;
            this.code = code
        },
        openModalGenerer() {
            this.dialogGenerer = true;
        },
        async revision(item) {
            console.log(item);
            this.dialogConfirmRevision = false
            this.isLoading = true;
            await axios.get(route('getRevision', {
                    id: item.id
                }))
                .then(res => {
                    this.isLoading = false
                    console.log(res.data)
                    if (res.data.code == 1) {
                        this.$toast.success('Mise à jour effectuée avec succès')
                        window.location.reload();
                    } else {
                        this.$toast.error('Echec de la révision, merci de réessayer')
                    }
                })
        },
        async detailItem(item) {
            this.isLoading = true;
            await axios.get(route('getDetail', {
                    id: item.id
                }))
                .then(res => {
                    this.isLoading = false
                    console.log(res.data)
                    if (res.data) {
                        this.donnees = res.data.donnees
                        this.dialogInfosDemande = true
                        // this.dialogInfosDemande = true
                        // this.aeronef = res.data.donnees.aeronef
                        // this.fichiers = res.data.donnees.fichiers
                        // this.postulant = res.data.donnees.demande.user.postulant
                        // this.demande = res.data.donnees.demande
                        // this.routes = res.data.donnees.routes
                    }
                })
            this.verif(this.donnees?.routes)
        },
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

        // rejeterLast(item,code){
        //   this.annuleGeneration(item)
        //   this.changeStatus(item,code)
        // },

        async changeStatus(item, code) {
            this.$alert.confirm('Etes-vous sûr ?', "Vous apporter une modification", () => {
                console.log(item, code, this.motif);
                this.isLoading = true
                axios.post(route('getChangeStatus', {
                        id: item.id,
                        code: code,
                        motif: this.motif
                    }))
                    .then(res => {
                        this.isLoading = false
                        console.log(res.data)
                        if (res.data.code == 1) {
                            this.$toast.success('Mise à jour effectuée avec succès')
                            window.location.reload();
                            this.close()
                        }
                    })
            })

        },

        verif(items) {
            const routeMerged = Object.values(items).reduce((accumulator, currentValue) => {
                return accumulator.concat(currentValue);
            }, []);
            let checks = routeMerged.filter((el) => el.check == true)
            if (checks.length == 0) {
                this.ready = false
            } else {
                this.ready = true
            }
        },

        async autoriser(item, check, items) {
            this.verif(items)
            await axios.get(route('getAutorisation', {
                    id: item.id,
                    check: check
                }))
                .then(res => {
                    console.log(res.data)
                    // if(res.data.code == 1){
                    //     // this.numGenerer = res.data.num
                    // }else{
                    //     this.$toast.warning('Autorisation echouée')
                    // }
                })
        },

        async annuleGeneration(item) {
            this.isLoading = true
            await axios.get(route('annuleAutorisation', {
                    demande_id: item.id
                }))
                .then(res => {
                    this.isLoading = false
                    console.log(res.data)
                    if (res.data) {
                        if (res.data.code == 1) {
                            this.dialogGenerer = false
                            window.location.reload();
                        } else {
                            this.$toast.warning('Autorisation echouée')
                        }
                    }
                })
        },

        async valideGeneration(item) {
            this.$alert.confirm('Etes-vous sûr ?', "Vous apporter une modification", () => {
                this.isLoading = true
                axios.get(route('valideAutorisation', {
                        demande_id: item.id
                    }))
                    .then(res => {
                        this.isLoading = false
                        console.log(res.data)
                        if (res.data) {
                            if (res.data.code == 1) {
                                this.$toast.success('Autorisation effectuée avec succès')
                                this.dialogGenerer = false
                                window.location.reload();
                                this.close()
                            } else if (res.data.code == 0) {
                                this.$toast.warning('Autorisation echouée')
                            } else {
                                this.$toast.warning('Une erreur est survenue')
                            }
                        }
                    })
            })
        }
    },
};
</script>

<style>
.custom-table .v-data-table__wrapper table {
    border-collapse: collapse;
}

.custom-table th,
.custom-table td {
    border: 1px solid #ddd;
}

.revise-width {
    width: 80px !important;
    /* Ajustez la largeur selon vos besoins */
}

.urgence-width {
    width: 80px !important;
    /* Ajustez la largeur selon vos besoins */
}
</style>
