<template>
    <SelectField
      v-model="peopleSelected"
      :items="people"
      filled
      chips
      color="blue-grey lighten-2"
      label="Select"
      item-text="name"
      item-value="name"
      multiple
    >
      <!-- Template for render selected data -->
      <template
      slot="selection"
      slot-scope="data"
      >
      <v-chip
        :input-value="data.selected"
        close
        class="chip--select-multi"
        @input="remove(data.item)"
      >
        {{ data.item.name }}
      </v-chip>
      </template>
        <!-- Template for render data when the select is expanded -->
        <template
        slot="item"
        slot-scope="data"
        >
        <!-- Divider and Header-->
        <template v-if="typeof data.item !== 'object'">
          <v-list-item-content>
              <v-list-item-title>{{data.item}}</v-list-item-title>
          </v-list-item-content>
        </template>
        <template v-else>
            <v-list-item-content>
                <v-list-item-title>{{ data.item.name }}</v-list-item-title>
                <v-list-item-subtitle>{{ data.item.group }}</v-list-item-subtitle>
            </v-list-item-content>
        </template>
        </template>
    </SelectField>
  </template>
  
  <script>
  export default {
    data() {
      return {
        selectedFields: [],
        peopleSelected: null,
        fields: [
          {
            text: "Demandes",
            items: [
              { text: "Date de demande", value: "date_demande" },
              { text: "Numéro d'ordre", value: "numero_ordre" },
              { text: "Ville résidence postulant", value: "ville_fait" },
              { text: "Nombre de mois", value: "nbre_mois" },
              { text: "Date de rejet", value: "date_rejet" },
              { text: "Date prévue du vol", value: "date_prevu_vol" },
              { text: "Date d'approbation", value: "date_approbation" },
              { text: "Date d'autorisation", value: "date_autorisation" },
              { text: "Permanence de la demande", value: "permanant" },
              { text: "Type de demande", value: "type_demande" },
              { text: "Type de vol", value: "type_vol" },
              { text: "Statut de la demande", value: "statut" },
              { text: "utilisateur ayant donné son approbation", value: "user_appro" },
              { text: "Type de demande", value: "user_autoriser" },
              // Ajoutez d'autres champs pour les agents ici...
            ],
          },
          {
            text: "Affectations",
            items: [
              { text: "Ref affectation", value: "ref_affectation" },
              { text: "Date", value: "date_affectation" },
              // Ajoutez d'autres champs pour les affectations ici...
            ],
          },
          // Ajoutez d'autres groupes de champs ici...
        ],
      };
    },
  };
  </script>
  