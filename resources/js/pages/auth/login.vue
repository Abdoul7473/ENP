<template>
<guest-layout>
    <v-main>
        <v-container fluid>
            <v-row align="center" justify="center" style="height: 100vh">
                <v-col cols="12" sm="12" md="10" lg="4">
                    <v-card>
                        <v-card-title class="d-flex align-center justify-center">
                            <Link :href="route('/')">
                            <application-logo style="height: 75" />
                            </Link>
                        </v-card-title>
                        <!-- <v-card-text>
                <p class="font-weight-semibold text--secondary mb-2">
                  Welcome to Laravel! 👋🏻
                </p>
                <p class="mb-2">
                  Please sign-in to your account and start the adventure
                </p>
              </v-card-text> -->
                        <v-card-text>
                            <v-form @submit.prevent="login">
                                <v-text-field v-model="form.email" prepend-inner-icon="mdi-email" label="E-mail / Email" type="email" outlined dense :error-messages="form.errors.email" />
                                <v-text-field v-model="form.password" prepend-inner-icon="mdi-lock" label="Mot de passe / Password" outlined dense :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'" :type="showPassword ? 'text' : 'password'" :error-messages="form.errors.password" @click:append="showPassword = !showPassword" />
                                 <!-- reCAPTCHA -->
                                 <div class="d-flex justify-center">
                                    <div class="g-recaptcha" data-sitekey="6LfEs8sqAAAAABo38hqkfddLk7Oao8Xj1ohiRg-b"></div>
                                </div>
                                <div class="d-flex align-center justify-space-between flex-wrap">
                                    <v-checkbox v-model="form.remember_me" label="Remember me" />
                                    <Link :href="route('password.request')">
                                    Mot de passe oublié ?
                                    </Link>
                                </div>
                                <v-btn :loading="form.processing" type="submit" block color="primary" class="mt-3"><v-icon>login</v-icon></v-btn>
                            </v-form>
                        </v-card-text>
                        <!-- <v-card-text
                class="d-flex align-center justify-center flex-wrap mt-2"
              >
                <span class="me-2"> New on our platform? </span>
                <Link :href="route('register')"> Create an account </Link>
              </v-card-text> -->
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-main>
</guest-layout>
</template>

<script>
import ApplicationLogo from "../../components/ApplicationLogo.vue";
import GuestLayout from "../../layouts/GuestLayout.vue"

export default {
    components: {
        ApplicationLogo,
        GuestLayout
    },
    data() {
        return {
            showPassword: false,
            isLoading: false,
            siteKey: $this.$page.props.recaptcha_site_key, // Clé publique de reCAPTCHA
            form: this.$inertia.form({
                email: null,
                password: null,
                remember_me: false,
                recaptcha: null, // Stocker la réponse reCAPTCHA
            }),
        };
    },
    // mounted(){
    //     window.onload = function() {
    //         if (window.history && window.history.pushState) {
    //             window.history.pushState('forward', null, './#forward');
    //             window.onpopstate = function() {
    //                 window.history.pushState('forward', null, './#forward');
    //             };
    //         }
    //     }

    //     // Charger le script reCAPTCHA
    //     const script = document.createElement("script");
    //     script.setAttribute("src", "https://www.google.com/recaptcha/enterprise.js");
    //     document.head.appendChild(script);
    // },
    created(){
        
    },
    methods: {
        async login() {
            const recaptchaResponse = document.querySelector(".g-recaptcha").value;

            if (!recaptchaResponse) {
                alert("Veuillez valider le reCAPTCHA !");
                return;
            }

            this.form.recaptcha = recaptchaResponse;
            this.form.post("/login");
        },
    },
};
</script>
