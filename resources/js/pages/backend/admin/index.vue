<template>
  <div class="admin-index">
    <h1>Dashboard</h1>

    <div class="dashboard-lists">
      <div class="posts-list-admin">
        <router-link :to="{ name: 'posts.create' }" class="nav-link add-post-button" active-class="active">
          <button class="create-new-button">
            Créer Un nouveau Guide
          </button>
        </router-link>
        <posts-list-admin />
      </div>
      <div class="categories-list-admin">
        <router-link :to="{ name: 'categories.create' }" class="nav-link add-category-button" active-class="active">
          <button class="create-new-button">
            Créer Une nouvelle Catégorie
          </button>
        </router-link>
        <categories-list-admin />
      </div>
    </div>
  </div>
</template>

<script>
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

  methods: {
  }
}
</script>
