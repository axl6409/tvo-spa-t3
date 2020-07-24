import axios from 'axios'
import * as types from '../mutation-types'

// State
export const state = {
  media: null
}

// Getters
export const getters = {
  media: state => state.media
}

// Mutations
export const mutations = {
  [types.SAVE_MEDIA] (state, { media }) {
    axios.post('/api/medias/store', {
      media
    })
    state.media = media
  },

  [types.FETCH_MEDIA_SUCCESS] (state, { media }) {
    state.media = media
  },

  [types.FETCH_MEDIA_FAILURE] (state) {
    state.media = null
  }
}

export const actions = {

  saveMedia ({ commit, dispatch }, payload) {
    commit(types.SAVE_MEDIA, payload)
  },

  async fetchMedia ({ commit }) {
    try {
      const { data } = await axios.get('/api/medias/all')
      commit(types.FETCH_MEDIA_SUCCESS, { media: data })
    } catch (e) {
      commit(types.FETCH_MEDIA_FAILURE)
    }
  }
}
