<template>
<v-app>
    <v-main>
        <v-container fluid fill-height>
            <v-row align="center" justify="center">
                <v-col cols="12" sm="10">
                    <v-card class="elevation-6 mt-10">
                        <v-window v-model="step">
                            <!-- Connexion -->
                            <v-window-item :value="1">
                                <LoginComponent @switchStep="switchStep" />
                            </v-window-item>
                            <!-- Inscription -->
                            <v-window-item :value="2">
                                <RegisterComponent @switchStep="switchStep" :pays="pays" :terms="terms" />
                            </v-window-item>
                        </v-window>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-main>
</v-app>
</template>

<script>
import RegisterComponent from '../components/RegisterComponent.vue';
import LoginComponent from '../components/LoginComponent.vue';

export default {
    components: {
        RegisterComponent,
        LoginComponent
    },
    props: ["stepac", "pays", "terms"], // La prop stepac indique si l'utilisateur a cliqué sur "Connexion" (2) ou "Inscription" (1)
    data() {
        return {
            step: 1 // Par défaut, commencez avec le composant de connexion
        };
    },
    watch: {
        stepac(newValue) {
            this.step = newValue;
        }
    },
    mounted(){
        window.history.pushState(null, null, window.location.href);
        window.onpopstate = function () {
            window.history.go(1);
        };
    },
    methods: {
        switchStep(step) {
            this.step = step;
        }
    },
    created() {
        this.switchStep(this.stepac)
    }
};
</script>
