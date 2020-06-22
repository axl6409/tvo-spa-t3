import axios from 'axios'
import * as types from '../mutation-types'
import Cookies from 'js-cookie'

// state
export const state = {
  stats: null,
  characters: null,
  token: Cookies.get('token')
}

// getters
export const getters = {
  stats: state => state.stats,
  characters: state => state.characters
}

// mutations
export const mutation = {
  [types.SAVE_TOKEN] (state, { token, remember }) {
    state.token = token
    Cookies.set('token', token, { expires: remember ? 365 : null })
  },

  [types.FETCH_CHARACT_SUCCESS] (state, { characters }) {
    state.characters = characters
  },

  [types.FETCH_STATS_SUCCESS] (state, { stats }) {
    state.stats = stats
  },

  [types.FETCH_CHARACT_FAILURE] (state) {
    state.token = null
    Cookies.remove('token')
  },

  [types.FETCH_STATS_FAILURE] (state) {
    state.token = null
    Cookies.remove('token')
  },

  [types.UPDATE_CHARACTERS] (state, { characters }) {
    state.characters = characters
  },

  [types.UPDATE_STATS] (state, { stats }) {
    state.stats = stats
  }
}

// actions
export const actions = {
  saveToken ({ commit, dispatch }, payload) {
    commit(types.SAVE_TOKEN, payload)
  },

  async fetchCharacters ({ commit }) {
    try {

      axios.defaults.baseURL = 'https://www.bungie.net/Platform'
      axios.defaults.headers.common['X-API-KEY'] = process.env('BUNGIE_API_KEY')
      const { data } = await axios.get('/api/profile')

      commit(types.FETCH_CHARACT_SUCCESS, { characters: data })
    } catch (e) {
      commit(types.FETCH_CHARACT_FAILURE)
    }
  },
  updateUser ({ commit }, payload) {
    commit(types.UPDATE_CHARACTERS, payload)
  }

}
