<template>
  <div class="single-post">
    <div class="single-post-image">
      <img :src="path + post.image" alt="">
    </div>

    <div class="single-post-body">
      <div class="single-header" alt="">
        <h1 class="single-post-title">
          {{ post.title }}
        </h1>
        <p class="single-post-category">
          Catégorie: {{ category.name }}
        </p>
      </div>
      <div class="single-post-content" v-html="post.content" />
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {

  loading: true,

  props: ['id'],

  data () {
    return {
      path: '/images/post/',
      post: {
        content: null
      },
      category: {}
    }
  },

  created () {
    this.getPostById(this.$route.params.id)
  },

  methods: {
    getPostById (id) {
      axios.get('/api/getPost/' + id)
        .then((response) => {
          console.log(response.data)
          this.post = response.data
          this.post.content = response.data.content
          this.getCategoryById(this.post.category_id)
        })
        .catch((error) => {
          console.log(error)
        })
    },

    getCategoryById (id) {
      console.log(id)
      axios.get('/api/getCategories/' + id)
        .then((response) => {
          console.log(response)
          this.category = response.data
        })
        .catch((error) => {
          console.log(error)
        })
    }
  }

}
</script>
