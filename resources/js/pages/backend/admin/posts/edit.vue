<template>
  <div class="post-edit">
    <form id="form" class="custom-form" @submit.prevent="createPost">
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
        <label for="title" class="form-label form-custom-label">Titre du guide</label>
        <input id="title" v-model="post.title" :title="post.title" type="text"
               name="title" class="form-control custom-form-fields"
        >
      </div>

      <!-- Category -->
      <div class="form-group">
        <label for="category" class="form-label form-custom-label">Categorie du guide</label>
        <select id="category" v-model="post.category"
                name="category" class="form-control custom-form-fields"
        >
          <option disabled>
            Choisir une catégorie
          </option>
          <option v-for="(category) in categories" :key="category.id" :value="category.id" :selected="post.category">
            {{ category.name }}
          </option>
        </select>
      </div>

      <div class="post-edit-image">
        <img :src="path + post.image" alt="">
      </div>

      <!-- Image -->
      <div class="form-group post-edit-select-image">
        <label for="content" class="form-label form-custom-label">Image d'en tête</label>
        <input type="file" name="image" class="form-control custom-form-fields" @change="selectedImage">
      </div>

      <!-- Content -->
      <div class="form-group">
        <label for="content" class="form-label form-custom-label">Contenu du guide</label>
        <editor
          id="content"
          v-model="post.content"
          api-key="qn9d6exax4dzon3nlr0h2q2uezhebpdn6gu8tntucbrsjnxm"
          :init="{
            height: 1000,
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
          :content="post.content"
        />
      </div>

      <!-- Submit Button -->
      <button :disabled="errors.length > 0" type="submit" class="btn btn-primary">
        Sauvegarder
      </button>
    </form>
  </div>
</template>

<script>
import axios from 'axios'
import { mapGetters } from 'vuex'
import Editor from '@tinymce/tinymce-vue'
import Swal from 'sweetalert2'

export default {
  middleware: 'auth',

  components: {
    'editor': Editor
  },

  props: ['id'],

  data () {
    return {
      post: {
        id: '',
        user_id: '',
        title: '',
        category: '',
        image: null,
        content: ''
      },
      path: '/images/post/thumbnail/',
      errors: []
    }
  },

  computed: {
    ...mapGetters({
      user: 'auth/user',
      categories: 'categories/categories'
    })
  },

  beforeCreate () {
    this.$store.dispatch('categories/fetchCategories')
  },

  created () {
    this.getPostById(this.$route.params.id)
  },

  methods: {
    closeBox () {
      this.errors = []
    },
    selectedImage (event) {
      this.post.image = event.target.files[0]
    },

    getPostById (id) {
      axios.get('/api/posts/edit/' + id)
        .then((response) => {
          this.post.id = response.data.id
          this.post.user_id = response.data.user_id
          this.post.title = response.data.title
          this.post.category = response.data.category_id
          this.post.image = response.data.image
          this.post.content = response.data.content
        })
        .catch((error) => {
          console.log(error)
        })
    },
    createPost (e) {
      this.post.user_id = this.user.id
      let formData = new FormData(e.target)
      let id = this.post.id

      formData.append('_method', 'PATCH')
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
        this.errors.push('Contenu requis')
      }

      if (this.errors.length === 0) {
        // this.$store.dispatch('posts/updatePost', formData, id)
        console.log(this.$store.state.posts.message)

        axios.post('/api/posts/update/' + id, formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        })
          .then((response) => {
            console.log(response)
            this.$store.dispatch('posts/fetchPosts')
            this.$router.push({ name: 'admin' })
          })
          .catch((error) => {
            console.log(error)
          })
      } else {
        console.log('There some errors')
      }
    }
  }
}
</script>
