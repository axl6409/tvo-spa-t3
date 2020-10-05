<template>
  <div class="user-card">
    <img :src="path + avatar" alt="">
    <div class="user-card-infos">
      <h3>{{ displayName }}</h3>
      <p>{{ user.memberType | memberType}}</p>
    </div>
  </div>
</template>

<script>

import axios from 'axios'

export default {

  filters: {
    memberType: function (value) {
      if (!value) return ''
      if (value === 5) {
        return 'Fondateur'
      }
      if (value === 3) {
        return 'Admin'
      }
    }
  },

  props: ['user'],

  data () {
    return {
      avatar: '',
      displayName: '',
      path: 'https://bungie.net/'
    }
  },

  created () {
    let membershipId = this.$props.user.destinyUserInfo.membershipId
    let membershipType = this.$props.user.destinyUserInfo.membershipType
    this.getUserAvatar(membershipId, membershipType)
  },

  methods: {
    getUserAvatar (id, type) {
      axios.get('/api/clan/single-member/' + id + '/' + type)
        .then((response) => {
          this.avatar = response.data.bungieNetUser.profilePicturePath
          this.displayName = response.data.bungieNetUser.displayName
        })
        .catch((error) => {
          console.log(error)
        })
    }
  }

}
</script>
