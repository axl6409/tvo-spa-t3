<template>
  <div class="single-post">
    <img class="single-post-image" :src="path + post.image" alt="">
    <div class="single-header" alt="">
      <h1 class="single-post-title">
        {{ post.title }}
      </h1>
      <p class="single-post-category">
        {{ category.name }}
      </p>
    </div>
    <div v-html="post.content" class="single-post-content">
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
