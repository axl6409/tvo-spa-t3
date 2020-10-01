<template>
  <div class="stats-block">
    <h4>{{ stat.statId | capitalize }}</h4>
    <p>{{ stat.basic.displayValue }}</p>
  </div>
</template>

<script>
export default {

  filters: {
    capitalize: function (value) {
      if (!value) return ''
      value = value.toString()
      return value.charAt(0).toUpperCase() + value.slice(1).replace(/([A-Z]+)/g, ' $1').trim()
    }
  },

  props: ['stat']

}
</script>
