<template>
  <div class="profile">
    <div class="character-section">
      <h2 class="character-section-title">Personnages</h2>
      <ul class="character-section-list">
        <li class="character-list-item" v-for="character in characters" v-bind:key="character">
          <router-link :to="{ name: 'character' , params: { id: character} }" class="nav-link" active-class="active">
            <!--<img :src="path + characters.infos" alt="">-->
            <character-card :character="character"/>
          </router-link>
        </li>
      </ul>
    </div>
    <div class="profile-section">
      <h2 class="profile-page-title">Stats du Compte</h2>
      <user-stats ></user-stats>
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
    axios.get('/api/profile/all').then((response) => {
      this.characters = response.data.profile.data.characterIds
      console.log(this.characters)
    })
  },

  mounted () {
  },

  methods: {

  }
}
</script>
