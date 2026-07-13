<template>
    <v-app-bar app color="secondary" dark flat class="px-12" >
      <!-- <v-btn >
        <v-icon color="primary" left class="mr-2">mdi-signature</v-icon> ANAC Niger
      </v-btn> -->

      <v-spacer></v-spacer>
      <v-btn text @click="scroll('home')" class="text-yellow">Home</v-btn>
      <v-btn text @click="scroll('about')"  >À propos</v-btn>
      <v-btn text @click="scroll('contact')"  > Contact</v-btn>
      <NavigationBtn text :href="$route('connexionpage')"> Connexion</NavigationBtn>
      <!-- <NavigationBtn text :href="$route('connexionpage', {params: 2})"> Inscription</NavigationBtn> -->
      <!-- <v-btn text @click="switchStep('connexion')"> Connexion</v-btn>
      <v-btn text @click="switchStep('inscription')"> Inscription</v-btn> -->
    </v-app-bar>
  </template>

  <script>
  export default {
    methods: {
      scroll(refName) {
        const element = document.getElementById(refName);
        element.scrollIntoView({ behavior: "smooth" });
      },
      switchStep(step) {
        this.$emit('switchStep', step);
        },
    },
  };
  </script>

  <style>
  </style>
