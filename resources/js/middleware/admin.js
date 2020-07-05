import store from '~/store'

export default ( to, from, next ) => {
  if ( !store.getters[ 'auth/user' ].checkRole( 1 ) ) {
    next( { name: '/' } )
  } else {
    next()
  }
}
