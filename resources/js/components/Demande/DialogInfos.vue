 <template>
    <!-- Tableaux de données -->
    <v-dialog v-model="dialogInfosDemande" max-width="1200" class="mx-auto">
        <v-card flat class="mx-auto">
        <v-toolbar dense dark color="primary" class="text-h6"
            >INFORMATIONS DE LA DEMANDE DE {{ donnees?.demande?.user?.postulant?.nom_raison_sociale }}</v-toolbar
            >
        <br>


        <!-- contenu des demande -->
        <v-card-text v-if="donnees?.demande?.statut_id == 5 || donnees?.demande?.statut_id == 6 ">
            <v-toolbar
            color="primary"
            dark
            >

            <v-toolbar-title>MOTIF <span v-if="donnees?.demande?.statut_id == 5">REJET</span><span v-else>RENVOIE</span></v-toolbar-title>
            </v-toolbar>
            <br>
            <!-- contenu des rejet ou renvoie -->
            <v-card-text>
                <b v-if="donnees?.demande?.statut_id == 5">{{donnees?.demande?.motif_rejet}}</b>
                <b v-else>{{ donnees?.motif_renvois[0]?.motif_renvoi }}</b>
            </v-card-text>
        </v-card-text>
        <!-- contenu des rejet ou renvoie -->


        <!-- contenu des demande -->
        <v-card-text>
            <v-toolbar
            color="primary"
            dark
            >

            <v-toolbar-title>NATURE DE LA DEMANDE</v-toolbar-title>
            </v-toolbar>
            <br>
            <!-- contenu de la demande -->
            <v-row>
                <v-col>
                    <v-label class="font-weight-bold">N° Ordre : </v-label><v-label >{{donnees?.demande?.numero_ordre}}</v-label>
                </v-col>
                <v-col>
                    <v-label class="font-weight-bold">Date de la demande : </v-label><v-label >{{formatTime(donnees?.demande?.date_demande)}}</v-label>
                </v-col>
                <v-col>
                    <v-label class="font-weight-bold">Ville : </v-label><v-label >{{donnees?.demande?.ville_fait}}</v-label>
                </v-col>
            </v-row>
            <br>
            <br>
            <v-row>
                <v-col>
                    <v-label class="font-weight-bold">Type de la demande : </v-label><v-label >{{donnees?.demande?.type_demande?.libelle}}</v-label>
                </v-col>
                <v-col>
                    <v-label class="font-weight-bold">Motif du vol : </v-label><v-label>{{donnees?.demande?.preciser ?? donnees?.demande?.type_vol?.libelle}}</v-label>

                </v-col>
                <v-col>
                    
                    <v-label class="font-weight-bold">Etat : </v-label><v-chip color="orange">{{donnees?.demande?.statut?.libelle}}</v-chip>

                </v-col>

            </v-row>
            <v-row>
                <v-col>
                    <v-label class="font-weight-bold">Type de bloc : </v-label><v-chip color="primary" v-if="donnees?.demande?.permanant == null">Demande simple</v-chip>
                    <v-chip color="primary" v-else>Bloc de {{ donnees?.demande?.nbre_mois }} mois</v-chip>
                </v-col>
            </v-row>
        </v-card-text>
        <!-- contenu des demande -->

            <!-- contenu des postulant -->
        <v-card-text>
            <v-toolbar
            color="primary"
            dark
            >
            <v-app-bar-nav-icon></v-app-bar-nav-icon>
            <v-toolbar-title>POSTULANT</v-toolbar-title>
            </v-toolbar>
            <br>
            <!-- contenu du postulant -->
            <v-row>
                <v-col>
                    <v-label class="font-weight-bold">Nom/Raison sociale : </v-label><v-label >{{donnees?.demande?.user?.postulant?.nom_raison_sociale}}</v-label>
                </v-col>
                <v-col>
                    <v-label class="font-weight-bold">Adresse : </v-label><v-label >{{donnees?.demande?.user?.postulant?.adresse}}</v-label>

                </v-col>
                <!-- <v-col>
                    <v-label class="font-weight-bold">Raison sociale : </v-label><v-label >{{postulant?.raison_sociale}}</v-label>
                </v-col> -->
                <v-col>
                    <v-label class="font-weight-bold">Email : </v-label><v-label >{{donnees?.demande?.user?.email}}</v-label>
                </v-col>
            </v-row>
            <br>
            <br>
            <v-row>
                <v-col>
                    <v-label class="font-weight-bold">Type postulant : </v-label><v-label >{{donnees?.demande?.user?.postulant?.type_postulant?.libelle}}</v-label>
                </v-col>

                <v-col>
                    <v-label class="font-weight-bold">Téléphone : </v-label>
                        <v-chip v-if="donnees?.demande?.user?.postulant?.tel2">{{donnees?.demande?.user?.postulant?.tel + ' / ' + donnees?.demande?.user?.postulant?.tel2}}</v-chip>
                        <v-chip v-else>{{donnees?.demande?.user?.postulant?.tel}}</v-chip>
                    </v-col>

            </v-row>
        </v-card-text>
        <!-- contenu des postulant -->

        <!-- contenu des aeronef -->
        <v-card-text>
            <!-- contenu de l'aeronef -->
            <v-toolbar
            color="primary"
            dark
            >
            <v-app-bar-nav-icon></v-app-bar-nav-icon>
            <v-toolbar-title>AERONEF</v-toolbar-title>
            </v-toolbar>
            <br>
            <v-row>
                <v-col>
                    <v-label class="font-weight-bold">Immatriculation : </v-label><v-label >{{donnees?.aeronef?.imatriculation}}</v-label>
                </v-col>
                <v-col>
                    <v-label class="font-weight-bold">Proprietaire Aeronef : </v-label><v-label >{{donnees?.aeronef?.proprietaire_aeronef}}</v-label>
                </v-col>
                <v-col>
                    <v-label class="font-weight-bold">Commandant de bord : </v-label><v-label >{{donnees?.aeronef?.commandant_bord}}</v-label>
                </v-col>
            </v-row>
            <br>
            <br>
            <v-row>
                <v-col md="2">
                    <v-label class="font-weight-bold">Type : </v-label><v-label >{{donnees?.aeronef?.type}}</v-label>
                </v-col>
                <v-col>
                    <v-label class="font-weight-bold">Nom Exploitant : </v-label><v-label >{{donnees?.aeronef?.nom_exploitant}}</v-label>
                </v-col>
                <v-col>
                    <v-label class="font-weight-bold">Téléphone Exploitant : </v-label><v-label >{{donnees?.aeronef?.tel_exploitant}}</v-label>
                </v-col>
                <v-col>
                    <v-label class="font-weight-bold">Email Exploitant : </v-label><v-label >{{donnees?.aeronef?.email_exploitant}}</v-label>
                </v-col>
            </v-row>
        </v-card-text>
        <!-- contenu des aeronef -->

        <!-- contenu des fichiers -->
        <v-card-text>
            <v-toolbar
            color="primary"
            dark
            >
            <v-app-bar-nav-icon></v-app-bar-nav-icon>
            <v-toolbar-title>FICHIERS</v-toolbar-title>
            </v-toolbar>
            <v-list
            subheader
            two-line
            >
            <v-list-item
                v-for="file in donnees?.fichiers"
                :key="file.fichier_requi.id"
            >
                <v-list-item-avatar>
                <v-icon
                    class="amber"
                    dark
                    v-text="'mdi-file'"
                ></v-icon>
                </v-list-item-avatar>
                <v-list-item-content>
                <a href="#"><v-list-item-title @click="showPdf(file)" v-text="file?.fichier_requi?.libelle"></v-list-item-title></a>
                <v-list-item-subtitle v-text="file.date_expire"></v-list-item-subtitle>
                </v-list-item-content>
                <v-list-item-action>
                <v-checkbox v-permission:any="'chef_departement|chef_service|verificateur'"
                    v-model="file.check"
                    :readonly="donnees?.demande?.statut_id >= 3"
                    @change="submitCheckedFiles()"

                    :label="file.check ? 'VÉRIFIÉ' : ''"
                ></v-checkbox>
                </v-list-item-action>
            </v-list-item>
            <br>
            </v-list>
        </v-card-text>
        <!-- contenu des fichiers -->

        <!-- contenu des routes -->
        <v-card-text>
            <v-toolbar
            color="primary"
            dark
            >
            <v-app-bar-nav-icon></v-app-bar-nav-icon>
            <v-toolbar-title>Routes</v-toolbar-title>
            </v-toolbar>
            <v-card-text v-for="(items, date) in donnees?.routes" :key="date">
                <v-card-title><v-row><v-col cols="5"></v-col><v-col><v-chip large class="font-weight-bold">{{ formatTime(date) }}</v-chip></v-col></v-row></v-card-title>
                <!-- contenu des routes -->
                <v-row v-for="item in items" :key="item.id">
                    <v-col><v-text-field
                    label="Ville de départ"
                    outlined
                    :value="item?.ville_depart?.libelle"
                    disabled
                    ></v-text-field></v-col>
                    <v-col><v-text-field
                    label="Ville d'arrivé"
                    outlined
                    :value="item?.ville_arrive?.libelle"
                    disabled
                    ></v-text-field></v-col>
                    <v-col><v-text-field
                    label="Heure de départ"
                    outlined
                    :value="item?.heure_depart"
                    disabled
                    ></v-text-field></v-col>
                    <v-col><v-text-field
                    label="Heure d'arrivé"
                    outlined
                    :value="item?.heure_arrive"
                    disabled
                    ></v-text-field></v-col>
                    <v-checkbox v-permission:any="'chef_departement|chef_service'" v-if="(donnees?.demande?.statut_id == 3 || donnees?.demande?.statut_id == 4)"
                    v-model="item.check"
                    disabled
                    @change="autoriser(item,item.check,donnees?.routes)"
                    :label="item?.check ? 'Généré' : ''"
                ></v-checkbox>
                </v-row>
            </v-card-text>
        </v-card-text>
        <!-- contenu des routes -->


        <!-- <v-card-actions><v-spacer /><v-btn color="primary" title="mettre à jour" @click="submitCheckedFiles()"><v-icon left>mdi-update</v-icon> Enregistrer</v-btn></v-card-actions> -->


        <!-- DialogPdf -->
            <v-dialog v-model="dialogPdf" max-width="800">
                <v-card v-if="url">
                    <v-card-text><vue-pdf-app style="height: 100vh;" :pdf="url"></vue-pdf-app></v-card-text>
                </v-card>
                <v-card v-else>
                    <v-card-text><span style="color: red;"> Pas de document</span></v-card-text>
                </v-card>
            </v-dialog>
        <!-- DialogPdf -->

        <!-- contenu des fichiers -->
        </v-card>
        <!-- <br v-if="donnees?.demande?.statut_id != 4"> -->
        <!-- groupe de Bouton -->
        <v-card max-width="1200" class="mx-auto" v-if="($page.props.auth.user.type_user_id == 1 && donnees?.demande?.statut_id == 1) || ($page.props.auth.user.type_user_id == 2 && donnees?.demande?.statut_id <= 2) || ($page.props.auth.user.type_user_id == 3 && donnees?.demande?.statut_id <= 3) ">
            <br>
            <v-card-text>
                <v-row>
                    <v-col md="1"></v-col>
                    <v-col md="5"><v-btn color="warning" v-permission="'demande.renvoi'" @click="modalMotif(1)"><v-icon left>mdi-replay</v-icon> Renvoyer pour rectification</v-btn></v-col>
                    <v-col><v-btn color="error" v-permission="'demande.rejet'" @click="modalMotif(0)"><v-icon left>mdi-cancel</v-icon> Rejetter</v-btn></v-col>
                    <!-- <v-col><v-btn color="error" v-permission="'demande.rejet'" @click="modalMotif(0)" v-if="$page.props.auth.user.type_user_id == 3"><v-icon left>mdi-cancel</v-icon> Rejetter</v-btn></v-col> -->
                    <v-col v-if="verifCheck && donnees?.demande?.statut_id == 1"><v-btn color="orange" v-permission="'verificateur'" @click="changeStatus(donnees?.demande,2)"><v-icon left>mdi-send</v-icon> Envoyer au supérieur</v-btn></v-col>
                    <!-- <v-col v-if="$page.props.auth.user.type_user_id == 2 && verifCheck"><v-btn color="orange" @click="changeStatus(donnees?.demande,2)"><v-icon left>mdi-send</v-icon> Envoyer au supérieur</v-btn></v-col> -->
                    <v-col v-if="verifCheck && donnees?.demande?.statut_id == 2 "><v-btn color="primary" v-permission="'chef_service'" @click="modalGenerer()"><v-icon left>mdi-send-outline</v-icon>Générer l'autorisation</v-btn></v-col>
                    <v-col v-if="verifCheck && donnees?.demande?.statut_id == 3 "><v-btn color="primary" v-permission="'chef_departement'" @click="modalGenerer()"><v-icon left>mdi-send-outline</v-icon>Valider l'autorisation</v-btn></v-col>
                </v-row>
            </v-card-text>
        </v-card>
        <!-- groupe de Bouton -->
        <v-dialog v-model="isLoading" persistent width="400">
          <v-card>
            <v-card-text>
              Patienter un instant ...
              <v-progress-linear
                indeterminate
                color="primary"
                height="10"
                rounded
                class="mb-0"
              >
                <template v-slot:prepend>
                  <v-icon color="primary">mdi-loading</v-icon>
                </template>
              </v-progress-linear>
            </v-card-text>
          </v-card>
        </v-dialog>
    </v-dialog>
    <!-- fin Tableaux de données -->
