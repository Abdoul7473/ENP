<template>
<postulant-layout>
    <v-row class="bg-img" justify="space-around">

        <v-card width="700">
            <!-- <v-img height="200px" src="https://cdn.pixabay.com/photo/2021/07/09/06/52/lavender-6398415_960_720.jpg"> -->
            <v-app-bar class="mt-8" flat color="rgba(0, 0, 0, 0)">
                <v-avatar size="100">
                    <v-img src="male.png"></v-img>
                </v-avatar>

            </v-app-bar>
            <v-card-text>
                <v-card-title>
                    <p class="ml-3">{{ user.postulant.nom_raison_sociale }}</p>
                </v-card-title>
                <div class="font-weight-bold ml-8 mb-2 container">Détails
                    <v-btn color="primary" size="small" @click="modifie()" variant="outlined">
                        <v-icon>mdi-pencil</v-icon>Modifié
                    </v-btn>
                </div>
                <v-list two-line>
                    <v-list-item>
                        <v-list-item-icon>
                            <v-icon color="indigo"> mdi-phone </v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-chip-group column>
                                <v-chip label>{{ user?.postulant?.tel }}</v-chip><v-chip label v-if="user?.postulant?.tel2">{{ user?.postulant?.tel2 }}</v-chip>
                            </v-chip-group>
                            <v-list-item-subtitle>Mobile</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <v-divider inset></v-divider>
                    <v-list-item>
                        <v-list-item-icon>
                            <v-icon color="indigo"> mdi-email </v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title>{{ user.email }}</v-list-item-title>
                            <v-list-item-subtitle>E-mail</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <v-divider inset></v-divider>
                    <v-list-item>
                        <v-list-item-icon>
                            <v-icon color="indigo"> mdi-map-marker </v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>{{ user.postulant.adresse }}</v-list-item-title>
                            <v-list-item-subtitle>Adresse</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
                <v-divider inset></v-divider>
                <v-list two-line>
                    <v-list-item>
                        <v-list-item-icon>
                            <v-icon color="indigo"> mdi-phone </v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>{{ user.postulant.ville.name }}</v-list-item-title>
                            <v-list-item-subtitle>Ville</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <v-divider inset></v-divider>
                    <v-list-item>
                        <v-list-item-icon>
                            <v-icon color="indigo"> mdi-email </v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title>{{ user.postulant.ville.pay.name }}</v-list-item-title>
                            <v-list-item-subtitle>Pays</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <v-divider inset></v-divider>
                    <v-list-item>
                        <v-list-item-icon>
                            <v-icon color="indigo"> mdi-map-marker </v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>{{ user.postulant.numero_ordre }}</v-list-item-title>
                            <v-list-item-subtitle>N° d'ordre</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <v-divider inset></v-divider>
                    <v-list-item>
                        <v-list-item-icon>
                            <v-icon color="indigo"> mdi-map-marker </v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>{{ user.postulant.fonction }}</v-list-item-title>
                            <v-list-item-subtitle>Fonction</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <div style="margin-left: 80%;">
                        <v-img width="1000" heigth="1000" :src="'signatures/' + user.postulant.signature_cachet"></v-img>
                    </div>
                </v-list>

            </v-card-text>
        </v-card>
    </v-row>
    <v-dialog v-model="dialog" max-width="1000">
        <v-card>
            <v-toolbar dense dark color="primary" class="text-h6">Modification des informations personnelles</v-toolbar>
            <v-card-text class="pt-12">
                <v-row>
                    <v-col cols="4">
                        <TextField required label="Nom ou raison sociale" hide-details dense v-model="form.name">
                        </TextField>
                    </v-col>
                    <v-col cols="4">
                        <TextField required label="Email" hide-details dense v-model="form.email">
                        </TextField>
                    </v-col>
                    <v-col cols="4">
                        <TextField label="Adresse" hide-details dense v-model="form.adresse">
                        </TextField>
                    </v-col>
                </v-row>
                <v-row class="pt-5">
                    <v-col cols="3">
                        <TextField label="Fonction" hide-details dense v-model="form.fonction">
                        </TextField>
                    </v-col>
                    <v-col cols="3">
                        <selectField label="Villes" required v-model="form.ville" outlined name="Villes" color="secondary" :items="villes" item-text="name" item-value="id" autocomplete="false" chips></selectField>
                    </v-col>
                    <v-col cols="3">
                        <TextField required label="Téléphone 1" hide-details dense v-model="form.tel"></TextField>
                    </v-col>
                    <v-col cols="3">
                        <TextField  label="Téléphone 2" hide-details dense v-model="form.tel2"></TextField>
                    </v-col>
                </v-row>
                <!-- <v-row>
                    <v-col cols="4">
                        <TextField  label="Téléphone 3" hide-details dense v-model="form.tel[2]">
                        </TextField>
                    </v-col>
                </v-row> -->
                <v-col class="pt-5">
                    <v-card-actions>
                        <v-spacer />
                        <v-btn @click="dialog = false" color="red">Annuler</v-btn>
                        <v-btn @click="submit()" color="primary">Enregistrer</v-btn>
                    </v-card-actions>
                </v-col>
            </v-card-text>
        </v-card>
    </v-dialog>

</postulant-layout>
</template>

<script>
import PostulantLayout from "../../layouts/PostulantLayout.vue";
export default {
    components: {
        PostulantLayout
    },
    props: ["user", "villes"],
    name: 'VFCProfileContactCard',
    data() {
        return {
            dialog: false,
            form: this.$inertia.form({
                id: this.user.id,
                name: this.user.postulant.nom_raison_sociale,
                email: this.user.email,
                adresse: this.user.postulant.adresse,
                ville: this.user.postulant.ville_id,
                fonction: this.user.postulant.fonction,
                tel: this.user.postulant.tel,
                tel2: this.user.postulant.tel2
            })
        }
    },
    methods: {
        submit() {
            console.log(this.form.ville)
            this.$alert.confirm('Etes-vous sûr ?', "Vous allez modifié votre profile", () => {
                this.form.post(route("modifie_postulant"), {
                    onSuccess: () => {
                        if (this.$page.props.flash.success) {
                            this.$alert.success(this.$page.props.flash.success)
                        }
                        if (this.$page.props.flash.error) {
                            this.$toast.error(this.$page.props.flash.error)
                        }
                        this.dialog = false
                    },
                    onError: this.$alert.messages
                })
            })
        },
        modifie() {
            this.dialog = true
        },
    },
}
</script>

<style>
.bg-img {
    /* background-image: url('https://cdn.pixabay.com/photo/2020/07/12/07/47/bee-5396362_1280.jpg'); */
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center top;
    border-radius: 3px;
}

.separator {
    position: absolute;
    /* Position absolue pour superposer la ligne sur le bouton */
    top: 50%;
    /* Positionne la ligne verticalement au milieu */
    right: 100%;
    left: 0;
    /* Positionne la ligne à gauche du conteneur */
    width: 100%;
    /* La ligne s'étend sur toute la largeur */
    height: 1px;
    /* Hauteur de la ligne */
    background-color: orange;
    /* Couleur de la ligne de séparation */
    transform: translateY(-50%);
    /* Centre la ligne verticalement */
    z-index: 1;
    /* Place la ligne au-dessus du bouton */
}

.container {
    position: relative;
    /* Permet de positionner la ligne par rapport au conteneur */
}

</style>
