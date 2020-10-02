<template>
  <div class="activities" :style="{ backgroundImage: `url('${imagePath}')`}">
    <div class="home-overlay">
      <div class="activities-banner">
        <ul class="activities-list">
          <li class="activities-list-item">
            Raids
          </li>
          <li class="activities-list-item">
            Osiris
          </li>
          <li class="activities-list-item">
            Donjons
          </li>
          <li class="activities-list-item">
            PVE - PVP
          </li>
          <li class="activities-list-item">
            Évènements
          </li>
        </ul>
      </div>
      <h2 class="activities-title">
        Activités du clan
      </h2>
      <div class="activities-blocks">
        <div class="activities-text">
          <p>
            Le clan est actif sur une grande partie de la journée et le soir.
            De part le nombre de joueur dans le clan, vous aurez toujours quelqu'un pour jouer avec vous.
            Les Raids, Osiris et autres activités sont organisés dans le Discord.
          </p>
          <p>
            Des évènements sont créés sur le Discord par les administrateurs, vous pouvez suggerer une activité à programmer.
          </p>
        </div>
        <div class="activities-members">
          <ul>
            <li v-for="user in users">
              <userCard :user="user" />
            </li>
          </ul>
        </div>
      </div>
    </div>

  </div>
</template>

<script>

import userCard from '../users/userCard'
import axios from 'axios'

export default {

  components: {
    userCard
  },

  data () {
    return {
      users: null,
      imagePath: '/images/settings/chasseur.jpg'
    }
  },

  created () {
    this.getClanAdmins()
  },

  methods: {
    getClanAdmins () {
      axios.get('/api/clan/admins-founder')
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
