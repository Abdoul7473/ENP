<template>
<admin-layout>
    <Toolbar Title="Liste des rappports" :breadcrumbs="breadcrumbs">

    </Toolbar>
    <CustomDataTable :headers="headers" :items="rapports">
        <template v-slot:addBtn>
            <v-btn @click="creer()" small color="primary">
                <v-icon left>mdi-plus-circle</v-icon> générer
            </v-btn>
        </template>

        <template v-slot:item.date_heure="{ item }">
            {{ formatDate(item.created_at) }}
        </template>
        <template v-slot:item.officier="{ item }">
            {{ item.encadreur.matricule }} {{ item.encadreur.nom }} {{ item.encadreur.prenom }}
        </template>
        <template v-slot:item.action="{ item }">
            <!-- <BtnAction icon display-icon="mdi-eye" title="Détail" @click="detail(item)" color="green" small /> -->
            <a :href="route('rapport.pdf', { id: item.id})" target="__blank" title="Imprimer la demande">
                <v-icon size="small" class="me-2" icon="mdi-printer" color="info" small>mdi-printer</v-icon>
            </a>
        </template>

    </CustomDataTable>
    <v-dialog v-model="dialog" max-width="800" persistent>
        <v-card>
            <v-toolbar dense dark color="primary" class="text-h6"> Génération de rapport journalier</v-toolbar>
            <v-card-text>
                <br>
                <div class="invitation-container">
                    <div>
                        <div class="content">
                            <v-row>
                                <v-col cols="12" sm="12">
                                    <selectField label="Officier du jour" required v-model="form.officier" outlined name="Officier du jour" color="secondary" :items="officiers" :item-text="item => `${item.matricule} ${item.nom} ${item.prenom}`" item-value="id" autocomplete="false" chips></selectField>
                                </v-col>
                                <v-col cols="12" sm="12">
                                    <v-textarea counter label="Description" required v-model="form.description"></v-textarea>
                                </v-col>
                            </v-row>
                        </div>
                    </div>
                </div>
            </v-card-text>
            <v-card-actions>
                <v-spacer />
                <v-btn dark small type="button" color="error" @click="close()">
                    <v-icon left>mdi-cancel</v-icon> Annuler
                </v-btn>
                <v-btn dark small color="green" @click="submit()">
                    <v-icon left>mdi-check-circle</v-icon> Enregistrer
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
    <v-dialog v-model="dialogInfo" max-width="1200" persistent>
        <v-card>
            <v-toolbar dense dark color="primary" class="text-h6"> Détail de rapport</v-toolbar>
            <div v-for="(tag, index) in items.situations">
                <v-card-text>
                    <v-simple-table>
                        <template v-slot:default>
                            <thead>
                                <v-chip outlined label color="primary">{{ tag.compagnie.nom }} 
                                </v-chip>
                                <tr>
                                    <th class="text-left">
                                        effectif théorique
                                    </th>
                                    <th class="text-left">
                                        Nombre present
                                    </th>
                                    <th class="text-left">
                                        Nombre d'absent
                                    </th>
                                    <th class="text-left">
                                        Nombre de malade
                                    </th>
                                    <th class="text-left">
                                        Nombre de permissionnaire
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ tag.compagnie.effectif }}</td>
                                    <td>{{ tag.nombre_present }}</td>
                                    <td>{{ tag.nombre_absent }}</td>
                                    <td>{{ tag.nombre_malade }}</td>
                                    <td>{{ tag.nombre_permissionnaire }}</td>
                                </tr>
                            </tbody>
                        </template>
                    </v-simple-table>

                </v-card-text>
            </div>

            <v-col>
                <v-btn color="orange">
                    <v-icon left>mdi-send</v-icon> Envoyer au supérieur
                </v-btn>
            </v-col>
        </v-card>

    </v-dialog>
</admin-layout>
</template>

<script>
import AdminLayout from "../../layouts/AdminLayout.vue"
export default {
    components: {
        AdminLayout
    },
    props: ["rapports", "officiers"],
    data() {
        return {
            dialog: false,
            dialogInfo: false,
            items: [],
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
            headers: [{
                    text: 'Date et heure',
                    align: 'start',
                    sortable: false,
                    value: 'date_heure',
                },
                {
                    text: 'Officier deu jour',
                    align: 'start',
                    sortable: false,
                    value: 'officier',
                },
                {
                    text: 'Actions ',
                    value: 'action'
                },
            ],
            form: this.$inertia.form({
                officier: null,
                description: null
            }),
            total_malade : 0,
            total_present : 0,
            total_permissionnaire : 0,
            total_absent : 0
        }

    },
    mounted() {},
    methods: {
        close() {
            this.dialog = false
        },
        detail(item) {
            this.dialogInfo = true
            this.items = item
            console.log(this.items);
            this.total_absent = this.items.some()

        },
        creer() {
            this.dialog = true
        },
        formatDate(dateString) {
            const date = new Date(dateString);
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();

            return `${day}/${month}/${year} à ${hours}:${minutes} `;
        },
        submit() {
            this.$alert.confirm('Etes-vous sûr ?', "De vouloir générer le rapport?", () => {

                this.form.post(route("rapport.store"), {
                    onSuccess: () => {
                        if (this.$page.props.flash.success) {
                            this.$toast.success(this.$page.props.flash.success)
                        }
                        if (this.$page.props.flash.error) {
                            this.$toast.error(this.$page.props.flash.error)
                        }
                    },

                });
            })
        },
    }
}
</script>
