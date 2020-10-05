<template>
  <div class="character-stats">
    <h2>Statistiques</h2>
    <div class="character-stats-header">
      <ul>
        <li class="character-stats-btn-item">
          <button class="stats-button" @click="setStat(allStats.allPvP.allTime)">
            PvP
          </button>
        </li>
        <li class="character-stats-btn-item">
          <button class="stats-button" @click="setStat(allStats.patrol.allTime)">
            Patrouille
          </button>
        </li>
        <li class="character-stats-btn-item">
          <button class="stats-button" @click="setStat(allStats.raid.allTime)">
            Raid
          </button>
        </li>
        <li class="character-stats-btn-item">
          <button class="stats-button" @click="setStat(allStats.story.allTime)">
            Histoire
          </button>
        </li>
        <li class="character-stats-btn-item">
          <button class="stats-button" @click="setStat(allStats.allStrikes.allTime)">
            Assaut
          </button>
        </li>
        <li class="character-stats-btn-item">
          <button class="stats-button" @click="setStat(allStats.allPvE.allTime)">
            PvE
          </button>
        </li>
        <li class="character-stats-btn-item">
          <button class="stats-button" @click="setStat(allStats.allPvECompetitive.allTime)">
            PvE (Competitive)
          </button>
        </li>
      </ul>
    </div>
    <CharacterStatsList :stats="stats" />
  </div>
</template>

<script>

import CharacterStatsList from './CharacterStatsList'
import axios from 'axios'

export default {

  components: {
    CharacterStatsList
  },

  props: ['id'],

  data () {
    return {
      stats: {},
      allStats: {}
    }
  },

  created () {
    this.getCharacterStats()
  },

  methods: {
    getCharacterStats () {
      axios.get('/api/profile/character/stats/' + this.$route.params.id)
        .then((response) => {
          console.log(response.data)
          this.allStats = response.data
        })
        .catch((error) => {
          console.log(error)
        })
    },
    setStat (stat) {
      this.stats = stat
    }
  }

}
</script>
