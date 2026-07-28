<template>
<v-data-table :headers="headers" :items="resultat" :search="search" item-key="name" dense class="my-3 pt-3" style="border: 1px solid rgb(245, 134, 52)" >
    <template v-slot:top>
        <v-row>

            
            <v-col class="pt-8" cols="3">
                <v-text-field v-model="search" prepend-inner-icon="mdi-search-web" single-line outlined dense clearable label="Rechercher" :placeholder="translate('recherche')" class="mx-3"></v-text-field>
            </v-col>
        </v-row>
    </template>

</v-data-table>
</template>

<script>
export default {
    props: {
        resultat: {
            type: [Object, Array]
        },
        headers: {},

    },
    data() {
        return {
            search: null,
        }
    },
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
