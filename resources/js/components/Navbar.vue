<template>
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <router-link :to="{ name: 'welcome' }" class="navbar-brand navbar-title">
        {{ appName }}
      </router-link>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false">
        <span class="navbar-toggler-icon" >
          <fa icon="bars" class="navbar-toggler-icon-bars" fixed-width />
        </span>
      </button>

      <div id="navbarToggler" class="collapse navbar-collapse">
        <ul class="navbar-nav">
          <li v-if="user" class="nav-item">
            <router-link :to="{ name: 'characters' }" class="nav-link pl-3" active-class="active">
              <fa icon="user" fixed-width />
              {{ $t('characters') }}
            </router-link>
          </li>
          <li v-if="user" class="nav-item">
            <router-link :to="{ name: 'posts' }" class="nav-link pl-3" active-class="active">
              <fa icon="user" fixed-width />
              {{ $t('guides') }}
            </router-link>
          </li>
        </ul>

        <ul class="navbar-nav ml-auto">
          <!-- Authenticated -->
          <li v-if="user" class="nav-item dropdown">
            <a class="nav-link dropdown-toggle"
               href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
            >
              <img :src="path + user.avatar" class="rounded-circle profile-photo mr-1" alt="user-avatar">
              {{ user.name }}
            </a>
            <div class="dropdown-menu dropdown-dark">
              <a href="#" class="nav-link pl-3" @click.prevent="logout">
                <fa icon="sign-out-alt" fixed-width />
                {{ $t('logout') }}
              </a>
              <router-link v-if="user.role_id < 3" :to="{ name: 'admin' }" class="nav-link pl-3" active-class="active">
                <fa icon="user" fixed-width />
                {{ $t('Guides') }}
              </router-link>
              <router-link v-if="user.role_id < 2" :to="{ name: 'users' }" class="nav-link pl-3" active-class="active">
                <fa icon="user" fixed-width />
                {{ $t('Users') }}
              </router-link>
              <button v-if="user.role_id < 2" class="manifest-btn btn btn-info" @click="checkManifest">
                Check Manifest
              </button>
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
import { mapGetters } from 'vuex'
import LocaleDropdown from './LocaleDropdown'
import axios from 'axios'

export default {

  components: {
    LocaleDropdown
  },

  data: () => ({
    path: 'https://www.bungie.net/',
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
      // Redirect to login.
      this.$router.push({ name: 'login' })
    },
    checkManifest () {
      axios.get('/api/manifest/check')
        .then((response) => {
          alert(response.data)
        })
        .catch(function (error) {
          if (error.response) {
            console.log(error.response.data)
            console.log(error.response.status)
            console.log(error.response.headers)
          } else if (error.request) {
            console.log(error.request)
          } else {
            console.log(error.config)
          }
        })
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
