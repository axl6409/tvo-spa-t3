<template>
  <div class="main-layout">
    <navbar />
    <Logo />
    <div class="main-container">
      <child />
    </div>
  </div>
</template>

<script>
import Navbar from '~/components/Navbar'
import Logo from '~/components/Logo'

export default {
  name: 'MainLayout',

  components: {
    Navbar,
    Logo
  }
}
</script>
