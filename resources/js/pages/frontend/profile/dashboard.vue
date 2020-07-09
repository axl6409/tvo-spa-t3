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
    characters: 'auth/characters'
  }),

  created () {
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
      this.memberInfos(instance)
      this.manifestTables()
      this.getDefinition('DestinyGenderDefinition')
      this.hashTranslation('DestinyGenderDefinition', 3111576190)
    },

    memberInfos (instance) {
      let mbType = this.user.membership_type
      let mbId = this.user.membership_id
      instance.get(`/Destiny2/${mbType}/Profile/${mbId}/?components=100,200`)
        .then((response) => {
          console.log(response)
          this.personages.datas = response.data.Response.characters.data
          this.personages.characterIds = response.data.Response.profile.data.characterIds
          /**
           * Convert an object to array
          const { resultArray } = Object.keys(items).map(function (key) {
            return [Number(key), items[key]]
          })
           */
        })
    },

    /**
    charactersInfos () {
      axios.get(`/api/profile/characters`)
        .then((response) => {
          console.log(response)
        })
    },
     */

    manifestTables () {
      axios.get(`/api/manifest/tables`).then((response) => {
        console.log(response)
      })
    },

    hashTranslation (def, id) {
      axios.get(`/api/manifest/query/${def}/${id}`).then((response) => {
        console.log(response)
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
