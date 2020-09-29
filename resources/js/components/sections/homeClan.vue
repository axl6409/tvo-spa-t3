<template>
  <div class="clan-section">
    <div class="first-section" :style="{ backgroundImage: `url('${imagePath}')`}">
      <div class="clan-info">
        <h3>On connaît l'humilité d'un gardien dans son élévation, et sa patience dans l'adversité.</h3>
        <div class="clan-info-conditions">
          <p>Le clan est ouvert à tous avec quelques conditions:</p>
          <ul>
            <li>Jouer sur PC</li>
            <li>Être francophone</li>
            <li>Être un joueur courtois et respectueux des autres</li>
            <li>Être actif sur le jeu</li>
          </ul>
        </div>
        <div class="clan-infos-text">
          <div class="infos-container">
            <p>
              La taille du clan étant limitée à 100, les joueurs ne s'étant pas connecté au jeu depuis plus de 2 moi
              ou n'ont manifestement pas d'intérêt pour le jeu pourront se voir epulsés afin de laisser la place aux nouveaux.
            </p>
            <p>Rien n'empêche un retour dans le clan après expulsion si vous vous remettez au jeu évidemment.</p>
          </div>
          <div class="infos-container">
            <p>Un serveur Discord est disponible.</p>
            <p>Utiliser le chat du clan (via Destiny Companion ou Bungie.net) pour demander une invitation.</p>
            <p>Amusez-vous bien !</p>
          </div>
        </div>
        <router-link :to="{ name: 'join' }">
          <button class="text-anime" @mouseenter="animeButton" @mouseleave="stopAnimeButton">
            Join Us
          </button>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>

import anime from 'animejs'
import ClanBanner from '../ClanBanner'

export default {

  components: {
    ClanBanner
  },

  props: ['infos'],

  data () {
    return {
      imagePath: '/images/settings/arcaniste.jpg'
    }
  },

  created () {
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
    }
  }

}
</script>
