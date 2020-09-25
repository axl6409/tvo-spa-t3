<template>
  <div class="roles-list">
    <h2>Rôles</h2>
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
            Description
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="role in roles" :key="role.id">
          <th scope="row">
            {{ role.id }}
          </th>
          <th>{{ role.name }}</th>
          <th>{{ role.description }}</th>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>

import { mapState } from 'vuex'

export default {

  middleware: 'auth',

  data () {
    return {

    }
  },

  computed: mapState({
    roles: state => state.roles.all
  }),

  created () {
    this.$store.dispatch('roles/fetchRoles')
  },

  methods: {
    deleteRole (id) {
      this.$store.dispatch('roles/deleteRole', id)
    }
  }
}
</script>
