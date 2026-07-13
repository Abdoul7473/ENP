<template>
  <v-container fluid>
    <v-card>
      <v-card-title class="bg-primary white--text text-center">Générateur de Requêtes (Etats / Rapports)</v-card-title>
      <v-card-text>
        <v-row>
          <v-col cols="8">
            <div id="builder"></div>
          </v-col>
          <v-col cols="4">
            <h5 class="box-title">Liste des Champs à Afficher :</h5>
            <!-- Vos champs à afficher ici -->
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12" class="text-center">
            <v-btn color="warning" @click="selectAll">Sélectionner Tout</v-btn>
            <v-btn color="primary" @click="deselectAll">Désélectionner Tout</v-btn>
          </v-col>
        </v-row>
        <!-- Autres éléments et boutons ici -->
      </v-card-text>
    </v-card>

    <v-card>
      <v-card-text>
        <h3 class="text-center">Tableau des Résultats</h3>
        <v-data-table :headers="headers" :items="data"></v-data-table>
      </v-card-text>
    </v-card>

    <!-- Modale pour sauvegarder la requête -->
    <v-dialog v-model="dialog" max-width="500px">
      <v-card>
        <v-card-title>Sauvegarde Requête</v-card-title>
        <v-card-text>
          <v-form @submit.prevent="saveQuery">
            <v-text-field v-model="queryName" label="Nom de la Requête" required></v-text-field>
            <!-- Gestion des erreurs de validation ici -->
            <v-btn type="submit" color="primary">Enregistrer</v-btn>
          </v-form>
        </v-card-text>
      </v-card>
    </v-dialog>
    <div id="builder"></div>
  </v-container>
</template>

<script>

export default {
  data() {
    return {
      // Données du tableau
      headers: [], // En-têtes de colonne
      data: [], // Données à afficher

      // Données de la modale
      dialog: false,
      queryName: '',

      // Autres données et états nécessaires
    }
  },
  methods: {
    selectAll() {
      // Logique pour sélectionner tous les champs
    },
    deselectAll() {
      // Logique pour désélectionner tous les champs
    },
    saveQuery() {
      // Logique pour sauvegarder la requête
    },
    initQueryBuilder() {
     

      // Autres écouteurs d'événements ici
    },
    // Autres méthodes nécessaires
  },
  mounted() {
    this.initQueryBuilder(); // Initialisation du QueryBuilder au montage du composant
  }
}
</script>

<style scoped>
/* Vos styles CSS ici */
</style>
