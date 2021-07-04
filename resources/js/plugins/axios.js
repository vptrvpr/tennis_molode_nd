import axios from 'axios'
import store from '~/store'
import router from '~/router'
import Swal from 'sweetalert2'
import i18n from '~/plugins/i18n'
import Vue from 'vue'


axios.interceptors.request.use( request => {
    const token = store.getters[ 'auth/token' ]
    if ( token ) {
        request.headers.common[ 'Authorization' ] = `Bearer ${token}`
    }

    if ( request.is_background !== true ) {
        store.dispatch( 'preloader/addPreloader' )
    }

    const locale = store.getters[ 'lang/locale' ]
    if ( locale ) {
        request.headers.common[ 'Accept-Language' ] = locale
    }

    return request
} )


// Response interceptor
axios.interceptors.response.use( response => {
    if ( response.config.is_background !== true ) {
        store.dispatch( 'preloader/deletePreloader' )
    }
    return response;
}, error => {
    const { status, data } = error.response
    const { config } = error

    if ( config.is_background !== true ) {
        store.dispatch( 'preloader/deletePreloader' )
    }

    if ( status >= 500 ) {
        Vue.prototype.$notification( 'Упс, произошла ошибка. Попробуйте позже...', true )
    }

    if ( data.text !== undefined ) {
        Vue.prototype.$notif( data, true )
    }

    // if ( status == 422 ) {
    //   Vue.prototype.$notification( 'Проверьте правильность ввода данных и повторите попытку', true )
    // }

    if ( status === 401 && store.getters[ 'auth/check' ] ) {
        Swal.fire( {
            type: 'warning',
            title: i18n.t( 'token_expired_alert_title' ),
            text: i18n.t( 'token_expired_alert_text' ),
            reverseButtons: true,
            confirmButtonText: i18n.t( 'ok' ),
            cancelButtonText: i18n.t( 'cancel' )
        } ).then( () => {
            store.commit( 'auth/LOGOUT' )

            router.push( { name: 'login' } )
        } )
    }

    return Promise.reject( error )
} )


// Request interceptor
// axios.interceptors.request.use( request => {
//   const token = store.getters[ 'auth/token' ]
//   if ( token ) {
//     request.headers.common[ 'Authorization' ] = `Bearer ${token}`
//   }
//
//   if ( request.is_background !== true ) {
//     store.dispatch( 'preloader/addPreloader' )
//   }
//
//   const locale = store.getters[ 'lang/locale' ]
//   if ( locale ) {
//     request.headers.common[ 'Accept-Language' ] = locale
//   }
//
//
//   request.headers['X-Socket-Id'] = Echo.socketId()
//
// return request
// } )
//
// Response interceptor
// axios.interceptors.response.use( response => {
//   if ( response.config.is_background !== true ) {
//     store.dispatch( 'preloader/deletePreloader' )
//   }
//
//   return response;
// }, error => {
// }, error => {
//   const { status } = error.response
//   const { config } = error
//
//   if ( config.is_background !== true ) {
//     store.dispatch( 'preloader/deletePreloader' )
//   }
//
//   if ( status >= 500 ) {
//     Swal.fire( {
//       type: 'error',
//       title: i18n.t( 'error_alert_title' ),
//       text: i18n.t( 'error_alert_text' ),
//       reverseButtons: true,
//       confirmButtonText: i18n.t( 'ok' ),
//       cancelButtonText: i18n.t( 'cancel' )
//     } )
//   }
//
//   if ( status === 401 && store.getters[ 'auth/check' ] ) {
//     Swal.fire( {
//       type: 'warning',
//       title: i18n.t( 'token_expired_alert_title' ),
//       text: i18n.t( 'token_expired_alert_text' ),
//       reverseButtons: true,
//       confirmButtonText: i18n.t( 'ok' ),
//       cancelButtonText: i18n.t( 'cancel' )
//     } ).then( () => {
//       store.commit( 'auth/LOGOUT' )
//
//       router.push( { name: 'login' } )
//     } )
//   }
//
//   return Promise.reject( error )
// } )
