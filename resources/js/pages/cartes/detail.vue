<template>
<admin-layout>
    <Toolbar Title="Détails des cartes" :breadcrumbs="breadcrumbs">

    </Toolbar>
    <v-card>
        <!-- <v-toolbar dense dark color="primary" class="text-h6"></v-toolbar> -->
        <v-card-text>
            <br>
            <div class="invitation-container" justify="center" align="center">
                <div v-for="(carte, index) in cartes" :key="index" class="invitation-card">
                    <v-row align="center">
                        <v-col cols="2" style="margin-right: 10px; margin-top: 20px;">
                            <v-img src="../../logo_pn.jpg" width="70" height="85" class="grey darken-4"></v-img>
                        </v-col>
                        <v-col cols="7">
                            <h4 align="center"> MINISTERE DE L'INTERIEUR</h4>
                            <br>
                            <h3 align="center" style="color: black;"> DIRECTION GENERALE DE LA POLICE NATIONALE</h3>
                            <br>
                            <h4 align="center"> ECOLE NATIONALE DE POLICE ET DE FORMATION PERMANENTE</h4>
                            <br>
                            <h4 align="center" style="color: deepskyblue;"> INVITATION</h4>
                        </v-col>
                        <v-col cols="2" style="margin-left: 49px; margin-top: 20px;">
                            <v-img src="../../logo_enp.png" width="70" height="85" class="grey darken-4"></v-img>
                        </v-col>
                    </v-row>
                    <div class="content">
                        <p style="color: black;">
                            SOUS LE HAUT PATRONAGE DE SON EXCELLENCE, MONSIEUR LE MINISTRE D'ETAT, MINISTRE DE L'INTERIEUR DE LA
                            SECURITE PUBLIQUE ET DE L'ADMINISTRATION DU TERRITOIRE
                        </p>
                        <p>Le Directeur Général de la Police Nationale, vous prie de bien vouloir honorer de votre présence à la
                            cérémonie de présentation au drapeau des élèves policiers, promotion 2025
                        </p>
                        <v-row>
                            <v-col cols="4">
                                <div style="margin-top: 60px;">
                                    <h3><v-icon large>mdi-calendar </v-icon> 19/09/2026</h3>
                                </div>
                            </v-col>
                            <v-col cols="4">
                                <div class="qr-section">
                                    <div v-html="carte.qr"></div>
                                </div>
                            </v-col>
                            <v-col cols="4">
                                <div style="margin-top: 60px;">
                                  <h3>08h:00 <v-icon large>mdi-clock</v-icon> </h3>  
                                </div>
                            </v-col>
                        </v-row>

                    </div>
                </div>
            </div>
        </v-card-text>
    </v-card>
</admin-layout>
</template>

<script>
import AdminLayout from "../../layouts/AdminLayout.vue"
export default {
    components: {
        AdminLayout
    },
    props: ["cartes"],
    data() {
        return {
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
        }
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
    width: 750px;
    min-height: 450px;
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0, 0, 0, .15);
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
    width: 100px;
    height: 100px;
}

.footer-text {
    color: #666;
    font-size: 14px;
}
</style>
