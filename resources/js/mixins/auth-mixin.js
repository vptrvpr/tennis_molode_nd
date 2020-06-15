import { mapGetters } from "vuex";

const AuthMixin = {
  computed: mapGetters( {
    authUser: 'auth/user'
  } )
}

export default AuthMixin
