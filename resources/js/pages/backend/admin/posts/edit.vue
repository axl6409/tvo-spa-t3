<template>
  <div class="post-edit">
    <form @submit.prevent="createPost">
      <!-- Title -->
      <div class="form-group">
        <label for="title" class="form-label">Title</label>
        <input id="title" :title="post.title" type="text" name="title"
               class="form-control" v-model="post.title"
        >
      </div>

      <!-- Category -->
      <div class="form-group">
        <label for="category" class="form-label">Category</label>
        <select id="category" :category="post.category" name="category"
                class="form-control" v-model="post.category"
        >
          <option disabled :value="post.category">
            Choisir une catégorie
          </option>
          <option v-for="(category) in categories" :key="category.id" :value="category.id">
            {{ category.name }}
          </option>
        </select>
      </div>

      <div class="post-edit-image">
        <img :src="path + post.image" alt="">
      </div>

      <!-- Image -->
      <div class="form-group">
        <label for="content" class="form-label">Image</label>
        <input type="file" name="image" class="form-control" @change="selectedImage">
      </div>

      <!-- Content -->
      <div class="form-group">
        <label for="content" class="form-label">Content</label>
        <editor
          id="content"
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
          :content="post.content"
          v-model="post.content"
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
import axios from 'axios'
import { mapGetters } from 'vuex'
import Editor from '@tinymce/tinymce-vue'

export default {
  middleware: 'auth',

  components: {
    'editor': Editor
  },

  props: ['id'],

  data () {
    return {
      post: {
        user_id: '',
        title: '',
        category: '',
        image: null,
        content: ''
      },
      path: "images/post/thumbnail/"
    }
  },

  computed: {
    ...mapGetters({
        user: 'auth/user',
        categories: 'categories/categories'
      }),
  },


  beforeCreate () {
    this.$store.dispatch('categories/fetchCategories')
  },

  created() {
    this.getPostById(this.$route.params.id)
  },

  methods: {
    selectedImage (event) {
      this.post.image = event.target.files[0]
    },

    getPostById (id) {
      axios.get('/api/posts/edit/' + id)
      .then((response) => {
        console.log(response)
        this.post.user_id = response.data.user_id
        this.post.title = response.data.title
        this.post.category = response.data.category
        this.post.image = response.data.image
        this.post.content = response.data.content
      })
      .catch((error) => {
        console.log(error)
      })
    },
    createPost (e) {
      this.post.userId = this.user.id
      let formData = new FormData(e.target)

      formData.append('title', this.post.title)
      formData.append('category', this.post.category)
      formData.append('image', this.post.image)
      formData.append('content', this.post.content)

      this.$store.dispatch('posts/updatePost', formData)
      this.$router.push({ name: 'admin' })
    }
  }
}
</script>
