<template>
  <div class="character-block">
    <img class="character-emblem" :src="path + characterEmblem" alt="">
    <p class="character-class">{{ characterClass }}</p>
    <p class="character-light">{{ characterLight }}</p>
    <p class="character-race">{{ characterRace }}</p>
  </div>
</template>

<script>
import axios from 'axios'

export default {

  props: ['character'],

  data () {
    return {
      path: 'https://www.bungie.net/',
      characterEmblem: '',
      characterClass: '',
      characterLight: '',
      characterRace: ''
    }
  },

  created () {
    this.getCharacterInfo()
  },

  methods: {
    getCharacterInfo () {
      axios.get(`/api/profile/character/${this.character}`).then((response) => {
        console.log(this.character)
        // Get emblem
        this.characterEmblem = response.data.Response.character.data.emblemBackgroundPath
        // Get Light level
        this.characterLight = response.data.Response.character.data.light
        // Get gender & Class
        let genderHash = response.data.Response.character.data.genderHash
        let classHash = response.data.Response.character.data.classHash
        this.characterClass = this.classHashTranslation('DestinyClassDefinition', classHash, genderHash)
        // Get Race
        let raceHash = response.data.Response.character.data.raceHash
        this.characterRace = this.raceHashTranslation('DestinyRaceDefinition', raceHash, genderHash)
      })
    },

    hashTranslation (def, id) {
      axios.get(`/api/manifest/query/${def}/${id}`).then((response) => {
        let result = response.data['0']['json']
        let result2 = JSON.parse(result)
        this.characterRace = result2['displayProperties']['name']
      })
    },

    classHashTranslation (def, id, genderHash) {
      axios.get(`/api/manifest/query/${def}/${id}`).then((response) => {
        let result = response.data['0']['json']
        let result2 = JSON.parse(result)
        this.characterClass = result2['genderedClassNamesByGenderHash'][genderHash]
      })
    },

    raceHashTranslation (def, id, genderHash) {
      axios.get(`/api/manifest/query/${def}/${id}`).then((response) => {
        let result = response.data['0']['json']
        let result2 = JSON.parse(result)
        this.characterRace = result2['genderedRaceNamesByGenderHash'][genderHash]
      })
    }
  }

}
</script>
