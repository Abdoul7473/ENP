<template>
<admin-layout>
    <Toolbar Title="Enregistrement d'un avanement">
    </Toolbar>
    <v-card>
        <v-card-text>
            <v-form ref="myForm" @submit.prevent="submit">
                <v-row class="pt-8">
                    <v-col cols="12" sm="4">
                        <TextField label="Date" type="date" rules="required" name="Date" v-model="form.date" required outlined dense color="secondary" autocomplete="false"></TextField>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <v-menu ref="menu" v-model="menu" :close-on-content-click="false" :nudge-right="40" :return-value.sync="form.heure_arrive" transition="scale-transition" offset-y max-width="290px" min-width="290px">
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field v-model="form.heure_arrive" label="Heure d'arrivée" prepend-icon="mdi-clock-time-four-outline" readonly v-bind="attrs" v-on="on"></v-text-field>
                            </template>
                            <v-time-picker format="24hr" v-if="menu" v-model="form.heure_arrive" full-width @click:minute="$refs.menu.save(form.heure_arrive)"></v-time-picker>
                        </v-menu>
                    </v-col>
                    <v-col cols="12" sm="4">
                        <v-menu ref="menu1" v-model="menu1" :close-on-content-click="false" :nudge-right="40" :return-value.sync="form.heure_depart" transition="scale-transition" offset-y max-width="290px" min-width="290px">
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field v-model="form.heure_depart" label="Heure de depart" prepend-icon="mdi-clock-time-four-outline" readonly v-bind="attrs" v-on="on"></v-text-field>
                            </template>
                            <v-time-picker format="24hr" v-if="menu1" v-model="form.heure_depart" full-width @click:minute="$refs.menu1.save(form.heure_depart)"></v-time-picker>
                        </v-menu>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="4">
                        <TextField label="Objectif Général" name="Objectif Général" v-model="form.objectif_general"  outlined dense color="secondary" autocomplete="false"></TextField>
                    </v-col>
                    <v-col cols="4">
                        <TextField label="Objectif Spécific" name="Objectif Spécific" v-model="form.objectif_specific"  outlined dense color="secondary" autocomplete="false"></TextField>
                    </v-col>
                    <v-col cols="4">
                        <TextField label="Progression du cours" name="Progression du cours" v-model="form.progression"  outlined dense color="secondary" autocomplete="false"></TextField>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="4">
                        <TextField label="Nombre d'heure" name="Nombre d'heure" v-model="form.nombre_heure" type="number"  outlined dense color="secondary" autocomplete="false"></TextField>
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
    props: ["grades", "compagnies", "entites", "profils","id"],
    data() {
        return {
            menu: false,
            menu1: false,
            form: this.$inertia.form({
                date : null,
                heure_arrive: null,
                heure_depart: null,
                progression: null,
                nombre_heure: null,
                objectif_general: null,
                objectif_specific: null,
                id : this.id
            }),

        }
    },
    methods: {
        submit() {
            this.form.post(route("avancement.store"), {
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
        }

    }
}
</script>

<style>
.language-option {
    display: flex;
    align-items: center;
}

.flag {
    width: 20px;
    height: 14px;
    margin-right: 8px;
}
</style>
