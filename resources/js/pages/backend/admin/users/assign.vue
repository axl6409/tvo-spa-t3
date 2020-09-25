<template>
  <div>
    <h1>Assigner un rôle</h1>
    <div>
      <ul>
        <li v-for="role in roles" :key="role.id">
          <button class="role-button" @click="assignRole(role.id)">
            {{ role.name }}
          </button>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>

import { mapState } from 'vuex'

export default {

  props: ['id'],

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
    assignRole (id) {
      this.$store.dispatch('users/assignRole', this.$route.params.id)
    }
  }

}
</script>
