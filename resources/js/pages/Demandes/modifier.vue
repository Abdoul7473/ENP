<template>
<postulant-layout>
    <Toolbar Title="Création de la demande" :breadcrumbs="breadcrumbs">
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
                            <selectField item-text="libelle" item-value="id" outlined :items="type_vol" label="Motif vol/Purpose of Flight" name="Motif du vol" rules="required" dense chips required v-model="formInfoDemande.type_vol"></selectField>
                        </v-col>
                        <v-col md="4" v-if="formInfoDemande.type_vol==4">
                            <TextField required label="à préciser/ to be specified" hide-details dense v-model="formInfoDemande.preciser">
                            </TextField>
                        </v-col>
                        <v-col md="4">
                            <DateField label="date du premier vol" name="Date" required dense v-model="formInfoDemande.date_prevu_vol"></DateField>
                        </v-col>
                        <v-col md="4">
                            <TextField required label="Fait à" hide-details dense v-model="formInfoDemande.ville_fait">
                            </TextField>
                        </v-col>
                        <!-- <v-col md="4" style="display: flex; justify-content: center;">
                            <v-switch v-model="formInfoDemande.permanant" dense inset :label="formInfoDemande.permanant ? ' Demande simple ?' : ' Demande pemanante ?'"></v-switch>
                        </v-col>

                        <v-col md="4" v-if="formInfoDemande.permanant">
                            <TextField label="Nombre de mois" hide-details dense v-model="formInfoDemande.nbre_mois" type="number" min="0">
                            </TextField>
                        </v-col> -->
                        <v-col md="4" ></v-col>
                        <v-col md="4" v-if="formInfoDemande.permanant"></v-col>
                        <v-col md="4" v-if="formInfoDemande.type_vol!==4"></v-col>
                        <v-col md="4" v-if="formInfoDemande.type_vol==4"></v-col>

                    </v-row>
                    <br>
                    <v-card>
                        <v-card-title style="line-height: 1%;">Information aéronef</v-card-title>
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
                    </v-card>
                    <br>
                    <br>
                </v-card>
                <v-card v-if="n==2">
                    <v-row :key="allroute.id" v-for="(allroute, i) in formRoute.Allroutes" style="margin-left: 1%; margin-top: 1%;">
                        <v-card>
                            <v-row style="margin-left: 2%; margin-top: 1%;">
                                <v-col md="6">
                                    <DateField label="Date" name="Date" required dense v-model="allroute.date_route"></DateField>
                                </v-col>
                                <v-col md="2" v-if="demande_modifier.statut_id!=4">
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
                                    <v-col md="2" v-if="demande_modifier.statut_id!=4">
                                        <v-btn class="mx-2" fab dark color="red" x-small @click="removeRow(allroute,iteneraire)">
                                            <v-icon dark>mdi-close</v-icon>
                                        </v-btn>
                                    </v-col>
                                </v-row>
                                <v-col md="2" style="margin-left: 85%;" v-if="demande_modifier.statut_id!=4">
                                    <v-btn class="mx-2" title="ajouter une route" fab dark color="primary" @click="ajouterroute(allroute)" x-small>
                                        <v-icon dark>mdi-plus</v-icon>
                                    </v-btn>
                                </v-col>

                            </v-row>
                            <br>
                        </v-card>
                        <br><br>
                    </v-row>
                    <v-row style="margin-left: 92%; margin-top: 4%;">
                        <v-col md="2" v-if="demande_modifier.statut_id!=4">
                            <v-btn class="mx-2" title="ajouter date" @click="ajouterroutes()" fab dark color="primary" x-small>
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
                        <v-col md="6" style="margin-top: 2%;">
                            <DateField label="Date d'expiration" name="Date"  dense v-model="allDoc.date_expire"></DateField>
                        </v-col>

                    </v-row>
                    <br>
                    <br>
                </v-card>

                <v-row style=" margin-top: 1%;">
                    <v-col>
                        <v-btn color="primary" @click="backStep(n)">
                            retour
                        </v-btn>
                    </v-col>
                    <v-col v-if="n==steps" style="display: flex; justify-content: flex-end;">
                        <v-btn color="primary" @click="submit()">
                            Enregistrer
                        </v-btn>
                    </v-col>
                    <v-col v-else style="display: flex; justify-content: flex-end;">
                        <v-btn color="primary" @click="nextStep(n)">
                            Suivant
                        </v-btn>
                    </v-col>
                </v-row>
                <br>

            </v-stepper-content>
        </v-stepper-items>
    </v-stepper>
    <!-- <v-dialog v-model="dialogModifier" max-width="500">
        <v-card>
            <v-toolbar dense dark color="primary" class="text-h6">Information </v-toolbar>
            <v-card-text style="margin-top: 4%;" class="text-h6" v-if="demande_modifier.statut_id==4">la modification de cette demande entrain la facturation de 66 000 FCFA, etes vous sur d'apporter la modification ?</v-card-text>
            <v-card-text style="margin-top: 4%;" class="text-h6" v-else>vous etes sûr de modifier cette demande ?</v-card-text>
            <v-card-actions>
                <v-spacer />
                <v-btn :disabled="form.processing" text color="error" @click="dialogModifier = false">NON</v-btn>
                <v-btn :loading="form.processing" text color="primary" @click="submit()">OUI</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog> -->
