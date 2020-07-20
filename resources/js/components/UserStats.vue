<template>
  <div>
    <h2>Profil Stats</h2>
    <ul>
      <li />
    </ul>
  </div>
</template>

<script>

import axios from 'axios'

export default {

  data () {
    return {
      profile: {
        currentSeason: '',
        
      }
    }
  },

  created() {
    this.getProfileInfos()
  },

  methods: {
    getProfileInfos () {
      axios.get('/api/profile/data').then((response) => {
        console.log(response)
      })
    }
  }
}
</script>
