<template>
<admin-layout>
    <Toolbar Title="Situations">
    </Toolbar>
    <v-banner class="mb-4">
        <div class="d-flex flex-wrap justify-space-between">
            <v-alert border="top" colored-border type="info" elevation="2">
                Enregitrement d'une situation de <v-chip outlined color="primary" label>{{ compagnie?.nom }}</v-chip> &nbsp;
                Effectif théorique <v-chip outlined label> {{ compagnie?.effectif }}</v-chip>
            </v-alert>
            <h5 class="text-h5 font-weight-bold"> </h5>
        </div>
    </v-banner>
    <v-card>
        <v-card-text>
            <v-form ref="myForm" @submit.prevent="submit">
                <v-row>
                    <v-col cols="12" sm="4">
                        <TextField label="Nombre présent" name="Nombre de present" v-model="form.nombre_present" required outlined dense color="secondary" autocomplete="false"></TextField>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <TextField label="Nombre d'absent" name="Nombre d'absent" v-model="form.nombre_absent" outlined dense color="secondary" autocomplete="false"></TextField>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <selectField :disabled="!form.nombre_absent" label="Sélectionner les absents" v-model="form.eleve_absents" outlined name="Eleves absents" color="secondary" :items="eleves" :item-text="item => `${item.matricule} ${item.nom} ${item.prenom}`" item-value="id" autocomplete="false" chips multiple></selectField>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" sm="4">
                        <TextField label="Nombre de malade" name="Nombre malade" v-model="form.nombre_malade" outlined dense color="secondary" autocomplete="false"></TextField>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <selectField :disabled="!form.nombre_malade" label="Sélectionner les malades" v-model="form.eleve_malades" outlined name="Eleves malades" color="secondary" :items="eleves" :item-text="item => `${item.matricule} ${item.nom} ${item.prenom}`" item-value="id" autocomplete="false" chips multiple></selectField>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <TextField label="Nombre de permissionnaire" name="Nombre de permissionnaire" v-model="form.nombre_permissionnaire" outlined dense color="secondary" autocomplete="false"></TextField>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" sm="4">
                        <selectField :disabled="!form.nombre_permissionnaire" label="Sélectionner les permissionnaires" v-model="form.eleve_permissionnaires" outlined name="Eleves permissionnaires" color="secondary" :items="eleves" :item-text="item => `${item.matricule} ${item.nom} ${item.prenom}`" item-value="id" autocomplete="false" chips multiple></selectField>
                    </v-col>
                </v-row>
                <v-card-actions>
                    <v-spacer />
                    <v-btn :loading="form.processing" @click="goBack()" color="error"> Annuler</v-btn>
                    <v-btn :loading="form.processing" type="submit" color="primary"> Enregistrer</v-btn>
                </v-card-actions>
            </v-form>
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
    props: ["eleves", "compagnie"],
    data() {
        return {
            form: this.$inertia.form({
                compagnie_id: this.compagnie?.id,
                nombre_present: 0,
                nombre_absent: 0,
                nombre_malade: 0,
                nombre_permissionnaire: 0,
                eleve_absents: [],
                eleve_malades: [],
                eleve_permissionnaires: []
            }),
            menu1: false,
            menu2: false,
            modal2: false,
            menu: false,
            sexes: [{
                    'id': 1,
                    'name': 'Masculin'
                },
                {
                    'id': 2,
                    'name': 'Feminin'
                }
            ]
        }
    },
    methods: {
        submit() {
            const somme = parseInt(this.form.nombre_absent) + parseInt(this.form.nombre_malade) + parseInt(this.form.nombre_permissionnaire) + parseInt(this.form.nombre_present)
            console.log(somme);
            
            if (parseInt(somme) == this.compagnie.effectif) {
                this.$alert.confirm('Etes-vous sûr ?', "Vous allez enregistrer cette situation", () => {
                    this.form.post(route("situation.store"), {
                        onSuccess: () => {
                            if (this.$page.props.flash.success) {
                                this.$alert.success(this.$page.props.flash.success)
                            }
                            if (this.$page.props.flash.error) {
                                this.$toast.error(this.$page.props.flash.error)
                            }
                        },
                        onError: this.$alert.messages
                    })
                })
            } else {
                this.$alert.warning("Veillez équilibrer les champs")
            }

        }
    }
}
</script>
