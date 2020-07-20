<template>
  <div>
    <div class="character-section">
      <h2 class="character-page-title">Personnages</h2>
      <ul>
        <li class="character-list-item" v-for="character in characters">
          <router-link :to="{ name: 'admin' }" class="nav-link" active-class="active">
            <!--<img :src="path + characters.infos" alt="">-->
            <character-card :character="character"/>
          </router-link>
        </li>
      </ul>
    </div>
    <div class="profil-section">
      <h2>Profil Stats</h2>
      <user-stats></user-stats>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import { mapGetters } from 'vuex'
import CharacterCard from '../../../components/CharacterCard'
import UserStats from '../../../components/UserStats'

export default {

  components: {
    CharacterCard,
    UserStats
  },

  data () {
    return {
      path: 'https://www.bungie.net/',
      characters: {},
      charactersDatas: {},
      profile: {}
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
  },

  mounted () {
  },

  methods: {

  }
}
</script>
