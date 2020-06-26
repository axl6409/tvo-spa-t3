<template>
  <div>
    <h1>Dashboard</h1>
    <button @click="checkManifest">
      Check Manifest
    </button>
  </div>
</template>

<script>
import axios from 'axios'

export default {

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
