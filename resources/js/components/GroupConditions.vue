<template>
    <v-card outlined>
      <v-card-text>
        <v-row>
          <v-col cols="12">
            <!-- Rendu récursif des conditions enfants -->
            <v-card v-for="(childCondition, childIndex) in group.children" :key="childIndex">
              <v-row v-if="childCondition.type === 'condition'">
                <ConditionRow :condition="childCondition" :index="childIndex" :key="childIndex" />
              </v-row>
              <v-row v-else-if="childCondition.type === 'group'">
                <GroupConditions :group="childCondition" :index="childIndex" :key="childIndex" />
              </v-row>
            </v-card>
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>
  </template>
  
  <script>
  import ConditionRow from './ConditionRow.vue';
  
  export default {
    components: {
      ConditionRow
    },
    props: {
      group: Object,
      index: Number
    }
  };
  </script>
  