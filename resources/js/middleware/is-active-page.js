import store from '~/store'

export default async ( to, from, next ) => {
    if ( store.getters[ 'auth/check' ] ) {
        if ( store.getters[ 'auth/user' ].is_active || store.getters[ 'auth/user' ].checkRole( 1 ) ) {
            next( { name: 'reservation' } )
        } else {
            next()
        }
    } else {
        next( { name: 'login' } )
    }

}
