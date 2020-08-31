<template>
  <div class="post-edit">
    <form @submit.prevent="createPost">
      <!-- Title -->
      <div class="form-group">
        <label for="title" class="form-label">Title</label>
        <input id="title" v-bind:title="post.title" type="text" name="title"
               class="form-control"
        >
      </div>

      <!-- Category -->
      <div class="form-group">
        <label for="category" class="form-label">Category</label>
        <select id="category" v-bind:category="post.category" name="category"
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
        <editor
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
          id="content"
          name="content"
          v-bind:content="post.content"
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
  import Editor from '@tinymce/tinymce-vue'

  export default {
    middleware: 'auth',

    props: ['post'],

    components: {
      'editor': Editor
    },

    data () {
      return {
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
        formData.append('image', this.post.image)
        formData.append('content', this.post.content)

        this.$store.dispatch('posts/updatePost', formData)
        this.$router.push({ name: 'admin' })
      }
    }
  }
</script>
