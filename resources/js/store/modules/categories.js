import axios from 'axios'
import * as types from '../mutation-types'

// State
export const state = {
  categories: null,
  message: ''
}

// Getters
export const getters = {
  categories: state => state.categories,
  message: state => state.message
}

// Mutations
export const mutations = {
  [types.SAVE_CAT] (state, category) {
    axios.post('/api/categories/store', category, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })
      .then((response) => {
        console.log(response)
        state.message = 'Catégorie Créée !'
      })
      .catch((error) => {
        console.log(error)
        state.message = 'Erreur lors de la création !'
      })
  },

  [types.PUSH_CATEGORY] (state, category) {
    state.categories.push(category)
  },

  [types.FETCH_CATEGORIES_SUCCESS] (state, { categories }) {
    state.categories = categories
  },

  [types.FETCH_CATEGORIES_FAILURE] (state) {
    state.categories = null
  },

  [types.DELETE_CATEGORY] (state, id) {
    axios.delete('/api/categories/delete/' + id)
      .then((response) => {
        console.log(response)
        state.message = 'Catégorie supprimée !'
      })
      .catch((error) => {
        console.log(error)
        state.message = 'Erreur lors de la suppresion !'
      })
    var index = state.categories.findIndex(p => p.id === id)
    state.categories.splice(index, 1)
  }
}

export const actions = {

  saveCategory ({ commit, dispatch }, payload) {
    commit(types.SAVE_CAT, payload)
    commit(types.PUSH_CATEGORY, payload)
  },

  async fetchCategories ({ commit }) {
    try {
      const { data } = await axios.get('/api/categories/all')
      commit(types.FETCH_CATEGORIES_SUCCESS, { categories: data.data })
    } catch (e) {
      commit(types.FETCH_CATEGORIES_FAILURE)
    }
  },

  deleteCategory ({commit}, category) {
    commit(types.DELETE_CATEGORY, category)
  }
}
