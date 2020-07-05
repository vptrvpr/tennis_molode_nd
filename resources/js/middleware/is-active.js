import store from '~/store'

export default async ( to, from, next ) => {
  if ( store.getters[ 'auth/user' ].is_active ) {
    next()
  } else {
    next( { name: 'not-active' } )
  }
}
