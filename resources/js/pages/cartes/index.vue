<template>
<admin-layout>
    <Toolbar Title="Cartes" :breadcrumbs="breadcrumbs">

    </Toolbar>
    <v-row>
        <v-col cols="4">
            <v-card class="mx-auto rounded-tr-xl" color="#26c6da" dark max-width="300" max-height="300">
                <v-card-title>

                    <span class="text-h6 font-weight-light">Total des codes QR </span>
                </v-card-title>

                <v-card-text class="text-h5 font-weight-bold">
                    {{total}}
                </v-card-text>

            </v-card>
        </v-col>
        <v-col cols="4">
            <v-card class="mx-auto rounded-tr-xl" color="primary" dark max-width="300" max-height="300">
                <v-card-title>

                    <span class="text-h6 font-weight-light">Les codes scannés </span>
                </v-card-title>

                <v-card-text class="text-h5 font-weight-bold">
                    {{scanne}}
                </v-card-text>

            </v-card>
        </v-col>
        <v-col cols="4">
            <v-card class="mx-auto rounded-tr-xl" color="secondary" dark max-width="300" max-height="300">
                <v-card-title>

                    <span class="text-h6 font-weight-light">Les codes restants </span>
                </v-card-title>

                <v-card-text class="text-h5 font-weight-bold">
                    {{restant}}
                </v-card-text>

            </v-card>
        </v-col>
    </v-row>

    <CustomDataTable :headers="headers" :items="lots">
        <template v-slot:addBtn>
            <v-btn @click="generate()"small color="primary">    
                <v-icon left>mdi-plus-circle</v-icon> Générer
            </v-btn>
            <v-btn  v-permission:any="'signature'"  @click="dialogSignature=true" class="ma-2" outlined type="button" small  color="primary">Signature</v-btn>
        </template>
        <template v-slot:item.date="{item}">
            {{ formatTime(item.created_at) }}
        </template>
        <template v-slot:item.action="{ item }">
            <BtnAction icon display-icon="mdi-qrcode" title="Détail du lot" @click="Detail(item)" target="__bank" color="green" small />
            <!-- <BtnAction icon display-icon="mdi-delete" title="Supprimer" @click="deleteItem(item)" color="error" small/> -->
            <a :href="route('invitation.pdf', { id: item.id})" target="__blank" title="Imprimer la demande">
                <v-icon size="small" class="me-2" icon="mdi-printer" color="info" small>mdi-printer</v-icon>
            </a>
        </template>

    </CustomDataTable>
    <v-dialog v-model="dialogDetail" max-width="1500" persistent>
        <v-card>
            <!-- <v-toolbar dense dark color="primary" class="text-h6"></v-toolbar> -->
            <v-card-text>
                <br>
                <div class="invitation-container">
                    <div v-for="(carte, index) in cartes" :key="index" class="invitation-card">
                        <div class="header">
                            <h1> INVITATION</h1>
                        </div>

                        <div class="content">
                            <p>
                                Vous êtes cordialement invité à participer à notre événement.
                            </p>

                            <div class="event-info">
                                <p><strong>Date :</strong> le 19 septembre 2026</p>
                                <p><strong>Lieu :</strong> eeee</p>
                            </div>

                            <div class="qr-section">
                                <div v-html="carte.qr"></div>
                            </div>

                        </div>
                    </div>
                </div>

            </v-card-text>
            <v-card-actions>
                <v-spacer />
                <v-btn @click="close()">Fermer</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
    <v-dialog v-model="dialog" max-width="500px" persistent>

        <v-card>
            <v-toolbar dense dark color="primary" class="text-h6">Génération des numéros</v-toolbar>
            <v-card-text style="margin-top: 3%;">
                <v-col md="12">
                    <TextField required label="Nombre de numero" type="number" hide-details dense v-model="form.nombre">
                    </TextField>
                </v-col>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn style="color: white;" color="red" @click="close()">
                    Fermer
                </v-btn>
                <v-btn color="primary" @click="submit">Générer</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
    <v-dialog v-model="dialogSignature" max-width="500px">

        <v-card style="margin-top: 3%;">
            <v-card-title color="primary">{{ $t('welcome.load_and_display_signature') }}</v-card-title>
            <v-card-text style="margin-top: 3%;">
                <v-row>
                    <v-col>
                        <v-file-input :label="$t('welcome.signature_and_stamp')" outlined prepend-icon="mdi-camera" accept="image/*" dense v-model="signature_cache.fichier"></v-file-input>
                    </v-col>
                </v-row>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn style="color: white;" color="red" @click="dialog = false">
                    {{$t('welcome.close')}}
                </v-btn>
                <v-btn color="primary" @click="submitSignature()">{{$t('welcome.save')}}</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</admin-layout>
