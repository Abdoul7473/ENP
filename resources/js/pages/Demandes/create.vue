<template>
<postulant-layout>
    <Toolbar :Title="$t('welcome.new_demande')" :breadcrumbs="breadcrumbs">
    </Toolbar>
    <!-- <v-banner class="mb-4">
        <div class="d-flex flex-wrap justify-space-between">
            <h5 class="text-h5 font-weight-bold">Création de la demande</h5>
            <v-breadcrumbs :items="breadcrumbs" class="pa-0"></v-breadcrumbs>
        </div>
    </v-banner> -->
    <v-stepper v-model="e1" dense>
        <v-stepper-header dense>
            <template v-for="n in steps" dense>
                <v-stepper-step :complete="e1 > n" :step="n" editable>

                    {{title(n)}}
                </v-stepper-step>
                <v-divider v-if="n !== steps" :key="n"></v-divider>
            </template>
        </v-stepper-header>
        <v-stepper-items>
            <v-stepper-content v-for="n in steps" :key="`${n}-content`" :step="n">
                <v-card v-if="n==1" dense>
                    <v-row dense style="display: flex; justify-content: center; margin-top: 1%;">
                        <v-col md="4">
                            <selectField outlined item-text="libelle" item-value="id" dense :items="type_demande" label="Nature demande/ Type of request" name="Nature de la demande" rules="required" chips required v-model="formInfoDemande.type_demande"></selectField>
                        </v-col>
                        <v-col md="4">
                            <selectField item-text="libelle" item-value="id" outlined :items="filteredTypeVol" label="Motif vol/Purpose of Flight" name="Motif du vol" rules="required" dense chips required v-model="formInfoDemande.type_vol"></selectField>
                        </v-col>
                        <v-col md="4" v-if="(formInfoDemande.type_vol==4 || formInfoDemande.type_vol==5)">
                            <v-text-field required :label="formInfoDemande.type_vol == 4 ? 'Rang et Identité du VIP / Identity and Title of VIP' : 'à préciser / to be specified'" hide-details dense v-model="formInfoDemande.preciser">
                            </v-text-field>
                        </v-col>
                        <v-col md="4">
                            <DateField label="date du premier vol / date of first flight" name="Date" required dense v-model="formInfoDemande.date_prevu_vol"></DateField>
                        </v-col>
                        <v-col md="4">
                            <TextField required label="Fait à / Done In" hide-details dense v-model="formInfoDemande.ville_fait">
                            </TextField>
                        </v-col>
                        <v-col md="4" style="display: flex; justify-content: center;" v-if="formInfoDemande.type_demande==1 && (formInfoDemande.type_vol==1 || formInfoDemande.type_vol==2 )">
                            <selectField label="Type de bloc / Block type" chips clear required v-model="formInfoDemande.permanant" outlined color="secondary" item-text="libelle" item-value="id" :items="items" autocomplete="false"></selectField>
                        </v-col>

                        <v-col md="4" v-if="formInfoDemande.permanant == 1">
                            <TextField label="Nombre de mois / Number of months" hide-details dense v-model="formInfoDemande.nbre_mois" type="number" min="0">
                            </TextField>
                        </v-col>
                        <v-col md="4" v-else></v-col>
                        <v-col md="4" v-if="formInfoDemande.permanant"></v-col>
                        <v-col md="4" v-if="formInfoDemande.type_vol!==4"></v-col>
                        <v-col md="4" v-if="formInfoDemande.type_vol==4"></v-col>

                    </v-row>
                    <br>
                    <v-card>
                        <v-card-title style="line-height: 1%;">{{$t('form.tab1.information_aeronef')}}</v-card-title>
                        <v-card-text style="margin-top: 3%;">
                            <v-row>
                                <v-col md="4">
                                    <TextField required label="Immatriculation aéronef/ Aircraft Registration" hide-details dense v-model="formInfoAeronef.imatriculation">
                                    </TextField>
                                </v-col>
                                <v-col md="4">
                                    <TextField required label="Type aéronef/ Aircraft Type" hide-details dense v-model="formInfoAeronef.type">
                                    </TextField>
                                </v-col>
                                <v-col md="4">
                                    <TextField required label="Indicatif d’appel/ Call Sign" hide-details dense v-model="formInfoAeronef.indicatif_appel">
                                    </TextField>
                                </v-col>
                                <v-col md="4">
                                    <TextField required label="Nom Proprietaire de l’aéronef/ Aircraft Owner name" hide-details dense v-model="formInfoAeronef.propreitaire_aeronef">
                                    </TextField>
                                </v-col>

                                <v-col md="4">
                                    <TextField required label="Nom Commandant de bord/ Captain's name" hide-details dense v-model="formInfoAeronef.commandant_bord">
                                    </TextField>
                                </v-col>
                                <v-col md="4">
                                    <TextField required label="Nom exploitant/Operator name" hide-details dense v-model="formInfoAeronef.nom_exploitant">
                                    </TextField>
                                </v-col>

                                <v-col md="4">
                                    <TextField required label="Téléphone exploitant/Operator Telephone" hide-details dense v-model="formInfoAeronef.tel_exploitant">
                                    </TextField>
                                </v-col>
                                <v-col md="4">
                                    <TextField type="email" required label="Email exploitant/Operator mail" hide-details dense v-model="formInfoAeronef.email_exploitant">
                                    </TextField>
                                </v-col>

                            </v-row>
                        </v-card-text>
                    </v-card>
                    <br>
                    <br>
                </v-card>
                <v-card v-if="n==2">
                    <v-row :key="allroute.id" v-for="(allroute, i) in formRoute.Allroutes" style="margin-left: 1%; margin-top: 1%;">
                        <v-card>
                            <v-row style="margin-left: 2%; margin-top: 1%;">
                                <v-col md="6">
                                    <DateField label="Date" name="Date" :disabled="i === 0" required dense v-model="allroute.date_route"></DateField>
                                </v-col>
                                <v-col md="2">
                                    <v-btn fab dark color="red" x-small @click="removeRowAllRoute(allroute)">
                                        <v-icon dark>mdi-close</v-icon>
                                    </v-btn>
                                    <!-- <v-btn icon display-icon="mdi-pencil" title="Modifier" @click="editItem(item)" color="warning" size="large"></v-btn> -->
                                </v-col>
                                <v-row :key="iteneraire.id" v-for="(iteneraire, j) in allroute.useroutes">
                                    <v-col md="3">
                                        <selectField outlined :items="aeroport" item-text="libelle" item-value="id" label="Aéroport départ" name="Aéroport départ" rules="required" chips required v-model="iteneraire.ville_depart"></selectField>
                                    </v-col>
                                    <v-col md="3">
                                        <selectField outlined :items="aeroport" item-text="libelle" item-value="id" label="Aéroport arriver" name="Aéroport arriver" rules="required" chips required v-model="iteneraire.ville_arrive"></selectField>
                                    </v-col>
                                    <v-col md="2">
                                        <TextField type="time" label="Heure départ" hide-details dense v-model="iteneraire.heure_depart">
                                        </TextField>
                                    </v-col>
                                    <v-col md="2">
                                        <TextField type="time" label="Heure arriver" hide-details dense v-model="iteneraire.heure_arrive">
                                        </TextField>
                                    </v-col>
                                    <v-col md="2">
                                        <v-btn class="mx-2" fab dark color="red" x-small @click="removeRow(allroute,iteneraire)">
                                            <v-icon dark>mdi-close</v-icon>
                                        </v-btn>
                                    </v-col>
                                </v-row>
                                <v-col md="2" style="margin-left: 85%;">
                                    <v-btn class="mx-2" title="ajouter une route / Add route" fab dark color="primary" @click="ajouterroute(allroute)" x-small>
                                        <v-icon dark>mdi-plus</v-icon>
                                    </v-btn>
                                </v-col>

                            </v-row>
                            <br>
                        </v-card>
                        <br><br>
                    </v-row>
                    <v-row style="margin-left: 92%; margin-top: 4%;">
                        <v-col md="2">
                            <v-btn class="mx-2" title="ajouter date / Add date" @click="ajouterroutes()" fab dark color="primary" x-small>
                                <v-icon dark>mdi-plus</v-icon>
                            </v-btn>
                        </v-col>
                    </v-row>

                    <br>
                </v-card>
                <v-card v-if="n==3">
                    <v-row :key="allDoc.id" v-for="(allDoc, i) in formFichierRequis.documents" style="height: 75px;">
                        <v-col md="6" style="margin-top: 2%;">
                            <v-file-input :label="nomfichier[i]" outlined dense v-model="allDoc.fichier"></v-file-input>
                        </v-col>
                        <v-col md="6" style="margin-top: 2%;" v-if="nomfichier[i] != 'Autre'">
                            <DateField label="Date d'expiration / Expiry date"  name="Date" dense v-model="allDoc.date_expire" ></DateField>
                        </v-col>

                    </v-row>
                    <br>
                    <br>
                </v-card>

                <v-row style=" margin-top: 1%;">
                    <v-col>
                        <v-btn color="primary" @click="backStep(n)">
                            {{$t('form.btn_prev')}}
                        </v-btn>
                    </v-col>
                    <v-col v-if="n==steps" style="display: flex; justify-content: flex-end;">
                        <v-btn color="primary" @click="submit()">
                            {{$t('welcome.save')}}
                        </v-btn>
                    </v-col>
                    <v-col v-else style="display: flex; justify-content: flex-end;">
                        <v-btn color="primary" @click="nextStep(n)">
                            {{$t('form.btn_next')}}
                        </v-btn>
                    </v-col>
                </v-row>
                <br>

            </v-stepper-content>
        </v-stepper-items>
    </v-stepper>
