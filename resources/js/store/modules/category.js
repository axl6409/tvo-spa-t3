import axios from 'axios'
import * as types from '../mutation-types'

// State
export const state = {
  category: null
}

// Getters
export const getters = {
  category: state => state.category
}

// Mutations
export const mutations = {
  [types.SAVE_CAT] (state, { category }) {
    axios.post('/api/medias/store', {
      category
    })
    state.category = category
  },

  [types.FETCH_CAT_SUCCESS] (state, { category }) {
    state.category = category
  },

  [types.FETCH_CAT_FAILURE] (state) {
    state.category = null
  }
}

export const actions = {

  saveCategory ({ commit, dispatch }, payload) {
    commit(types.SAVE_CAT, payload)
  },

  async fetchCategories ({ commit }) {
    try {
      const { data } = await axios.get('/api/categories/all')
      commit(types.FETCH_CAT_SUCCESS, { category: data })
    } catch (e) {
      commit(types.FETCH_CAT_FAILURE)
    }
  }
}
