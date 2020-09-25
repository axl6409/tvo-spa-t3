<template>
  <form id="form" class="custom-form" @submit.prevent="createCategory">
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

    <h1 class="form-edit-title">Nouvelle Catégorie</h1>

    <!-- Title -->
    <div class="form-group">
      <label for="name" class="form-label form-custom-label">Name</label>
      <input id="name" v-model="category.name" type="text" name="name"
             class="form-control custom-form-fields"
      >
    </div>

    <!-- Content -->
    <div class="form-group">
      <label for="description" class="form-label form-custom-label">Description</label>
      <input id="description" v-model="category.description" type="text" name="description"
             class="form-control custom-form-fields"
      >
    </div>

    <!-- Image -->
    <div class="form-group">
      <label for="image" class="form-label form-custom-label">Image</label>
      <input id="image" type="file" name="image" class="form-control custom-form-fields" @change="selectedImage">
    </div>

    <!-- Submit Button -->
    <button type="submit" class="btn btn-primary">
      Sauvegarder
    </button>
  </form>
</template>

<script>
import axios from 'axios'
import { mapGetters } from 'vuex'

export default {
  middleware: 'admin',

  data () {
    return {
      category: {
        name: '',
        description: '',
        image: null
      },
      errors: []
    }
  },

  computed: mapGetters({
    categories: 'categories/categories'
  }),

  beforeCreate () {
    this.$store.dispatch('categories/fetchCategories')
  },

  methods: {
    selectedImage (event) {
      this.category.image = event.target.files[0]
    },
    createCategory (e) {
      let formData = new FormData(e.target)

      formData.append('name', this.category.name)
      formData.append('description', this.category.description)
      formData.append('image', this.category.image)

      axios.post('/api/categories/store', formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      }).then((response) => {
        console.log(response)
        this.$store.dispatch('categories/fetchCategories')
      }).catch((error) => {
        console.log(error)
      })

      this.$router.push({ name: 'admin' })
    }
  }
}
</script>
