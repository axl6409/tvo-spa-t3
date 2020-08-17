<template>
  <div class="post-edit">
    <form @submit.prevent="createPost">

      <!-- Errors -->
      <div class="form-errors-block" v-if="errors.length">
        <p>Corriger les erreurs ci dessous:</p>
        <ul class="form-errors-list">
          <li class="form-errors-items" v-for="error in errors">{{ error }}</li>
        </ul>
        <button class="btn btn-light" @click="closeBox">Close</button>
      </div>
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
        <label for="image" class="form-label">Image</label>
        <input type="file" id="image" name="image" class="form-control" @change="selectedImage">
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
        },
        errors: []
      }
    },

    watch: {
      title(value) {
        this.post.title = value
        this.validateTitle(value)
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
      closeBox() {
        this.errors = []
      },
      validateImage(value) {

      },
      selectedImage (event) {
        this.post.image = event.target.files[0]
        if (this.post.image.size > 1000000) {
          this.post.image = null
          this.errors.push('Image trop lourde, < 1Mb')
        }
      },
      createPost (e) {
        this.post.userId = this.user.id
        let formData = new FormData(e.target)

        formData.append('title', this.post.title)
        formData.append('category', this.post.category)
        formData.append('image', this.post.image)
        formData.append('content', this.post.content)

        if (!this.post.title) {
          this.errors.push('Titre requis')
        }
        if (!this.post.category) {
          this.errors.push('Catégorie requise')
        }
        if (!this.post.image) {
          this.errors.push('Image requise')
        }
        if (!this.post.content) {
          this.errors.push('Contenu Requis')
        }

        this.$store.dispatch('posts/savePost', formData)
        this.$router.push({ name: 'admin' })

      }
    }
  }
</script>
