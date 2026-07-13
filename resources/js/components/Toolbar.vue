<template>
    <div>
      <v-card outlined width="100%" height="70px" color="white" class="mb-2">
        <v-card outlined width="100%" height="3px" color="orange"></v-card>
        <v-toolbar color="white" class="px-2">
          <!-- <v-btn text class="ma-0 mr-2" color="orange" @click="onClickLeftButton">
            <v-icon>{{ leftButtonIcon }}</v-icon>
          </v-btn>
          <v-icon class="mr-2" color="secondary" size="20">{{ icon }}</v-icon> -->
          <v-toolbar-title style="color: rgb(243, 124, 32);">{{ Title }}</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-breadcrumbs :items="breadcrumbs" class="pa-0 custom-breadcrumbs"></v-breadcrumbs>
        </v-toolbar>
        <v-card outlined width="100%" height="3px" color="primary"></v-card>
      </v-card>
      <slot />
    </div>
  </template>
  
  <script>
  export default {
    props: {
      icon: { default: 'mdi-home' },
      iconSize: { default: 'x-large' },
      leftButtonIcon: { default: 'mdi-reply' },
      searchQuery: { type: String, default: '' },
      Title: { type: String, default: 'Home' },
      items: { type: Array, default: () => [] },
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
        let previousRoute = window.history.state ? window.history.state.url : null;
        let previousRouteName;
  
        if (previousRoute) {
          previousRouteName = previousRoute.includes("/") ? previousRoute.split("/").pop() : null;
        }
  
        // // Si vous souhaitez revenir à la page précédente, utilisez window.history.back()
        // // Sinon, vous pouvez exécuter une autre logique selon votre besoin ici
        // window.history.back();
      }
    }
  }
  </script>
  
  <style scoped>
  .custom-breadcrumbs {
    color: rgb(243, 124, 32);
  }
  </style>
  