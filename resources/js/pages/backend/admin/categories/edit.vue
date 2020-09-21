<template>
  <form @submit.prevent="createCategory">
    <!-- Title -->
    <div class="form-group">
      <label for="name" class="form-label">Name</label>
      <input id="name" v-model="category.name" type="text" name="name"
             class="form-control"
      >
    </div>

    <!-- Content -->
    <div class="form-group">
      <label for="description" class="form-label">Description</label>
      <input id="description" v-model="category.description" type="text" name="description"
             class="form-control"
      >
    </div>

    <div class="category-form-image">
      <img :src="path + category.image" alt="">
    </div>

    <!-- Image -->
    <div class="form-group">
      <label for="image" class="form-label">Image</label>
      <input id="image" type="file" name="image" class="form-control" @change="selectedImage">
    </div>

    <!-- Submit Button -->
    <button type="submit" class="btn btn-primary">
      Sauvegarder
    </button>
  </form>
</template>

<script>
import axios from 'axios'

export default {
  middleware: 'auth',

  props: ['id'],

  data () {
    return {
      category: {
        name: '',
        description: '',
        image: null
      },
      path: 'images/category/thumbnail/'
    }
  },

  created () {
    this.getCategoryById(this.$route.params.id)
  },

  methods: {
    selectedImage (event) {
      this.category.image = event.target.files[0]
    },
    getCategoryById (id) {
      axios.get('/api/categories/edit/' + id)
        .then((response) => {
          console.log(response)
          this.category.name = response.data.name
          this.category.description = response.data.description
          this.category.image = response.data.image
        })
        .catch((error) => {
          console.log(error)
        })
    },
    createCategory (e) {
      let formData = new FormData(e.target)

      formData.append('_method', 'PATCH')
      formData.append('name', this.category.name)
      formData.append('description', this.category.description)
      formData.append('image', this.category.image)

      axios.post('/api/categories/update/' + this.$route.params.id, formData, {
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
