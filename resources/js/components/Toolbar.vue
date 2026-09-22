<template>
<div>
    <v-card outlined width="100%" height="70px" color="white" class="mb-2">

        <v-toolbar color="white" class="px-2">
            <v-btn @click="onClickLeftButton" class="ma-0 mr-2" icon>
                <v-icon color="red" large>mdi-arrow-left </v-icon>
            </v-btn>
            <v-toolbar-title style="color: black;">{{ Title }}</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-breadcrumbs :items="breadcrumbs" class="pa-0 custom-breadcrumbs"></v-breadcrumbs>
        </v-toolbar>
    </v-card>
    <slot />
</div>
</template>

  
  
<script>
export default {
    props: {
        icon: {
            default: 'mdi-home'
        },
        iconSize: {
            default: 'x-large'
        },
        leftButtonIcon: {
            default: 'mdi-reply'
        },
        searchQuery: {
            type: String,
            default: ''
        },
        Title: {
            type: String,
            default: 'Home'
        },
        items: {
            type: Array,
            default: () => []
        },
        breadcrumbs: {
            type: Array,
            default: () => [{
                text: "App",
                disabled: false,
                href: "/home",
            }]
        }
    },
    methods: {
        onClickLeftButton() {
            window.history.back()
        }
    }
}
</script>
  
  
<style scoped>
.custom-breadcrumbs {
    color: rgb(243, 124, 32);
}
</style>
