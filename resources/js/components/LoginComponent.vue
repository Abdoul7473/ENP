<template>
<v-card>
    <v-row class="fill-height" transition="slide-x-transition">
        <v-col cols="6" md="6" style="background-color: white;">
            <v-card-text class="mt-14">
                <h4 class="text-center">S'INSTRUIRE POUR MIEUX SERVIR</h4>
                <!-- <h6 class="text-center  grey--text ">Connectez-vous à votre compte pour pouvoir continuer à créer <br>et à modifier vos flux d'intégration</h6> -->
                <v-row align="center" justify="center">
                    <v-col cols="12" sm="8">
                        <v-form @submit.prevent="login">
                            <TextField v-model="form.email" prepend-inner-icon="mdi-email" label="E-mail " type="email" required :error-messages="form.errors.email" />
                            <TextField v-model="form.password" prepend-inner-icon="mdi-lock" label="Mot de passe " required color="primary" :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'" :type="showPassword ? 'text' : 'password'" :error-messages="form.errors.password" @click:append="showPassword = !showPassword" />
                            <div class="d-flex justify-center">
                                <div class="g-recaptcha" :data-sitekey="siteKey"></div>
                            </div>
                            <br>
                            <v-row>
                                <v-col cols="12" sm="7">
                                    <!-- <v-checkbox v-model="form.remember_me" label="Se rappeler de moi / Remember me" class="mt-n1" color="primary"></v-checkbox> -->
                                </v-col>
                               
                            </v-row>
                            <v-btn :loading="form.processing" type="submit" color="primary" dark block tile><v-icon>mdi-login</v-icon></v-btn>
                        </v-form>
                        <div class="d-flex  justify-space-between align-center mx-10 mb-16">
                        </div>
                    </v-col>
                </v-row>
                <!-- <v-btn class="ma-2 pt-10" icon @click="goBack">
                    <v-icon>mdi-arrow-left</v-icon>
                </v-btn> -->
            </v-card-text>
        </v-col>
        <v-col cols="12" md="6" class="rounded-bl-xl" style="background-color: white;">
            <div class="container">
                <img src="logo_enp.png" alt="Image de connexion" class="image">
            </div>
        </v-col>
    </v-row>
</v-card>
</template>

<script>
export default {
    data() {
        return {
            email: '',
            password: '',
            rememberMe: false,
            showPassword: false,
            isLoading: false,
            siteKey: this.$page.props.recaptcha_site_key, // Clé publique de reCAPTCHA
            form: this.$inertia.form({
                email: null,
                password: null,
                remember_me: false,
                // recaptcha: null, // Stocker la réponse reCAPTCHA
            }),
        };
    },
    mounted(){
        // window.onload = function() {
        //     if (window.history && window.history.pushState) {
        //         window.history.pushState('forward', null, './#forward');
        //         window.onpopstate = function() {
        //             window.history.pushState('forward', null, './#forward');
        //         };
        //     }
        // }

        // Charger le script reCAPTCHA
        // const script = document.createElement("script");
        // script.setAttribute("src", "https://www.google.com/recaptcha/enterprise.js");
        // document.head.appendChild(script);
    },
    methods: {
        login() {
            // console.log('hhhj')
            // const recaptchaResponse = document.querySelector(".g-recaptcha-response").value;

            // if (!recaptchaResponse) {
            //     alert("Veuillez valider le reCAPTCHA !");
            //     return;
            // }

            // this.form.recaptcha = recaptchaResponse;
            this.form.post("/login", {
                
                onFinish: () => {
                    if (this.$page.props.flash.error) {
                        this.$alert.error(this.$page.props.flash.error)
                    }
                }
            })
        },
        
        goBack() {
            this.$inertia.visit(this.route('/'));
        },
        switchToRegister() {
            this.$emit('switchStep', 2); // Émet un événement pour passer à l'étape d'inscription
        }
    },
};
</script>

<style scoped>
.v-application .rounded-bl-xl {
    border-bottom-left-radius: 300px !important;
}

.v-application .rounded-br-xl {
    border-bottom-right-radius: 300px !important;
}

.container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
}

.image {
    width: 100%;
    max-width: 300px;
    /* ajustez la taille de l'image selon vos besoins */
}

.content {
    margin-top: 20px;
    /* ajustez la marge supérieure du contenu selon vos besoins */
    text-align: center;
}
</style>
