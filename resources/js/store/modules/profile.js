import axios from 'axios'
import Cookies from 'js-cookie'
import * as types from '../mutation-types'

// state
export const state = {
  characters: null
}

// getters
export const getters = {
  characters: state => state.characters
}

// mutations
export const mutations = {

  [types.FETCH_CHARACT_SUCCESS] (state, { characters }) {
    state.characters = characters
  },

  [types.UPDATE_CHARACT] (state, { characters }) {
    state.characters = characters
  }
}

// actions
export const actions = {

  async fetchCharacters ({ commit }) {
    try {
      const { data } = await axios.get('/api/characters/all')
      console.log(axios.get('/api/characters/all'))
      commit(types.FETCH_CHARACT_SUCCESS, { characters: data })
    } catch (e) {
      commit(types.FETCH_CHARACT_FAILURE)
    }
  },

  updateCharacters ({ commit }, payload) {
    commit(types.UPDATE_CHARACT, payload)
  }
}
