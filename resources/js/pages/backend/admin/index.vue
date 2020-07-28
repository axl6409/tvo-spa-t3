<template>
  <div>
    <h1>Dashboard</h1>
    <button @click="checkManifest">
      Check Manifest
    </button>

    <div class="dashboard-actions">
      <p class="posts">
        <h2>Guides</h2>
        <router-link :to="{ name: 'posts.create' }" class="nav-link" active-class="active">
          <p class="new-post-btn">Créer Un nouveau Guide</p>
        </router-link>
        <router-link :to="{ name: 'posts.index' }" class="nav-link" active-class="active">
          <p class="new-post-btn">Admin des guides</p>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import axios from 'axios'

export default {

  data () {
    return {
    }
  },

  created () {
    console.log(this.post)
  },

  methods: {
    checkManifest () {
      axios.get('/api/manifest/check')
        .then((response) => {
          alert(response.data)
        })
        .catch(function (error) {
          if (error.response) {
            console.log(error.response.data)
            console.log(error.response.status)
            console.log(error.response.headers)
          } else if (error.request) {
            console.log(error.request)
          } else {
            console.log(error.config)
          }
        })
    }
  }
}
</script>
