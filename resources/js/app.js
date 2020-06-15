import Vue from 'vue'
import store from '~/store'
import router from '~/router'
import i18n from '~/plugins/i18n'
import App from '~/components/App'
import Vuetify from 'vuetify'
import moment from 'moment'

Vue.use( Vuetify )

Vue.prototype.$blue = '#2196F3';
Vue.prototype.$green = '#CDDC39';
Vue.prototype.$moment = moment;


const vuetify = new Vuetify( {
  lang: {
    current: 'ru',
  },
} );

import '~/plugins'
import '~/components'

Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue( {
  i18n,
  store,
  router,
  vuetify,
  ...App
} )
