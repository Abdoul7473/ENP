<template>
<guest-layout>
    <v-main>
        <v-container fluid>
            <v-row align="center" justify="center" style="height: 100vh">
                <v-col cols="12" sm="12" md="10" lg="4">
                    <v-card>
                        <v-card-text>
                            <v-alert type="info" color="primary">
                                NOTE : votre mot de passe doit contenir
                                <li>Au moins 8 caractères!</li>
                                <li>Au moins un symbole <b> <u>Exmples :</u> !@#$%^&*(),.?":{}|<> </b></li>
                                <li>Au moins une lettre majuscules! </li>
                                <li>Au moins une lettre minuscule! </li>
                                <li>Au moins un chiffre! </li>
                                <li>Au moins trois lettre diffentes! </li>
						                </v-alert>
                            <h3 v-if="message" style="color: red; margin-left: 80px;" >Les copies colés ne sont pas autorisés! </h3>
                        </v-card-text>
                        <v-card-text>
                            <v-form @submit.prevent="submit">
                                <v-text-field @paste="handlePaste" v-model="form.old_password" prepend-inner-icon="mdi-lock" label="Ancien mot de passe" :error-messages="form.errors.password" outlined dense :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'" :type="showPassword ? 'text' : 'password'" @click:append="showPassword = !showPassword" />
                                <v-text-field @paste="handlePaste" v-model="form.password" @input="validatePassword" prepend-inner-icon="mdi-lock" label="Mot de passe" :rules="[rules.required, rules.min, rules.strength]" :error-messages="form.errors.password" outlined dense :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'" :type="showPassword ? 'text' : 'password'" @click:append="showPassword = !showPassword" />
                                <v-progress-linear :color="score_password.color" :value="score_password.value"></v-progress-linear>
                                <br>
                                <v-text-field @paste="handlePaste" v-model="form.password_confirmation" @input="validatePassword" prepend-inner-icon="mdi-lock" label="Confirmation" :rules="[rules.required, rules.min, rules.strength]" :error-messages="form.errors.password_confirmation" outlined dense :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'" :type="showPassword ? 'text' : 'password'" @click:append="showPassword = !showPassword" />
                                <v-progress-linear :color="score_password_conf.color" :value="score_password_conf.value"></v-progress-linear>
                                <v-btn :loading="form.processing" :disabled="!isValid" type="submit" block color="primary" class="mt-3">Change Password</v-btn>
                            </v-form>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-main>
</guest-layout>
</template>

<script>
import ApplicationLogo from "../../components/ApplicationLogo.vue";
import GuestLayout from '../../layouts/GuestLayout.vue';
import {
    zxcvbn
} from '@zxcvbn-ts/core'
export default {
    props: ["id"],
    components: {
        ApplicationLogo,
        GuestLayout
    },
    data() {
        return {
            showPassword: false,
            isLoading: false,
            isValid : false,
            message : false,
            rules: {
                required: value => !!value || 'Entrer un mot de passe',
                min: v => v.length >= 8 || 'Utilisez 8 caractères ou plus pour votre mot de passe',
                strength: v => zxcvbn(v).score >= 3 || 'Veuillez choisir un mot de passe plus fort. Essayez un mélange de lettres, de chiffres et de symboles.',
            },
            form: this.$inertia.form({
                id: this.id,
                old_password: '',
                password: '',
                password_confirmation: '',
            }),
        };
    },
    methods: {
        validatePassword() {
            this.message = false;
            const result = zxcvbn(this.form.password) && zxcvbn(this.form.password_confirmation);
            const hasMinimumLength = this.form.password.length >= 8 && this.form.password_confirmation.length >= 8;
            const hasUppercase = /[A-Z]/.test(this.form.password) && /[A-Z]/.test(this.form.password_confirmation);
            const m = /[a-z]/.test(this.form.password) && /[a-z]/.test(this.form.password_confirmation);
            const hasSymbol = /[!@#$%^&*(),.?":{}|<>]/.test(this.form.password) && /[!@#$%^&*(),.?":{}|<>]/.test(this.form.password_confirmation); // Vous pouvez ajuster les symboles en fonction de vos besoins
            const hasNumber = /\d/.test(this.form.password) && /\d/.test(this.form.password_confirmation);
            this.isValid = result.score >= 3 && hasMinimumLength && hasUppercase && hasSymbol && hasNumber && m;
            // console.log(this.isValid)
        },
        submit() {
            // console.log('toto')
            this.$alert.confirm('Etes-vous sûr ?', "Vous allez changer votre mot de passe", () => {
                this.form.post(route("change_password_store"), {
                    onSuccess: () => {
                        if (this.$page.props.flash.success) {
                            this.$alert.success(this.$page.props.flash.success)
                        }
                        if (this.$page.props.flash.error) {
                            this.$toast.error(this.$page.props.flash.error)
                        }
                    },
                    onError: this.$alert.messages
                })
            })
            // this.form.post("/change_password",{});
        },
        handlePaste(event) {
            event.preventDefault();
            this.message = true
        },
    },
    computed: {
        score_password() {
            const result = zxcvbn(this.form.password);

            switch (result.score) {
                case 4:
                    return {
                        color: "light-blue",
                            value: 100
                    };
                case 3:
                    return {
                        color: "light-green",
                            value: 75
                    };
                case 2:
                    return {
                        color: "yellow",
                            value: 50
                    };
                case 1:
                    return {
                        color: "orange",
                            value: 25
                    };
                default:
                    return {
                        color: "red",
                            value: 0
                    };
            }
        },
        score_password_conf() {
            const result = zxcvbn(this.form.password_confirmation);

            switch (result.score) {
                case 4:
                    return {
                        color: "light-blue",
                            value: 100
                    };
                case 3:
                    return {
                        color: "light-green",
                            value: 75
                    };
                case 2:
                    return {
                        color: "yellow",
                            value: 50
                    };
                case 1:
                    return {
                        color: "orange",
                            value: 25
                    };
                default:
                    return {
                        color: "red",
                            value: 0
                    };
            }
        }
    }
};
</script>
