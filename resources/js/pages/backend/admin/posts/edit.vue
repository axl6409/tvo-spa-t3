<template>
  <div class="post-edit">
    <form @submit.prevent="createPost">
      <!-- Title -->
      <div class="form-group">
        <label for="title" class="form-label">Title</label>
        <input id="title" v-model="post.title" type="text" name="title"
               class="form-control"
        >
      </div>

      <!-- Category -->
      <div class="form-group">
        <label for="category" class="form-label">Category</label>
        <select id="category" v-model="post.category" name="category"
                class="form-control"
        >
          <option disabled value="">
            Choisir une catégorie
          </option>
          <option v-for="(category) in categories" :value="category.id">
            {{ category.name }}
          </option>
        </select>
      </div>

      <!-- Image -->
      <div class="form-group">
        <label for="content" class="form-label">Image</label>
        <input type="file" name="image" class="form-control" @change="selectedImage">
      </div>

      <!-- Content -->
      <div class="form-group">
        <label for="content" class="form-label">Content</label>
        <input id="content" v-model="post.content" type="text" name="content"
               class="form-control"
        >
      </div>

      <!-- Submit Button -->
      <button type="submit" class="btn btn-primary">
        Sauvegarder
      </button>
    </form>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  middleware: 'auth',

  data () {
    return {
      post: {
        userId: '',
        title: '',
        category: '',
        image: null,
        content: null
      }
    }
  },

  computed: mapGetters({
    user: 'auth/user',
    categories: 'categories/categories'
  }),

  beforeCreate () {
    this.$store.dispatch('categories/fetchCategories')
  },

  methods: {
    selectedImage (event) {
      this.post.image = event.target.files[0]
    },
    createPost (e) {
      this.post.userId = this.user.id
      let formData = new FormData(e.target)

      formData.append('title', this.post.title)
      formData.append('category', this.post.category)
      formData.append('tags', this.post.tags)
      formData.append('image', this.post.image)
      formData.append('content', this.post.content)

      this.$store.dispatch('posts/savePost', formData)
      this.$router.push({ name: 'posts.index' })
    }
  }
}
</script>
