import axios from 'axios'
import Cookies from 'js-cookie'
import * as types from '../mutation-types'

// state
export const state = {
  user: {
    id: 0,
    checkRole: function ( role ) {
      return true
    },
  },
  token: Cookies.get( 'token' )
}

// getters
export const getters = {
  user: state => state.user,
  token: state => state.token,
  check: state => state.user.id !== 0
}

// mutations
export const mutations = {
  [ types.SAVE_TOKEN ]( state, { token, remember } ) {
    state.token = token
    Cookies.set( 'token', token, { expires: remember ? 365 : null } )
  },

  [ types.FETCH_USER_SUCCESS ]( state, { user } ) {
    user.checkRole = function ( roleId ) {
      var checkResult = false
      user.roles.map( item => {
        if ( item.id === roleId ) {
          checkResult = true
        }
      } )
      return checkResult
    }
    state.user = user
  },

  [ types.FETCH_USER_FAILURE ]( state ) {
    state.token = null
    Cookies.remove( 'token' )
  },

  [ types.LOGOUT ]( state ) {
    state.user = null
    state.token = null

    Cookies.remove( 'token' )
  },

  [ types.UPDATE_USER ]( state, { user } ) {
    user.checkRole = function ( roleId ) {
      var checkResult = false
      user.roles.map( item => {
        if ( item.id === roleId ) {
          checkResult = true
        }
      } )
      return checkResult
    }
    state.user = user
  }
}

// actions
export const actions = {
  saveToken( { commit, dispatch }, payload ) {
    commit( types.SAVE_TOKEN, payload )
  },

  async fetchUser( { commit } ) {
    try {
      const { data } = await axios.get( '/api/user' )

      commit( types.FETCH_USER_SUCCESS, { user: data } )
    } catch ( e ) {
      commit( types.FETCH_USER_FAILURE )
    }
  },

  updateUser( { commit }, payload ) {
    commit( types.UPDATE_USER, payload )
  },

  async logout( { commit } ) {
    try {
      await axios.post( '/api/logout' )
    } catch ( e ) {
    }

    commit( types.LOGOUT )
  },

  async fetchOauthUrl( ctx, { provider } ) {
    const { data } = await axios.post( `/api/oauth/${provider}` )

    return data.url
  }
}
