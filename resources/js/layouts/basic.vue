<template>
  <div class="basic-layout">
    <character-nav />
    <child />
  </div>
</template>

<script>
import CharacterNav from '~/components/CharacterNav'

export default {

  name: 'BasicLayout',

  components: {
    CharacterNav
  }
}
</script>

<style lang="scss">
.basic-layout {
  color: #636b6f;
  height: 100vh;
  font-weight: 100;
  position: relative;

  .links > a {
    color: #636b6f;
    padding: 0 25px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: .1rem;
    text-decoration: none;
    text-transform: uppercase;
  }
}
</style>
