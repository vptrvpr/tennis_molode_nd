import * as types from "../mutation-types";

export const state = {
    preloaders: [],
    text: ''
}

// getters
export const getters = {
    preloaders: state => state.preloaders,
    text: state => state.text
}

// mutations
export const mutations = {
    [ types.ADD_PRELOADER ]( state ) {
        state.preloaders.push( { preloader: 'default' } )
    },

    [ types.DELETE_PRELOADER ]( state ) {
        setTimeout( () => {
            state.preloaders.pop()
        }, 150 )
    }
}

// actions
export const actions = {
    addPreloader( { commit } ) {
        commit( types.ADD_PRELOADER )
    },

    deletePreloader( { commit } ) {
        commit( types.DELETE_PRELOADER )
    }
}
