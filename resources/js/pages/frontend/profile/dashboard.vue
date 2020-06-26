<template>
  <div>
    <h1>Character Vue</h1>
    <ul>
      <!--
      <li v-for="character in characters" :key="character.emblemBackgroundPath">
        <img :src="path + character.emblemBackgroundPath" alt="">
      </li>
      -->
    </ul>
  </div>
</template>

<script>
import axios from 'axios'
import { mapGetters } from 'vuex'

export default {

  data () {
    return {
      path: 'https://www.bungie.net/',
      manifest: null
    }
  },

  computed: {
    ...mapGetters('profile', {
      characters: 'characters'
    }),
    ...mapGetters('auth', {
      user: 'user'
    })
  },

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

      this.memberInfos(instance)
    },

    memberInfos (instance) {
      let mbType = this.user.membership_type
      let mbId = this.user.membership_id
      instance.get(`/Destiny2/${mbType}/Profile/${mbId}/?components=200`)
        .then((response) => {
          const { data } = response.data.Response.characters.data
          this.$store.dispatch('profile/updateCharacters', { characters: data })
          console.log(this.characters)
        })
      this.test()
    },

    test () {
      axios.get('/api/characters/all').then((response) => { console.log(response) })
    },

    hashTanslation ($type, $hash) {
      console.log(this.characters)
      axios.post('/api/manifest/query')
        .then((response) => {
          console.log(response.data)
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
