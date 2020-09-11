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

  [types.FETCH_POSTS_SUCCESS] (state, { post }) {
    state.post = post
  },

  [types.FETCH_POSTS_FAILURE] (state) {
    state.post = null
  },

  [types.FETCH_POST_BY_ID] (state, id) {
    axios.get('/api/posts/edit/' + id)
      .then((response) => {
        console.log(response)
      })
      .catch((error) => {
        console.log(error)
        state.message = error
      })
  },

  [types.DELETE_POST] (state, id) {
    axios.delete('/api/posts/delete/' + id)
      .then((response) => {
        state.message = 'Post deleted with success !'
      })
    var index = state.post.findIndex(p => p.id === id)
    state.post.splice(index, 1)
  }

}

export const actions = {

  savePost ({ commit, dispatch }, payload) {
    commit(types.SAVE_POST, payload)
  },

  async fetchPosts ({ commit }) {
    try {
      const { data } = await axios.get('/api/posts/index')
      commit(types.FETCH_POSTS_SUCCESS, { post: data.data })
    } catch (e) {
      commit(types.FETCH_POSTS_FAILURE)
    }
  },

  getPostById ({ commit }, id) {
    commit(types.FETCH_POST_BY_ID, { id: id })
  },

  deletePost ({ commit }, post) {
    commit(types.DELETE_POST, post)
  }
}
