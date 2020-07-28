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

      <!-- Tags -->
      <div class="form-group">
        <label for="tags" class="form-label">tags</label>
        <auto-complete />
      </div>

      <!-- Image -->
      <div class="form-group">
        <label for="content" class="form-label">Image</label>
        <input type="file" name="image" class="form-control">
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
import axios from 'axios'
import { mapGetters } from 'vuex'
import AutoComplete from '../../../../components/AutoComplete'

export default {
  middleware: 'auth',

  components: {
    AutoComplete
  },

  data () {
    return {
      post: {
        userId: '',
        title: '',
        category: {
          id: '',
          name: ''
        },
        tags: [],
        image: null,
        content: null
      },
      search: '',
      results: [],
      isOpen: false
    }
  },

  computed: mapGetters({
    user: 'auth/user',
    tags: 'tags/tags',
    categories: 'categories/categories'
  }),

  beforeCreate () {
    this.$store.dispatch('tags/fetchTags')
    this.$store.dispatch('categories/fetchCategories')
  },

  methods: {
    createPost (e) {
      this.post.userId = this.user.id

      let formData = new FormData(e.target)
      formData.append('title', this.post.title)
      formData.append('category', this.post.category)
      formData.append('tags', this.post.tags)
      formData.append('image', this.post.image)
      formData.append('content', this.post.content)

      axios.post('/api/posts/store',
        formData,
        {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        }
      ).then(function () {
        console.log('Success !')
      })
        .catch(function () {
          console.log('Failure')
        })
      this.$router.push({ name: 'posts.index' })
    },

    onChange () {
      this.isOpen = true
      this.filterResults()
    },
    filterResults () {
      console.log(this.post.tags.indexOf(this.tags) !== -1)
    },
    setResult (result) {
      this.search = result
      this.isOpen = false
    },

    addTag (event) {
      event.preventDefault()
      var val = event.target.value.trim()
      if (val.length > 0) {
        this.post.tags.push(val)
        event.target.value = ''
      }
    },

    removeTag (index) {
      this.post.tags.splice(index, 1)
    },

    removeLastTag (event) {
      if (event.target.value.length === 0) {
        this.removeTag(this.post.tags.length - 1)
      }
    },

    selectedFile (e) {
      this.post.image = e.target.files[0]
      console.log(this.form.image)
    }
  }
}
</script>
