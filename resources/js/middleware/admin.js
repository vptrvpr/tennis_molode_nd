import store from '~/store'

export default ( to, from, next ) => {
    console.log( store.getters[ 'auth/user' ] )
    if ( !store.getters[ 'auth/user' ].checkRole( 1 ) ) {
        next( { name: 'reservation' } )
    } else {
        next()
    }
}
