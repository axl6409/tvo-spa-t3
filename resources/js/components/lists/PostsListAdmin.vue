<template>
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
      <tr v-for="post in posts" :key="post.id">
        <th scope="row">
          {{ post.id }}
        </th>
        <th>{{ post.title }}</th>
        <th>{{ post.is_publish ? 'Publié' : 'Brouillon' }}</th>
        <th>{{ post.created_at }}</th>
        <th>
          <i class="fas fa-times" />
          <button class="edit-button">
            <router-link :to="{ name: 'posts.edit', params: { post: post } }">
              <fa icon="edit" fixed-width />
            </router-link>
          </button>
          <button class="delete-button" @click="deletePost(post.id)">
            <fa icon="times" fixed-width />
          </button>
          <button class="publish-button">
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

  data () {
    return {
    }
  },

  computed: mapState({
    posts: state => state.posts.post
  }),

  created () {
    this.$store.dispatch('posts/fetchPosts')
  },

  methods: {
    deletePost (postId) {
      this.$store.dispatch('posts/deletePost', postId)
    }
  }
}
</script>
