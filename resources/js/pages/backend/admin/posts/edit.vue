<template>
  <div class="post-edit">
    <form @submit.prevent="createPost" @keydown="form.onKeydown($event)">
      <!-- Alert -->
      <alert-error :form="form" />

      <!-- Title -->
      <div class="form-group">
        <label for="title">Title</label>
        <input id="title" v-model="form.title" type="text" name="title"
               class="form-control" :class="{ 'is-invalid': form.errors.has('title') }"
        >
        <has-error :form="form" field="title" />
      </div>

      <!-- Category -->
      <div class="form-group">
        <label for="category">Category</label>
        <input id="category" v-model="form.category" type="text" name="category"
               class="form-control" :class="{ 'is-invalid': form.errors.has('category') }"
        >
        <has-error :form="form" field="category" />
      </div>

      <!-- Tags -->
      <div class="form-group">
        <label for="tags">tags</label>
        <input id="tags" v-model="form.tags" type="text" name="tags"
               class="form-control" :class="{ 'is-invalid': form.errors.has('tags') }"
        >
        <has-error :form="form" field="tags" />
      </div>

      <!-- Image -->
      <div class="form-group">
        <label for="content">Image</label>
        <input type="file" name="image" class="form-control"
               :class="{ 'is-invalid': form.errors.has('image') }" @change="selectFile"
        >
        <has-error :form="form" field="image" />
      </div>

      <!-- Content -->
      <div class="form-group">
        <label for="content">Content</label>
        <input id="content" v-model="form.content" type="text" name="content"
               class="form-control" :class="{ 'is-invalid': form.errors.has('content') }"
        >
        <has-error :form="form" field="content" />
      </div>

      <!-- Submit Button -->
      <button :disabled="form.busy" type="submit" class="btn btn-primary">
        Sauvegarder
      </button>
    </form>
  </div>
</template>

<script>
import Form from 'vform'
import { mapGetters } from 'vuex'

const objectToFormData = window.objectToFormData

export default {
  middleware: 'auth',

  data: () => ({
    form: new Form({
      user: '',
      category: '',
      tags: '',
      title: '',
      content: '',
      image: '',
      is_published: false,
      published_at: ''
    })
  }),

  computed: mapGetters({
    user: 'auth/user',
    tags: 'tags/tags'
  }),

  beforeCreate () {
    this.$store.dispatch('fetchTags')
  },

  methods: {
    createPost () {
      this.userId = this.user.id
      const { data } = this.form.post('/api/posts/store')
      console.log(data)
    },

    selectFile (e) {
      const file = e.target.files[0]

      // Do some client side validation...

      this.form.image = file

      this.form.submit('post', '/medias/store', {
        // Transform form data to FormData
        transformRequest: [function (data, headers) {
          return objectToFormData(data)
        }],

        onUploadProgress: e => {
          // Do whatever you want with the progress event
          console.log(e)
        }
      })
        .then(({ data }) => {
          console.log(data)
        })
    }
  }
}
</script>
