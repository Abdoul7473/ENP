<template>
<div style="margin-left: 1%; margin-right: 1%; ">

    <v-data-table :headers="headers" :items="resultat" item-key="name" :search="search"  dense class="my-3 pt-3" style="border: 1px solid rgb(245, 134, 52)"  :loading="load">
        <template v-slot:top>
            <v-row>

                <v-col cols="9" class="pt-8">
                    <form action="/export/activite" target="_bank" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="_token" :value="csrf" />
                        <input type="hidden" name="type" value="2" />
                        <input type="hidden" name="tableau" :value="JSON.stringify(tableau)" />
                        &nbsp; <v-btn type="submit" color="primary" title="Imprimer listes des activitées en PDF">
                            <v-icon>mdi-file-pdf</v-icon>
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
        headers: {},
    },
    data: () => ({

    }),
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
