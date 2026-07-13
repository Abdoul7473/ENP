<template>
<v-card class="px-2" color="basil" flat elevation="2" outlined>
    <v-dialog v-model="dialog" max-width="1200" class="mx-auto">
        <v-card flat class="mx-auto">
            <v-toolbar dense dark color="primary" class="text-h6">INFORMATIONS DE LA DEMANDE DE &nbsp;<b>{{ nom_raison_sociale }}</b> </v-toolbar>
            <br>
            <!-- contenu des demande -->

            <v-card-text>
                <v-row>
                    <v-col cols="4">
                        <v-label class="font-weight-bold">Type de la demande : {{ type_demande }}</v-label>
                    </v-col>
                    <v-col cols="4">
                        <v-label class="font-weight-bold">Type du vol : {{ type_vol }}</v-label>

                    </v-col>
                    <v-col cols="4">
                        <v-label class="font-weight-bold">Etat : {{ statut }}</v-label>
                    </v-col>
                </v-row>
                <v-row class="pt-8">
                    <v-col cols="4">
                        <v-label class="font-weight-bold">Immatriculation : {{ immatriculation }}</v-label>
                    </v-col>
                    <v-col cols="4">
                        <v-label class="font-weight-bold">Identifiant d'appel : {{ call }}</v-label>
                    </v-col>
                    <v-col cols="4">
                        <v-label class="font-weight-bold">Nom Propriété : {{ proprietaire_aeronef }}</v-label>
                    </v-col>
                </v-row>
                <v-row class="pt-8">
                    <v-col cols="4">
                        <v-label class="font-weight-bold">Nom Exploitant : {{ nom_exploitant }}</v-label>
                    </v-col>
                </v-row>
                <v-card-title>
                    <v-row>
                        <v-col cols="5"></v-col>
                        <v-col>
                            <v-chip large class="font-weight-bold">Routes</v-chip>
                        </v-col>
                    </v-row>
                </v-card-title>
                <v-simple-table>
                    <template v-slot:default>
                        <thead>
                            <tr>
                                <th class="text-center" style="border: 1px solid ;padding: 7px; font-size: large;">
                                    Date
                                </th>
                                <th class="text-center" style="border: 1px solid ;padding: 7px; font-size: large; ">
                                    Ville de depart
                                </th>
                                <th class="text-center" style="border: 1px solid ;padding: 7px; font-size: large;">
                                    Ville d'arriver
                                </th>
                                <th class="text-center" style="border: 1px solid ;padding: 7px; font-size: large;">
                                    Heure de depart
                                </th>
                                <th class="text-center" style="border: 1px solid ;padding: 7px; font-size: large;">
                                    Heure d'arriver
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in routes" :key="item.id">
                                <td style="border: 1px solid ;padding: 7px;  ">{{ item.date_route}}</td>
                                <td style="border: 1px solid ;padding: 7px;  ">{{ item.ville_depar?.code_icao }} / {{ item.ville_depar.nom }}</td>
                                <td style="border: 1px solid ;padding: 7px;  ">{{ item.ville_arrive?.code_icao }} / {{ item.ville_arrive.nom }}</td>
                                <td style="border: 1px solid ;padding: 7px;  " v-if="item.heure_arrive">{{ item.heure_depart }}</td>
                                <td style="border: 1px solid ;padding: 7px;  " v-else>Non indiqué</td>
                                <td style="border: 1px solid ;padding: 7px; " v-if="item.heure_arrive">{{ item.heure_arrive}}</td>
                                <td style="border: 1px solid ;padding: 7px;  " v-else>Non indiqué</td>
                            </tr>
                        </tbody>
                    </template>
                </v-simple-table>
                <br>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn style="color: white;" color="red" @click="dialog = false">
                        <v-icon>mdi-cancel</v-icon> Fermer
                    </v-btn>
                </v-card-actions>
            </v-card-text>
        </v-card>

    </v-dialog>
    <v-dialog v-model="dialog_over" max-width="600" class="mx-auto">
        <v-card flat class="mx-auto">
            <v-toolbar dense dark color="primary" class="text-h6">Routes</v-toolbar>
            <br>
            <v-card-text>
                <div v-for="(tag, index) in num_autorisations" :key="index" small color="secondary">
                    <li> {{ tag.route?.ville_depar?.libelle }} - {{ tag.route?.ville_arive?.libelle }}</li>
                </div>
            </v-card-text>
        </v-card>
    </v-dialog>
    <CustomTable :headers="headers" :items="resultat.resultat">
        <template v-slot:addBtn>
            <form action="/query/export" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="data_from" :value="JSON.stringify(resultat)" />
                <input type="hidden" name="_token" :value="csrf" />
                <input type="hidden" name="tab" :value="type" />
                <v-btn type="submit" color="secondary">Exporter excel</v-btn>
            </form>
            <form action="/query/export" method="POST" target="_blank" enctype="multipart/form-data">
                <input type="hidden" name="data_from" :value="JSON.stringify(resultat)" />
                <input type="hidden" name="_token" :value="csrf" />
                <input type="hidden" name="_method" value="POST">
                <input type="hidden" name="tab" :value="type" />
                <input type="hidden" name="type" value="print" />
                <v-btn type="submit" color="secondary">
                    <v-icon small> mdi-printer </v-icon> Imprimer
                </v-btn>
            </form>
        </template>
        <template v-slot:item.immatriculation="{item}">
            <div v-for="(tag, index) in item.aeronefs" :key="index" small color="secondary">
                {{ tag?.imatriculation }}
            </div>
        </template>
        <template v-slot:item.imatriculation="{item}">
            <div small color="secondary">
                {{ item?.num_autorisations[0]?.route?.demande?.aeronefs[0]?.imatriculation }}
            </div>
        </template>
        <template v-slot:item.date_vol="{item}">
            <div small color="secondary">
                {{ item?.num_autorisations[0]?.route?.demande?.date_prevu_vol }}
            </div>
        </template>
        <template v-slot:item.date_autorisation="{ item }">
            <div small color="secondary">
                {{ formatDate(item?.date_autorisation) }}
            </div>
        </template>
        <template v-slot:item.type_demande="{item}">
            <div small color="secondary">
                {{ item?.type_demande?.libelle }}
            </div>
        </template>
        <template v-slot:item.postulant="{item}">
            <div small color="secondary">
                {{ item?.num_autorisations[0]?.route?.demande?.user?.postulant?.nom_raison_sociale }}
            </div>
        </template>
        <template v-slot:item.nombre_route="{item}">
            <div small color="secondary">
                <v-chip color="green" @click="FechRoute(item),dialog_over = true">
                    {{ item?.nombre_route}} &nbsp; &nbsp;<v-icon left>mdi-eye</v-icon>
                </v-chip>
            </div>
        </template>
        <template v-slot:item.cal="{item}">
            <div small color="secondary">
                {{ item?.num_autorisations[0]?.route?.demande?.aeronefs[0]?.indicatif_appel }}
            </div>
        </template>
        <template v-slot:item.call="{item}">
            <div v-for="(tag, index) in item.aeronefs" :key="index" small color="secondary">
                {{ tag?.indicatif_appel }}
            </div>
        </template>
        <template v-slot:item.motif="{item}">
            <h4 v-if="item?.type_vol_id == 4">{{ item?.preciser }}</h4>
            <h4 v-else>{{ item?.type_vol?.libelle }}</h4>
        </template>
        <template v-slot:item.num="{item}">
            <div v-for="(tag, index) in item?.nums" :key="index" small color="secondary">
                {{ tag?.num }}
            </div>
        </template>
        <template v-slot:item.action="{item}">
            <BtnAction icon display-icon="mdi-eye" title="Voir plus" @click="detail(item)" color="primary" small />
        </template>
    </CustomTable>
