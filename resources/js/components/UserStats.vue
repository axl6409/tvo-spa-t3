<template>
  <div class="profile-stats">
    <ul v-for="stat in profile.stats" class="profile-stats-list">
      <li class="profile-stats-title">
        {{ stat.statId | capitalize }}
      </li>
      <li class="profile-stats-value">
        {{ stat.basic.value }}
      </li>
    </ul>
  </div>
</template>

<script>

import axios from 'axios'

export default {

  filters: {
    capitalize: function (value) {
      if (!value) return ''
      value = value.toString()
      return value.charAt(0).toUpperCase() + value.slice(1).replace(/([A-Z]+)/g, ' $1').trim()
    },

    addSpace: function (value) {
      if (!value) return ''
      value.replace(/([A-Z].*)/g, ' $1').trim()
    }
  },

  data () {
    return {
      profile: {
        stats: {}
      }
    }
  },

  created () {
    this.getProfileInfos()
  },

  methods: {
    getProfileInfos () {
      axios.get('/api/profile/data').then((response) => {
        this.profile.stats = response.data.mergedAllCharacters.merged.allTime
        console.log(this.profile.stats)
      })
    }
  }
}
</script>
