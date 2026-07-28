<template>
<v-app style="background-color: #f5f5f5">
    <v-navigation-drawer v-model="drawer" app  color="primary">
        <v-sheet color="secondary" class="pa-4 rounded-tr-xl text-center">
            <v-progress-circular model-value="80" color="primary" :size="100" :width="2" class="">
                <v-avatar size="85">
                    <v-img src="../../male.png" alt="John"></v-img>
                </v-avatar>
            </v-progress-circular>
            <div class="mt-4" v-if="$page.props.auth.user.type_user_id == null">{{ user.name }}</div>
            <div class="mt-4" v-else>{{ user.name }}</div>
            <span class="mb-6 text-caption">{{ user.email }}</span>
        </v-sheet>
        <v-divider></v-divider>

        <v-list nav class="mb-4">
            <v-list-item-group >
                <v-list-item v-for="(item, i) in Single_items" :key="i" v-if="!item.permission || hasPermission(item.permission)" :disabled="!item.disabled" @click="goToPage(item.to)">
                    <v-list-item-action>
                        <v-icon color="white">{{ item.icon }}</v-icon>
                        <!-- {{ item.disabled }} -->
                    </v-list-item-action>
                    <v-list-item-content style="color: white;">
                        <v-list-item-title v-text="item.title" />
                    </v-list-item-content>
                </v-list-item>
            </v-list-item-group>
            <v-list-item @click="logout">
                <v-list-item-action>
                    <v-icon color="white">mdi-exit-to-app</v-icon>
                </v-list-item-action>
                <v-list-item-content style="color: white;">
                    <v-list-item-title>Déconnecter</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-list>
    </v-navigation-drawer>
    <v-main style="padding-bottom: 80px;">
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
        </div>
        <!-- <AppFooter /> -->
    </v-main>
</v-app>
</template>

<script>
import ApplicationLogo from "../components/ApplicationLogo.vue"
import AppFooter from "../components/AppFooter.vue"
export default {
    components: {
        ApplicationLogo,
        AppFooter
    },
    data() {
        return {
            userPermissions: [],
            drawer: !this.$vuetify.breakpoint.smAndDown,
            interval: {},
            value: 0,
            key: 0,
            isLoading: false,
            miniVariant: false,
            Single_items:  
            [
                {
                    icon: "mdi-apps",
                    title: "Accueil",
                    to: "home",
                    disabled : true
                },
                {
                    icon: "mdi-account",
                    title: "Utilisateurs",
                    to: "user.index",
                    disabled : true
                },
                {
                    icon: "mdi-database-outline",
                    title: "Rôles et permissions",
                    to: "roles.index",
                    disabled : true
                },
                {
                    icon: "mdi-calendar",
                    title: "Année Académique",
                    to: "annee.index",
                    disabled : true
                },
                {
                    icon: "mdi-cash-register",
                    title: "Cartes",
                    to: "carte.index",
                    disabled :  this.$page.props.annee_encours ? true : false
                },
                
                {
                    icon: "mdi-account",
                    title: "Visiteurs",
                    to: "visiteurs.index",
                    disabled :  this.$page.props.annee_encours ? true : false
                },
                {
                    icon: "mdi-account",
                    title: "Compagnies",
                    to: "compagnie.index",
                    disabled :  this.$page.props.annee_encours ? true : false
                },
                {
                    icon: "mdi-database-outline",
                    title: "Rapport",
                    to: "rapport.index",
                    disabled :  this.$page.props.annee_encours ? true : false
                },
                {
                    icon: "mdi-account",
                    title: "Encadreurs",
                    to: "encadreur.index",
                    disabled :  this.$page.props.annee_encours ? true : false
                },
                {
                    icon: "mdi-database-outline",
                    title: "Requête",
                    to: "query.create"
                },
            ],
            
            miniVariant: false,
        };
    },
    created() {
        this.$gates.setRoles(this.$page.props.user_roles);
        this.$gates.setPermissions(this.$page.props.user_permissions);
        this.$inertia.on('start', () => {
            this.isLoading = true
        })

        this.$inertia.on('finish', () => {
            this.isLoading = false
        })
    },
    mounted() {
        this.$gates.getRoles();
        this.$gates.getPermissions();
        
    },
    computed: {
        appName() {
            return this.$page.props.appName;
        },
        user() {
            return this.$page.props.auth.user;
        },
        indexMenu() {
            const inertiaUrl = this.$inertia.page.url.split("?")[0];
            const index = this.items.findIndex((item) => {
                const windowUrl = this.route(item.to);
                return windowUrl.includes(inertiaUrl);
            });
            return index;
        },
    },
    watch: {
        $page: {
            handler() {
                const message = this.$page.props.flash.message;
                if (message != null) {
                    switch (message.type) {
                        case "success":
                            this.$toast.success(message.text);
                            break;
                        case "error":
                            this.$toast.error(message.text);
                            break;
                    }
                }
            },
        },
    },
    methods: {
        hasPermission(permission) {
            const perms = this.$page.props.user_permissions || [];
            return perms.includes(permission);
        },
        logout() {
            this.$inertia.post("/logout");
        },
        goToDemande(type) {
            const t = this.route('demandes.index', {
                type: type
            })
            this.$inertia.get(t);
        },
        goToPage(page) {
            const t = this.route(page)
            this.$inertia.get(t);
        },
    },

};
</script>

<style scoped>
.v-application .rounded-br-xl {
    border-bottom-right-radius: 50px !important;
}
</style>
