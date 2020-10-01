<template>
  <div>
    <div class="userblock">
      <h1 class="user-view-title">
        Assigner un rôle
      </h1>
      <ul>
        <li class="user-name">
          {{ user.nickname }}
        </li>
        <li class="user-avatar">
          <img :src="path + user.avatar" alt="user-avatar">
        </li>
      </ul>
      <form id="form" class="custom-form user-role-form" @submit.prevent="updateUser">
        <!-- Role -->
        <div class="form-group">
          <label for="role" class="form-label form-custom-label">Rôle de l'utilisateur</label>
          <select id="role" v-model="userRole"
                  name="role" class="form-control custom-form-fields"
          >
            <option disabled>
              Choisir un rôle
            </option>
            <option v-for="(role) in roles" :key="role.id" :value="role.id" :selected="user.role_id">
              {{ role.name }}
            </option>
          </select>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary user-button">
          Sauvegarder
        </button>
      </form>
    </div>
  </div>
</template>

<script>

import axios from 'axios'
import { mapState } from 'vuex'

export default {

  props: ['id'],

  data () {
    return {
      userRole: '',
      userInfos: null,
      path: 'https://www.bungie.net'
    }
  },

  computed: {
    ...mapState({
      user: state => state.users.user,
      roles: state => state.roles.all
    })
  },

  beforeCreate () {
    this.$store.dispatch('users/fetchUserById', this.$route.params.id)
    this.$store.dispatch('roles/fetchRoles')
  },

  methods: {
    updateUser (e) {
      let formData = new FormData(e.target)

      formData.append('_method', 'PATCH')
      formData.append('role', this.userRole)

      axios.post('/api/users/assignRole/' + this.$route.params.id, formData)
        .then((response) => {
          console.log(response)
          this.$store.dispatch('users/fetchUsers')
          this.$router.push({ name: 'users' })
        })
        .catch((error) => {
          console.log(error)
        })
    }
  }

}
</script>
