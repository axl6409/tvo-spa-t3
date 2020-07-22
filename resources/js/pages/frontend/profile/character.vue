<template>
  <div class="single-character">
    <div class="character-banner">
      <div class="character-banner-image" :src="path + characterEmblemBackground" :style="{ backgroundImage: `url('${path + characterEmblemBackground}')` }"></div>
    </div>
    <div class="character-head">
      <div class="character-head-emblem" :src="path + characterEmblem" :style="{ backgroundImage: `url('${path + characterEmblem}')` }"></div>
      <div class="character-head-block">
        <h1 class="character-head-display-name">{{ user.name }}</h1>
        <div class="character-head-infos">
          <div class="character-infos-race">{{ characterClass }}</div>
          <div class="character-infos-light">{{ characterLight }}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import CharacterCard from '../../../components/CharacterCard'
import axios from 'axios'
import { mapGetters } from 'vuex'

export default {

  components: {
    CharacterCard
  },

  props: ['id'],

  data () {
    return {
      path: 'https://www.bungie.net/',
      characterEmblemBackground: '',
      characterEmblem: '',
      characterClass: '',
      characterLight: ''
    }
  },

  computed: mapGetters({
    user: 'auth/user'
  }),

  created () {
    this.getCharacterInfos()
  },

  mounted () {
  },

  methods: {

    getCharacterInfos () {
      let id = this.$route.params.id
      axios.get(`/api/profile/character/${id}`).then((response) => {
        console.log(response)
        let emblemHash = response.data.Response.character.data.emblemHash
        this.getBackgroundEmblemByHash('DestinyInventoryItemDefinition', emblemHash)
        this.getEmblemByHash('DestinyInventoryItemDefinition', emblemHash)
        let classHash = response.data.Response.character.data.classHash
        let genderHash = response.data.Response.character.data.genderHash
        this.classHashTranslation('DestinyClassDefinition', classHash, genderHash)
        this.characterLight = response.data.Response.character.data.light
      })
    },

    getBackgroundEmblemByHash (def, id) {
      axios.get(`/api/manifest/query/${def}/${id}`).then((response) => {
        let result = response.data['0']['json']
        let result2 = JSON.parse(result)
        this.characterEmblemBackground = result2['secondarySpecial']
      })
    },

    getEmblemByHash (def, id) {
      axios.get(`/api/manifest/query/${def}/${id}`).then((response) => {
        let result = response.data['0']['json']
        let result2 = JSON.parse(result)
        this.characterEmblem = result2['secondaryOverlay']
      })
    },

    classHashTranslation (def, id, genderHash) {
      axios.get(`/api/manifest/query/${def}/${id}`).then((response) => {
        let result = response.data['0']['json']
        let result2 = JSON.parse(result)
        this.characterClass = result2['genderedClassNamesByGenderHash'][genderHash]
      })
    }
  }
}
</script>
