import axios from 'axios'
import * as types from '../mutation-types'

// State
export const state = {
  tags: null
}

// Getters
export const getters = {
  tags: state => state.tags
}

// Mutations
export const mutations = {
  [types.SAVE_TAGS] (state, { tags }) {
    axios.post('/api/medias/store', {
      tags
    })
    state.tags = tags
  },

  [types.FETCH_TAGS_SUCCESS] (state, { tags }) {
    state.tags = tags
  },

  [types.FETCH_TAGS_FAILURE] (state) {
    state.tags = null
  }
}

export const actions = {

  saveTags ({ commit, dispatch }, payload) {
    commit(types.SAVE_TAGS, payload)
  },

  async fetchTags ({ commit }) {
    try {
      const { data } = await axios.get('/api/tags/all')
      commit(types.FETCH_TAGS_SUCCESS, { tag: data })
    } catch (e) {
      commit(types.FETCH_TAGS_FAILURE)
    }
  }
}
