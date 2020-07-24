import axios from 'axios'
import * as types from '../mutation-types'

// State
export const state = {
  post: null
}

// Getters
export const getters = {
  post: state => state.post
}

export const mutations = {
  [types.SAVE_POST] (state, { post }) {
    axios.post('/api/posts/store', {
      post
    })
    state.post = post
  },

  [types.FETCH_POST_SUCCESS] (state, { post }) {
    state.post = post
  },

  [types.FETCH_POST_FAILURE] (state) {
    state.post = null
  }
}

export const actions = {

  savePost ({ commit, displatch }, payload) {
    commit(types.SAVE_POST, payload)
  },

  async fetchPosts ({ commit }) {
    try {
      const { data } = await axios.get('/api/posts/all')
      commit(types.FETCH_POST_SUCCESS, { post: data })
    } catch (e) {
      commit(types.FETCH_POST_FAILURE)
    }
  }
}
