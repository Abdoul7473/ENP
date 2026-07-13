<template>
<v-app>
    <v-app-bar app color="secondary" flat>
        <v-container class="py-0 fill-height">
            <v-menu min-width="270px" offset-y transition="slide-x-transition">
                <template v-slot:activator="{ on }">
                    <v-btn v-on="on" icon large>
                        <v-avatar item size="32px">
                            <v-img alt="user" src="/male.png"></v-img>
                        </v-avatar>
                    </v-btn>
                </template>
                <v-card outlined class="mx-auto" max-width="270" tile color="primary">
                    <v-list>
                        <v-list-item color="primary">
                            <v-list-item-avatar>
                                <v-img src="male.png"></v-img>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-title class="title">
                                    {{user.name}}
                                </v-list-item-title>
                                <v-list-item-subtitle>{{$t('welcome.profile')}}: Postulant</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-card>
                <v-list dense>
                    <v-list-item-group color="primary">
                        <v-list-item @click="profil()">
                            <v-list-item-icon>
                                <v-icon v-text="'mdi-account'"></v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title v-text="$t('welcome.profile')"></v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item @click="change()">
                            <v-list-item-icon>
                                <v-icon v-text="'mdi-lock-open'"></v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title v-text="$t('welcome.change_password')"></v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item @click="openDoc('cgu')">
                            <v-list-item-icon>
                                <v-icon v-text="'mdi-file-document-outline'"></v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title>C.GU</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item @click="openDoc('deposit')">
                            <v-list-item-icon>
                                <v-icon v-text="'mdi-file-document-outline'"></v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title>Conditions de dépôt</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item @click="logout">
                            <v-list-item-icon>
                                <v-icon v-text="'mdi-logout'"></v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title v-text="$t('welcome.logout')"></v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-item-group>
                </v-list>
            </v-menu>
            <v-btn v-for="link in links" :key="link" text>
                {{ link }}
            </v-btn>
            <v-btn text @click="dialog=true" style="color: white;">{{ $t('welcome.load_signature') }}</v-btn>
            <v-btn text @click="create()" style="color: white;" >{{ $t('welcome.new_demande') }}</v-btn>
            <v-btn v-if="showBalance" text style="color: white; font-size: 30px;" >{{ formatPrice(balance) }} FCFA</v-btn>
            <div>
                <v-btn v-if="!isLoading && !showBalance" color="primary" @click="getBalance">
                    {{$t('welcome.balance')}}
                </v-btn>

                <v-progress-circular v-if="isLoading" indeterminate color="primary"></v-progress-circular>

                <!-- <p v-if="showBalance">{{ balance }} FCFA</p> -->
            </div>
            <v-spacer></v-spacer>

            <!-- <v-responsive max-width="260">
                <v-text-field dense flat hide-details rounded solo-inverted></v-text-field>
            </v-responsive> -->
            <v-btn @click="changeLanguage('fr')">FR</v-btn>
            <v-btn @click="changeLanguage('en')">EN</v-btn>
        </v-container>
    </v-app-bar>

    <v-main class="grey lighten-3" style="padding-bottom: 80px;">
        <v-container fluid>
            <v-row>
                <v-col cols="3">
                    <v-sheet rounded="lg">
                        <v-list color="primary">
                            <v-list-item v-for="(item, i) in items" :key="i" @click="goToPage(item.to)">
                                <v-list-item-action>
                                    <v-icon style="color: white;">{{ item.icon }}</v-icon>
                                </v-list-item-action>
                                <v-list-item-content>
                                <v-list-item-title style="color: white;" v-text="item.title" />
                            </v-list-item-content>
                            <v-chip v-if="item.nbre !== null && item.nbre !== undefined">{{item.nbre}}</v-chip>
                        </v-list-item>

                            <v-divider class="my-2"></v-divider>

                            <!-- <v-list-item link color="grey lighten-4">
                                <v-list-item-content>
                                    <v-list-item-title style="color: white;">
                                        Refresh
                                    </v-list-item-title>
                                </v-list-item-content>
                            </v-list-item> -->
                        </v-list>
                    </v-sheet>
                </v-col>

                <v-col>
                    <v-sheet min-height="90vh" rounded="lg" style="overflow: hidden; padding-bottom: 80px;">
                        <div :key="key" class="mb-8 pa-1">
                            <slot></slot>
                            <v-dialog v-model="isLoading" persistent width="400">
                                <v-card>
                                    <v-card-text>
                                        {{ $t('welcome.waiting_load') }}
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
                                    <v-card-title color="primary">{{ $t('welcome.load_and_display_signature') }}</v-card-title>
                                    <v-card-text style="margin-top: 3%;">
                                        <v-row>
                                            <v-col>
                                                <v-file-input :label="$t('welcome.signature_and_stamp')" outlined prepend-icon="mdi-camera" accept="image/*" dense v-model="form.signature_cache"></v-file-input>
                                            </v-col>
                                        </v-row>
                                    </v-card-text>
                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-btn style="color: white;" color="red" @click="dialog = false">
                                            {{$t('welcome.close')}}
                                        </v-btn>
                                        <v-btn color="primary" @click="submit()">{{$t('welcome.save')}}</v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-dialog>
                            <v-dialog v-model="docDialog" max-width="900px">
                                <v-card class="doc-card">
                                    <v-card-title>
                                        {{ docTitle }}
                                    </v-card-title>
                                    <v-card-text class="doc-body">
                                        <div v-if="docUrl" class="doc-content">
                                            <iframe v-if="isPdf" :src="docUrl" class="doc-frame" frameborder="0"></iframe>
                                            <div v-else class="text-center doc-alt">
                                                <p>Le document est disponible en format Word. Cliquez pour l'ouvrir :</p>
                                                <a :href="docUrl" target="_blank" rel="noopener">Ouvrir le document</a>
                                            </div>
                                        </div>
                                        <div v-else class="text-center" style="color: red;">
                                            Aucun document disponible.
                                        </div>
                                    </v-card-text>
                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-btn color="primary" @click="docDialog = false">Fermer</v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-dialog>
                        </div>
                    </v-sheet>
                </v-col>
            </v-row>

        </v-container>
        <AppFooter />
    </v-main>
