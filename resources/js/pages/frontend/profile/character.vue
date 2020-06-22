<template>
  <div>
    <h1>Character Vue</h1>
    <p></p>
    <fetch-users />
  </div>
</template>

<script>
import FetchUsers from '~/components/FetchUsers'

export default {

  components: {
    FetchUsers
  },

  middleware: 'auth',

  props: {

  }
}
</script>
