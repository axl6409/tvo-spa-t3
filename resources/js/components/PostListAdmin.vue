<template>
  <div>
    <table class="table post-table">
      <tbody>
        <tr>
          <th scope="row">
            {{ post.id }}
          </th>
          <th>{{ post.title }}</th>
          <th>{{ post.is_publish }}</th>
          <th>{{ post.created_at }}</th>
          <th>
            <i class="fas fa-times" />
            <button class="edit-button">
              <router-link :to="{ name: 'posts.create' }">
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
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import axios from 'axios'

export default {

  props: ['post'],

  computed: mapGetters({
    allPosts: 'post/post'
  }),

  beforeCreate () {
  },

  methods: {
    deletePost (id) {
      axios.delete('/api/posts/delete/' + id)
        .then(function () {
          console.log('Success !')
        }).catch(function () {
          console.log('Failed !')
        })
    }
  }
}
</script>
