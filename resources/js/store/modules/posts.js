import axios from 'axios'
import * as types from '../mutation-types'

// State
export const state = {
  post: [],
  message: null
}

// Getters
export const getters = {
  posts: state => state.post,
  messages: state => state.message
}

export const mutations = {
  [types.SAVE_POST] (state, post) {
    axios.post('/api/posts/store', post, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })
      .then((response) => {
        state.message = 'Post created with success !'
      })
      .catch((error) => {
        console.log(error)
      })
  },

  [types.PUSH_POST] (state, post) {
    state.post.push(post)
  },

  [types.DELETE_POST] (state, id) {
    axios.delete('/api/posts/delete/' + id)
      .then((response) => {
        state.message = 'Post deleted with success !'
      })
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
    commit(types.PUSH_POST, payload)
  },

  async fetchPosts ({ commit }) {
    try {
      const { data } = await axios.get('/api/posts/index')
      commit(types.FETCH_POST_SUCCESS, { post: data })
    } catch (e) {
      commit(types.FETCH_POST_FAILURE)
    }
  },

  deletePost ({ commit }, post) {
    commit(types.DELETE_POST, post)
  }
}
