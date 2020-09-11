<template>
  <div class="post-edit">
    <form @submit.prevent="createPost">
      <!-- Errors -->
      <div v-if="errors.length" class="form-errors-block">
        <p>Corriger les erreurs ci dessous:</p>
        <ul class="form-errors-list">
          <li v-for="error in errors" class="form-errors-items">
            {{ error }}
          </li>
        </ul>
        <button class="btn btn-light" @click="closeBox">
          Close
        </button>
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
          <option v-for="(category) in categories" :key="category.id" :value="category.id">
            {{ category.name }}
          </option>
        </select>
      </div>

      <!-- Image -->
      <div class="form-group">
        <label for="image" class="form-label">Image</label>
        <input id="image" type="file" name="image" class="form-control" @change="selectedImage">
      </div>

      <!-- Content -->
      <div class="form-group">
        <label for="content" class="form-label">Content</label>
        <editor
          id="content"
          v-model="post.content"
          api-key="qn9d6exax4dzon3nlr0h2q2uezhebpdn6gu8tntucbrsjnxm"
          :init="{
            height: 500,
            menubar: false,
            plugins: [
              'advlist autolink lists link image charmap print preview anchor',
              'searchreplace visualblocks code fullscreen',
              'insertdatetime media table paste code help wordcount'
            ],
            toolbar:
              'undo redo | formatselect | bold italic backcolor | \
               alignleft aligncenter alignright alignjustify | \
               bullist numlist outdent indent | removeformat | help'
          }"
          name="content"
        />
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
import axios from 'axios'
import Editor from '@tinymce/tinymce-vue'

export default {
  middleware: 'auth',

  components: {
    'editor': Editor
  },

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

  computed: mapGetters({
    user: 'auth/user',
    categories: 'categories/categories'
  }),

  beforeCreate () {
    this.$store.dispatch('categories/fetchCategories')
  },

  methods: {
    closeBox () {
      this.errors = []
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
      if (!this.post.content) {
        this.errors.push('Contenu Requis')
      }

      if (this.errors.length === 0) {
        axios.post('/api/posts/store', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        }).then((response) => {
          console.log(response)
          this.$store.dispatch('posts/fetchPosts')
        }).catch((error) => {
          console.log(error)
        })
        this.$router.push({ name: 'admin' })
      } else {
        console.log('There some errors')
      }
    }
  }
}
</script>
