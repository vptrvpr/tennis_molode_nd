import Vue from 'vue'
import store from '~/store'
import router from '~/router'
import i18n from '~/plugins/i18n'
import App from '~/components/App'
import Vuetify from 'vuetify'
import moment from 'moment'
import VueTheMask from 'vue-the-mask'
import Notifications from 'vue-notification'


Vue.use( Notifications )
Vue.use( Vuetify )
Vue.use( VueTheMask )

Vue.prototype.$blue = '#2196F3';
Vue.prototype.$red = '#F44336';
Vue.prototype.$green = '#CDDC39';
Vue.prototype.$moment = moment;


Vue.prototype.$notif = function ( responseDate, error = false ) {
  console.log(responseDate)
  this.$notify( {
    group: 'all',
    title: error ? 'Ошибка' : 'Успешно',
    text: responseDate.text,
    type: error ? 'error' : 'success',
    duration: 7500,
  } );

  return true;
}


moment.updateLocale( 'en', {
  week: {
    dow: 1,
  },
} )


const vuetify = new Vuetify( {
  lang: {
    current: 'ru',
  },
} );

function randomInteger( min, max ) {
  // получить случайное число от (min-0.5) до (max+0.5)
  let rand = min - 0.5 + Math.random() * ( max - min + 1 );
  return Math.round( rand );
}


if ( localStorage.user_id === undefined ) {
  localStorage.user_id = randomInteger( 1, 1000000 )
}

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
