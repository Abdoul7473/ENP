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
            <v-row>
                <v-col></v-col>
                <!-- Sélection du mode de paiement -->
                 <v-col>
                    <v-radio-group v-model="paymentMethod" row>
                        <v-radio value="compte">
                            <template v-slot:label>
                                <v-icon color="blue">mdi-bank</v-icon> Mon Compte
                                
                            </template>
                        </v-radio>
                        <v-radio value="visa">
                            <template v-slot:label>
                                <v-icon color="green">mdi-credit-card</v-icon> Visa
                            </template>
                        </v-radio>
                    </v-radio-group>
                </v-col>
            <v-col></v-col>
            </v-row>
           
            <div>
                <form ref="checkoutForm" :action=paymentUrl method="POST" style="display: none;" :target="paymentMethod === 'visa' ? '_blank' : '_self'">
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
                    <v-btn @click="paymentMethod === 'compte' ? payer() : submitForm()" color="primary">{{$t('payment.payer')}}</v-btn>
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
                paymentMethod: 'compte', // Par défaut, Visa est sélectionné
                form: this.$inertia.form({
                    id: this.demande.id,
                    type: this.demande.type_demande.libelle,
                    statut: this.demande.statut_id,
                    frais: this.frais
                }),
                items: ['Al IZZA', 'NITA', 'AMANA', 'ZEYNA'],
            }
        },
        computed: {
            paymentUrl() {
                return this.paymentMethod === 'compte' ? '/checkout-visa' : '/checkout';
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
                this.$alert.confirm('Etes-vous sûr ?', "Vous allez effectuer ce paiement sur votre compte cette action est irreversible", () => {
                    this.form.post(route('deposit.paiement')),{
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
    
