<template>
<div style="margin-left: 1%; margin-right: 1%; ">

    <v-data-table :headers="headers" :items="resultat" item-key="name" :search="search" dense class="my-3 pt-3" style="border: 1px solid rgb(245, 134, 52)" :loading="load">
        <template v-slot:top>
            <v-row>

                <v-col cols="1" class="pt-5">
                    <form action="/rapport/export" target="_bank" method="GET" enctype="multipart/form-data">
                        <input type="hidden" name="_token" :value="csrf" />
                        <input type="hidden" name="tab" value="1" />
                        <input type="hidden" name="date" :value="JSON.stringify(date)" />
                        <input type="hidden" name="resultat" :value="JSON.stringify(resultat)" />
                        &nbsp; <v-btn type="submit" color="primary" title="Imprimer listes des visiteurs en Excel">
                            EXCEL
                        </v-btn>
                    </form>
                </v-col>
                <v-col cols="4" class="pt-5">
                    <form action="/rapport/export" target="_bank" method="GET" enctype="multipart/form-data">
                        <input type="hidden" name="_token" :value="csrf" />
                        <input type="hidden" name="tab" value="2" />
                        <input type="hidden" name="date" :value="JSON.stringify(date)" />
                        <input type="hidden" name="resultat" :value="JSON.stringify(resultat)" />
                        &nbsp; <v-btn type="submit" color="primary" title="Imprimer listes des activitées en PDF">
                            <v-icon>mdi-file-pdf</v-icon> PDF
                        </v-btn>
                    </form>
                </v-col>
            </v-row>
        </template>

    </v-data-table>
</div>
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
        date: {},
        headers: {},
    },
    data: () => ({}),
    mounted() {
        this.csrf = this.$page.props.csrf_token
    },
    methods: {},
    created() {
        this.headers.forEach((item, i, items) => {
            if (i === 0) {
                item.class = 'primary white--text rounded-l-xl'
            } else if (i === items.length - 1) {
                item.class = 'primary white--text rounded-r-xl'
            } else {
                item.class = 'primary white--text'
            }
            item.divider = true
        })
    },
}
</script>

<style>
.custom-primary {
    background-color: rgba(225, 230, 210, 1) !important;
    color: black !important;
    /* pour s'assurer que le texte reste visible */
}
</style>
