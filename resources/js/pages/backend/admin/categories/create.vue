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

    <!-- Image -->
    <div class="form-group">
      <label for="image" class="form-label">Image</label>
      <input type="file" id="image" name="image" class="form-control" @change="selectedImage">
    </div>

    <!-- Submit Button -->
    <button type="submit" class="btn btn-primary">
      Sauvegarder
    </button>
  </form>
</template>

<script>
  import { mapGetters } from 'vuex'

  export default {
    middleware: 'auth',

    data () {
      return {
        category: {
          name: '',
          description: '',
          image: null
        }
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

        this.$store.dispatch('categories/saveCategory', formData)
        this.$router.push({ name: 'admin' })
      }
    }
  }
</script>
