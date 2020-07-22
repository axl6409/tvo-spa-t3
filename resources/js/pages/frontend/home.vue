<template>
  <div class="home-container">
    <h1 class="home-main-title">Tempus Vincit Omnia</h1>
    <p class="home-main-subtitle">Destiny 2 - Clan PC</p>
  </div>
</template>

<script>
export default {
  layout: 'default',

  metaInfo () {
    return { title: this.$t('home') }
  },

  data: () => ({
    title: window.config.appName
  })
}
</script>
