<v-card outlined class="mb-md-2">
    <v-card-subtitle color="primary" class="font-weight-bold subtitle-style mx-auto">Query builder</v-card-subtitle>
    <v-card-text>
        <v-col cols="2">
            <!-- Sélection de la table -->
            <selectField v-model="table" item-text="name" item-value="id" :items="tables" label="Table"></selectField>
        </v-col>
        <v-row dense justify="center" v-for="(condition, i) in form.conditions" :key="i">
            <template v-if="condition.type === 'condition'">
                <v-row>
                    <v-col cols="3">
                        <selectField v-model="condition.query.selectedOperator" :items="getColumnNames(table)" label="Colonne"></selectField>
                    </v-col>
                    <v-col cols="3">
                        <selectField v-model="condition.query.value" :items="operators" label="Opérateur"></selectField>
                    </v-col>
                    <v-col cols="3">
                        <TextField v-model="condition.query.value" label="Valeur de filtre"></TextField>
                    </v-col>
                    <v-col cols="1">
                        <!-- Bouton pour supprimer la condition -->
                        <BtnAction icon display-icon="mdi-minus" title="Supprimer cette condition" @click="removeSubCondition(groupIndex, conditionIndex)" color="error" small/>
                    </v-col>
                </v-row>
                <BtnAction icon display-icon="mdi-plus" title="Ajouter un groupe de condition" @click="addGroupConditions()" color="primary" small/>
            </template>
            <template v-else-if="condition.type === 'group'">
                <div v-for="(childCondition, j) in condition.children" :key="j">
                    <!-- Afficher chaque enfant du groupe de conditions -->
                    <template v-if="childCondition.type === 'condition'">
                        <!-- Si c'est une condition -->
                        <v-col cols="2">
                            <!-- Sélection de la table -->
                            <selectField v-model="childCondition.query.rule" item-text="name" item-value="id" :items="tables" label="Table"></selectField>
                        </v-col>
                        <v-col cols="3">
                            <selectField v-model="childCondition.query.selectedOperator" :items="getColumnNames(childCondition.query.rule)" label="Colonne"></selectField>
                        </v-col>
                        <v-col cols="3">
                            <selectField v-model="childCondition.query.value" :items="operators" label="Opérateur"></selectField>
                        </v-col>
                        <v-col cols="3">
                            <TextField v-model="childCondition.query.value" label="Valeur de filtre"></TextField>
                        </v-col>
                    </template>
                </div>
            </template>
        </v-row>
        <v-row>
            <BtnAction icon display-icon="mdi-plus" title="Ajouter une condition" @click="addConditions()" color="primary" small/>
        </v-row>
    </v-card-text>
</v-card>