</postulant-layout>
</template>

<!-- quant c'est pas un modal -->
<!-- <NavigationBtn :href="$route('employee.create')"  color="primary" small><v-icon left>mdi-plus-circle</v-icon> ajouter</NavigationBtn> -->

<script>
import { log10 } from "chart.js/helpers";
import PostulantLayout from "../../layouts/PostulantLayout.vue";

export default {
    props: ["type_demande", "type_vol", "aeroport", "type_fichier", "nbre_renvoi", "nbre_rejet", "nbre_auto", "nbre_annule"],
    components: {
        PostulantLayout,
    },
    data() {
        return {
            e1: 1,
            steps: 3,
            nomfichier: [],
            breadcrumbs: [{
                    text: this.$t('welcome.home'),
                    disabled: false,
                    href: "/homepostulant",
                },
                {
                    text: this.$t('welcome.new_demande'),
                    disabled: true,
                    href: "/homepostulant",
                },
            ],

            isUpdate: false,
            isLoading: false,
            isLoadingTable: false,
            itemId: null,
            options: {},
            search: null,
            params: {},
            formInfoDemande: this.$inertia.form({
                ville_fait: null,
                type_demande: null,
                type_vol: null,
                preciser: null,
                date_prevu_vol: null,
                permanant: null,
                nbre_mois: null
            }),

            formInfoAeronef: this.$inertia.form({
                imatriculation: null,
                type: null,
                indicatif_appel: null,
                commandant_bord: null,
                nom_exploitant: null,
                tel_exploitant: null,
                email_exploitant: null,
                propreitaire_aeronef: null,
            }),

            formRoute: this.$inertia.form({
                Allroutes: [],
            }),
            formFichierRequis: this.$inertia.form({
                documents: []
            }),

            form: this.$inertia.form({
                infoDemande: [],
                infoAeronef: null,
                infoRroutes: null,
                infoFichier: null,
            }),
            items: [{
                id: null,
                libelle: 'Demande simple / Simple request'
            }, {
                id: 1,
                libelle: 'Bloc permis / Bloc permit'
            }],
        };
    },
    computed: {
        formTitle() {
            return this.isUpdate ? "Edit demande" : "Create demande";
        },
        isPostulant() {
            return !!(this.$page && this.$page.props && this.$page.props.user && this.$page.props.user.postulant);
        },
        filteredTypeVol() {
            if (!this.isPostulant) {
                return this.type_vol;
            }
            return (this.type_vol || []).filter((item) => item.id !== 4);
        },
    },

    watch: {
        isPostulant(val) {
            if (val && this.formInfoDemande.type_vol === 4) {
                this.formInfoDemande.type_vol = null;
            }
        },
        "formInfoDemande.permanant"(val) {
            if (!val) {
                this.formInfoDemande.nbre_mois = null;
            }
        },
        "formInfoDemande.type_demande"(val) {
            if (val !== 1) {
                this.formInfoDemande.permanant = null;
                this.formInfoDemande.nbre_mois = null;
            }
        },
        steps(val) {
            if (this.e1 > val) {
                this.e1 = val
            }
        },
    },
    methods: {
    
        free() {
            console.log('permanant', this.formInfoDemande.permanant);
        },
        ajouterDoc(i) {
            this.formFichierRequis.documents.push({
                id_nomfichier: i,
                date_expire: null,
                fichier: null,
            })
        },
        valideDate(elt,index){
        console.log(elt,index);
        // Crée une nouvelle instance de l'objet Date
        
            let currentDate = new Date();

            // Affiche la date et l'heure actuelles
            console.log(currentDate);

            // Si vous souhaitez seulement la date au format ISO
            let isoDate = currentDate.toISOString().split('T')[0];
            console.log('iso',isoDate);
            if(isoDate>=elt){
              this.formFichierRequis.documents[index].date_expire=null;
              this.$alert.error('votre date n\'est pas valide ');
              console.log('tesg',this.formFichierRequis.documents[index].date_expire);
            }
            // Si vous souhaitez seulement l'heure
            let currentTime = currentDate.toLocaleTimeString();
            console.log(currentTime);

            // Si vous souhaitez formater la date
            let options = { year: 'numeric', month: 'long', day: 'numeric' };
            let formattedDate = currentDate.toLocaleDateString('fr-FR', options);
            console.log(formattedDate);
      },
        removeRowAllRoute(id) {
            this.formRoute.Allroutes = this.formRoute.Allroutes.filter((el) => el !== id);
        },
        removeRow(Allroutes, useroute) {
            Allroutes.useroutes = Allroutes.useroutes.filter((el) => el !== useroute);
        },
        ajouterroutes() {
            this.formRoute.Allroutes.push({
                date_route: null,
                useroutes: [],
            });
            let useroute = this.formRoute.Allroutes[this.formRoute.Allroutes.length - 1];
            this.ajouterroute(useroute);
        },
        ajouterroute(useroute) {
            useroute.useroutes.push({
                ville_depart: null,
                ville_arrive: null,
                heure_depart: null,
                heure_arrive: null,
            })
        },
        nextStep(n) {
            if (n === this.steps) {
                this.e1 = 1
            } else {
                this.e1 = n + 1
                this.formRoute.Allroutes[0].date_route = this.formInfoDemande.date_prevu_vol
            }
        },

        backStep(n) {
            if (n === 1) {
                this.e1 = 1
            } else {
                this.e1 = n - 1
            }
        },
        title(n) {
            if (n === 1) {
                return this.$t('form.tab1.libelle')
            } else if (n === 2) {
                return this.$t('form.tab2.libelle')
            } else if (n === 3) {
                return this.$t('form.tab3.libelle')
            }
        },
        updateData() {
            this.isLoadingTable = true
            this.$inertia.get("/employee", this.params, {
                preserveState: true,
                preverseScroll: true,
                onSuccess: () => {
                    this.isLoadingTable = false
                },
            });
        },
        create() {
            this.dialog = true;
            this.form.reset();
            this.form.clearErrors();
        },
        submit() {
            this.form.infoDemande = this.formInfoDemande;
            this.form.infoAeronef = this.formInfoAeronef;
            this.form.infoRroutes = this.formRoute;
            this.form.infoFichier = this.formFichierRequis
            this.$alert.confirm('Etes-vous sûr ?', "vous etes sûr de vouloir enregistrer cette demande ?", () => {
                this.form.post(route("demande.store"), {
                    onSuccess: () => {
                    },
                });
            })
            // if (this.isUpdate) {
            //   this.form.put(route("employee.update", this.itemId), {
            //     preverseScroll: true,
            //     onSuccess: () => {
            //       this.isLoading = false;
            //       this.dialog = false;
            //       this.isUpdate = false;
            //       this.itemId = null;
            //       this.form.reset();
            //     },
            //   });
            // } else {
            //   this.form.post(route("employee.store"), {
            //     preverseScroll: true,
            //     onSuccess: () => {
            //       this.isLoading = false;
            //       this.dialog = false;
            //       this.form.reset();
            //     },
            //   });
            // }
        },
    },
    mounted() {
        this.ajouterroutes();
        this.type_fichier.forEach(element => {
            this.nomfichier.push(element.libelle)
            this.ajouterDoc(element.id);
        });
        if (this.isPostulant && this.formInfoDemande.type_vol === 4) {
            this.formInfoDemande.type_vol = null;
        }
    },
};
</script>
