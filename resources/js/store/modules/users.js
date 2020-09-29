import axios from 'axios'
import * as types from '../mutation-types'

// State
export const state = {
  all: [],
  user: null,
  message: null
}

// Getters
export const getters = {
  all: state => state.all,
  user: state => state.user,
  message: state => state.message
}

// Mutations
export const mutations = {
  [types.ASSIGN_ROLE] (state, id, roleId) {
    axios.patch('/api/users/assignRole/' + id, roleId)
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
  },

  [types.FETCH_USER_BY_ID] (state, id) {
    axios.get('/api/users/single/' + id)
      .then((response) => {
        console.log(response)
        state.user = response.data
      })
      .catch((error) => {
        console.log(error)
        state.message = error
      })
  },

  [types.DELETE_USER] (state, id) {
    axios.delete('/api/users/delete/' + id)
      .then((response) => {
        console.log(response)
        state.message = 'Utilisateur Supprimé'
      })
      .catch((error) => {
        console.log(error)
        state.message = error
      })
    var index = state.all.findIndex(p => p.id === id)
    state.all.splice(index, 1)
  }
}

// Actions
export const actions = {

  assignRole ({ commit }, id, roleId) {
    commit(types.ASSIGN_ROLE, id, roleId)
  },

  deleteUser ({ commit }, id) {
    commit(types.DELETE_USER, id)
  },

  fetchUsers ({ commit }) {
    commit(types.FETCH_USERS)
  },

  fetchUserById ({ commit }, id) {
    commit(types.FETCH_USER_BY_ID, id)
  },

  fetchUserInfos ({ commit }, id) {
    commit(types.FETCH_USER_INFOS, id)
  }
}
