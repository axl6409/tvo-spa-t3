<template>
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <router-link :to="{ name: 'welcome' }" class="navbar-brand navbar-title">
        {{ appName }}
      </router-link>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false">
        <span class="navbar-toggler-icon" />
      </button>

      <div id="navbarToggler" class="collapse navbar-collapse">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="#">
              <router-link :to="{ name: 'characters' }" class="nav-link pl-3" active-class="active">
                {{ $t('personnages') }}
              </router-link>
            </a>
          </li>
        </ul>

        <ul class="navbar-nav ml-auto">
          <!-- Authenticated -->
          <li v-if="user" class="nav-item dropdown">
            <a class="nav-link dropdown-toggle"
               href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
            >
              <img :src="user.photo_url" class="rounded-circle profile-photo mr-1">
              {{ user.name }}
            </a>
            <div class="dropdown-menu dropdown-dark">
              <a href="#" class="nav-link pl-3" @click.prevent="logout">
                <fa icon="sign-out-alt" fixed-width />
                {{ $t('logout') }}
              </a>
              <router-link :to="{ name: 'admin' }" class="nav-link pl-3" active-class="active">
                <fa icon="user" fixed-width />
                {{ $t('admin') }}
              </router-link>
            </div>
          </li>
          <!-- Guest -->
          <template v-else>
            <li class="nav-item">
              <router-link :to="{ name: 'login' }" class="nav-link" active-class="active">
                {{ $t('login') }}
              </router-link>
            </li>
            <li class="nav-item">
              <router-link :to="{ name: 'register' }" class="nav-link" active-class="active">
                {{ $t('register') }}
              </router-link>
            </li>
          </template>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
import LocaleDropdown from './LocaleDropdown'
import { mapGetters } from 'vuex'
import Cookies from 'js-cookie'

export default {
  components: {
    LocaleDropdown
  },

  data: () => ({
    appName: window.config.appName
  }),

  computed: mapGetters({
    user: 'auth/user',
    characters: 'profile/profile'
  }),

  methods: {
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')
      Cookies.remove()
      console.log(Cookies.get())
      // Redirect to login.
      this.$router.push({ name: 'login' })
    }
  }
}
</script>

<style scoped>
  .profile-photo {
    width: 2rem;
    height: 2rem;
    margin: -.375rem 0;
  }
</style>
