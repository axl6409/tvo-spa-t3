<template>
  <div class="clan-banner">
    <canvas id="layer1">
    </canvas>
  </div>
</template>

<script>
import axios from 'axios'

export default {

  data () {
    return {
      banner: {
        decalBackgroundColorId: {},
        decalColorId: {},
        decalId: {},
        gonfalonColorId: {},
        gonfalonDetailColorId: {},
        gonfalonDetailId: {},
        gonfalonId: {}
      },
      path: 'https://www.bungie.net/'
    }
  },

  created () {
    this.getClanBanner()
  },

  methods: {
    getClanBanner () {
      axios.get('/api/clan/banner')
        .then((response) => {
          console.log(response.data)
          this.banner.decalBackgroundColorId = this.hashTranslation('DecalSecondaryColors', response.data.decalBackgroundColorId)
          this.banner.decalColorId = this.hashTranslation('DecalPrimaryColors', response.data.decalColorId)
          this.banner.decalId = this.hashTranslation('Decals', response.data.decalId)
          this.banner.gonfalonColorId = this.hashTranslation('GonfalonColors', response.data.gonfalonColorId)
          this.banner.gonfalonDetailColorId = this.hashTranslation('GonfalonDetailColors', response.data.gonfalonDetailColorId)
          this.banner.gonfalonDetailId = this.hashTranslation('GonfalonDetails', response.data.gonfalonDetailId)
          this.banner.gonfalonId = this.hashTranslation('Gonfalons', response.data.gonfalonId)

        })
        .catch((error) => {
          console.log(error)
        })
    },

    hashTranslation (def, id) {
      axios.get(`/api/clanManifest/query/${def}/${id}`).then((response) => {
        let result = response.data['0']['json']
        let result2 = JSON.parse(result)
        console.log(result2)
      })
    },
  }

}
</script>
