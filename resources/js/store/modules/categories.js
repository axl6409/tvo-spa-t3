import axios from 'axios'
import * as types from '../mutation-types'

// State
export const state = {
  categories: null
}

// Getters
export const getters = {
  categories: state => state.categories
}

// Mutations
export const mutations = {
  [types.SAVE_CAT] (state, { categories }) {
    state.categories = categories
  },

  [types.FETCH_CATEGORIES_SUCCESS] (state, { categories }) {
    state.categories = categories
  },

  [types.FETCH_CATEGORIES_FAILURE] (state) {
    state.categories = null
  }
}

export const actions = {

  saveCategory ({ commit, dispatch }, payload) {
    commit(types.SAVE_CAT, payload)
  },

  async fetchCategories ({ commit }) {
    try {
      const { data } = await axios.get('/api/categories/all')
      commit(types.FETCH_CATEGORIES_SUCCESS, { categories: data })
    } catch (e) {
      commit(types.FETCH_CATEGORIES_FAILURE)
    }
  }
}