</v-card>
</template>

<script>
import AdminLayout from "../../layouts/AdminLayout.vue"
export default {
    components: {
        AdminLayout
    },
    props: {
        resultat: {
            type: [Object, Array]
        },
        headers: {},
        type: null,
    },
    data: () => ({
        dialog_over: false,
        num_autorisations: [],
        call: null,
        type_demande: null,
        type_vol: null,
        immatriculation: null,
        nom_exploitant: null,
        nom_raison_sociale: null,
        proprietaire_aeronef: null,
        routes: [],
        statut: null,
        dialog: false,
        csrf: null,
        demandes: [],
    }),
    mounted() {
        this.csrf = this.$page.props.csrf_token
    },
    methods: {
        formatDate(date) {
            const options = { day: 'numeric', month: 'long', year: 'numeric' };
            return new Date(date).toLocaleDateString('fr-FR', options);
        },
        detail(item) {
            console.log(item)
            this.dialog = true
            this.demandes = item
            this.type_demande = item?.type_demande?.libelle,
                this.call = item.aeronefs[0].indicatif_appel
            this.type_vol = item?.type_vol?.libelle,
                this.immatriculation = item.aeronefs[0]?.imatriculation,
                this.nom_exploitant = item.aeronefs[0]?.nom_exploitant,
                this.nom_raison_sociale = item.user.postulant.nom_raison_sociale,
                this.proprietaire_aeronef = item.aeronefs[0]?.proprietaire_aeronef,
                this.routes = item.routes
            this.statut = item.statut.libelle
        },
        FechRoute(item) {
            this.num_autorisations = item.num_autorisations
        }
    },
}
</script>

<style>

</style>
