<template>
  <div class="profile">
    <div class="character-section">
      <h2 class="character-section-title">
        Personnages
      </h2>
      <ul class="character-section-list">
        <li v-for="character in characters" :key="character" class="character-list-item">
          <router-link :to="{ name: 'character' , params: { id: character} }" class="nav-link" active-class="active">
            <!--<img :src="path + characters.infos" alt="">-->
            <character-card :ref="loading" :character="character" />
          </router-link>
        </li>
      </ul>
    </div>
    <div class="profile-section">
      <h2 class="profile-page-title">
        Stats du Compte
      </h2>
      <user-stats :ref="loading" />
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import { mapGetters } from 'vuex'
import CharacterCard from '../../../components/CharacterCard'
import UserStats from '../../../components/UserStats'

export default {

  middleware: 'auth',

  components: {
    CharacterCard,
    UserStats
  },

  data () {
    return {
      error: false,
      path: 'https://www.bungie.net/',
      characters: {},
      charactersDatas: {}
    }
  },

  computed: mapGetters({
    user: 'auth/user',
    authenticated: 'auth/check',
    profile: 'profile/profile'
  }),

  created () {
    this.$store.dispatch('profile/fetchProfile')
    this.requestCharacterIds()
    axios.get('/api/manifest/tables').then((response) => {
      console.log(response)
    })
  },

  mounted () {
    this.$loading = this.$refs.loading
  },

  methods: {
    async requestCharacterIds () {
      try {
        const { data } = await axios.get('/api/profile/all')
        this.characters = data.profile.data.characterIds
        console.log(data)
        this.error = false
      } catch (e) {
        this.characters = null
        this.error = e
      }
    }
  }
}
</script>
