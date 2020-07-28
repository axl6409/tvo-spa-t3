<template>
  <div class="post-index">
    <h1>All Posts</h1>
    <router-link :to="{ name: 'posts.create' }" class="nav-link" active-class="active">
      <p class="new-post-btn">
        Créer Un nouveau Guide
      </p>
    </router-link>

    <table class="table post-table">
      <thead>
        <tr>
          <th scope="col">
            #
          </th>
          <th scope="col">
            Title
          </th>
          <th scope="col">
            Is Publish
          </th>
          <th scope="col">
            Create At
          </th>
          <th scope="col">
            Actions
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="guide in guides.post" v-bind:key="getPosts">
          <th scope="row">
            {{ guide.id }}
          </th>
          <th>{{ guide.title }}</th>
          <th>{{ guide.is_publish }}</th>
          <th>{{ guide.created_at }}</th>
          <th>
            <i class="fas fa-times" />
            <button class="edit-button">
              <router-link :to="{ name: 'posts.create' }">
                <fa icon="edit" fixed-width />
              </router-link>
            </button>
            <button class="delete-button" @click="deletePost(guide.id)">
              <fa icon="times" fixed-width />
            </button>
            <button class="publish-button">
              <fa icon="paper-plane" fixed-width />
            </button>
          </th>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>

import { mapGetters } from 'vuex'
import axios from 'axios'

export default {

  data () {
    return {
      guides: null
    }
  },

  computed: {
    ...mapGetters({
      posts: 'post/post'
    })
  },

  beforeCreate () {
    this.$store.dispatch('post/fetchPosts')
  },

  created () {
    this.getPosts()
  },

  methods: {
    getPosts () {
      this.guides = this.$store.state.post
    },
    deletePost (postId) {
      this.$store.commit('DELETE_POST', postId)
    }
  }
}
</script>
