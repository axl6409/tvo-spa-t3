import axios from 'axios'
import * as types from '../mutation-types'

// State
export const state = {
  all: [],
  message: null
}

// Getters
export const getters = {
  all: state => state.all,
  message: state => state.message
}

// Mutations
export const mutations = {
  [types.FETCH_ROLES] (state) {
    axios.get('/api/roles/all')
      .then((response) => {
        console.log(response)
        state.all = response.data
      })
      .catch((error) => {
        console.log(error)
        state.message = error
      })
  },

  [types.DELETE_ROLE] (state, id) {
    axios.delete('/api/roles/delete/' + id)
      .then((response) => {
        console.log(response)
        state.message = response.data
      })
      .catch((error) => {
        console.log(error)
        state.message = error
      })
    var index = state.post.findIndex(p => p.id === id)
    state.post.splice(index, 1)
  }
}

// Actions
export const actions = {

  fetchRoles ({ commit }) {
    commit(types.FETCH_ROLES)
  },

  deleteRole ({ commit }, id) {
    commit(types.DELETE_ROLE, id)
  }
}
