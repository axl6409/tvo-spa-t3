<template>
  <div class="character-section">
    <h1 class="character-page-title">Personnages</h1>
    <ul>
      <li class="character-list-item" v-for="character in characters">
        <router-link :to="{ name: 'admin' }" class="nav-link" active-class="active">
          <!--<img :src="path + characters.infos" alt="">-->
          <character-card :character="character"/>
        </router-link>
      </li>
    </ul>
  </div>
</template>

<script>
import axios from 'axios'
import { mapGetters } from 'vuex'
import CharacterCard from '../../../components/CharacterCard'

export default {

  components: {
    CharacterCard
  },

  data () {
    return {
      path: 'https://www.bungie.net/',
      characters: {},
      charactersDatas: {}
    }
  },

  computed: mapGetters({
    user: 'auth/user',
    authenticated: 'auth/check'
  }),

  created () {
    axios.get('/api/profile/all').then((response) => {
      this.characters = response.data.profile.data.characterIds
      console.log(this.characterIds)
    })
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
      this.memberInfos()
    },

    memberInfos () {
      axios.get(`/api/profile/characterIds`)
        .then((response) => {
          this.characters.characterIds = response.data
        })
    }

  }
}
</script>
