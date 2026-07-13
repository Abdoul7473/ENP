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
                                <v-list-item-subtitle>Profil: Pro</v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-card>
                <v-list dense>
                    <v-list-item-group color="primary">
                        <v-list-item @click="navigate('/profile')">
                            <v-list-item-icon>
                                <v-icon v-text="'mdi-account'"></v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title v-text="'Mon profil'"></v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item @click="navigate('/password-reset')">
                            <v-list-item-icon>
                                <v-icon v-text="'mdi-lock-open'"></v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title v-text="'Changement de mot de passe'"></v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item @click="logout">
                            <v-list-item-icon>
                                <v-icon v-text="'mdi-logout'"></v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title v-text="'Déconnexion'"></v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-item-group>
                </v-list>
            </v-menu>
            <v-btn v-for="link in links" :key="link" text>
                {{ link }}
            </v-btn>
            <!-- <v-btn text @click="dialog=true" style="color: white;">charger signature</v-btn>
            <v-btn text @click="create()" style="color: white;" >Nouvelle demande</v-btn> -->
            <v-spacer></v-spacer>

            <v-responsive max-width="260">
                <v-text-field dense flat hide-details rounded solo-inverted></v-text-field>
            </v-responsive>
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
                                <v-chip>{{item.nbre}}</v-chip>
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
                                        Patienter un instant ...
                                        <v-progress-linear indeterminate color="primary" height="10" rounded class="mb-0">
                                            <template v-slot:prepend>
                                                <v-icon color="primary">mdi-loading</v-icon>
                                            </template>
                                        </v-progress-linear>
                                    </v-card-text>
                                </v-card>
                            </v-dialog>
                            <!-- <v-dialog v-model="dialog" max-width="500px">

                                <v-card style="margin-top: 3%;">
                                    <v-card-title color="primary">chargement et affichage de signature</v-card-title>
                                    <v-card-text style="margin-top: 3%;">
                                        <v-row>
                                            <v-col>
                                                <v-file-input label="Signature et cache/vSignature and stamp" outlined prepend-icon="mdi-camera" accept="image/*" dense v-model="form.signature_cache"></v-file-input>
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
                            </v-dialog> -->
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
            key: 0,
            dialog: false,
            isLoading: false,
            form: this.$inertia.form({
                signature_cache: null,
            }),
            items: [
            // {
            //         icon: "mdi-account",
            //         title: " Demandes annulées",
            //         to: "demande.annuler",
            //         nbre: this.$page.props.nbre_annule
            //     },

            //     {
            //         icon: "mdi-account",
            //         title: " Demandes autorisées",
            //         to: "demande.autoriser",
            //         nbre: this.$page.props.nbre_auto
            //     },
            //     {
            //         icon: "mdi-account",
            //         title: " Demandes renvoyées",
            //         to: "demande.renvoyer",
            //         nbre: this.$page.props.nbre_renvoi
            //     },
            //     {
            //         icon: "mdi-account",
            //         title: " Demandes rejetées",
            //         to: "demande.rejeter",
            //         nbre: this.$page.props.nbre_rejet

            //     },
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
    },
    methods: {
        create() {
            if (this.$page.props.user.postulant.signature_cachet) {
                this.$inertia.get("/demande/create");
            } else {
                this.$toast.warning("Veuillez charger votre signature et cachet", {
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
            this.$alert.confirm('Etes-vous sûr ?', "vous etes sûr de vouloir enregistrer?", () => {
                if (this.form.signature_cache !== null) {
                    this.form.post(route("demande.signature"), {
                        onSuccess: () => {
                            this.form.reset();
                            this.dialog = false
                            this.$toast.success("Signature chargée avec succès", {
                                position: "top-center",
                            });
                        },
                    });
                }
            })
        },
    }
}
</script>
