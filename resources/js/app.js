require("./bootstrap")
require("./plugins/vue-toastification")
import Vue from "vue"
import {
  App as InertiaApp,
  plugin as InertiaPlugin
} from "@inertiajs/inertia-vue"
import { Link } from "@inertiajs/inertia-vue"
import vuetify from "./plugins/vuetify"
import 'sweetalert2/dist/sweetalert2.min.css'
import {format} from 'date-fns'
import { InertiaProgress } from "@inertiajs/progress"
import VueGates from 'vue-gates'
import VueSweetalert2 from 'vue-sweetalert2'
// import * as directives from 'vuetify/directives'
import VCurrencyField from 'v-currency-field'
import TextField from '../js/components/Form/TextField'
import TextareaField from '../js/components/Form/TextareaField'
import DateField from '../js/components/Form/DateField'
import DateRangePicker from '../js/components/Form/DateRangePicker'
import SelectField from '../js/components/Form/SelectField'
import AppTable from '../js/components/AppTable'
import BtnAction from '../js/components/BtnAction'
import CustomDataTable from '../js/components/CustomDataTable'
import QueryB from '../js/components/QueryB'
import QueryBuilder from '../js/components/QueryBuilder'
import NavigationBtn from '../js/components/NavigationBtn'
import Toolbar from '../js/components/Toolbar'
import SelectFiled from '../js/components/SelectFiled.vue'
import Demande from '../js/components/Rapport/Demande.vue'
import Autorisations from '../js/components/Rapport/Autorisations.vue'
import Aeronefs from '../js/components/Rapport/Aeronefs.vue'
import Routes from '../js/components/Rapport/Routes.vue'
import Resultat from '../js/components/Rapport/Resultat.vue'
import CustomTable from '../js/components/CustomTable'
import VueI18n from 'vue-i18n';
import en from './locales/en.json';
import fr from './locales/fr.json';


const options = {
  cancelButtonColor: '#F44336',
  confirmButtonColor: 'primary',
  confirmButtonText: 'Ok',
  cancelButtonText: 'Annuler',
  reverseButtons: true
};


Vue.prototype.$alert = {
  confirm: (title, text = '', callBack) => {
      Vue.prototype.$swal({
          title,
          text,
          showCancelButton: true,
          icon: 'warning',
      }).then(res => {
          if(res.isConfirmed) {
              callBack()
          }
      })
  },
  success: (text = '') => {
      Vue.prototype.$swal({
          title: 'SUCCES',
          text,
          icon: 'success',
          confirmButtonColor: '#33ba6d',

      })
  },

  error: (text = '') => {
      Vue.prototype.$swal('ERREUR', text, 'error')
  },

  info: (text = '') => {
      Vue.prototype.$swal('INFO', text, 'info')
  },
  warning: (text = '') => {
      Vue.prototype.$swal('AVERTISSEMENT', text, 'warning')
  },

  messages: (messages= {}) => {
      const keys = Object.keys(messages)
      let text = ''
      keys.forEach((v) => {
          text+= `<h5 style="color: red">${messages[v]}</h5>`
      })
      Vue.prototype.$swal('ERREUR', text, 'error')

  }
}

Vue.use(VueI18n);

const i18n = new VueI18n({
    locale: 'fr', // langue par défaut
    fallbackLocale: 'en',
    messages: {
        en,
        fr,
    },
});

Vue.use(VCurrencyField, {
  locale: 'fr-FR',
  decimalLength: {min: 0, max: 4},
  autoDecimalMode: false,
  min: null,
  max: null,
  defaultValue: 0,
  valueAsInteger: false,
  allowNegative: true
})
Vue.prototype.$route = route
Vue.prototype.$formatDate = (date, datetime = true) => {
  const options = datetime ? 'dd/MM/yyyy HH:mm:s' : 'dd/MM/yyyy'
  return format(new Date(date), options)
}
Vue.prototype.$formatAmount = (value) => {
  if (value === null || value === undefined || value === '') return '0'
  const raw = typeof value === 'string' ? value.replace(/\s+/g, '').replace(/,/g, '') : value
  const num = Number(raw)
  if (!isFinite(num)) return String(value)
  const intVal = Math.round(num)
  return intVal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ')
}
Vue.use(VueSweetalert2, options);
Vue.use(VueGates)
Vue.use(InertiaPlugin)
Vue.component("SelectFiled", SelectFiled)
Vue.component("Link", Link)
Vue.component('TextField', TextField)
Vue.component('TextareaField', TextareaField)
Vue.component('DateField', DateField)
Vue.component('DateRangePicker', DateRangePicker)
Vue.component('SelectField', SelectField)
Vue.component('AppTable', AppTable)
Vue.component('BtnAction', BtnAction)
Vue.component('CustomDataTable', CustomDataTable)
Vue.component('CustomTable', CustomTable)
Vue.component('NavigationBtn', NavigationBtn)
Vue.component('Toolbar', Toolbar)
Vue.component('QueryB', QueryB)
Vue.component('QueryBuilder', QueryBuilder)
Vue.component('Demande', Demande)
Vue.component('Autorisations', Autorisations)
Vue.component('Aeronefs', Aeronefs)
Vue.component('Routes', Routes)
Vue.component('Resultat', Resultat)
Vue.mixin({ methods: { route: window.route } })
const app = document.getElementById("app")
// app.use(i18n)
new Vue({
  vuetify,
  i18n,
  render: h =>
    h(InertiaApp, {
      props: {
        title: title => `${title} - My App`,
        initialPage: JSON.parse(app.dataset.page),
        resolveComponent: name => require(`./pages/${name}`).default
      }
    })
}).$mount(app)

InertiaProgress.init({ color: "#fff" })
