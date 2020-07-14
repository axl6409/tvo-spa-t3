<template>
  <div>
    <h1>Character Vue</h1>
    <ul>
      <li v-for="character in personages.datas" :key="character.emblemBackgroundPath">
        <router-link :to="{ name: 'admin' }" class="nav-link" active-class="active">
          {{ $t('admin') }}
          <img :src="path + character.emblemBackgroundPath" alt="">
        </router-link>
      </li>
      <p>{{ this.profile }}</p>
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
      personages: {
        characterIds: [],
        datas: {}
      }
    }
  },

  computed: mapGetters({
    user: 'auth/user',
    profile: 'profile/profile',
    authenticated: 'auth/check'
  }),

  created () {
    this.$store.dispatch('profile/fetchProfile')
    const instance = axios.create({
      baseURL: 'https://www.bungie.net/Platform',
      headers: {
        'X-API-Key': 'd1cf7e1500084cfb8c11b7432556859f'
      }
    })
    this.init(instance)
  },

  mounted () {
  },

  methods: {

    init (instance) {
      console.log(this.user)
      this.memberInfos(instance)
      this.manifestTables()
      this.getDefinition('DestinyGenderDefinition')
      this.hashTranslation('DestinyClassDefinition', 671679327)
    },

    memberInfos (instance) {
      let mbType = this.user.membership_type
      let mbId = this.user.membership_id
      instance.get(`/Destiny2/${mbType}/Profile/${mbId}/?components=100`)
        .then((response) => {
          this.personages.characterIds = response.data.Response.profile.data.characterIds
          this.personages.characterIds.forEach(function (item) {
            axios.get(`/api/profile/characters/${item}`).then((response) => {
              let emblem = response.data.Response.character.data.emblemBackgroundPath
              console.log(emblem)
            })
          })
          /**
           * Convert an object to array
          const { resultArray } = Object.keys(items).map(function (key) {
            return [Number(key), items[key]]
          })
           */
        })
    },

    manifestTables () {
      axios.get(`/api/profile/all`).then((response) => {
        console.log(response)
      })
    },

    hashTranslation (def, id) {
      axios.get(`/api/manifest/query/${def}/${id}`).then((response) => {
        let result = response.data['0']['json']
        let result2 = JSON.parse(result)
        console.log(result2)
      })
    },

    getDefinition (def) {
      axios.get(`/api/manifest/definition/${def}`).then((response) => {
        console.log(response)
      })
    }

  }
}
</script>
