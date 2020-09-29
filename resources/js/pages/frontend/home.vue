<template>
  <div class="home-container">
    <homeIntro :infos="infos" />

    <homeClan :infos="infos" />

    <homeSection1 />

    <homeSection2 />

    <Footer />
  </div>
</template>

<script>

import homeIntro from '../../components/sections/homeIntro'
import homeClan from '../../components/sections/homeClan'
import homeSection1 from '../../components/sections/homeSection1'
import homeSection2 from '../../components/sections/homeSection2'
import Footer from '../../components/Footer'
import { mapGetters } from 'vuex'

export default {
  layout: 'default',

  components: {
    homeIntro,
    homeClan,
    homeSection1,
    homeSection2,
    Footer
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