</postulant-layout>
</template>

<!-- quant c'est pas un modal -->
<!-- <NavigationBtn :href="$route('employee.create')"  color="primary" small><v-icon left>mdi-plus-circle</v-icon> ajouter</NavigationBtn> -->

<script>
import PostulantLayout from "../../layouts/PostulantLayout.vue";

export default {
    props: ["type_demande", "type_vol", "aeroport", "type_fichier", "demande_modifier", 'aeronefs', 'routes', 'demande_fichiers', "nbre_renvoi", "nbre_rejet", "nbre_auto", "nbre_annule"],
    components: {
        PostulantLayout,
    },
    data() {
        return {
            e1: 1,
            steps: 3,
            nomfichier: [],
            dialogModifier: false,
            breadcrumbs: [{
                    text: "Home postulant",
                    disabled: false,
                    href: "/homepostulant",
                },
                {
                    text: "Creation de la demande",
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
                imageUrl: null,
                id_demande: null,
                ville_fait: null,
                signature_cache: null,
                type_demande: null,
                type_vol: null,
                preciser: null,
                date_prevu_vol: null,
                permanant: null,
                nbre_mois: null
            }),

            formInfoAeronef: this.$inertia.form({
                id_aeronef: null,
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
                infoDemande: null,
                infoAeronef: null,
                infoRroutes: null,
                infoFichier: null,
            }),
        };
    },
    computed: {
        formTitle() {
            return this.isUpdate ? "Edit demande" : "Create demande";
        },
    },

    watch: {
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
        loadFichier(file) {
            const file_url = file;
            console.log('file_url', file_url);
            return fetch(file_url)
                .then(response => response.blob())
                .then(blob => {
                    const fileName = file_url.substring(file_url.lastIndexOf('/') + 1);
                    console.log('fileName', fileName);
                    const file = new File([blob], fileName, {
                        type: 'text/plain'
                    });

                    // Mettre à jour la valeur du fichier dans les données
                    return file;
                })
                .catch(error => {
                    console.error('Erreur lors du chargement du fichier :', error);
                });
        },
        async ajouterDoc(elts) {
            console.log('elt_fichier', elts);
            for (const elt of elts) {
                 console.log('element', elt);
                this.nomfichier.push(elt.fichier_requi.libelle)
                // this.ajouterDoc(element);
                const file_url = '/documents/fichier_requis/' + elt.fichier;
                let loadedFile = null;
                if (elt.fichier) {
                    loadedFile = await this.loadFichier(file_url);
                    console.log('loaded', loadedFile.name);
                }

                this.formFichierRequis.documents.push({
                    id_fichier: elt.id,
                    id_nomfichier: elt.fichier_requi.id,
                    date_expire: elt.date_expire,
                    fichier: loadedFile,
                });
            // console.log('loaded',loadedFile.name);
            // console.log('loadedFile', loadedFile.name, 'file_url ajout', file_url ,'elt.fichier',elt.fichier);
            // if (elt.fichier!= null ) {

            // }else{
            //     this.formFichierRequis.documents.push({
            //       id_fichier: elt.id,
            //       id_nomfichier: elt.fichier_requi.id,
            //       date_expire: elt.date_expire,
            //       fichier:null,
            //   })
            // }
        };
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
        modifierroutes() {
            console.log('this.routes', this.routes);
            if (this.routes != []) {
                for (var cle in this.routes) {
                    this.formRoute.Allroutes.push({
                        date_route: cle,
                        useroutes: [],
                    });

                    for (var cle1 in this.routes[cle]) {
                        let useroute = this.formRoute.Allroutes[this.formRoute.Allroutes.length - 1];
                        this.modifierroute(useroute, this.routes[cle][cle1])
                    }
                }
            } else {
                this.ajouterroutes();
            }

        },
        ajouterroute(useroute) {
            useroute.useroutes.push({
                id_route: null,
                ville_depart: null,
                ville_arrive: null,
                heure_depart: null,
                heure_arrive: null,
            })
        },
        modifierroute(useroute, data_route) {
            useroute.useroutes.push({
                id_route: data_route.id,
                ville_depart: data_route.ville_depart,
                ville_arrive: data_route.ville_arrive,
                heure_depart: data_route.heure_depart,
                heure_arrive: data_route.heure_arrive,
            })
        },
        nextStep(n) {
            if (n === this.steps) {
                this.e1 = 1
            } else {
                this.e1 = n + 1
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
                return "Nature et Aéronef "
            } else if (n === 2) {
                return "Itinéraire du/des vol(s)"
            } else if (n === 3) {
                return "Fichiers requis"
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
            this.form.infoFichier = this.formFichierRequis;
            console.log('formInfoDemande', this.formInfoDemande);
            console.log('formInfoAeronef', this.formInfoAeronef);
            console.log('formRoute', this.formRoute);
            console.log('formFichierRequis', this.formFichierRequis);
            console.log('form', this.form);
            if(this.demande_modifier.statut_id==4){
              this.$alert.confirm('Motification', "Cette modification sera facturer, etes vous sur d'apporter la modification ?", () => {
                this.form.post(route("demande.update"), {
                    onSuccess: () => {
                        this.formInfoDemande.reset();
                        this.formInfoAeronef.reset();
                        this.formRoute.reset();
                        this.formFichierRequis.reset();
                        this.form.reset();
                    },
                });
              })
            }else {
              this.$alert.confirm('Motification', "vous etes sûr de modifier cette demande ?", () => {
                this.form.post(route("demande.update"), {
                    onSuccess: () => {
                        this.formInfoDemande.reset();
                        this.formInfoAeronef.reset();
                        this.formRoute.reset();
                        this.formFichierRequis.reset();
                        this.form.reset();
                    },
                });
              })
            }

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
        for (var cle in this.routes) {
            console.log("Clé :", cle);
            console.log('route', this.routes[cle]);
            for (var cle1 in this.routes[cle]) {
                console.log('intineraire', this.routes[cle][cle1]);
            }
        }

        this.modifierroutes();

        this.formInfoDemande.date_prevu_vol = this.demande_modifier.date_prevu_vol,
        this.formInfoDemande.id_demande = this.demande_modifier.id,
        this.formInfoDemande.ville_fait = this.demande_modifier.ville_fait,
        this.formInfoDemande.type_demande = this.demande_modifier.type_demande_id,
        this.formInfoDemande.type_vol = this.demande_modifier.type_vol_id,
        this.formInfoDemande.preciser = this.demande_modifier.preciser,
        this.formInfoDemande.date_prevu_vol = this.demande_modifier.date_prevu_vol,
        this.formInfoDemande.permanant = this.demande_modifier.permanant,
        this.formInfoDemande.nbre_mois = this.demande_modifier.nbre_mois

        this.formInfoAeronef.id_aeronef = this.aeronefs[0].id,
        this.formInfoAeronef.imatriculation = this.aeronefs[0].imatriculation,
        this.formInfoAeronef.type = this.aeronefs[0].type,
        this.formInfoAeronef.indicatif_appel = this.aeronefs[0].indicatif_appel,
        this.formInfoAeronef.commandant_bord = this.aeronefs[0].commandant_bord,
        this.formInfoAeronef.nom_exploitant = this.aeronefs[0].nom_exploitant,
        this.formInfoAeronef.tel_exploitant = this.aeronefs[0].tel_exploitant,
        this.formInfoAeronef.email_exploitant = this.aeronefs[0].email_exploitant,
        this.formInfoAeronef.propreitaire_aeronef = this.aeronefs[0].proprietaire_aeronef,
        this.ajouterDoc(this.demande_fichiers);

            // this.demande_fichiers.forEach((element,index) => {
            //     console.log('element', element,index);
            //     this.nomfichier.push(element.fichier_requi.libelle)
            //     this.ajouterDoc(element);
            // });

        console.log('modifier_demande', this.aeronefs);
    },
};
</script>
