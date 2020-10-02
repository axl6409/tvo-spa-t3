<template>
  <div class="home-intro-container">
    <h1 class="home-intro-title">
      {{ infos.detail.name }}
    </h1>
    <p class="home-intro-subtitle">
      Destiny 2 - Clan PC
    </p>

    <div class="home-intro-text">
      <div class="intro-content-left">
        <h3>{{ infos.detail.motto }}</h3>
      </div>
    </div>
  </div>
</template>

<script>
export default {

  props: ['infos'],

  data () {
    return {
    }
  }

}
</script>
