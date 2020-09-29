<template>
  <table class="table list-table">
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
      <tr v-for="post in posts" :key="post.id">
        <th scope="row">
          {{ post.id }}
        </th>
        <th>{{ post.title | truncate }}</th>
        <th>{{ post.is_publish ? 'Publié' : 'Brouillon' }}</th>
        <th>{{ post.created_at }}</th>
        <th>
          <i class="fas fa-times" />
          <button class="edit-button">
            <router-link :to="{ name: 'posts.edit', params: { id: post.id } }">
              <fa icon="edit" fixed-width />
            </router-link>
          </button>
          <button class="delete-button" @click="deletePost(post.id)">
            <fa icon="times" fixed-width />
          </button>
          <button class="publish-button" @click="publishPost(post.id)">
            <fa icon="paper-plane" fixed-width />
          </button>
        </th>
      </tr>
    </tbody>
  </table>
</template>

<script>

import { mapState } from 'vuex'

export default {

  filters: {
    truncate: function (text) {
      if (!text) return ''
      text = text.toString()
      if (text.length > 65) {
        return text.substring(0, 65) + '...'
      } else {
        return text
      }
    }
  },

  data () {
    return {
    }
  },

  computed: mapState({
    posts: state => state.posts.post
  }),

  created () {
    this.$store.dispatch('posts/fetchPosts')
    this.truncateTitle()
  },

  methods: {
    truncateTitle () {
      if (this.$store.state.posts.post.title > 10) {
        return this.$store.state.posts.post.title.substring(0, 10) + '...'
      }
    },
    publishPost (id) {
      this.$store.dispatch('posts/publishPost', id)
    },
    deletePost (postId) {
      this.$store.dispatch('posts/deletePost', postId)
    }
  }
}
</script>
