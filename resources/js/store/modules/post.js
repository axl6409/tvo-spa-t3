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

  [types.DELETE_POST] (state, id) {
    var index = state.post.findIndex(p => p.id === id)
    state.post.splice(index, 1)
  },

  [types.FETCH_POST_SUCCESS] (state, { post }) {
    state.post = post
  },

  [types.FETCH_POST_FAILURE] (state) {
    state.post = null
  }
}

export const actions = {

  savePost ({ commit, dispatch }, payload) {
    commit(types.SAVE_POST, payload)
  },

  async fetchPosts ({ commit }) {
    try {
      const { data } = await axios.get('/api/posts/index')
      console.log(data)
      commit(types.FETCH_POST_SUCCESS, { post: data })
    } catch (e) {
      commit(types.FETCH_POST_FAILURE)
    }
  },

  deletePost ({ commit }, post) {
    axios.delete('/api/posts/delete/' + post.id)
      .then(function () {
        commit(types.DELETE_POST, post)
      })
  }
}
