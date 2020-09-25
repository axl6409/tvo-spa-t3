<template>
  <div class="users-list">
    <h2>Utilisateurs</h2>
    <table class="table post-table">
      <thead>
        <tr>
          <th scope="col">
            #
          </th>
          <th scope="col">
            Name
          </th>
          <th scope="col">
            Bungie ID
          </th>
          <th scope="col">
            Rôle
          </th>
          <th scope="col">
            Actions
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <th scope="row">
            {{ user.id }}
          </th>
          <th>{{ user.name }}</th>
          <th>{{ user.bungie_id }}</th>
          <th>{{ user.role_id }}</th>
          <th>
            <button class="delete-button" @click="deleteUser(user.id)">
              <fa icon="times" fixed-width />
            </button>
            <button class="publish-button">
              <router-link :to="{ name: 'users.assign', params: { id: user.id } }">
                <fa icon="paper-plane" fixed-width />
              </router-link>
            </button>
          </th>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { mapState } from 'vuex'

export default {

  data () {
    return {

    }
  },

  computed: mapState({
    users: state => state.users.all
  }),

  created () {
    this.$store.dispatch('users/fetchUsers')
  },

  methods: {
  }

}
</script>