</template>

<script>
import AdminLayout from "../../layouts/AdminLayout.vue";
import VuePdfApp from "vue-pdf-app";
// import this to use default icons for buttons
import "vue-pdf-app/dist/icons/main.css";
export default {
props: ["demandes","donnees","dialogInfosDemande","type"],
components: { AdminLayout , VuePdfApp },
data() {
  return {
      url: null,
      currentYear: new Date().getFullYear(),
      motif: '',
      qrcode: '',
      dialogGenerer: false,
      dialogPdf: false,
      isLoading: false,
      details: [],
      code: null,
      type_autorisation: null,
      dialogMotif: false,
      dialogAutorisation: false,
      postulant: null,
      demande: null,
      checkbox: true,
      fichiers: [],
      routes: [],
      aeronef: null,
      breadcrumbs: [
          {
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
      };
},
created(){
    // console.log('testdonnees',this.donnees);
},
computed: {
  verifCheck() {
    // console.log('testtttt',this.donnees.fichiers);
    let check = this.donnees?.fichiers.filter((el) => el.check == false)
    if(check.length == 0){
        return true
    }else{
        return false
    }
  },
},
methods: {
  formatTime(dateString) {
      const date = new Date(dateString);
      let options = { year: 'numeric', month: 'long', day: 'numeric' };
      return date.toLocaleDateString('fr-FR', options);
    },
    modalMotif(code) {
        this.$emit('modal-motif', code);
    },
    modalGenerer() {
        this.$emit('modal-generer');
    },
  showPdf(file){
      this.url = file.fichier ? '../documents/fichier_requis/'+file.fichier : null
      this.dialogPdf = true
      console.log('test',this.url);
  },
  async submitCheckedFiles() {
    this.isLoading = true
      await axios.post(route('postFilesCheck',{ fichiers: this.donnees.fichiers}))
      .then(res => {
        this.isLoading = false
        console.log(res.data)
        if(res.data.code == 1){
            this.$toast.success('Mise à jour effectuée avec succès')
        }else{
            this.$toast.warning('La mise à jour n\'a pas été effectuée')
        }
      })
  },
  async changeStatus(item,code){
    this.$alert.confirm('Etes-vous sûr ?', "Vous apporter une modification", () => {
      console.log(item,code,this.motif);
    this.isLoading = true
       axios.post(route('getChangeStatus',{ id: item.id , code: code, motif: this.motif }))
        .then(res => {
            this.isLoading = false
          console.log(res.data)
          if(res.data.code == 1){
            this.$toast.success('Mise à jour effectuée avec succès')
            window.location.reload();
            this.close()
          }
        })
      })

    },

},
};
</script>
