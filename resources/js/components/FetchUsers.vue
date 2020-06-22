<template>
  <div>
    <ul>
      <li>
        <router-link :to="{ name: 'characters' }">
          <p>{{ user.membership_id }}</p>
        </router-link>
      </li>
    </ul>
  </div>
</template>

<script>
import axios from 'axios'
import { mapGetters } from 'vuex'

export default {

  characters: () => {
    return {
      characters: null
    }
  },

  computed: mapGetters({
    user: 'auth/user'
  }),

  created () {
    this.init()
  },

  mounted () {
  },

  methods: {

    init () {
      const instance = axios.create({
        baseURL: 'https://www.bungie.net/Platform',
        headers: {
          'X-API-Key': 'd1cf7e1500084cfb8c11b7432556859f'
        }
      })

      this.userInfos()
    },

    memberInfos (instance) {
      let mbType = this.user.membership_type
      let mbId = this.user.membership_id
      instance.get(`/Destiny2/${mbType}/Profile/${mbId}/?components=200`)
        .then((response) => {
          this.characters = response.data.Response.characters
          console.log(this.characters)
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
    },

    userInfos () {
      axios.get('/api/profile')
        .then((response) => {
          console.log(response.data)
        })
    }

  }

}
</script>
