<template>
  <div>
    <h1 class="public-page-title">
      Les Guides
    </h1>

    <div class="categories-buttons">
      <button class="btn btn-light post-by-category-btn">
        Tous
      </button>
      <button v-for="category in categories"
              :key="category.id"
              class="btn btn-light post-by-category-btn"
              @click="getPostsByCategory(category.id)"
      >
        {{ category.name }}
      </button>
    </div>

    <div class="posts-public-list">
      <ul>
        <li v-for="post in posts" :key="post.id" class="post-block">
          <router-link :to="{ name: 'posts.single', params: { id: post.id }}">
            <post-block :post="post" />
          </router-link>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import PostBlock from '../../../components/posts/PostBlock'

export default {

  components: {
    PostBlock
  },

  data () {
    return {
    }
  },

  computed: mapGetters({
    posts: 'posts/posts',
    categories: 'categories/categories'
  }),

  beforeCreate () {
    this.$store.dispatch('posts/fetchPosts')
    this.$store.dispatch('categories/fetchCategories')
  },

  created () {
  },

  methods: {
    getPostsByCategory (id) {
    }
  }

}
</script>
