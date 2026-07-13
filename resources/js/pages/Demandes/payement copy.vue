<template>
<postulant-layout>
    <Toolbar Title="Payement"> </Toolbar>
    <v-banner class="mb-4">
        <div class="d-flex flex-wrap justify-space-between">
            <h5 class="text-h5 font-weight-bold">{{$t('payment.title')}}</h5>
        </div>
    </v-banner>
    <v-card>
        <v-btn @click="goBack()" color="primary"><v-icon>mdi-reply</v-icon>{{$t('form.btn_prev')}}</v-btn>
        <v-row style="margin-left: 10px;">
            <v-col cols="3"></v-col>
            <v-col>
                <v-alert border="top" colored-border type="info" elevation="2">
                    <li  v-if="demande.statut_id !== 8">{{$t('payment.type_demande')}} :<b> {{ demande.type_demande.libelle }} </b></li>
                    <li v-if="demande.permanant && demande.statut_id !== 8">{{$t('payment.block_of')}} : <b>{{ demande.nbre_mois }} {{$t('payment.months')}}</b> </li>
                    <li v-if="demande.statut_id !== 8">{{$t('payment.montant_total_demande')}} :<b> {{$formatAmount(frais)}} FCFA</b></li>
                    <li v-if="demande.statut_id == 8">{{$t('payment.montant_total_revision')}} :<b> {{$formatAmount(frais)}} FCFA</b></li>

                </v-alert>

            </v-col>
            <v-col class="pt-12">
                <!-- <v-btn @click="dialog = true" color="primary">payer</v-btn> -->
            </v-col>
        </v-row>
        <v-dialog v-model="dialog" max-width="600">
            <v-card>
                <v-toolbar dense dark color="primary" class="text-h6">{{$t('payment.title')}}</v-toolbar>
                <v-card-text class="pt-4">
                    <v-row>
                        <v-col cols="12">
                            <selectField label="Reference" required v-model="form.ref" name="Reference" outlined color="secondary" :items="items" autocomplete="false"></selectField>
                        </v-col>
                        <v-col cols="12">
                            <VuePhoneNumberInput v-model="form.tel" default-country-code="NE" required isValid show-code-on-list no-flags :translations="translation_1" />
                        </v-col>
                    </v-row>

                    <v-col class="pt-12">
                        <v-card-actions>
                            <v-spacer />
                            <v-btn @click="dialog = false" color="red">{{$t('form.btn_prev')}}</v-btn>
                            <!-- <v-btn @click="payer" color="primary">Confirmer</v-btn> -->
                            <a href="/get-checkout" target="_blank" @click.prevent="payer"><v-btn @click="payer" color="primary">{{$t('table.submit')}}</v-btn></a>
                        </v-card-actions>
                    </v-col>
                </v-card-text>
            </v-card>
        </v-dialog>
        <div>
            <form ref="checkoutForm" action="/checkout" method="POST" style="display: none;">
            <!-- Ajoutez ici les champs de votre formulaire si nécessaire -->
            <!-- Par exemple : -->
            <input type="hidden" name="statut_id" :value="demande.statut_id">
            <input type="hidden" name="demande_id" :value="demande.id">
            <input type="hidden" name="_token" :value="csrfToken">
            <input type="hidden" name="frais" :value="frais">
            <input type="hidden" name="type" :value="demande.type_demande.libelle">
            </form>
            <!-- <button @click="submitForm">Envoyer</button> -->
            <!-- <v-btn @click="submitForm" color="primary">payer</v-btn> -->
            <v-col class="col-8">
                <v-btn @click="submitForm" color="primary">{{$t('payment.payer')}}</v-btn>
            </v-col>
        </div>
    </v-card>
</postulant-layout>
</template>

<script>
import PostulantLayout from "../../layouts/PostulantLayout.vue";
import VuePhoneNumberInput from 'vue-phone-number-input';
import 'vue-phone-number-input/dist/vue-phone-number-input.css';
import { VDataTable } from "vuetify/lib";
export default {
    components: {
        VuePhoneNumberInput,
        PostulantLayout
    },
    props: ["frais", "demande"],
    data() {
        return {
            translation_1: {
                countrySelectorLabel: 'Code pays',
                countrySelectorError: 'Choisir un pays',
                phoneNumberLabel: 'Numéro de téléphone',
                example: 'Exemple :'
            },
            dialog: false,
            csrfToken: '',
            fraisTotal:null,
            form: this.$inertia.form({
                id: this.demande.id,
                ref: null,
                tel: null,
                frais: this.frais
            }),
            items: ['Al IZZA', 'NITA', 'AMANA', 'ZEYNA'],
        }
    },
    mounted(){
        this.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    methods: {
        submitForm() {
      this.$refs.checkoutForm.submit();
    },
        payer() {
            this.$alert.confirm('Etes-vous sûr ?', "Vous allez payer ce tarif", () => {
                window.open('/get-checkout', '_blank'),{
                    onSuccess: () => {
                        this.dialog = false
                    }
                }
                // this.$inertia.get(route("checkout.index")),{
                // this.form.post(route('checkout'))
                // , {
                    // onSuccess: () => {
                    //     this.dialog = false
                    // }}
                //         if (this.$page.props.flash.success) {
                //             this.$alert.success(this.$page.props.flash.success)
                //         }
                //         if (this.$page.props.flash.error) {
                //             this.$alert.error(this.$page.props.flash.error)
                //         }
                //     }
                // })
            })
        },
        goBack(){
            this.$inertia.get("/homepostulant");
        }
    }
}
</script>
