<template>
  <div class="home-title-container">
    <homeIntro :infos="infos" />

    <homeClan />
  </div>
</template>

<script>

import homeIntro from '../../components/sections/homeIntro'
import homeClan from '../../components/sections/homeClan'
import { mapGetters } from 'vuex'

export default {
  layout: 'default',

  components: {
    homeIntro,
    homeClan
  },

  data () {
    return {
      clanDetails: {}
    }
  },

  computed: mapGetters({
    infos: 'clan/infos',
    members: 'clan/members'
  }),

  beforeCreate () {
    this.$store.dispatch('clan/fetchInfos')
    this.$store.dispatch('clan/fetchMembers')
  },

  methods: {
  }
}
</script>