</template>

<script>
import AdminLayout from "../../layouts/AdminLayout.vue"
export default {
    components: {
        AdminLayout
    },
    props: ["lots", "cartes", "qr", "total", "scanne", "restant"],
    data() {
        return {
            dialog: false,
            dialogSignature : false,
            loading: false,
            dialogDetail: false,
            selection: 1,
            e1: 1,
            steps: 2,
            breadcrumbs: [{
                    text: "App",
                    disabled: false,
                    href: "/home",
                },
                {
                    text: "Home",
                    disabled: true,
                    href: "/home",
                },
            ],
            selectedMonth: null,
            headers: [{
                    text: 'Date de génération',
                    align: 'start',
                    sortable: false,
                    value: 'date',
                },
                {
                    text: 'Nombres totaux',
                    value: 'nombre'
                },
                {
                    text: 'Actions ',
                    value: 'action'
                },
            ],
            form: this.$inertia.form({
                nombre: 0
            }),
            signature_cache: this.$inertia.form({
                fichier: 0
            }),
        }

    },
    mounted() {
        // console.log(this.qr);

    },
    methods: {
        close() {
            this.dialog = false
            this.dialogDetail = false
            this.dialogSignature = false
            this.form.reset()
        },
        reserve() {
            this.loading = true

            setTimeout(() => (this.loading = false), 2000)
        },
        generate() {
            this.dialog = true
        },
        submit() {
            this.$alert.confirm('Etes-vous sûr ?', "De vouloir générer ces numéros?", () => {

                this.form.post(route("carte.store"), {
                    onSuccess: () => {
                        if (this.$page.props.flash.success) {
                            this.$alert.success(this.$page.props.flash.success)
                        }
                        if (this.$page.props.flash.error) {
                            this.$toast.error(this.$page.props.flash.error)
                        }
                        this.close()
                        this.form.reset();
                    },
                    onError: this.$alert.messages

                });
            })
        },
        submitSignature() {
            this.$alert.confirm(this.$t('welcome.question_confirm'), this.$t('welcome.message_confirm_save'), () => {
                if (this.signature_cache.fichier !== null) {
                    this.signature_cache.post(route("carte.signature"), {
                        onSuccess: () => {
                            this.signature_cache.reset();
                            this.dialogSignature = false
                            this.$toast.success(this.$t('welcome.response_signature_load'), {
                                position: "top-center",
                            });
                        },
                    });
                }
            })
        },
        Detail(item) {
            this.$inertia.get(route('carte.detail', item.id))

            // this.dialogDetail = true
        },
        formatTime(dateString) {
            const date = new Date(dateString);
            let options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
            };
            return date.toLocaleDateString('fr-FR', options);
        },
    }
}
</script>

<style>
.invitation-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
}

.invitation-card {
    width: 400px;
    min-height: 550px;
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0, 0, 0, .15);
    border: 3px solid #d4af37;
}

.header {
    background: linear-gradient(135deg, #d4af37, #f5d76e);
    color: white;
    text-align: center;
    padding: 20px;
}

.content {
    padding: 25px;
    text-align: center;
}

.content h2 {
    color: #333;
    margin-bottom: 15px;
}

.event-info {
    margin: 20px 0;
}

.qr-section {
    margin: 25px 0;
}

.qr-section svg,
.qr-section img {
    width: 180px;
    height: 180px;
}

.footer-text {
    color: #666;
    font-size: 14px;
}
</style>
