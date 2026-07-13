<template>
<v-footer color="secondary" padless dark class="font-weight-medium" fixed app style="background-color: #37474F; bottom: 0; width: 100%; height: 100px;">
    <v-row justify="center" align="center">
        <!-- <v-col cols="12" sm="6" md="3">
            <v-img src="../../enp.jpeg" max-height="130" contain class="grey darken-4"></v-img>
        </v-col> -->

        <v-col cols="12" sm="6" md="3">
            <v-card-text>

            </v-card-text>
        </v-col>

        <v-col cols="12" sm="6" md="6">
            <v-card-text>
                <v-btn
                v-for="icon in icons"
                :key="icon"
                class="mx-4 white--text"
                icon
                >
                    <v-icon size="24px">
                        {{ icon }}
                    </v-icon>
                </v-btn>
            </v-card-text>
        </v-col>
    </v-row>

    <v-row align="center" justify="center">
        <v-col>
            <v-card-text class="white--text">
                <div class="text-center white--text">
                    &copy; {{ new Date().getFullYear() }} Officiers de Police (Promotion 025). {{ $t('welcome.mark_company') }}.
                </div>
            </v-card-text>
        </v-col>
    </v-row>
</v-footer>
</template>

  
<script>
export default {
    data: () => ({
        icons: [
            'mdi-facebook',
            'mdi-twitter',
            'mdi-linkedin',
            'mdi-instagram',
        ],
    }),
}
</script>

  
<style scoped>
/* Add your custom styles here */
</style>
    