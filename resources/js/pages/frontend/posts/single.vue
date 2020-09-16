<template>
  <div class="single-post">
    <div class="single-header" :src="path + post.image" alt="">
      <h1 class="single-post-title">
        {{ post.title }}
      </h1>
      <span class="single-post-category">
        {{ post.category }}
      </span>

    </div>
    <div class="single-post-content">
      {{ post.content }}
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {

  props: ['id'],

  data () {
    return {
      path: 'images/post/',
      post: {},
      category: {}
    }
  },

  created() {
    this.getPostById(this.$route.params.id)
    this.getCategoryById(this.post.id)
  },

  methods: {
    getPostById (id) {
      axios.get('/api/getPost/' + id)
      .then((response) => {
        console.log(response)
        this.post = response.data
      })
      .catch((error) => {
        console.log(error)
      })
    },
    getCategoryById (id) {
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
