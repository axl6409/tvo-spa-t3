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
  [types.ASSIGN_ROLE] (state, id) {
    axios.post('/api/users/setAdmin/' + id)
      .then((response) => {
        console.log(response)
        state.message = response.data
      })
      .catch((error) => {
        console.log(error)
        state.message = error
      })
  },

  [types.FETCH_USERS] (state) {
    axios.get('/api/users/all')
      .then((response) => {
        console.log(response)
        state.all = response.data
      })
      .catch((error) => {
        console.log(error)
        state.message = error
      })
  }
}

// Actions
export const actions = {

  assignRole ({ commit }, id) {
    commit(types.ASSIGN_ROLE, id)
  },

  fetchUsers ({ commit }) {
    commit(types.FETCH_USERS)
  }
}
