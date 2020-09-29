<template>
  <div class="users-list">
    <h2>Utilisateurs</h2>
    <table class="table list-table">
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
          <th scope="col" class="list-actions-col">
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
            <button class="role-button btn btn-primary">
              <router-link :to="{ name: 'users.assign', params: { id: user.id } }">
                <fa icon="eye" fixed-width />
              </router-link>
            </button>
            <button class="role-button btn btn-danger" @click="deleteUser(user.id)">
              <fa icon="times" fixed-width />
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
    deleteUser (id) {
      this.$store.dispatch('users/deleteUser', id)
    }
  }

}
</script>
