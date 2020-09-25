import axios from 'axios'
import * as types from '../mutation-types'

// State
export const state = {
  infos: null,
  members: null,
  message: null
}

// Getters
export const getters = {
  infos: state => state.infos,
  members: state => state.members,
  message: state => state.message
}

// Mutations
export const mutations = {
  [types.FETCH_CLAN_INFOS] (state) {
    axios.get('/api/clan/infos')
      .then((response) => {
        console.log(response)
        state.infos = response.data
      })
      .catch((error) => {
        console.log(error)
        state.message = error
      })
  },

  [types.FETCH_CLAN_MEMBERS] (state) {
    axios.get('/api/clan/members')
      .then((response) => {
        console.log(response)
        state.members = response.data
      })
      .catch((error) => {
        console.log(error)
        state.message = error
      })
  }
}

// Actions
export const actions = {
  fetchInfos ({ commit }) {
    commit(types.FETCH_CLAN_INFOS)
  },

  fetchMembers ({ commit }) {
    commit(types.FETCH_CLAN_MEMBERS)
  }
}
