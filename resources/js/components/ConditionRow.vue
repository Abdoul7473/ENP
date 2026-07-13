<template>
    <v-row>
      <v-col cols="3">
        <selectField v-model="condition.query.selectedOperator" :items="columns" label="Colonne"></selectField>
      </v-col>
      <v-col cols="3">
        <selectField v-model="condition.query.value" :items="operators" label="Opérateur"></selectField>
      </v-col>
      <v-col cols="3">
        <TextField v-model="condition.query.value" label="Valeur de filtre"></TextField>
      </v-col>
      <v-col cols="1">
        <!-- Bouton pour supprimer la condition -->
        <BtnAction icon display-icon="mdi-minus" title="Supprimer cette condition" @click="removeCondition()" color="error" small />
      </v-col>
    </v-row>
  </template>
  
  <script>
  export default {
    props: {
      condition: Object,
      index: Number,
      columns: Array,
      operators: Array
    },
    methods: {
      removeCondition() {
        // Retirez la condition de votre tableau de conditions
      }
    }
  };
  </script>
  