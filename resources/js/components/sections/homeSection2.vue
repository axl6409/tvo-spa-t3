<template>
  <div class="members" :style="{ backgroundImage: `url('${imagePath}')`}">
    <div class="home-overlay">
      <div class="home-members-banner">
        <h2>Membres - {{ infos.detail.memberCount }}</h2>
      </div>
      <div class="home-members-block">
        <p>
          Nous sommes présent sur Discord, Steam et Bungie.net !
        </p>
        <div class="home-members-block-socials">
          <img :src="discordImage" alt="discord-logo">
          <img :src="steamImage" alt="steam-logo">
          <img :src="bungieImage" alt="bungie-logo">
        </div>
        <p>
          Demandez votre lien d'invitation sur le chat de Bungie
        </p>
        <div class="home-members-block-infos">
          <p>
            Vous devez avoir le jeu et un compte Bungie pour pouvoir vous incrire sur le Discord, le Clan ou même ce site.
          </p>
          <button class="text-anime" @mouseenter="animeButton" @mouseleave="stopAnimeButton">
            <a class="btn-bungie-link" href="https://www.bungie.net/">Créer un compte bungie</a>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import axios from 'axios'
import anime from 'animejs'

export default {
  data () {
    return {
      users: null,
      infos: null,
      imagePath: '/images/settings/titans.jpg',
      discordImage: '/images/settings/discord.png',
      steamImage: '/images/settings/steam.png',
      bungieImage: '/images/settings/bungie.png'
    }
  },

  created () {
    this.getClanMembers()
    this.getClanInfos()
  },

  methods: {
    animeButton () {
      var button = document.getElementsByClassName('text-anime')
      anime({
        targets: button,
        color: '#f3cf00',
        borderColor: '#f3cf00',
        scale: [1, 1.1]
      })
    },
    stopAnimeButton () {
      var button = document.getElementsByClassName('text-anime')
      anime({
        targets: button,
        color: '#f5f5f5',
        borderColor: '#f5f5f5',
        scale: [1.1, 1]
      })
    },
    getClanInfos () {
      axios.get('/api/clan/infos')
        .then((response) => {
          console.log(response)
          this.infos = response.data
        })
        .catch((error) => {
          console.log(error)
        })
    },
    getClanMembers () {
      axios.get('/api/clan/members')
        .then((response) => {
          console.log(response)
          this.users = response.data.results
        })
        .catch((error) => {
          console.log(error)
        })
    }
  }

}
</script>
