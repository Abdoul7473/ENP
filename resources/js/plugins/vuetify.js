import Vue from "vue"
import Vuetify from "vuetify"
import fr from 'vuetify/lib/locale/fr'
import colors from "vuetify/lib/util/colors"
import "vuetify/dist/vuetify.min.css"
import "@mdi/font/css/materialdesignicons.css"
import './vee-validate'
Vue.use(Vuetify)

const options = {
  theme: {
    light: true,
    themes: {
      light: {
        primary: '#037832',
        secondary: '#F37C20',
        accent: '#8c9eff',
        error: '#b71c1c',
        info: colors.teal.lighten1,
        warning: colors.amber.base,
        success: colors.green.accent3
      }
    }
  },
  icons: {
    iconfont: "mdi"
  },
  lang: {
    locales: { fr },
    current: 'fr',
  },
}

export default new Vuetify(options)
