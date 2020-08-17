<template>
  <div>
    <h1>Dashboard</h1>
    <button @click="checkManifest">
      Check Manifest
    </button>

    <div class="dashboard-actions">

    </div>

    <div class="dashboard-lists">
      <div class="posts-list-admin">
        <router-link :to="{ name: 'posts.create' }" class="nav-link" active-class="active">
          <p class="new-post-btn">Créer Un nouveau Guide</p>
        </router-link>
        <posts-list-admin></posts-list-admin>
      </div>
      <div class="categories-list-admin">
        <router-link :to="{ name: 'categories.create' }" class="nav-link" active-class="active">
          <p class="new-post-btn">Créer Une nouvelle Catégorie</p>
        </router-link>
        <categories-list-admin></categories-list-admin>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import PostsListAdmin from '../../../components/lists/PostsListAdmin'
import CategoriesListAdmin from '../../../components/lists/CategoriesListAdmin'

export default {

  components: {
    PostsListAdmin,
    CategoriesListAdmin
  },

  data () {
    return {
    }
  },

  created () {
    console.log(this.post)
  },

  methods: {
    checkManifest () {
      axios.get('/api/manifest/check')
        .then((response) => {
          alert(response.data)
        })
        .catch(function (error) {
          if (error.response) {
            console.log(error.response.data)
            console.log(error.response.status)
            console.log(error.response.headers)
          } else if (error.request) {
            console.log(error.request)
          } else {
            console.log(error.config)
          }
        })
    }
  }
}
</script>
