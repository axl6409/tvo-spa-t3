<template>
  <div class="character-stats-body">
    <h3></h3>
    <div>
    </div>
    <div class="character-stats-list">
      <ul>
        <li class="stats-list-item" v-for="stat in stats" :key="stat.id">
          <characterStatsBlock :stat="stat" />
        </li>
      </ul>
    </div>
  </div>
</template>

<script>

import CharacterStatsBlock from './CharacterStatsBlock'

export default {

  props: ['stats'],

  components: {
    CharacterStatsBlock
  }

}
</script>
