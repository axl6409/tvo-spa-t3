<template>
  <div class="main-layout">
    <navbar />
    <Logo />
    <div class="container mt-4">
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
