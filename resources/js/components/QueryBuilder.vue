<template>
    <v-card outlined class="mb-md-2">
    <v-card-subtitle color="primary" class="font-weight-bold subtitle-style mx-auto">Query builder</v-card-subtitle>
    <v-card-text>
      <v-container>
        <!-- Sélection de la table -->
        <v-row>
          <v-col cols="12" sm="6" md="4">
            <selectField v-model="table" item-text="name" item-value="id" :items="tables" label="Table"></selectField>
          </v-col>
        </v-row>
        <!-- Conditions -->
        <v-card v-for="(condition, index) in form.conditions" :key="index">
          <v-row v-if="condition.type === 'condition' && table != null">
            <ConditionRow :condition="condition" :index="index" :key="index" :columns="getColumnNames()" />
          </v-row>
          <v-row v-else-if="condition.type === 'group'">
            <GroupConditions :group="condition" :index="index" :key="index" />
          </v-row>
        </v-card>
        <!-- Bouton Ajouter -->
        <v-row>
          <v-col cols="12">
            <v-btn @click="addConditions()" color="primary" small>Ajouter une condition</v-btn>
            <v-btn @click="addGroupConditions()" color="primary" small>Ajouter un groupe de conditions</v-btn>
          </v-col>
        </v-row>
      </v-container>
    </v-card-text>
  </v-card>
</template>
<script>
import ConditionRow from './ConditionRow.vue';
import GroupConditions from './GroupConditions'
export default {
    components: {
        ConditionRow,
        GroupConditions
    },
    data() {
        return {
        selectedTable: '',
        table: '',
        form: this.$inertia.form({
            conditions: [
            {
                type: "condition",
                logicalOperator: null,
                query: {
                    rule: '',
                    selectedOperator: '',
                    value: ''
                }
            }
            ],
            date: null,
        }),
        operators: ['=', '>', '<', '>=', '<=', '!=', 'LIKE', 'NOT LIKE', 'IN', 'NOT IN']
        };
    },
    props: {
        tables: Array,
        cv: Object
    },
    methods: {
        addConditions(){
        this.form.conditions.push({
            type: "condition",
            logicalOperator: null,
            query: {
                rule: '',
                selectedOperator: '',
                value: ''
            }
        });
        },
        addGroupConditions(){
            this.form.conditions.push({
                type: "group",
                logicalOperator: null,
                children: [
                {
                    type: "condition",
                    logicalOperator: null,
                    query: {
                    rule: '',
                    selectedOperator: '',
                    value: ''
                    }
                }
                ]
            });
        },
        removeCondition(groupIndex, conditionIndex) {
            this.conditions[groupIndex].query.children.splice(conditionIndex, 1);
        },
        executeQuery() {
        // Construction de la requête en fonction des choix de l'utilisateur
        
        },
        getColumnNames(tableName) {
            const table = this.tables.find((table) => table.id ==tableName)
            return table?.columns
            // console.log(tableName, table?.columns)
        }
    },
    mounted() {
        // Ajoutez une condition initiale
        // this.addConditions();
        // this.addGroupConditions()
    }
}
</script>