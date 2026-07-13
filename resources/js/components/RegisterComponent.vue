<template>
<v-card>
    <v-row>
        <v-col cols="12" md="6" class="secondary rounded-br-xl">
            <div class="container">
                <img src="anac.png" alt="Image de connexion" class="image">
                <div class="content">
                    <v-card-text class="white--text">
                        <h3 class="text-center">Avez-vous déjà un compte ?</h3>
                        <h3 class="text-center">Already have an account ?</h3>
                    </v-card-text>
                    <div class="text-center">
                        <v-btn tile outlined dark @click="switchToLogin"><v-icon>mdi-login</v-icon></v-btn>
                    </div>
                </div>
            </div>
        </v-col>

        <v-col cols="12" md="6">
            <v-card-text class="mt-7">
                <h3 class="text-center">Créer un compte / Create an account</h3><br>
                <!-- <h5 class="text-center  grey--text ">Préparons-nous pour que vous puissiez commencer à créer votre <br>
                    première expérience d'intégration</h5> -->
                <v-row align="center" justify="center" dense>
                    <v-col cols="12" sm="8">

                        <v-form ref="myForm" @submit.prevent="register" v-model="valid">
                            <v-row dense>
                                <v-col cols="12" sm="6">
                                    <TextField label="Nom / Raison Sociale" rules="required" name="Nom ou Raison Sociale" v-model="form.nom_raison_sociale" outlined dense color="secondary" autocomplete="false" required class="mt-4"></TextField>
                                </v-col>
                                <v-col cols="12" sm="6">
                                    <TextField label="Fonction / Function" type="Fonction" v-model="form.fonction" outlined dense color="secondary" autocomplete="false"></TextField>
                                </v-col>
                            </v-row>
                            <v-row dense>
                                <v-col cols="12">
                                    <VuePhoneNumberInput v-model="form.tel" default-country-code="NE" required isValid show-code-on-list no-flags :translations="translation_1" />
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="12">
                                    <VuePhoneNumberInput v-model="form.tel2" default-country-code="NE" show-code-on-list no-flags :translations="translation_2" />
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="12" sm="6">
                                    <TextField label="Adresse / Address" v-model="form.adresse" outlined dense color="secondary" autocomplete="false"></TextField>
                                </v-col>
                                <v-col cols="12" sm="6">
                                    <TextField label="E-mail / Email" type="email" rules="required" name="E-mail" v-model="form.email" required outlined dense color="secondary" autocomplete="false"></TextField>
                                </v-col>
                            </v-row>
                            <v-row dense>
                                <v-col cols="12" sm="6">
                                    <selectField label="Pays / Country" required v-model="form.pay_id" outlined @change="getVille(form.pay_id)" name="Pays" color="secondary" :items="pays" item-text="name" item-value="id" autocomplete="false"></selectField>
                                </v-col>
                                <v-col cols="12" sm="6">
                                    <selectField label="Villes / Town" required :disabled="!form.pay_id" v-model="form.ville_id" name="Ville" outlined color="secondary" :items="villes" item-text="name" item-value="id" autocomplete="false"></selectField>
                                </v-col>
                            </v-row>
                            <v-row dense>
                                <v-col cols="12" sm="10">
                                    <v-checkbox label="Etes-vous un operateur privé? / Are you a private operator" v-model="form.check" @click="checker()"></v-checkbox>
                                </v-col>
                                <v-col cols="12" v-if="form.check" sm="6">
                                    <v-file-input v-model="form.fichier" color="orange" @change="chargeFile" counter label="Fichier" base-color="green" placeholder="Téleverser votre fichier / Upload file" prepend-icon="mdi-paperclip" variant="outlined" :show-size="1000">
                                    </v-file-input>
                                </v-col>
                            </v-row>
                            <v-row dense>
                                <v-col cols="12">
                                    <v-checkbox v-model="form.accept_cgu" hide-details>
                                        <template v-slot:label>
                                            <span>J'accepte les </span>
                                            <a href="#" @click.stop.prevent="openDoc('cgu')">conditions générales d'utilisation</a>
                                        </template>
                                    </v-checkbox>
                                </v-col>
                                <v-col cols="12">
                                    <v-checkbox v-model="form.accept_deposit" hide-details>
                                        <template v-slot:label>
                                            <span>J'accepte les </span>
                                            <a href="#" @click.stop.prevent="openDoc('deposit')">conditions de dépôt</a>
                                        </template>
                                    </v-checkbox>
                                </v-col>
                            </v-row>
                            <br>
                            <v-btn color="secondary" :loading="form.processing" :disabled="!form.accept_cgu || !form.accept_deposit" type="submit" dark block tile>
                                <v-icon>mdi-content-save</v-icon>
                            </v-btn>
                        </v-form>
                    </v-col>
                </v-row>
                <!-- <v-btn class="ma-2" icon @click="goBack">
                    <v-icon>mdi-arrow-left</v-icon>Retour
                </v-btn> -->
            </v-card-text>
        </v-col>
    </v-row>
<v-btn class="ma-2" icon @click="goBack">
    <v-icon>mdi-arrow-left</v-icon>
</v-btn>

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
</v-card>
</template>

<script>
import VuePhoneNumberInput from 'vue-phone-number-input';
import 'vue-phone-number-input/dist/vue-phone-number-input.css';
export default {
    components: {
        VuePhoneNumberInput
    },
    props: ["pays", "terms"],
    data() {
        return {
            translation_1: {
                countrySelectorLabel: 'Code',
                countrySelectorError: 'Choisir un pays',
                phoneNumberLabel: 'Tel 1',
                example: 'Exemple :'
            },
            translation_2: {
                countrySelectorLabel: 'Code',
                countrySelectorError: 'Choisir un pays',
                phoneNumberLabel: 'Tel 2',
                example: 'Exemple :'
            },
            villes: [],
            valid: null,
            docDialog: false,
            docType: null,
            form: this.$inertia.form({
                check: false,
                accept_cgu: false,
                accept_deposit: false,
                nom_raison_sociale: '',
                email: '',
                tel: '',
                tel2: '',
                adresse: null,
                fonction: null,
                fichier: null,
                pay_id: null,
                ville_id: null
            })
        };
    },
    computed: {
        docUrl() {
            if (!this.docType || !this.terms || !this.terms[this.docType]) {
                return null;
            }
            return this.terms[this.docType].url;
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
        checker() {
            this.form.fichier = null
        },
        chargeFile() {
            if (this.form.fichier.type !== "application/pdf") {
                this.$alert.error("veuillez charger un PDF")
                this.form.fichier = ''
            }
        },
        register() {
            this.$alert.confirm(this.$t('welcome.question_confirm'), this.$t('welcome.message_confirm_save'), () => {
                this.form.post(route("register"), {
                    onFinish: () => {
                        if (this.$page.props.flash.success) {
                            this.$alert.success(this.$page.props.flash.success)
                        }
                        if (this.$page.props.flash.error) {
                            this.$alert.error(this.$page.props.flash.error)
                        }
                    },
                    onError: this.$alert.messages
                });
            })
        },
        goBack() {
            this.$inertia.visit(this.route('/'));
        },
        switchToLogin() {
            this.$emit('switchStep', 1); // Émet un événement pour passer à l'étape de connexion
        },
        openDoc(type) {
            this.docType = type;
            this.docDialog = true;
        },
        getVille(item) {
            axios.get('/page', {
                    params: {
                        pay_id: item
                    }
                })
                .then(res => {
                    this.villes = res.data
                })
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