</v-app>
</template>

<script>
import AppFooter from "../components/AppFooter.vue";
export default {
    components: {
        AppFooter
    },
    data() {
        return {
            balance: "0",
            showBalance: false,
            key: 0,
            dialog: false,
            docDialog: false,
            docType: null,
            isLoading: false,
            form: this.$inertia.form({
                signature_cache: null,
            }),
            items: [{
                    icon: "mdi-text-box",
                    title: this.$t('welcome.all_data'),
                    to: "homepostulant",
                    nbre: this.$page.props.nbre_demandes
                },
                {
                    icon: "mdi-shield-check",
                    title: this.$t('welcome.request_waiting'),
                    to: "demande.attentes",
                    nbre: this.$page.props.nbre_attente
                },

                {
                    icon: "mdi-shield-check",
                    title: this.$t('welcome.request_approved'),
                    to: "demande.autoriser",
                    nbre: this.$page.props.nbre_auto
                },
                {
                    icon: "mdi-sync-circle",
                    title: this.$t('welcome.request_resent'),
                    to: "demande.renvoyer",
                    nbre: this.$page.props.nbre_renvoi
                },
                {
                    icon: "mdi-close-box",
                    title: this.$t('welcome.request_canceled'),
                    to: "demande.annuler",
                    nbre: this.$page.props.nbre_annule
                },
                {
                    icon: "mdi-close-octagon",
                    title: this.$t('welcome.request_rejected'),
                    to: "demande.rejeter",
                    nbre: this.$page.props.nbre_rejet

                },
                {
                    icon: "mdi-close-octagon",
                    title: this.$t('welcome.request_reviewed'),
                    to: "demande.revisees",
                    nbre: this.$page.props.nbre_revisees

                },
                {
                    icon: "mdi-receipt",
                    title: "Paiements",
                    to: "postulant.paiements",
                    nbre: null
                },
            ],
            links: [

            ],
        }
    },
    created() {
        this.$inertia.on('start', () => {
            this.isLoading = true
        })
        this.$inertia.on('finish', () => {
            this.isLoading = false
        })
    },
    computed: {
        appName() {
            return this.$page.props.appName;
        },
        user() {
            return this.$page.props.auth.user;
        },
        docUrl() {
            if (!this.docType || !this.$page.props.terms || !this.$page.props.terms[this.docType]) {
                return null;
            }
            return this.$page.props.terms[this.docType].url;
        },
        docTitle() {
            if (this.docType === 'cgu') {
                return "Conditions générales d'utilisation";
            }
            if (this.docType === 'deposit') {
                return "Conditions de dépôt";
            }
            return "Document";
        },
        isPdf() {
            return this.docUrl ? this.docUrl.toLowerCase().endsWith('.pdf') : false;
        },
    },
    methods: {
        formatPrice(price) {
            // Convertir le prix en une chaîne de caractères
            let priceStr = price.toString();

            // Diviser la chaîne en groupes de trois chiffres de droite à gauche
            let parts = [];
            while (priceStr.length > 3) {
            parts.unshift(priceStr.slice(-3));
            priceStr = priceStr.slice(0, -3);
            }
            parts.unshift(priceStr); // Ajouter le premier groupe

            // Rejoindre les parties avec un séparateur (par exemple, une virgule)
            return parts.join(' ');
        },
        getBalance() {
            this.isLoading = true;
            axios.get(`/getBalance`)
                .then(response => {
                    console.log('response',response.data.balance);
                    
                this.balance = response.data.balance;
                this.showBalance = true;
                })
                .catch(error => {
                console.error("Erreur lors de la récupération du solde :", error);
                })
                .finally(() => {
                this.isLoading = false;

                // Masquer le solde et réafficher le bouton après 30s
                setTimeout(() => {
                    this.showBalance = false;
                }, 10000);
            });
        },
        changeLanguage(lang) {
            this.$i18n.locale = lang;
        },
        create() {
            if (this.$page.props.user.postulant.signature_cachet) {
                this.$inertia.get("/demande/create");
            } else {
                this.$toast.warning(this.$t('welcome.message_toast_signature'), {
                    position: "top-center",
                });
            }

        },
        logout() {
            this.$inertia.post("/logout");
        },
        goToPage(page) {
            this.$inertia.visit(this.route(page));
        },
        submit() {
            this.$alert.confirm(this.$t('welcome.question_confirm'), this.$t('welcome.message_confirm_save'), () => {
                if (this.form.signature_cache !== null) {
                    this.form.post(route("demande.signature"), {
                        onSuccess: () => {
                            this.form.reset();
                            this.dialog = false
                            this.$toast.success(this.$t('welcome.response_signature_load'), {
                                position: "top-center",
                            });
                        },
                    });
                }
            })
        },
        change(){
            this.$inertia.get('/reset_password')
        },
        profil(){
            this.$inertia.get('/detail')
        },
        openDoc(type) {
            this.docType = type;
            this.docDialog = true;
        }
    }
}
</script>

<style scoped>
.doc-card {
    height: 85vh;
    display: flex;
    flex-direction: column;
}

.doc-body {
    flex: 1;
    padding: 0 16px 16px 16px;
}

.doc-content {
    height: 100%;
}

.doc-frame {
    width: 100%;
    height: 100%;
}

.doc-alt {
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
</style>
