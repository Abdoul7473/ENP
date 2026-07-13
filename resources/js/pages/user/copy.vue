<template>
  <guest-layout>
      <div id="app">
          <v-app>
              <v-container>
                  <v-row justify="center">
                      <v-col cols="12" sm="4">
                          <v-form>
                              <v-text-field v-model="password" @input="validatePassword"  :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'" :rules="[rules.required, rules.min, rules.strength]" :type="showPassword ? 'text' : 'password'" label="Password" class="mb-6" @click:append="showPassword = !showPassword"></v-text-field>
                              <v-progress-linear :color="score.color" :value="score.value"></v-progress-linear>
                          </v-form>
                          <v-btn type="submit" :disabled="!isValid" color="primary"> Enregistrer</v-btn>
                      </v-col>
                  </v-row>
              </v-container>
          </v-app>
      </div>
  </guest-layout>
  </template>
  
  <script>
  import ApplicationLogo from "../../components/ApplicationLogo.vue";
  import GuestLayout from '../../layouts/GuestLayout.vue';
  import {
      zxcvbn
  } from '@zxcvbn-ts/core'
  export default {
      props: {
          email: String,
          token: String,
      },
      components: {
          ApplicationLogo,
          GuestLayout
      },
      data() {
          return {
              isValid: false,
              showPassword: false,
              password: '',
              rules: {
                  required: value => !!value || 'Enter a password',
                  min: v => v.length >= 8 || 'Use 8 characters or more for your password',
                  strength: v => zxcvbn(v).score >= 3 || 'Please choose a stronger password. Try a mix of letters, numbers, and symbols.',
              },
          }
      },
      methods: {
          validatePassword() {
            
              const result = zxcvbn(this.password);
              const hasMinimumLength = this.password.length >= 8;
              const hasUppercase = /[A-Z]/.test(this.password);
              const hasSymbol = /[!@#$%^&*(),.?":{}|<>]/.test(this.password); // Vous pouvez ajuster les symboles en fonction de vos besoins
  
              this.isValid = result.score >= 3 && hasMinimumLength && hasUppercase && hasSymbol;
              console.log(this.isValid)
          }
      },
  
      computed: {
          score() {
              const result = zxcvbn(this.password);
  
              switch (result.score) {
                  case 4:
                      return {
                          color: "light-blue",
                              value: 100
                      };
                  case 3:
                      return {
                          color: "light-green",
                              value: 75
                      };
                  case 2:
                      return {
                          color: "yellow",
                              value: 50
                      };
                  case 1:
                      return {
                          color: "orange",
                              value: 25
                      };
                  default:
                      return {
                          color: "red",
                              value: 0
                      };
              }
          }
      }
  };
  </script>
  