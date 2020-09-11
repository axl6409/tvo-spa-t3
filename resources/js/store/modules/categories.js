import axios from 'axios'
import * as types from '../mutation-types'

// State
export const state = {
  category: [],
  message: ''
}

// Getters
export const getters = {
  categories: state => state.category,
  message: state => state.message
}

// Mutations
export const mutations = {

  [types.FETCH_CATEGORIES_SUCCESS] (state, { categories }) {
    state.category = categories
  },

  [types.FETCH_CATEGORIES_FAILURE] (state) {
    state.category = null
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
    var index = state.category.findIndex(p => p.id === id)
    state.category.splice(index, 1)
  }
}

export const actions = {

  async fetchCategories ({ commit }) {
    try {
      const { data } = await axios.get('/api/categories/index')
      commit(types.FETCH_CATEGORIES_SUCCESS, { categories: data.data })
    } catch (e) {
      commit(types.FETCH_CATEGORIES_FAILURE)
    }
  },

  async fetchCategoryById ({ commit }, id) {
    try {
      const { data } = await axios.get('/api/categories/edit/' + id)
      console.log(data)
      commit(types.FETCH_CATEGORIES_SUCCESS, { categories: data.data })
    } catch (e) {
      console.log(e)
      commit(types.FETCH_CATEGORIES_FAILURE)
    }
  },

  deleteCategory ({ commit }, category) {
    commit(types.DELETE_CATEGORY, category)
  }
}
