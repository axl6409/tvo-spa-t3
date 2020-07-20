import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
  profile: null
}

// getters
export const getters = {
  profile: state => state.profile
}

// mutations
export const mutations = {
  [types.FETCH_PROFILE_SUCCESS] (state, { profile }) {
    state.profile = profile
  },

  [types.FETCH_PROFILE_FAILURE] (state) {
    state.profile = null
  }

}

// actions
export const actions = {
  async fetchProfile ({ commit }) {
    try {
      const { data } = await axios.get('/api/profile/all')
      commit(types.FETCH_PROFILE_SUCCESS, { profile: data })
    } catch (e) {
      commit(types.FETCH_PROFILE_FAILURE)
    }
  }
}
